<x-app-layout>
  <div class="max-w-5xl mx-auto px-6 py-8">
    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}"
       class="text-sm text-text-muted hover:text-accent-gold">← Terug naar overzicht</a>

    <div class="mt-4 grid gap-6 md:grid-cols-[320px,1fr]">
      <div class="rounded-xl overflow-hidden border border-surface bg-navbar/40">
        <img src="{{ $title->image_url }}" alt="{{ $title->title }}" class="w-full aspect-[2/3] object-cover">
      </div>

      <div>
        <div class="rounded-xl border border-surface bg-navbar/40 p-6">
          <h1 class="text-2xl font-bold">{{ $title->title }}</h1>
          <div class="mt-1 text-sm text-text-muted">
            {{ ucfirst($title->type) }} : {{ $title->year ?? 'n/a' }} : {{ $title->platform?->name }}
          </div>

          @if($title->genres->isNotEmpty())
            <div class="mt-2 flex flex-wrap gap-2">
              @foreach($title->genres as $g)
                <span class="rounded-md bg-surface/40 border border-surface/70 px-2 py-0.5 text-xs">
                  {{ $g->name }}
                </span>
              @endforeach
            </div>
          @endif

          <p class="mt-4">{{ $title->description ?? 'Geen beschrijving.' }}</p>
        </div>

        <div class="mt-5">
          @auth
            @can('use-watchlist')
              @if(!$inWatchlist)
                <form method="POST" action="{{ route('watchlist.store') }}">
                  @csrf
                  <input type="hidden" name="title_id" value="{{ $title->id }}">
                  <button class="rounded-md bg-accent-purple text-white px-4 py-2 hover:opacity-90">
                    + Voeg toe aan watchlist
                  </button>
                </form>
              @else
                <div class="flex items-center gap-3">
                  <span class="text-sm text-text-muted">
                    In watchlist ({{ strtolower(str_replace('_',' ',$inWatchlist->status)) }})
                  </span>
                  <a href="{{ route('watchlist.index') }}"
                    class="text-sm rounded-md border border-surface px-3 py-2 hover:bg-surface">
                    Bekijk watchlist
                  </a>
                </div>
              @endif
            @else
              {{-- Admin acties --}}
              <div class="flex items-center gap-2">
                <a href="{{ route('admin.titles.edit', $title) }}"
                  class="rounded-md border border-surface px-3 py-2 hover:bg-surface text-sm">
                  Bewerken
                </a>
                <form method="POST" action="{{ route('admin.titles.toggle-publish', $title) }}">
                  @csrf
                  <button class="rounded-md text-sm {{ $title->is_published ? 'bg-yellow-600/30 text-yellow-100' : 'bg-green-600/30 text-green-100' }} px-3 py-2">
                    {{ $title->is_published ? 'Unpublish' : 'Publish' }}
                  </button>
                </form>
              </div>
            @endcan
          @else
            <a href="{{ route('login') }}" class="text-sm underline">Log in</a>
            <span class="text-sm text-text-muted">om aan je watchlist toe te voegen</span>
          @endauth
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
