@csrf

<div class="grid gap-4 sm:grid-cols-2">
    {{-- Titel --}}
    <div class="sm:col-span-2">
        <label class="text-sm">Titel <span class="text-red-400">*</span></label>
        <input type="text" name="title" required
               value="{{ old('title', $title->title ?? '') }}"
               class="mt-1 w-full bg-surface border border-surface/80 rounded-md px-3 py-2">
        @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Type --}}
    <div>
        <label class="text-sm">Type <span class="text-red-400">*</span></label>
        <select name="type" required
                class="mt-1 w-full bg-surface border border-surface/80 rounded-md px-3 py-2">
            <option value="movie"  @selected(old('type', $title->type ?? '') === 'movie')>Film</option>
            <option value="series" @selected(old('type', $title->type ?? '') === 'series')>Serie</option>
        </select>
        @error('type') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Jaar --}}
    <div>
        <label class="text-sm">Jaar <span class="text-red-400">*</span></label>
        <input type="number" name="year" required min="1900" max="2100"
               value="{{ old('year', $title->year ?? '') }}"
               class="mt-1 w-full bg-surface border border-surface/80 rounded-md px-3 py-2">
        @error('year') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Platform --}}
    <div>
        <label class="text-sm">Platform <span class="text-red-400">*</span></label>
        <select name="platform_id" required
                class="mt-1 w-full bg-surface border border-surface/80 rounded-md px-3 py-2">
            @foreach($platforms as $p)
                <option value="{{ $p->id }}" @selected(old('platform_id', $title->platform_id ?? null) == $p->id)>
                    {{ $p->name }}
                </option>
            @endforeach
        </select>
        @error('platform_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Gepubliceerd --}}
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_published" value="1"
               @checked(old('is_published', $title->is_published ?? false))>
        <span class="text-sm">Gepubliceerd</span>
    </div>

    {{-- Beschrijving --}}
    <div class="sm:col-span-2">
        <label class="text-sm">Beschrijving <span class="text-red-400">*</span></label>
        <textarea name="description" rows="4" required maxlength="1000"
                  class="mt-1 w-full bg-surface border border-surface/80 rounded-md px-3 py-2">{{ old('description', $title->description ?? '') }}</textarea>
        @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Poster / Afbeelding  --}}
    <div class="sm:col-span-2"
         x-data="imagePicker('{{ isset($title) && $title->image ? $title->image_url : '' }}')">
        <label class="text-sm">Poster / Afbeelding
            <span class="text-text-muted text-xs">(jpg, jpeg, png, webp — max 2MB)</span>
        </label>

        <input id="image" type="file" name="image" accept="image/*"
               @change="fileChosen($event)"
               class="mt-1 block w-full bg-surface border border-surface/80 rounded-md px-3 py-2 text-sm">
        @error('image') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror

        <div class="mt-3 flex items-start gap-3">
            <div class="h-40 w-28 rounded-md border border-surface/70 bg-surface/40 flex items-center justify-center overflow-hidden">
                <img x-show="preview || current" x-cloak
                     :src="preview || current" alt="Poster preview"
                     class="h-full w-full object-cover">
                <span x-show="!preview && !current" x-cloak class="text-[11px] text-text-muted px-2 text-center">
                    Nog geen afbeelding
                </span>
            </div>
            <div class="text-xs text-text-muted space-y-2">
                <p x-show="preview" x-cloak>Voorbeeld (nog niet opgeslagen)</p>
                <p x-show="!preview && current" x-cloak>Huidige afbeelding</p>
                <div class="flex gap-2">
                    <button type="button" @click="clear()"
                            class="px-3 py-1 rounded-md border border-surface hover:bg-surface">
                        Verwijderen
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Genres  --}}
    @php
        $selectedGenres = collect(old('genres', isset($title) ? $title->genres->pluck('id')->all() : []));
    @endphp
    <div class="sm:col-span-2">
        <label class="block text-sm mb-1">Genres <span class="text-red-400">*</span></label>

        {{-- verborgen required input – zorgt dat er minimaal 1 checkbox gekozen moet zijn --}}
        <input type="text" tabindex="-1" autocomplete="off"
               onfocus="this.blur()" required
               class="sr-only peer" style="position:absolute;opacity:0;height:0;width:0;padding:0;border:0">

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-2">
            @foreach($genres as $g)
                <label class="inline-flex items-center gap-2 rounded-md border border-surface/70 bg-surface px-3 py-2 text-sm">
                    <input type="checkbox" name="genres[]" value="{{ $g->id }}"
                           @checked($selectedGenres->contains($g->id))>
                    <span>{{ $g->name }}</span>
                </label>
            @endforeach
        </div>

        @error('genres')   <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        @error('genres.*') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        <p class="text-[11px] text-text-muted mt-1">Kies minimaal 1 genre.</p>
    </div>
</div>

<div class="mt-6">
    <button class="bg-accent-purple text-white px-4 py-2 rounded-lg hover:opacity-90">Opslaan</button>
</div>

@push('scripts')
<script>

window.imagePicker = function (initialUrl = '') {
    return {
        current: initialUrl,  
        preview: null,       

        fileChosen(e) {
            const file = e.target.files && e.target.files[0];
            if (!file) { this.preview = null; return; }

            const okType = ['image/jpeg', 'image/png', 'image/webp'].includes(file.type);
            if (!okType) {
                alert('Alleen jpg, png of webp toegestaan.');
                e.target.value = '';
                this.preview = null;
                return;
            }
            this.preview = URL.createObjectURL(file);
        },

        clear() {
            this.preview = null;
            const input = document.getElementById('image');
            if (input) input.value = '';
        }
    };
};
</script>
@endpush

