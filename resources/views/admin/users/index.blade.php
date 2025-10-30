<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-8">
    <nav class="flex items-center text-sm text-text-muted mb-6">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-accent-gold transition">
            Admin dashboard
        </a>
        <span class="mx-2 text-text-muted/60">›</span>
        <span class="text-text-primary font-medium">Gebruikers</span>
    </nav>
        {{-- Titel + teller + zoek/filter --}}
        <div class="mb-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-semibold">Gebruikers</h1>
                    <span class="rounded-lg border border-surface bg-navbar/40 px-3 py-1.5 text-sm text-text-muted">
                        Totaal: {{ $users->total() }}
                    </span>
                </div>

                <form method="GET" action="{{ route('admin.users.index') }}" class="flex w-full md:w-auto items-center gap-2">
                    <div class="flex-1 md:w-64">
                        <label for="q" class="sr-only">Zoek</label>
                        <input
                            id="q"
                            type="text"
                            name="q"
                            value="{{ $q }}"
                            placeholder="Zoek op naam of e-mail…"
                            class="w-full rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-accent-gold focus:border-transparent"
                        />
                    </div>

                    <label for="role" class="sr-only">Rol</label>
                    <select id="role" name="role"
                            class="rounded-lg bg-surface border border-surface/80 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent-gold">
                        <option value="" @selected($role==='')>Alle rollen</option>
                        <option value="admin" @selected($role==='admin')>admin</option>
                        <option value="user"  @selected($role==='user')>user</option>
                    </select>

                    <button class="rounded-lg bg-accent-purple text-white px-4 py-2 text-sm hover:opacity-90">
                        Filteren
                    </button>

                    @if($q !== '' || $role !== '')
                        <a href="{{ route('admin.users.index') }}"
                           class="rounded-lg border border-surface px-3 py-2 text-sm hover:bg-surface">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            @if($q !== '' || $role !== '')
                <div class="mt-3 flex flex-wrap items-center gap-2 text-xs">
                    @if($q !== '')
                        <span class="rounded-md border border-surface bg-navbar/40 px-2 py-1">
                            Zoek: <strong>{{ $q }}</strong>
                        </span>
                    @endif
                    @if($role !== '')
                        <span class="rounded-md border border-surface bg-navbar/40 px-2 py-1">
                            Rol: <strong>{{ $role }}</strong>
                        </span>
                    @endif
                </div>
            @endif
        </div>

        {{-- Flash --}}
        @if (session('status'))
            <div class="mb-5 rounded-xl border border-surface bg-navbar/40 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        {{-- Tabelkaart --}}
        <div class="rounded-xl border border-surface bg-navbar/40 p-4">
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-separate border-spacing-y-2">
                    <thead class="sticky top-0 bg-navbar/70 backdrop-blur border-b border-surface/70">
                        <tr class="text-left text-text-muted">
                            <th class="px-4 py-2 font-medium">Gebruiker</th>
                            <th class="px-4 py-2 font-medium">E-mail</th>
                            <th class="px-4 py-2 font-medium">Rol</th>
                            <th class="px-4 py-2 font-medium text-right">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="rounded-lg bg-surface/10 hover:bg-surface/25 transition">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-surface text-xs font-semibold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $user->name }}</div>
                                            <div class="text-[11px] text-text-muted">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-text-muted">
                                    {{ $user->email }}
                                </td>

                                <td class="px-4 py-3">
                                    @if($user->role === 'admin')
                                        <span class="rounded-md bg-accent-purple/30 text-white px-2 py-0.5 text-xs">admin</span>
                                    @else
                                        <span class="rounded-md border border-surface px-2 py-0.5 text-xs">user</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-right">
                                    <form action="{{ route('admin.users.update-role', $user) }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <label for="role-{{ $user->id }}" class="sr-only">Rol</label>
                                        <select id="role-{{ $user->id }}" name="role"
                                            class="bg-surface border border-surface/70 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-accent-gold">
                                            <option value="user"  @selected($user->role==='user')>user</option>
                                            <option value="admin" @selected($user->role==='admin')>admin</option>
                                        </select>

                                        <button
                                            class="px-3 py-1.5 rounded-md bg-accent-purple text-white hover:opacity-90 text-xs">
                                            Opslaan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-surface/70">
                {{ $users->links() }}
            </div>
        </div>

    </div>
</x-app-layout>