<x-app-layout>
    <form action="{{route('photos.store')}}" method="post">
        @csrf
        {{--        <label for="name">Name</label>--}}
        {{--        <input id="name" name="title">
        vraag waar van de form moet corresponderen met database--}}
        <x-input-label for="title">Title</x-input-label>
        <x-text-input name="title" id="title"></x-text-input>

        <x-input-label for="description">Description</x-input-label>
        <textarea name="description" id="description"></textarea>

        <x-input-label for="category_id">Category</x-input-label>
        <select name="category_id" id="category_id" required>
            <option value="">Select a category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->leagues }}</option>
            @endforeach
        </select>

        {{--        <button type="submit">Submit</button>--}}
        <x-primary-button type="submit">Submit</x-primary-button>
    </form>
</x-app-layout>
