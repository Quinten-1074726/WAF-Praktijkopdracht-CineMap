<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-8">

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

        @if($titles->count())
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ($titles as $t)
            <div class="group rounded-xl overflow-hidden border border-surface bg-navbar/40 hover:bg-surface/30 transition">
                {{-- Klikbare info (poster + tekst) --}}
                <a href="{{ route('titles.show', $t) }}" class="block">
                <img src="{{ $t->image_url }}" alt="{{ $t->title }}"
                    class="w-full aspect-[2/3] object-cover transition group-hover:scale-[1.01] duration-200">
                <div class="p-3">
                    <div class="font-semibold truncate">{{ $t->title }}</div>
                    <div class="text-xs text-text-muted">
                    {{ ucfirst($t->type) }} - {{ $t->year ?? 'n/a' }} - {{ $t->platform?->name }}
                    </div>
                </div>
                </a>

                {{-- Watchlist actions (alleen ingelogd) --}}
                @auth
                @php $status = $watchStatuses[$t->id] ?? null; @endphp
                <div class="px-3 pb-3 -mt-1 flex items-center justify-between">
                    <span class="text-[11px] text-text-muted">
                    @if($status)
                        In watchlist ({{ strtolower(str_replace('_',' ',$status)) }})
                    @endif
                    </span>

                    @if(!$status)
                    <form method="POST" action="{{ route('watchlist.store') }}">
                        @csrf
                        <input type="hidden" name="title_id" value="{{ $t->id }}">
                        <button class="text-[11px] rounded-md bg-accent-purple text-white px-2.5 py-1 hover:opacity-90">
                        + Watchlist
                        </button>
                    </form>
                    @endif
                </div>
                @endauth
            </div>
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
