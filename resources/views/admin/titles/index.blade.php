<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-8">

        {{-- Breadcrumbs --}}
        <nav class="flex items-center text-sm text-text-muted mb-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-accent-gold transition">
                Admin dashboard
            </a>
            <span class="mx-2 text-text-muted/60">›</span>
            <span class="text-text-primary font-medium">Titels</span>
        </nav>

        <div class="mb-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-semibold">Titels</h1>
                    <span class="rounded-lg border border-surface bg-navbar/40 px-3 py-1.5 text-sm text-text-muted">
                        Totaal: {{ $titles->total() }}
                    </span>
                </div>

                <form method="GET" action="{{ route('admin.titles.index') }}" class="flex w-full md:w-auto items-center gap-2">
                    <div class="flex-1 md:w-64">
                        <label for="q" class="sr-only">Zoek</label>
                        <input
                            id="q"
                            type="text"
                            name="q"
                            value="{{ $q }}"
                            placeholder="Zoek op titel of beschrijving…"
                            class="w-full rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-accent-gold focus:border-transparent"
                        />
                    </div>

                    <label for="filter" class="sr-only">Filter</label>
                    <select id="filter" name="filter"
                            class="rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent-gold">
                        <option value="" @selected($filter==='')>Alle</option>
                        <option value="unpublished" @selected($filter==='unpublished')>Ongepubliceerd</option>
                    </select>

                    <button class="rounded-lg bg-accent-purple text-white px-4 py-2 text-sm hover:opacity-90">
                        Filteren
                    </button>

                    @if(($q ?? '') !== '' || ($filter ?? '') !== '')
                        <a href="{{ route('admin.titles.index') }}"
                           class="rounded-lg border border-surface px-3 py-2 text-sm hover:bg-surface">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="mt-3">
                <a href="{{ route('admin.titles.create') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-accent-purple text-white px-4 py-2 text-sm hover:opacity-90">
                    Nieuwe titel
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
            @if($titles->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-separate border-spacing-y-2">
                        <thead class="sticky top-0 bg-navbar/70 backdrop-blur border-b border-surface/70">
                            <tr class="text-left text-text-muted">
                                <th class="px-4 py-2 font-medium">Titel</th>
                                <th class="px-4 py-2 font-medium">Jaar</th>
                                <th class="px-4 py-2 font-medium">Type</th>
                                <th class="px-4 py-2 font-medium">Platform</th>
                                <th class="px-4 py-2 font-medium">Aangemaakt door</th>
                                <th class="px-4 py-2 font-medium">Status</th>
                                <th class="px-4 py-2 font-medium text-right w-64">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($titles as $t)
                                <tr class="rounded-lg bg-surface/10 hover:bg-surface/25 transition">
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $t->title }}</div>
                                        <div class="text-[11px] text-text-muted">ID: {{ $t->id }}</div>
                                    </td>

                                    {{-- Jaar --}}
                                    <td class="px-4 py-3">
                                        {{ $t->year ?? 'n/a' }}
                                    </td>

                                    {{-- Type --}}
                                    <td class="px-4 py-3">
                                        {{ ucfirst($t->type) }} 
                                    </td>

                                    {{-- Platform --}}
                                    <td class="px-4 py-3">
                                        {{ $t->platform?->name ?? '—' }}
                                    </td>

                                    {{-- User --}}
                                    <td class="px-4 py-3">
                                        {{ $t->user?->name ?? '—' }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-4 py-3">
                                        @if($t->is_published)
                                            <span class="rounded-md bg-green-600/25 text-green-200 px-2 py-0.5 text-xs">Published</span>
                                        @else
                                            <span class="rounded-md bg-yellow-600/25 text-yellow-200 px-2 py-0.5 text-xs">Draft</span>
                                        @endif
                                    </td>

                                    {{-- Acties --}}
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('admin.titles.edit', $t) }}"
                                               class="px-3 py-1.5 rounded-md border border-surface hover:bg-surface text-xs">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.titles.toggle-publish', $t) }}" method="POST">
                                                @csrf
                                                <button
                                                    class="px-3 py-1.5 rounded-md text-xs
                                                        {{ $t->is_published ? 'bg-yellow-600/30 text-yellow-100' : 'bg-green-600/30 text-green-100' }}">
                                                    {{ $t->is_published ? 'Unpublish' : 'Publish' }}
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.titles.destroy', $t) }}" method="POST"
                                                  onsubmit="return confirm('Weet je zeker dat je deze titel wilt verwijderen?');">
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
                    {{ $titles->links() }}
                </div>
            @else
                <div class="text-sm text-text-muted px-2 py-4">
                    Geen titels gevonden.
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
