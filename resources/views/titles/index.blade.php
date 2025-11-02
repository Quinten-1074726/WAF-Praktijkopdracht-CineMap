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

        {{-- Filters --}}
        <form method="GET" action="{{ route('home') }}" class="mb-6">
        <input type="hidden" name="q" value="{{ $q }}"/>

        <div class="flex flex-col gap-3 md:flex-row md:items-end md:gap-4">
            <div class="w-full md:w-40">
            <label class="text-xs text-text-muted">Type</label>
            <select name="type"
                    class="w-full rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm">
                <option value="">Alle</option>
                <option value="movie"  @selected(($type ?? '')==='movie')>Movie</option>
                <option value="series" @selected(($type ?? '')==='series')>Series</option>
            </select>
            </div>
            <div class="w-full md:w-52">
            <label class="text-xs text-text-muted">Platform</label>
            <select name="platform"
                    class="w-full rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm">
                <option value="">Alle</option>
                @foreach($platforms as $p)
                <option value="{{ $p->id }}" @selected(($platformId ?? null) == $p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
            </div>
            <div>
            <label class="text-xs text-text-muted">Jaar van</label>
            <input type="number" name="year_from" value="{{ $yearFrom ?: '' }}" placeholder="2000"
                    class="w-28 rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm" placeholder="2000">
            </div>
            <div>
            <label class="text-xs text-text-muted">Jaar tot</label>
            <input type="number" name="year_to"   value="{{ $yearTo   ?: '' }}" placeholder="2025"
                    class="w-28 rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm" placeholder="2025">
            </div>

            <div class="w-full md:w-72" x-data="{ open:false }">
            <label class="text-xs text-text-muted">Genres</label>

            <div class="relative">
                <button type="button"
                        @click="open = !open"
                        class="w-full flex items-center justify-between rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm hover:bg-surface/70">
                <span class="truncate">
                    Genres
                    @php $selected = collect($genreIds ?? []); @endphp
                    @if($selected->count() > 0)
                    ({{ $selected->count() }} gekozen)
                    @endif
                </span>
                <span class="text-text-muted">▾</span>
                </button>
                <div x-show="open" x-transition @click.outside="open=false"
                    class="absolute z-20 mt-1 w-[22rem] rounded-xl border border-surface bg-navbar/95 backdrop-blur shadow-xl">
                <div class="p-3 grid grid-cols-2 gap-2 max-h-56 overflow-auto">
                    @foreach($genres as $g)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="genres[]"
                            value="{{ $g->id }}"
                            @checked(collect($genreIds)->contains($g->id))
                            class="rounded border-surface/70 bg-surface">
                        <span>{{ $g->name }}</span>
                    </label>
                    @endforeach
                </div>

                <div class="flex items-center justify-between border-t border-surface/70 px-3 py-2">
                    <button type="button"
                            class="text-xs text-text-muted hover:text-text-primary"
                            @click="$el.closest('[x-data]').querySelectorAll('input[type=checkbox]').forEach(cb=>cb.checked=false)">
                    Reset alle genres
                    </button>
                    <button type="button" class="text-xs rounded-md bg-accent-purple text-white px-3 py-1 hover:opacity-90"
                            @click="open=false">
                    Klaar
                    </button>
                </div>
                </div>
            </div>
            @php
                $chosen = ($genreIds ?? []);
                $preview = $genres->whereIn('id', $chosen)->take(3);
                $extra = max(0, count($chosen) - $preview->count());
            @endphp
            @if(!empty($chosen))
                <div class="mt-1 flex flex-wrap gap-1">
                @foreach($preview as $g)
                    <span class="rounded-md bg-surface/40 border border-surface/70 px-2 py-0.5 text-[11px]">{{ $g->name }}</span>
                @endforeach
                @if($extra > 0)
                    <span class="text-[11px] text-text-muted">+{{ $extra }}</span>
                @endif
                </div>
            @endif
            </div>

            <div class="flex gap-2">
            <button class="rounded-lg bg-accent-purple text-white px-4 py-2 text-sm hover:opacity-90">
                Filteren
            </button>
            @if($q || $type || $platformId || $yearFrom || $yearTo || !empty($genreIds))
                <a href="{{ route('home') }}"
                class="rounded-lg border border-surface px-3 py-2 text-sm hover:bg-surface">
                Reset
                </a>
            @endif
            </div>
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
                    @can('use-watchlist')
                        @php $status = $watchStatuses[$t->id] ?? null; @endphp
                        <div class="px-3 pb-3 -mt-1 flex items-center justify-between">
                            @if($status)
                                <span class="text-[11px] rounded-md bg-accent-gold/20 border border-accent-gold/30 text-accent-gold px-2 py-1">
                                    In watchlist ({{ strtolower(str_replace('_',' ',$status)) }})
                                </span>
                            @endif

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
                    @else
                        {{-- Admin quick action --}}
                        <div class="px-3 pb-3 -mt-1 flex items-center justify-end">
                            <a href="{{ route('admin.titles.edit', $t) }}"
                            class="text-[11px] px-2.5 py-1 rounded-md border border-surface hover:bg-surface">
                                Bewerken
                            </a>
                        </div>
                    @endcan
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
