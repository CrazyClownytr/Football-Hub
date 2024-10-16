<x-layout>
    <h1>Photos</h1>
    @foreach($photos as $photo)
        <x-photo-item :photo="$photo">

        </x-photo-item>
    @endforeach
</x-layout>
