<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-8">
      <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}"
        class="text-sm text-text-muted hover:text-accent-gold">
        ← Terug naar overzicht
      </a>
        <div class="mt-4 rounded-xl border border-surface bg-navbar/40 p-6">
            <h1 class="text-2xl font-bold">{{ $title->title }}</h1>
            <div class="mt-1 text-sm text-text-muted">
                {{ ucfirst($title->type) }} • {{ $title->year ?? 'n/a' }} • {{ $title->platform?->name }}
            </div>
            <p class="mt-4">{{ $title->description ?? 'Geen beschrijving.' }}</p>
        </div>
    </div>
</x-app-layout>
