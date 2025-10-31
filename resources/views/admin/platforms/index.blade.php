<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-8">

        {{-- Breadcrumbs --}}
        <nav class="flex items-center text-sm text-text-muted mb-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-accent-gold transition">
                Admin dashboard
            </a>
            <span class="mx-2 text-text-muted/60">›</span>
            <span class="text-text-primary font-medium">Platforms</span>
        </nav>

        <div class="mb-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-semibold">Platforms</h1>
                    <span class="rounded-lg border border-surface bg-navbar/40 px-3 py-1.5 text-sm text-text-muted">
                        Totaal: {{ $platforms->total() }}
                    </span>
                </div>

                <form method="GET" action="{{ route('admin.platforms.index') }}" class="flex w-full md:w-auto items-center gap-2">
                    <div class="flex-1 md:w-64">
                        <label for="q" class="sr-only">Zoek</label>
                        <input
                            id="q"
                            type="text"
                            name="q"
                            value="{{ $q }}"
                            placeholder="Zoek op platformnaam…"
                            class="w-full rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-accent-gold focus:border-transparent"
                        />
                    </div>

                    <button class="rounded-lg bg-accent-purple text-white px-4 py-2 text-sm hover:opacity-90">
                        Filteren
                    </button>

                    @if(($q ?? '') !== '')
                        <a href="{{ route('admin.platforms.index') }}"
                           class="rounded-lg border border-surface px-3 py-2 text-sm hover:bg-surface">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="mt-3">
                <a href="{{ route('admin.platforms.create') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-accent-purple text-white px-4 py-2 text-sm hover:opacity-90">
                    + Nieuw platform
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-5 rounded-xl border border-surface bg-navbar/40 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        {{-- Tabel --}}
        <div class="rounded-xl border border-surface bg-navbar/40 p-4">
            @if($platforms->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-separate border-spacing-y-2">
                        <thead class="sticky top-0 bg-navbar/70 backdrop-blur border-b border-surface/70">
                            <tr class="text-left text-text-muted">
                                <th class="px-4 py-2 font-medium">Platform</th>
                                <th class="px-4 py-2 font-medium">Aantal titels</th>
                                <th class="px-4 py-2 font-medium text-right w-56">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($platforms as $p)
                                <tr class="rounded-lg bg-surface/10 hover:bg-surface/25 transition">
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $p->name }}</div>
                                        <div class="text-[11px] text-text-muted">ID: {{ $p->id }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-text-muted">
                                        {{ $p->titles_count }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('admin.platforms.edit', $p) }}"
                                               class="px-3 py-1.5 rounded-md border border-surface hover:bg-surface text-xs">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.platforms.destroy', $p) }}" method="POST"
                                                  onsubmit="return confirm('Weet je zeker dat je dit platform wilt verwijderen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-3 py-1.5 rounded-md bg-red-600/30 text-red-100 text-xs">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 border-t border-surface/70">
                    {{ $platforms->links() }}
                </div>
            @else
                <div class="text-sm text-text-muted px-2 py-4">
                    Geen platforms gevonden.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
