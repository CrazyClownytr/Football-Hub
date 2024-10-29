<x-app-layout>
    <div class="container mx-auto py-12 bg-green-900 rounded-lg shadow-lg">

        <!-- Back to All Uploads -->
        <div class="flex justify-between items-center mb-8 px-6">
            <a href="{{ route('photos.index') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Back to All Uploads
            </a>
        </div>

        <!-- Photo Details -->
        <div class="photo-item border border-gray-300 rounded-lg p-6 bg-white shadow-md">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $photo->title }}</h1>

            @if ($photo->image)
                <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}"
                     class="max-w-full h-auto rounded-lg mb-4 shadow-md">
            @endif

            <p class="text-gray-700 mb-4">{{ $photo->description }}</p>

            <div class="text-gray-600">
                <p>Uploaded by: {{ $photo->user ? $photo->user->name : 'Unknown User' }}</p>
                <p>Category: {{ $photo->category ? $photo->category->leagues : 'No Category' }}</p>
            </div>
        </div>

        <!-- Edit and Delete Actions -->
        <div class="flex space-x-4 mt-6">
            <!-- Edit Button -->
            <a href="{{ route('photos.edit', $photo) }}"
               class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                Edit Your Post
            </a>

            <!-- Delete Button -->
            <form action="{{ route('photos.destroy', $photo) }}" method="post"
                  onsubmit="return confirm('Are you sure you want to delete this photo?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Delete
                </button>
            </form>
        </div>

        <!-- Navigation Links -->
        <div class="flex justify-center space-x-4 mt-8">
            <a href="{{ route('photos.index') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Back to Photos List
            </a>
            <a href="{{ route('home') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Back to Home Page
            </a>
        </div>
    </div>

</x-app-layout>
