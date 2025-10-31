<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

            <div class="rounded-xl border border-surface bg-navbar/40 p-5">
                <h3 class="font-semibold text-lg">Totaal titels</h3>
                <p class="text-3xl mt-2">{{ \App\Models\Title::count() }}</p>
                <a href="{{ route('admin.titles.index') }}"
                   class="inline-block mt-4 text-sm bg-accent-purple text-white px-3 py-1.5 rounded-md hover:opacity-90">
                    Bekijk titels
                </a>
            </div>

            <div class="rounded-xl border border-surface bg-navbar/40 p-5">
                <h3 class="font-semibold text-lg">Nog niet gepubliceerd</h3>
                <p class="text-3xl mt-2 text-accent-gold">
                    {{ \App\Models\Title::where('is_published', false)->count() }}
                </p>
                <a href="{{ route('admin.titles.index', ['filter' => 'unpublished']) }}"
                   class="inline-block mt-4 text-sm border border-surface px-3 py-1.5 rounded-md hover:bg-surface">
                    Toon ongepubliceerde
                </a>
            </div>

            <div class="rounded-xl border border-surface bg-navbar/40 p-5">
                <h3 class="font-semibold text-lg">Gebruikers</h3>
                <p class="text-3xl mt-2">{{ \App\Models\User::count() }}</p>
                <a href="{{ route('admin.users.index') }}"
                   class="inline-block mt-4 text-sm border border-surface px-3 py-1.5 rounded-md hover:bg-surface">
                    Bekijk gebruikers
                </a>
            </div>

            <div class="rounded-xl border border-surface bg-navbar/40 p-5">
                <h3 class="font-semibold text-lg">Platforms</h3>
                <p class="text-3xl mt-2">{{ \App\Models\Platform::count() }}</p>
                <a href="{{ route('admin.platforms.index') }}"
                   class="inline-block mt-4 text-sm border border-surface px-3 py-1.5 rounded-md hover:bg-surface">
                    Bekijk platforms
                </a>
            </div>
            <div class="rounded-xl border border-surface bg-navbar/40 p-5">
                <h3 class="font-semibold text-lg">Genres</h3>
                <p class="text-3xl mt-2">{{ \App\Models\Genre::count() }}</p>
                <a href="{{ route('admin.genres.index') }}"
                class="inline-block mt-4 text-sm border border-surface px-3 py-1.5 rounded-md hover:bg-surface">
                    Bekijk genres
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
