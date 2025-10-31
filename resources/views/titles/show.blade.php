<x-app-layout>
    <div class="max-w-5xl mx-auto px-6 py-8">
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}"
           class="text-sm text-text-muted hover:text-accent-gold">← Terug naar overzicht</a>

        <div class="mt-4 grid gap-6 md:grid-cols-[220px,1fr]">
            {{-- Poster --}}
            <div class="rounded-xl overflow-hidden border border-surface bg-navbar/40">
                <img src="{{ $title->image_url }}" alt="{{ $title->title }}" class="w-full object-cover">
            </div>

            {{-- Info --}}
            <div class="rounded-xl border border-surface bg-navbar/40 p-6">
                <h1 class="text-2xl font-bold">{{ $title->title }}</h1>
                <div class="mt-1 text-sm text-text-muted">
                    {{ ucfirst($title->type) }} : {{ $title->year ?? 'n/a' }} : {{ $title->platform?->name }}
                </div>
                <p class="mt-4">{{ $title->description ?? 'Geen beschrijving.' }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
