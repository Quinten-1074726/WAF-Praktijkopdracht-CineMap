<x-app-layout>
    <H1 class="block text-2xl font-medium text-gray-400" >Voeg Titel</H1>
    <form method="POST" action="{{ route('titles.store') }}" class="space-y-4">
        @csrf
<form method="POST" action="{{ route('titles.store') }}" class="space-y-4">
    @csrf

    <div>
      <label for="title" class="block text-sm font-medium text-gray-400">Title</label>
      <input
        type="text" name="title" id="title"
        value="{{ old('title') }}"
        class="mt-1 block w-full border @error('title') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      @error('title')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div>
      <label for="description" class="block text-sm font-medium text-gray-400">Beschrijving</label>
      <textarea
        name="description" id="description" rows="3"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description') }}</textarea>
      @error('description')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div>
      <label for="type" class="block text-sm font-medium text-gray-400">Type</label>
      <select
        name="type" id="type"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
        <option value="movie"  @selected(old('type') === 'movie')>Film</option>
        <option value="series" @selected(old('type') === 'series')>Serie</option>
      </select>
      @error('type')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div>
      <label for="year" class="block text-sm font-medium text-gray-400">Jaar</label>
      <input
        type="number" name="year" id="year" value="{{ old('year') }}"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      @error('year')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div>
      <label for="is_published" class="inline-flex items-center gap-2 text-sm font-medium text-gray-400">
        <input type="checkbox" name="is_published" id="is_published"
               value="1" @checked(old('is_published'))>
        Gepubliceerd
      </label>
      @error('is_published')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-400">
        Opslaan
      </button>
    </div>
  </form>
</x-app-layout>
