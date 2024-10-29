<x-app-layout>
    <div class="container mx-auto py-12 bg-green-900 rounded-lg shadow-md">

        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8 px-6">
            <div>
                <h2 class="text-3xl font-bold text-white">Welcome to My Football Hub</h2>
                <p class="mt-2 text-gray-200">
                    Dive into the world of football! Check out the latest uploads and photos.
                </p>
            </div>
            <div class="flex items-center space-x-4">
                @if(auth()->check())
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-300 bg-green-700 hover:text-white hover:bg-green-800 transition ease-in-out duration-150">
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
                                                 class="text-green-700 hover:bg-green-800 hover:text-white"
                                                 onclick="event.preventDefault();
                                                 this.closest('form').submit();">
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

        <!-- Intro Section -->
        <div class="text-center px-6">
            <h2 class="text-4xl font-bold mb-4 text-yellow-300">Explore Top Football Leagues!</h2>
            <p class="mb-8 text-gray-200">
                Discover exciting moments and highlights from recent uploads by our community.
            </p>
            <p class="font-semibold text-yellow-400">
                * Note: To create a post, you must be logged in and have liked at least 5 posts.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4 mb-6 px-6">
            <a href="{{ route('photos.index') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                View All Uploads
            </a>
            <a href="{{ route('photos.create') }}"
               class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                Create Photo
            </a>
            @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('admin.admin-index') }}"
                   class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Admin Page
                </a>
            @endif
        </div>

        <!-- User Role Info -->
        <p class="text-gray-200 text-center mb-4">
            User Role: <span
                class="font-semibold text-yellow-300">{{ auth()->check() ? auth()->user()->role : 'Guest' }}</span>
        </p>

        <!-- Welcome Message -->
        <div class="mt-10 text-center px-6">
            <p class="text-lg text-white">Hello and welcome! Browse and share your favorite football moments here.</p>
        </div>

    </div>

</x-app-layout>
