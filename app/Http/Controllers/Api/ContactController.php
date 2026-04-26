<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\Site;
use App\Services\ContactFormValidatorService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $site = $request->user();

        if (! $site instanceof Site) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 401);
        }

        $perPage = min(max((int) $request->integer('per_page', 15), 1), 100);

        $query = $site->submissions()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $submissions = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $submissions,
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $submission = $this->resolveOwnedSubmission($request, $id);

        if ($submission instanceof JsonResponse) {
            return $submission;
        }

        return response()->json([
            'success' => true,
            'data' => $submission,
        ]);
    }

    public function store(Request $request, ContactFormValidatorService $validatorService)
    {
        $siteKeyValidator = Validator::make($request->all(), [
            'site_key' => ['required', 'string', 'exists:sites,site_key'],
        ]);

        if ($siteKeyValidator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $siteKeyValidator->errors()->toArray(),
            ], 422);
        }

        $site = Site::where('site_key', (string) $request->input('site_key'))->first();

        if (! $site instanceof Site) {
            return response()->json([
                'success' => false,
                'message' => 'Site not found.',
            ], 404);
        }

        if (! $site->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This site is inactive.',
            ], 403);
        }

        $site->loadMissing('formFields');

        $validator = Validator::make(
            $request->all(),
            $validatorService->rulesForSite($site)
        );

        $allowedFieldKeys = $validatorService->allowedFieldKeys($site);
        $validator->after(function ($validator) use ($request, $allowedFieldKeys): void {
            $incomingFields = $request->input('fields', []);

            if (! is_array($incomingFields)) {
                return;
            }

            $unknownKeys = array_diff(array_keys($incomingFields), $allowedFieldKeys);

            foreach ($unknownKeys as $key) {
                $validator->errors()->add("fields.$key", 'This field is not allowed for this site.');
            }
        });

        try {
            $validated = $validator->validate();
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'errors' => $exception->errors(),
            ], 422);
        }

        $submission = ContactSubmission::create([
            'site_id' => $site->id,
            'name' => $this->sanitizeString($validated['name']),
            'email' => $this->sanitizeString($validated['email']),
            'subject' => $this->sanitizeNullableString($validated['subject'] ?? null),
            'message' => $this->sanitizeString($validated['message']),
            'fields' => $this->sanitizeFields($validated['fields'] ?? []),
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your message has been received. We will get back to you shortly.',
            'reference' => $this->buildReference($submission->id),
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $submission = $this->resolveOwnedSubmission($request, $id);

        if ($submission instanceof JsonResponse) {
            return $submission;
        }

        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:100'],
            'email' => ['sometimes', 'required', 'email', 'max:150'],
            'subject' => ['nullable', 'string', 'max:200'],
            'message' => ['sometimes', 'required', 'string', 'max:5000'],
            'fields' => ['nullable', 'array'],
            'status' => ['sometimes', 'required', 'in:new,read,replied,spam,archived'],
        ]);

        if (array_key_exists('name', $validated)) {
            $validated['name'] = $this->sanitizeString($validated['name']);
        }

        if (array_key_exists('email', $validated)) {
            $validated['email'] = $this->sanitizeString($validated['email']);
        }

        if (array_key_exists('subject', $validated)) {
            $validated['subject'] = $this->sanitizeNullableString($validated['subject']);
        }

        if (array_key_exists('message', $validated)) {
            $validated['message'] = $this->sanitizeString($validated['message']);
        }

        if (array_key_exists('fields', $validated)) {
            $validated['fields'] = $this->sanitizeFields($validated['fields'] ?? []);
        }

        $submission->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Submission updated successfully.',
            'data' => $submission->fresh(),
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $submission = $this->resolveOwnedSubmission($request, $id);

        if ($submission instanceof JsonResponse) {
            return $submission;
        }

        $submission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Submission deleted successfully.',
        ]);
    }

    private function resolveOwnedSubmission(Request $request, int $id): ContactSubmission|JsonResponse
    {
        $site = $request->user();

        if (! $site instanceof Site) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 401);
        }

        $submission = $site->submissions()->find($id);

        if ($submission === null) {
            return response()->json([
                'success' => false,
                'message' => 'Submission not found.',
            ], 404);
        }

        return $submission;
    }

    private function buildReference(int $id): string
    {
        return 'SUB-'.str_pad((string) $id, 5, '0', STR_PAD_LEFT);
    }

    private function sanitizeFields(array $fields): array
    {
        return collect($fields)
            ->map(function ($value) {
                if (is_string($value)) {
                    return $this->sanitizeString($value);
                }

                return $value;
            })
            ->all();
    }

    private function sanitizeString(string $value): string
    {
        return trim(strip_tags($value));
    }

    private function sanitizeNullableString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return $this->sanitizeString($value);
    }
}
