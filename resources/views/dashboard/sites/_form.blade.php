@csrf

<div>
    <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Name</label>
    <input id="name" name="name" type="text" value="{{ old('name', $site->name ?? '') }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-indigo-200 focus:ring">
    @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="site_key" class="mb-1 block text-sm font-medium text-slate-700">Site Key</label>
    <input id="site_key" name="site_key" type="text" value="{{ old('site_key', $site->site_key ?? '') }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-indigo-200 focus:ring">
    @error('site_key') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="url" class="mb-1 block text-sm font-medium text-slate-700">URL</label>
    <input id="url" name="url" type="url" value="{{ old('url', $site->url ?? '') }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-indigo-200 focus:ring">
    @error('url') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="admin_email" class="mb-1 block text-sm font-medium text-slate-700">Admin Email</label>
    <input id="admin_email" name="admin_email" type="email" value="{{ old('admin_email', $site->admin_email ?? '') }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-indigo-200 focus:ring">
    @error('admin_email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="description" class="mb-1 block text-sm font-medium text-slate-700">Description</label>
    <textarea id="description" name="description" rows="3" class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-indigo-200 focus:ring">{{ old('description', $site->description ?? '') }}</textarea>
    @error('description') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>

<label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $site->is_active ?? true)) class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
    Active Site
</label>
