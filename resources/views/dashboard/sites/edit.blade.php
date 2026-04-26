<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Site | Dashboard</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="min-h-screen bg-slate-100">
    <main class="mx-auto max-w-3xl px-4 py-10">
        <h1 class="mb-1 text-2xl font-bold text-slate-900">Edit Site</h1>
        <p class="mb-6 text-sm text-slate-500">Update website settings for the Contact API.</p>

        <div class="rounded-xl bg-white p-6 shadow">
            <form method="POST" action="{{ route('dashboard.sites.update', $site) }}" class="space-y-4">
                @method('PUT')
                @include('dashboard.sites._form')

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Save Changes</button>
                    <a href="{{ route('dashboard.sites.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
