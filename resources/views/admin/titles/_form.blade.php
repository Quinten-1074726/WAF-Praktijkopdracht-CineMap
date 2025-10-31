@csrf

<div class="grid gap-4 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label class="text-sm">Titel</label>
        <input type="text" name="title" value="{{ old('title', $title->title ?? '') }}"
               class="mt-1 w-full bg-surface border border-surface/80 rounded-md px-3 py-2">
        @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm">Type</label>
        <select name="type" class="mt-1 w-full bg-surface border border-surface/80 rounded-md px-3 py-2">
            <option value="movie" @selected(old('type', $title->type ?? '') === 'movie')>Film</option>
            <option value="series" @selected(old('type', $title->type ?? '') === 'series')>Serie</option>
        </select>
        @error('type') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm">Jaar</label>
        <input type="number" name="year" value="{{ old('year', $title->year ?? '') }}"
               class="mt-1 w-full bg-surface border border-surface/80 rounded-md px-3 py-2">
        @error('year') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm">Platform</label>
        <select name="platform_id" class="mt-1 w-full bg-surface border border-surface/80 rounded-md px-3 py-2">
            @foreach($platforms as $p)
                <option value="{{ $p->id }}" @selected(old('platform_id', $title->platform_id ?? null) == $p->id)>
                    {{ $p->name }}
                </option>
            @endforeach
        </select>
        @error('platform_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_published" value="1"
               @checked(old('is_published', $title->is_published ?? false))>
        <span class="text-sm">Gepubliceerd</span>
    </div>

    <div class="sm:col-span-2">
        <label class="text-sm">Beschrijving</label>
        <textarea name="description" rows="4"
                  class="mt-1 w-full bg-surface border border-surface/80 rounded-md px-3 py-2">{{ old('description', $title->description ?? '') }}</textarea>
        @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    
    <div class="sm:col-span-2">
        <label class="text-sm">Poster / Afbeelding</label>
        <input type="file" name="image" accept="image/*"
                class="mt-1 block w-full bg-surface border border-surface/80 rounded-md px-3 py-2 text-sm">
        @error('image') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror

        @isset($title)
            @if($title->image)
                <div class="mt-2">
                    <img src="{{ $title->image_url }}" alt="Huidige poster" class="h-32 rounded-md object-cover">
                </div>
            @endif
        @endisset
    </div>

</div>


<div class="mt-6">
    <button class="bg-accent-purple text-white px-4 py-2 rounded-lg hover:opacity-90">Opslaan</button>
</div>
