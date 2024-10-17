<x-layout>
    <h1>Photos</h1>
    <a href="{{route('photos.create')}}">Create photo</a>
    @foreach($photos as $photo)
        <x-photo-item :photo="$photo">
        </x-photo-item>
        <p>Uploaded by: {{ $photo->user ? $photo->user->name : 'Unknown User' }}</p>
        <p>Category: {{ $photo->category->leagues ?? 'No Category' }}</p>
    @endforeach


</x-layout>


