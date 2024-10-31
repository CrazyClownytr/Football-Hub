<x-app-layout>
    <div class="container mx-auto py-12 bg-white rounded-lg shadow-lg">

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4 mb-6 px-6">
            <a href="{{ route('home') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Back To Home Page
            </a>
            <a href="{{ route('photos.index') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                View All Uploads
            </a>
            <a href="{{ route('photos.create') }}"
               class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                Create Photo
            </a>
            @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('admin.photos-index') }}"
                   class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Admin Page
                </a>
            @endif
        </div>

        @if(session('message'))
            <div class="bg-yellow-500 text-white p-4 rounded-md mb-4 text-center">
                {{ session('message') }}
            </div>
        @endif

        <!-- Search and Filter -->
        <div class="mb-8 text-center">
            <form method="GET" action="{{ route('photos.index') }}" class="flex justify-center space-x-4 mb-4">
                <div>
                    <label for="category" class="text-gray-800 font-semibold">Filter by Category:</label>
                    <select name="category" id="category"
                            class="bg-gray-200 text-gray-800 rounded-md border border-gray-300">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->leagues }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Click to Filter
                </button>
            </form>

            <form method="GET" action="{{ route('photos.index') }}" class="flex justify-center space-x-4">
                <label for="search" class="text-gray-800 font-semibold">Search Posts:</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       placeholder="Search by title or description"
                       class="px-3 py-2 border border-black-300 rounded-md text-black">
                <button type="submit"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Search
                </button>
            </form>

        </div>

        <!-- Centered Photo List -->
        <div class="flex flex-wrap justify-center">
            @foreach($photos as $photo)
                <div class="photo-item border border-gray-300 rounded-lg p-4 m-2 bg-gray-100 shadow-md w-80">
                    @if ($photo->image)
                        <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}"
                             class="max-w-full h-auto rounded-lg mb-2">
                    @endif
                    <h2 class="text-xl font-bold text-gray-800">{{ $photo->title }}</h2>
                    <p class="text-gray-600">Uploaded by: {{ $photo->user ? $photo->user->name : 'Unknown User' }}</p>
                    <p class="text-gray-600">Category: {{ $photo->category->leagues ?? 'No Category' }}</p>
                    <a href="{{ route('photos.show', $photo) }}" class="text-blue-600 hover:underline">Show details
                        of {{ $photo->title }}</a>

                    @if ($photo->likes->contains('user_id', auth()->id()))
                        <form action="{{ route('photos.unlike', $photo) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Unlike
                            </button>
                        </form>
                    @else
                        <form action="{{ route('photos.like', $photo) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit"
                                    class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                Like
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
