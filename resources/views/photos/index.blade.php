<x-layout>
    <h1>Photos</h1>
    <a href="{{route('photos.create')}}">Create photo</a>
    @foreach($photos as $photo)

        <x-photo-item :photo="$photo">
        </x-photo-item>

        @if ($photo->image)
            <img src="{{ asset($photo->image) }}" alt="{{ $photo->title }}"
                 style="width: 150px; height: auto;">
        @endif

        <p>Uploaded by: {{ $photo->user ? $photo->user->name : 'Unknown User' }}</p>
        <p>Category: {{ $photo->category->leagues ?? 'No Category' }}</p>
        <a href="{{ route('photos.show', $photo) }}">Show Details</a>

    @endforeach


</x-layout>


