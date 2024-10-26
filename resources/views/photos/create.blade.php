<x-app-layout>
    <form action="{{route('photos.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        {{--        <label for="name">Name</label>--}}
        {{--        <input id="name" name="title">
        vraag waar van de form moet corresponderen met database--}}
        <x-input-label for="title">Title</x-input-label>
        <x-text-input name="title" id="title" value="{{old('title')}}"></x-text-input>
        @error('title')
        <span>
         {{$message}}
        </span>
        @enderror
        <x-input-label for="description">Description</x-input-label>
        <textarea name="description" id="description">{{ old('description') }}</textarea>
        @error('description')
        <span>
         {{$message}}
        </span>
        @enderror
        <x-input-label for="category_id">Category</x-input-label>
        <select name="category_id" id="category_id" required>
            <option value="">Select a category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->leagues }}
                </option>
            @endforeach
        </select>

        <x-input-label for="image">Image</x-input-label>
        <input type="file" name="image" id="image" accept="image/*">
        @error('image')
        <span>
         {{$message}}
        </span>
        @enderror

        {{--        <button type="submit">Submit</button>--}}
        <x-primary-button type="submit">Submit</x-primary-button>
    </form>
</x-app-layout>
