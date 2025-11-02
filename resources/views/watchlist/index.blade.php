<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-8">
        <nav class="mb-4 text-sm text-text-muted">
            <a href="{{ route('home') }}" class="hover:text-accent-gold">Home</a>
            <span class="mx-2">/</span>
            <span class="text-text-primary">Watchlist</span>
        </nav>
        {{-- Header + filters --}}
        <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-semibold">Mijn Watchlist</h1>
                <span class="rounded-lg border border-surface bg-navbar/40 px-3 py-1.5 text-sm text-text-muted">
                    Totaal: {{ $items->total() }}
                </span>
            </div>

            <form method="GET" action="{{ route('watchlist.index') }}" class="flex flex-wrap items-end gap-2">
                <div>
                    <label class="sr-only" for="q">Zoek</label>
                    <input id="q" type="text" name="q" value="{{ $q }}"
                        placeholder="Zoek op titel…"
                        class="w-56 rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm">
                </div>

                <div>
                    <label class="sr-only" for="status">Status</label>
                    <select id="status" name="status"
                            class="rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm">
                        <option value="">Alle statussen</option>
                        <option value="WIL_KIJKEN" @selected($status==='WIL_KIJKEN')>Wil kijken</option>
                        <option value="BEZIG"      @selected($status==='BEZIG')>Bezig</option>
                        <option value="GEZIEN"     @selected($status==='GEZIEN')>Gezien</option>
                    </select>
                </div>

                {{-- Genres--}}
                <div class="w-72" x-data="{ open:false }">
                    <label class="text-xs text-text-muted">Genres</label>
                    <div class="relative">
                        <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-between rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm hover:bg-surface/70">
                            <span class="truncate">
                                Genres
                                @php $sel = collect($genreIds ?? []); @endphp
                                @if($sel->count()) ({{ $sel->count() }} gekozen) @endif
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
                                <button type="button" class="text-xs text-text-muted hover:text-text-primary"
                                        @click="$el.closest('[x-data]').querySelectorAll('input[type=checkbox]').forEach(cb=>cb.checked=false)">
                                    Reset genres
                                </button>
                                <button type="button" class="text-xs rounded-md bg-accent-purple text-white px-3 py-1 hover:opacity-90"
                                        @click="open=false">Klaar</button>
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
                </div>

                <button class="rounded-lg bg-accent-purple text-white px-4 py-2 text-sm hover:opacity-90">
                    Filter
                </button>

                @if($q || $status || !empty($genreIds))
                    <a href="{{ route('watchlist.index') }}"
                    class="rounded-lg border border-surface px-3 py-2 text-sm hover:bg-surface">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="mb-4 flex gap-2 text-xs text-text-muted">
            <span class="rounded-md border border-surface bg-navbar/40 px-2 py-1">Wil kijken: {{ $counts['WIL_KIJKEN'] ?? 0 }}</span>
            <span class="rounded-md border border-surface bg-navbar/40 px-2 py-1">Bezig: {{ $counts['BEZIG'] ?? 0 }}</span>
            <span class="rounded-md border border-surface bg-navbar/40 px-2 py-1">Gezien: {{ $counts['GEZIEN'] ?? 0 }}</span>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-lg border border-surface bg-navbar/40 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        {{-- Lijst --}}
        @if($items->count())
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
            @foreach($items as $item)
            <div class="group rounded-xl overflow-hidden border border-surface bg-navbar/40 hover:bg-surface/30 transition">
                <a href="{{ route('titles.show', $item->title) }}" class="block">
                <img src="{{ $item->title->image_url }}" alt="{{ $item->title->title }}"
                    class="w-full aspect-[2/3] object-cover transition group-hover:scale-[1.01] duration-200">
                <div class="p-3">
                    <div class="font-semibold truncate">{{ $item->title->title }}</div>
                    <div class="text-xs text-text-muted">
                    {{ ucfirst($item->title->type) }} – {{ $item->title->year ?? 'n/a' }} – {{ $item->title->platform?->name }}
                    </div>
                    @if($item->title->genres->isNotEmpty())
                    <div class="mt-1 flex flex-wrap gap-1">
                        @foreach($item->title->genres->take(3) as $g)
                        <span class="rounded-md bg-surface/40 border border-surface/70 px-1.5 py-0.5 text-[10px]">{{ $g->name }}</span>
                        @endforeach
                        @if($item->title->genres->count() > 3)
                        <span class="text-[10px] text-text-muted">+{{ $item->title->genres->count()-3 }}</span>
                        @endif
                    </div>
                    @endif
                </div>
                </a>
                <div
                x-data="{ s: '{{ $item->status }}', canRate: {{ $seenCount >= 5 ? 'true' : 'false' }} }"
                class="px-3 pb-3"
                >
                <form id="wl-{{ $item->id }}" method="POST" action="{{ route('watchlist.update', $item) }}" class="space-y-2">
                    @csrf @method('PATCH')

                    <div class="flex items-center gap-2">
                    <div class="relative">
                        <select name="status" x-model="s"
                                class="appearance-none w-44 pr-7 rounded-lg bg-surface border border-surface/70 px-3 py-2 text-sm">
                        <option value="WIL_KIJKEN">Wil kijken</option>
                        <option value="BEZIG">Bezig</option>
                        <option value="GEZIEN">Gezien</option>
                        </select>
                        <span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-text-muted"></span>
                    </div>

                    <template x-if="s === 'GEZIEN'">
                        <input type="number" name="rating" min="1" max="10"
                            value="{{ old('rating', $item->rating) }}"
                            placeholder="rating (1–10)"
                            :disabled="!canRate"
                            class="w-24 rounded-lg bg-surface border border-surface/70 px-3 py-2 text-sm">
                    </template>

                    <button type="submit" form="wl-{{ $item->id }}"
                            class="ml-auto rounded-lg bg-accent-purple text-white px-3 py-2 text-xs hover:opacity-90">
                        Opslaan
                    </button>
                    </div>

                    <template x-if="s === 'GEZIEN'">
                    <div>
                        <template x-if="!canRate">
                        <p class="mb-1 text-[11px] text-yellow-300">
                            Min. 5 × “Gezien” nodig voor rating/review.
                        </p>
                        </template>
                        <textarea name="review" rows="2"
                                placeholder="Korte review (min. 10 tekens)…"
                                :disabled="!canRate"
                                class="w-full rounded-lg bg-surface border border-surface/70 px-3 py-2 text-sm"></textarea>
                    </div>
                    </template>
                </form>

                <form method="POST" action="{{ route('watchlist.destroy', $item) }}" class="mt-2">
                    @csrf @method('DELETE')
                    <button class="w-full rounded-lg border border-surface px-3 py-2 text-xs hover:bg-surface">
                    Verwijder
                    </button>
                </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $items->links() }}
        </div>
        @else
        <p class="text-text-muted">Nog niets in je watchlist.</p>
        @endif
    </div>
</x-app-layout>
