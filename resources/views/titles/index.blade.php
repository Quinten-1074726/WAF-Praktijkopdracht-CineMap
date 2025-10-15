<x-app-layout>
  <x-slot name="header">

    <h2 class="font-semibold text-xl">CineMap – Films & Series</h2>
  </x-slot>

  <div class="space-y-3">
    @forelse($titles as $t)
      <a href="{{ route('titles.show',$t) }}" class="block p-4 border text-white rounded hover:bg-gray-50">
        <div class="font-semibold">{{ $t->title }}</div>
        <div class="text-sm text-gray-600">{{ ucfirst($t->type) }} {{ $t->year ?? 'n/a' }}</div>
      </a>
    @empty
      <p class="text-gray-600">Nog geen titels.</p>
    @endforelse
      <a href="{{ route('titles.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Voeg Title</a>
    <div>{{ $titles->links() }}</div>
  </div>
</x-app-layout>
