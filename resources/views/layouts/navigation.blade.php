<nav x-data="{ open: false }" class="bg-navbar text-text-primary border-b border-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- Left: logo + name --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <x-application-logo class="block h-7 w-auto fill-current text-text-primary" />
                    <span class="font-semibold text-lg tracking-wide">CineMap</span>
                </a>
            </div>

            {{-- Center: search (desktop) --}}
            <div class="hidden md:block flex-1 max-w-xl mx-6">
                <form action="{{ route('titles.index') }}" method="GET">
                    <label class="sr-only" for="q">Zoek</label>
                    <div class="flex">
                        <input
                            id="q"
                            name="q"
                            type="text"
                            value="{{ request('q') }}"
                            placeholder="Zoek films of series…"
                            class="w-full rounded-l-lg bg-surface border border-surface/80 px-3 py-2 text-sm placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-accent-purple focus:border-transparent"
                        />
                        <button type="submit"
                            class="rounded-r-lg bg-accent-purple px-4 text-white text-sm hover:opacity-90 transition">
                            Zoeken
                        </button>
                    </div>
                </form>
            </div>

            {{-- Right: auth actions (desktop) --}}
            <div class="hidden sm:flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}"
                       class="px-3 py-2 rounded-lg bg-accent-purple hover:opacity-90 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-3 py-2 rounded-lg border border-surface hover:bg-surface transition">
                       Maak account
                    </a>
                @endguest

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-surface hover:bg-surface transition">
                                <span class="text-sm">{{ auth()->user()->name }}</span>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <div class="sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md hover:bg-surface focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-surface">
        <div class="px-4 py-3 space-y-3">
            {{-- Mobile search --}}
            <form action="{{ route('titles.index') }}" method="GET">
                <label class="sr-only" for="q-mobile">Zoek</label>
                <div class="flex">
                    <input
                        id="q-mobile"
                        name="q"
                        type="text"
                        value="{{ request('q') }}"
                        placeholder="Zoek films of series…"
                        class="w-full rounded-l-lg bg-surface border border-surface/80 px-3 py-2 text-sm placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-accent-gold focus:border-transparent"
                    />
                    <button type="submit"
                        class="rounded-r-lg bg-accent-purple px-4 text-white text-sm hover:opacity-90 transition">
                        Zoeken
                    </button>
                </div>
            </form>

            @guest
                <div class="flex gap-2">
                    <a href="{{ route('login') }}" class="flex-1 px-3 py-2 rounded-lg bg-accent-purple text-center">Login</a>
                    <a href="{{ route('register') }}" class="flex-1 px-3 py-2 rounded-lg border border-surface text-center">Maak account</a>
                </div>
            @endguest

            @auth
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md hover:bg-surface">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="px-3 py-2">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-md bg-accent-gold text-background">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>
