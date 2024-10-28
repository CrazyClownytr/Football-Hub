<x-layout>
    <div class="container mx-auto py-12">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center space-x-4">
                @if(auth()->check())
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                {{ Auth::user()->name }}
                                <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                 this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                        Log In
                    </a>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4 mb-6">
            <a href="{{ route('home') }}"
               class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                Back To Home Page
            </a>
            <a href="{{ route('photos.index') }}"
               class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                View All Uploads
            </a>
            <a href="{{ route('photos.create') }}"
               class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition">
                Create Photo
            </a>
            @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('admin.photos-index') }}"
                   class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Admin Page
                </a>
            @endif
        </div>

        @if(session('message'))
            <div class="alert alert-warning mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Search and Filter -->
        <div class="mb-8 text-center">
            <form method="GET" action="{{ route('photos.index') }}" class="flex justify-center space-x-4 mb-4">
                <div>
                    <label for="category" class="text-white">Filter by Category:</label>
                    <select name="category" id="category" class="bg-gray-700 text-white rounded-md">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->leagues }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Click to Filter
                </button>
            </form>

            <form method="GET" action="{{ route('photos.index') }}" class="flex justify-center space-x-4">
                <label for="search" class="text-white">Search Posts:</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       placeholder="Search by title or description" class="px-3 py-2 border border-gray-300 rounded-md">
                <button type="submit"
                        class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition">Search
                </button>
            </form>
        </div>

        <!-- Photo List -->
        @foreach($photos as $photo)
            <div class="photo-item border border-gray-300 rounded-lg p-4 mb-4 bg-white shadow-md">
                @if ($photo->image)
                    <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}"
                         class="max-w-full h-auto rounded-lg mb-2">
                @endif
                <h2 class="text-xl font-bold text-gray-800">{{ $photo->title }}</h2>
                <p class="text-gray-600">Uploaded by: {{ $photo->user ? $photo->user->name : 'Unknown User' }}</p>
                <p class="text-gray-600">Category: {{ $photo->category->leagues ?? 'No Category' }}</p>
                <a href="{{ route('photos.show', $photo) }}" class="text-blue-500 hover:underline">Show details
                    of {{ $photo->title }}</a>

                @if ($photo->likes->contains('user_id', auth()->id()))
                    <form action="{{ route('photos.unlike', $photo) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Unlike
                        </button>
                    </form>
                @else
                    <form action="{{ route('photos.like', $photo) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit"
                                class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Like
                        </button>
                    </form>
                @endif
            </div>
        @endforeach

    </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 mt-12 py-4 text-center border-t border-gray-200 dark:border-gray-700">
        <p class="text-gray-500 dark:text-gray-400">© 2024 Your Website. All rights reserved.</p>
    </footer>
</x-layout>
