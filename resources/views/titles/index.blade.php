<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-8">

        {{-- Home-intro (alleen op / ) --}}
        @if (request()->routeIs('home'))
            <div class="mb-6 mx-auto max-w-3xl rounded-xl border border-surface bg-navbar/40 p-4 text-center">
                @auth
                    <p class="text-sm">
                        Welkom, <span class="font-semibold">{{ auth()->user()->name }}</span>
                    </p>
                @endauth
                <p class="mt-1 text-[15px] text-text-muted">
                    Track je films & series. Zoek, filter en houd je watchlist bij.
                </p>
            </div>
        @endif

        {{-- Zoekbalk --}}
        <form method="GET" action="{{ route('home') }}" class="mb-6">
            <div class="flex">
                <input
                    type="text" name="q" value="{{ $q }}"
                    placeholder="Zoek films of series…"
                    class="w-full rounded-l-lg bg-surface border border-surface/80 px-3 py-2 text-sm placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-accent-purple focus:border-transparent"
                />
                <button class="rounded-r-lg bg-accent-purple px-4 text-white text-sm hover:opacity-90">
                    Zoeken
                </button>
            </div>
        </form>

        {{-- Grid met titels --}}
        @if($titles->count())
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($titles as $t)
                    <a href="{{ route('titles.show', $t) }}"
                       class="block rounded-xl border border-surface bg-navbar/40 p-4 hover:bg-surface/30 transition">
                        <div class="font-semibold">{{ $t->title }}</div>
                        <div class="text-xs text-text-muted mt-1">
                            {{ ucfirst($t->type) }} • {{ $t->year ?? 'n/a' }} • {{ $t->platform?->name }}
                        </div>
                        <p class="text-sm mt-2 line-clamp-3 text-text-muted">
                            {{ $t->description }}
                        </p>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $titles->links() }}
            </div>
        @else
            <p class="text-text-muted">Geen titels gevonden.</p>
        @endif
    </div>
</x-app-layout>
