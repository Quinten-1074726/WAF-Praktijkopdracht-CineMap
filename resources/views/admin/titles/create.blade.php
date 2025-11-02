<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-8">
        <nav class="text-sm text-text-muted mb-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-accent-gold">Admin dashboard</a>
            <span class="mx-2">›</span>
            <a href="{{ route('admin.titles.index') }}" class="hover:text-accent-gold">Titels</a>
            <span class="mx-2">›</span>
            <span class="text-text-primary font-medium">Nieuwe titel</span>
        </nav>

        <h1 class="text-2xl font-semibold mb-4">Nieuwe titel</h1>

        <form method="POST" action="{{ route('admin.titles.store') }}" enctype="multipart/form-data">
            @include('admin.titles._form', [
                'title' => new \App\Models\Title,
                'platforms' => $platforms,
                'genres' => $genres,
            ])
        </form>
    </div>
</x-app-layout>
