<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-10">
        {{-- Breadcrumbs --}}
        <nav class="flex items-center text-sm text-text-muted mb-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-accent-gold transition">Admin dashboard</a>
            <span class="mx-2 text-text-muted/60">›</span>
            <a href="{{ route('admin.platforms.index') }}" class="hover:text-accent-gold transition">Platforms</a>
            <span class="mx-2 text-text-muted/60">›</span>
            <span class="text-text-primary font-medium">Bewerken</span>
        </nav>

        <h1 class="text-2xl font-semibold mb-6">Platform bewerken</h1>

        <form method="POST" action="{{ route('admin.platforms.update', $platform) }}" class="space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block text-sm font-medium mb-1">Naam platform</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $platform->name) }}"
                    class="w-full rounded-lg bg-surface border border-surface/80 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent-gold focus:border-transparent"
                    required
                />
                @error('name')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.platforms.index') }}"
                   class="rounded-lg border border-surface px-4 py-2 text-sm hover:bg-surface">
                    Annuleren
                </a>
                <button type="submit"
                        class="rounded-lg bg-accent-purple text-white px-5 py-2 text-sm hover:opacity-90">
                    Wijzigingen opslaan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
