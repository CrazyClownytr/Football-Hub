<x-layout>
    <h1>Photos</h1>
    @foreach($photos as $photo)
        <x-photo-item :photo="$photo">

        </x-photo-item>
    @endforeach

    {{--    delete--}}
    {{--    <form action="{{route('photos.destroy', $photo)}}" method="post">--}}
    {{--        @csrf--}}
    {{--        @method('DELETE')--}}
    {{--        <input type="submit" value="delete">--}}

    {{--    </form>--}}
</x-layout>

//hier geen loop
