<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sites | Dashboard</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="min-h-screen bg-slate-100">
    <main class="mx-auto max-w-6xl px-4 py-10">
        <div class="mb-6 flex items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Sites</h1>
                <p class="text-sm text-slate-500">Manage API-enabled websites.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('dashboard') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Dashboard</a>
                <a href="{{ route('dashboard.sites.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Add Site</a>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl bg-white shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Site Key</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">URL</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Admin Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($sites as $site)
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $site->name }}</td>
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $site->site_key }}</td>
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $site->url }}</td>
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $site->admin_email }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($site->is_active)
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">Active</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-rose-100 px-2.5 py-1 text-xs font-semibold text-rose-700">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right text-sm">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('dashboard.sites.edit', $site) }}" class="rounded-md border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                                        <form method="POST" action="{{ route('dashboard.sites.destroy', $site) }}" onsubmit="return confirm('Delete this site?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-rose-700">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">No sites found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 p-4">
                {{ $sites->links() }}
            </div>
        </div>
    </main>
</body>
</html>
