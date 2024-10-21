<x-layout>
    <h1>Photos</h1>
    <a href="{{ route('photos.create') }}">Create photo</a>

    @foreach($photos as $photo)
        <div class="photo-item">

            @if ($photo->trashed())
                <!-- Als de foto soft deleted is -->
                <p>{{ $photo->title }} - This post has been deleted.</p>
                <form action="{{ route('photos.restore', $photo) }}" method="post">
                    @csrf
                    <input type="submit" value="Restore">
                </form>
            @else
                <!-- Normale weergave voor niet-verwijderde foto's -->
                <h2>{{ $photo->title }}</h2>

                @if ($photo->image)
                    <img src="{{ asset($photo->image) }}" alt="{{ $photo->title }}" style="width: 150px; height: auto;">
                @endif

                <p>Uploaded by: {{ $photo->user ? $photo->user->name : 'Unknown User' }}</p>
                <p>Category: {{ $photo->category->leagues ?? 'No Category' }}</p>
                <a href="{{ route('photos.show', $photo) }}">Show details of {{$photo->title}}</a>
            @endif
        </div>
    @endforeach
</x-layout>
