<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-8">
        {{-- Titel + teller --}}
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Gebruikers</h1>
            <span class="rounded-lg border border-surface bg-navbar/40 px-3 py-1.5 text-sm text-text-muted">
                Totaal: {{ $users->total() }}
            </span>
        </div>

        {{-- Flash message --}}
        @if (session('status'))
            <div class="mb-5 rounded-xl border border-surface bg-navbar/40 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        {{-- Table container --}}
        <div class="rounded-xl border border-surface bg-navbar/40 p-4">
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-left text-text-muted border-b border-surface/70">
                            <th class="px-4 py-2 font-medium">Gebruiker</th>
                            <th class="px-4 py-2 font-medium">E-mail</th>
                            <th class="px-4 py-2 font-medium">Rol</th>
                            <th class="px-4 py-2 font-medium text-right">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="rounded-lg bg-surface/10 hover:bg-surface/25 transition">
                                {{-- Gebruiker + avatar --}}
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

                                {{-- E-mail --}}
                                <td class="px-4 py-3 text-text-muted">
                                    {{ $user->email }}
                                </td>

                                {{-- Rol --}}
                                <td class="px-4 py-3">
                                    @if($user->role === 'admin')
                                        <span class="rounded-md bg-accent-purple/30 text-white px-2 py-0.5 text-xs">admin</span>
                                    @else
                                        <span class="rounded-md border border-surface px-2 py-0.5 text-xs">user</span>
                                    @endif
                                </td>

                                {{-- Acties --}}
                                <td class="px-4 py-3 text-right">
                                    <form action="{{ route('admin.users.update-role', $user) }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <select name="role"
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

            {{-- Pagination --}}
            <div class="px-4 py-3 border-t border-surface/70">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
