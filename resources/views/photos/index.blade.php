<x-layout>
    <h1>Photos</h1>
    <a href="{{ route('home') }}">Back To Home Page</a>
    <a href="{{ route('photos.create') }}">Create photo</a>
    @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('admin.photos-index') }}"
           class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
            Admin Page
        </a>
    @endif

    {{--//non ingelogde gebruiker--}}
    @if(session('message'))
        <div class="alert alert-warning">
            {{ session('message') }}
        </div>
    @endif

    {{--    //like updates--}}
    @if (session('message'))
        <div class="alert alert-warning">
            {{ session('message') }}
        </div>
    @endif

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
        </select>-
        <button type="submit">Click to Filter</button>
    </form>

    <form method="GET" action="{{ route('photos.index') }}">
        <label for="search">Search Posts:</label>
        <input type="text" name="search" id="search" value="{{ request('search') }}"
               placeholder="Search by title or description">
        <button type="submit">Search</button>
    </form>

    @foreach($photos as $photo)

        @if ($photo->likes->contains('user_id', auth()->id()))
            <form action="{{ route('photos.unlike', $photo) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Unlike</button>
            </form>
        @else
            <form action="{{ route('photos.like', $photo) }}" method="POST">
                @csrf
                <button type="submit">Like</button>
            </form>
        @endif

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
