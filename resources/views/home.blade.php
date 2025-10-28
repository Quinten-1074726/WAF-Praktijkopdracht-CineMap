<x-app-layout>
    <div class="mx-auto max-w-6xl px-6 py-16">
        <div class="text-center">
            <h1 class="text-4xl font-bold tracking-tight">CineMap</h1>
            <p class="mt-4 text-lg text-text-muted">
                Track je films & series. Zoek, filter en houd je watchlist bij.
            </p>

        <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-xl border border-surface bg-navbar/40 p-5">
                <h3 class="font-semibold flex items-center gap-2">
                    <span class="inline-block h-2 w-2 rounded-full bg-accent-gold"></span>
                    Snel zoeken
                </h3>
                <p class="mt-2 text-sm text-text-muted">
                    Vind films/series op titel, genre of platform.
                </p>
            </div>
            <div class="rounded-xl border border-surface bg-navbar/40 p-5">
                <h3 class="font-semibold">Watchlist</h3>
                <p class="mt-2 text-sm text-text-muted">Markeer “Wil kijken”, “Bezig” of “Gezien”.</p>
            </div>
            <div class="rounded-xl border border-surface bg-navbar/40 p-5">
                <h3 class="font-semibold">Reviews & Ratings</h3>
                <p class="mt-2 text-sm text-text-muted">Laat je mening achter na het kijken.</p>
            </div>
        </div>
    </div>
</x-app-layout>
