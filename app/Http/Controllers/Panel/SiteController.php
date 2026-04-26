<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function index(): View
    {
        $sites = Site::query()->latest()->paginate(15);

        return view('dashboard.sites.index', compact('sites'));
    }

    public function create(): View
    {
        return view('dashboard.sites.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $validated['is_active'] = $request->boolean('is_active', true);

        Site::create($validated);

        return redirect()
            ->route('dashboard.sites.index')
            ->with('status', 'Site created successfully.');
    }

    public function edit(Site $site): View
    {
        return view('dashboard.sites.edit', compact('site'));
    }

    public function update(Request $request, Site $site): RedirectResponse
    {
        $validated = $request->validate($this->rules($site->id));
        $validated['is_active'] = $request->boolean('is_active');

        $site->update($validated);

        return redirect()
            ->route('dashboard.sites.index')
            ->with('status', 'Site updated successfully.');
    }

    public function destroy(Site $site): RedirectResponse
    {
        $site->delete();

        return redirect()
            ->route('dashboard.sites.index')
            ->with('status', 'Site deleted successfully.');
    }

    private function rules(?int $siteId = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'site_key' => ['required', 'string', 'max:255', Rule::unique('sites', 'site_key')->ignore($siteId)],
            'url' => ['required', 'url', 'max:255'],
            'admin_email' => ['required', 'email', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}
