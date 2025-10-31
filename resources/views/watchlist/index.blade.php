<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-8">

        {{-- Header + filters --}}
        <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-semibold">Mijn Watchlist</h1>
                <span class="rounded-lg border border-surface bg-navbar/40 px-3 py-1.5 text-sm text-text-muted">
                    Totaal: {{ $items->total() }}
                </span>
            </div>

            <form method="GET" action="{{ route('watchlist.index') }}" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ $q }}"
                       placeholder="Zoek op titel…"
                       class="w-48 rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm">
                <select name="status"
                        class="rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm">
                    <option value="">Alle statussen</option>
                    <option value="WIL_KIJKEN" @selected($status==='WIL_KIJKEN')>Wil kijken</option>
                    <option value="BEZIG"      @selected($status==='BEZIG')>Bezig</option>
                    <option value="GEZIEN"     @selected($status==='GEZIEN')>Gezien</option>
                </select>
                <button class="rounded-lg bg-accent-purple text-white px-4 py-2 text-sm hover:opacity-90">
                    Filter
                </button>
                @if($q || $status)
                    <a href="{{ route('watchlist.index') }}" class="rounded-lg border border-surface px-3 py-2 text-sm hover:bg-surface">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Status-badges --}}
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
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($items as $item)
                    <div class="rounded-xl border border-surface bg-navbar/40 p-4">
                        {{-- optioneel: poster --}}
                        @php
                            $poster = $item->title->poster_path
                                ? asset('storage/'.$item->title->poster_path)
                                : Vite::asset('resources/images/placeholder-title.jpg');
                        @endphp
                        <img src="{{ $poster }}" alt="{{ $item->title->title }}" class="mb-3 w-full aspect-[2/3] object-cover rounded-lg">

                        <a href="{{ route('titles.show', $item->title) }}" class="font-semibold hover:underline">
                            {{ $item->title->title }}
                        </a>
                        <div class="text-xs text-text-muted mt-1">
                            {{ ucfirst($item->title->type) }} • {{ $item->title->year ?? 'n/a' }} • {{ $item->title->platform?->name }}
                        </div>

                        <div class="mt-3 flex items-center justify-between">
                            {{-- Update status/rating --}}
                            <form method="POST" action="{{ route('watchlist.update', $item) }}" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <select name="status" class="rounded-md bg-surface border border-surface/70 px-2 py-1 text-xs">
                                    <option value="WIL_KIJKEN" @selected($item->status==='WIL_KIJKEN')>Wil kijken</option>
                                    <option value="BEZIG"      @selected($item->status==='BEZIG')>Bezig</option>
                                    <option value="GEZIEN"     @selected($item->status==='GEZIEN')>Gezien</option>
                                </select>
                                <input type="number" name="rating" min="1" max="10" value="{{ $item->rating }}"
                                       placeholder="rating"
                                       class="w-16 rounded-md bg-surface border border-surface/70 px-2 py-1 text-xs">
                                <button class="text-xs rounded-md bg-accent-purple text-white px-3 py-1 hover:opacity-90">
                                    Opslaan
                                </button>
                            </form>

                            {{-- Verwijderen --}}
                            <form method="POST" action="{{ route('watchlist.destroy', $item) }}">
                                @csrf @method('DELETE')
                                <button class="text-xs rounded-md border border-surface px-3 py-1 hover:bg-surface">
                                    Verwijder
                                </button>
                            </form>
                        </div>

                        {{-- Review veld (optioneel) --}}
                        @if($item->status === 'GEZIEN')
                            <form method="POST" action="{{ route('watchlist.update', $item) }}" class="mt-3">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="{{ $item->status }}">
                                <textarea name="review" rows="2"
                                          placeholder="Schrijf een korte review (optioneel)…"
                                          class="w-full rounded-md bg-surface border border-surface/70 px-3 py-2 text-sm">{{ $item->review }}</textarea>
                                <div class="mt-2 text-right">
                                    <button class="text-xs rounded-md bg-accent-purple text-white px-3 py-1 hover:opacity-90">
                                        Review opslaan
                                    </button>
                                </div>
                            </form>
                        @endif
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
