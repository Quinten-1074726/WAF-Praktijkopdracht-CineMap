<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-8">
        <nav class="mb-4 text-sm text-text-muted">
            <a href="{{ route('admin.genres.index') }}" class="hover:text-accent-gold">← Terug naar genres</a>
        </nav>

        <h1 class="text-2xl font-semibold mb-6">Genre bewerken</h1>

        <form method="POST" action="{{ route('admin.genres.update', $genre) }}" class="space-y-4">
            @csrf @method('PATCH')
            <div>
                <label class="block text-sm font-medium mb-1" for="name">Naam</label>
                <input type="text" name="name" id="name" value="{{ old('name', $genre->name) }}"
                       class="w-full rounded-lg bg-surface border border-surface/70 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent-purple">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button class="rounded-lg bg-accent-purple text-white px-4 py-2 text-sm hover:opacity-90">
                Bijwerken
            </button>
        </form>
    </div>
</x-app-layout>
