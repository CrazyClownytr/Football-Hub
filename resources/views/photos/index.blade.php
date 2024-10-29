<x-app-layout>
    <div class="container mx-auto py-12 bg-green-900 rounded-lg shadow-lg">

        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8 px-6">
            <div class="flex items-center space-x-4">
                @if(auth()->check())
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-300 bg-green-700 hover:text-white transition ease-in-out duration-150">
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
                            <x-dropdown-link :href="route('profile.edit')"
                                             class="text-green-700 hover:bg-green-800 hover:text-white">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();"
                                                 class="text-green-700 hover:bg-green-800 hover:text-white">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        Log In
                    </a>
                @endif
            </div>
        </div>

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
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Click to Filter
                </button>
            </form>

            <form method="GET" action="{{ route('photos.index') }}" class="flex justify-center space-x-4">
                <label for="search" class="text-white">Search Posts:</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       placeholder="Search by title or description" class="px-3 py-2 border border-gray-300 rounded-md">
                <button type="submit"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Search
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
                <a href="{{ route('photos.show', $photo) }}" class="text-blue-600 hover:underline">Show details
                    of {{ $photo->title }}</a>

                @if ($photo->likes->contains('user_id', auth()->id()))
                    <form action="{{ route('photos.unlike', $photo) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Unlike
                        </button>
                    </form>
                @else
                    <form action="{{ route('photos.like', $photo) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit"
                                class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Like
                        </button>
                    </form>
                @endif
            </div>
        @endforeach

    </div>


</x-app-layout>
