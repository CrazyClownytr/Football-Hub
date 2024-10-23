<x-layout>
    <h1>Photos</h1>
    <a href="{{ route('photos.create') }}">Create photo</a>

    <form method="GET" action="{{ route('photos.index') }}">
        <label for="category">Filter by Category:</label>
        <select name="category" id="category">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->leagues }}
                </option>
            @endforeach
        </select>
        <button type="submit">Filter</button>
    </form>

    <form method="GET" action="{{ route('photos.index') }}">
        <label for="search">Search Photos:</label>
        <input type="text" name="search" id="search" value="{{ request('search') }}"
               placeholder="Search by title or description">
        <button type="submit">Search</button>
    </form>

    @foreach($photos as $photo)
        <div class="photo-item">
            @if ($photo->image)
                <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}">
            @endif
            <h2>{{ $photo->title }}</h2>
            <p>Uploaded by: {{ $photo->user ? $photo->user->name : 'Unknown User' }}</p>
            <p>Category: {{ $photo->category->leagues ?? 'No Category' }}</p>
            <a href="{{ route('photos.show', $photo) }}">Show details of {{ $photo->title }}</a>
        </div>
    @endforeach
</x-layout>
