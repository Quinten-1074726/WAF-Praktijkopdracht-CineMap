<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-surface bg-navbar/40 p-5">
                <h3 class="font-semibold text-lg">Totaal titels</h3>
                <p class="text-3xl mt-2">{{ \App\Models\Title::count() }}</p>
            </div>

            <div class="rounded-xl border border-surface bg-navbar/40 p-5">
                <h3 class="font-semibold text-lg">Nog niet gepubliceerd</h3>
                <p class="text-3xl mt-2 text-accent-gold">
                    {{ \App\Models\Title::where('is_published', false)->count() }}
                </p>
            </div>

            <div class="rounded-xl border border-surface bg-navbar/40 p-5">
                <h3 class="font-semibold text-lg">Gebruikers</h3>
                <p class="text-3xl mt-2">{{ \App\Models\User::count() }}</p>
            </div>

            <div class="rounded-xl border border-surface bg-navbar/40 p-5">
                <h3 class="font-semibold text-lg">Platforms</h3>
                <p class="text-3xl mt-2">{{ \App\Models\Platform::count() }}</p>
            </div>
        </div>

        <div class="mt-10">
            <a href="{{ route('admin.titles.index') }}"
               class="inline-block bg-accent-purple text-white px-5 py-2.5 rounded-lg hover:opacity-90 transition">
                Beheer titels
            </a>
        </div>
    </div>
</x-app-layout>
