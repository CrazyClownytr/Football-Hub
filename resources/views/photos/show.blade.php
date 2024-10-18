<x-layout>
    <h1>{{ $photo->title }}</h1>
    <p>{{ $photo->description }}</p>

    <p>Uploaded by: {{ $photo->user ? $photo->user->name : 'Unknown User' }}</p>
    <p>Category: {{ $photo->category ? $photo->category->leagues : 'No Category' }}</p>
    @if ($photo->image)
        <img src="{{ asset($photo->image) }}" alt="{{ $photo->title }}"
             style="width: 150px; height: auto;">
    @endif

    {{-- Delete button --}}
    <form action="{{ route('photos.destroy', $photo) }}" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete">
    </form>

    <a href="{{ route('photos.index') }}">Back to Photos List</a>
</x-layout>

