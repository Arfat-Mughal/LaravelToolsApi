<?php

use App\Http\Controllers\Api\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/specialized-tools', function () {
    $tools = collect(config('specialized_tools', []))
        ->map(function (array $tool, string $slug) {
            return [
                'slug' => $slug,
                'name' => $tool['name'],
                'url' => $tool['url'],
                'description' => $tool['description'],
                'redirect_url' => route('redirect.tool', ['tool' => $slug]),
            ];
        })
        ->values();

    return response()->json([
        'status' => 'ok',
        'total' => $tools->count(),
        'data' => $tools,
    ]);
});

Route::middleware(['throttle:contact-api'])
    ->post('/contact', [ContactController::class, 'store']);

Route::middleware(['auth:sanctum', 'site.active', 'site.key'])
    ->group(function (): void {
        Route::get('/contact', [ContactController::class, 'index']);
        Route::get('/contact/{id}', [ContactController::class, 'show'])->whereNumber('id');
        Route::match(['put', 'patch'], '/contact/{id}', [ContactController::class, 'update'])->whereNumber('id');
        Route::delete('/contact/{id}', [ContactController::class, 'destroy'])->whereNumber('id');
    });
