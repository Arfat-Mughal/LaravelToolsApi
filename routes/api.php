<?php

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
