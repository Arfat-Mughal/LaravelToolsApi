<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | LaravelToolsApi</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="min-h-screen bg-slate-100">
    <main class="mx-auto flex min-h-screen w-full max-w-md items-center px-4">
        <div class="w-full rounded-xl bg-white p-6 shadow-lg">
            <h1 class="mb-1 text-2xl font-bold text-slate-900">Login</h1>
            <p class="mb-6 text-sm text-slate-600">Sign in to access your account.</p>

            @if ($errors->any())
                <div class="mb-4 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-indigo-200 focus:ring"
                    >
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-indigo-200 focus:ring"
                    >
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    Remember me
                </label>

                <button type="submit" class="w-full rounded-md bg-indigo-600 px-4 py-2 font-semibold text-white transition hover:bg-indigo-700">
                    Sign In
                </button>
            </form>
        </div>
    </main>
</body>
</html>
