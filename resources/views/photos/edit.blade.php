<x-app-layout>
    @if(auth()->id()=== $photo->user_id)
        <h1>Edit Photo</h1>
        <form action="{{ route('photos.update', $photo) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-input-label for="title">Title</x-input-label>
            <x-text-input name="title" id="title" value="{{ old('title', $photo->title) }}"></x-text-input>
            @error('title')
            <span>{{ $message }}</span>
            @enderror

            <x-input-label for="description">Description</x-input-label>
            <textarea name="description" id="description">{{ old('description', $photo->description) }}</textarea>
            @error('description')
            <span>{{ $message }}</span>
            @enderror

            <x-input-label for="category_id">Category</x-input-label>
            <select name="category_id" id="category_id">
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $photo->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->leagues }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
            <span>{{ $message }}</span>
            @enderror

            <x-input-label for="image">Image</x-input-label>
            <input type="file" name="image" id="image" accept="image/*">
            @if($photo->image)
                <p>Current Image:</p>
                <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}"
                     style="width: 150px; height: auto;">
            @endif
            @error('image')
            <span>{{ $message }}</span>
            @enderror

            <x-primary-button type="submit">Update Photo</x-primary-button>
        </form>
    @endif
</x-app-layout>
