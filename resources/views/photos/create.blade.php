<x-layout>
    <div class="container mx-auto py-12">

        <!-- Back to All Uploads -->
        <div class="mb-4">
            <a href="{{ route('photos.index') }}"
               class="text-blue-500 hover:underline">Back to All Uploads</a>
        </div>

        <!-- Form Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-black">Create New Post</h2>
            <p class="text-black-300">Fill out the form below to upload your post.</p>
        </div>

        <!-- Create Photo Form -->
        <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-gray-800 p-8 rounded-lg shadow-lg">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <x-input-label for="title" class="text-white">Title</x-input-label>
                <x-text-input name="title" id="title" value="{{ old('title') }}" class="w-full mt-1"/>
                @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <x-input-label for="description" class="text-white">Description</x-input-label>
                <textarea name="description" id="description"
                          class="w-full mt-1 rounded-md bg-gray-700 text-white h-24">{{ old('description') }}</textarea>
                @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-6">
                <x-input-label for="category_id" class="text-white">Category</x-input-label>
                <select name="category_id" id="category_id" class="w-full mt-1 rounded-md bg-gray-700 text-white"
                        required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                @error('image')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <x-primary-button type="submit"
                                  class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Submit
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 mt-12 py-4 text-center border-t border-gray-200 dark:border-gray-700">
        <p class="text-gray-500 dark:text-gray-400">© 2024 Football Lovers. All rights reserved.</p>
    </footer>
</x-layout>
