<x-layout>
    <div class="container mx-auto py-12">

        <!-- Back to Original Post -->
        <div class="mb-4">
            <a href="{{ route('photos.show', ['photo' => $photo->id]) }}"
               class="text-blue-500 hover:underline">Back to Original Post</a>
        </div>

        <!-- Form Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-black">Edit Photo</h2>
            <p class="text-black-300">Update the form below to edit your post.</p>
        </div>

        <!-- Edit Photo Form -->
        <form action="{{ route('photos.update', $photo) }}" method="POST" enctype="multipart/form-data"
              class="bg-gray-800 p-8 rounded-lg shadow-lg">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-6">
                <x-input-label for="title" class="text-white">Title</x-input-label>
                <x-text-input name="title" id="title" value="{{ old('title', $photo->title) }}" class="w-full mt-1"/>
                @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <x-input-label for="description" class="text-white">Description</x-input-label>
                <textarea name="description" id="description"
                          class="w-full mt-1 rounded-md bg-gray-700 text-white h-24">{{ old('description', $photo->description) }}</textarea>
                @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-6">
                <x-input-label for="category_id" class="text-white">Category</x-input-label>
                <select name="category_id" id="category_id" class="w-full mt-1 rounded-md bg-gray-700 text-white">
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}" {{ old('category_id', $photo->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->leagues }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="mb-6">
                <x-input-label for="image" class="text-white">Image</x-input-label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full mt-1 rounded-md bg-gray-700 text-white">
                @if($photo->image)
                    <p class="mt-2">Current Image:</p>
                    <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}"
                         class="w-32 h-auto rounded-lg mt-2">
                @endif
                @error('image')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <x-primary-button type="submit"
                                  class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Update Post
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 mt-12 py-4 text-center border-t border-gray-200 dark:border-gray-700">
        <p class="text-gray-500 dark:text-gray-400">© 2024 Football Lovers. All rights reserved.</p>
    </footer>
</x-layout>
