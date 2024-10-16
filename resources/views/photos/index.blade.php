<x-layout>
    <h1>Photos</h1>
    <a href="{{route('photos.create')}}">Create photo</a>
    @foreach($photos as $photo)
        <x-photo-item :photo="$photo">

        </x-photo-item>
    @endforeach
</x-layout>


