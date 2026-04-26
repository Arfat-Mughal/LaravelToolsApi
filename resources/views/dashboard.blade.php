<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | LaravelToolsApi</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="min-h-screen bg-slate-100">
    <main class="mx-auto max-w-5xl px-4 py-10">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-md bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-900">
                    Logout
                </button>
            </form>
        </div>

        <div class="rounded-xl bg-white p-6 shadow">
            <p class="text-slate-700">
                Welcome back, {{ auth()->user()->name }}.
            </p>
            <p class="mt-2 text-sm text-slate-500">
                This is your authenticated dashboard.
            </p>
            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                <div class="rounded-lg border border-slate-200 p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Total Sites</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-900">{{ $siteCount ?? 0 }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Active Sites</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-900">{{ $activeSiteCount ?? 0 }}</p>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('dashboard.sites.index') }}" class="inline-block rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Manage Sites
                </a>
                <a href="{{ url('/') }}" class="inline-block rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Go to Home
                </a>
            </div>
        </div>
    </main>
</body>
</html>
