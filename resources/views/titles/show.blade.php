<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">{{ $title->title }}</h2>
  </x-slot>

  <p class="mb-2 text-gray-700">{{ $title->description ?? 'Geen beschrijving.' }}</p>
  <p class="text-sm text-gray-600">
    Type: {{ ucfirst($title->type) }} Jaar: {{ $title->year ?? 'n/a' }}
  </p>

  <a class="underline mt-4 inline-block" href="{{ route('titles.index') }}">← Terug</a>
</x-app-layout>
