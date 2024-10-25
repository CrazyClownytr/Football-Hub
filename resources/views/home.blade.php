<x-app-layout>
    <div class="container mx-auto py-12">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-white">Welcome to My Home Page</h2>
                <p class="mt-2 text-gray-300">
                    Explore the various photos and uploads on this platform.
                </p>
            </div>

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

        <div class="text-center">
            <h2 class="text-3xl font-bold mb-4 text-white">Explore the Top 5 Football Leagues and the Champions
                League!</h2>
            <p class="mb-8 text-gray-300">
                Discover exciting moments from recent uploads by our community. Like and share your favorites!
            </p>
            <p class="font-semibold text-red-500">
                Note: To create a post, you must be logged in and have liked at least 5 posts.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4 mb-6">
            <a href="{{ route('photos.index') }}"
               class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                View All Uploads
            </a>
            <a href="{{ route('photos.create') }}"
               class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition">
                Create Photo
            </a>
            @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('admin.admin-index') }}"
                   class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Admin Page
                </a>
            @endif
        </div>

        <p class="text-gray-300 text-center">
            User Role: <span class="font-semibold">{{ auth()->check() ? auth()->user()->role : 'Not logged in' }}</span>
        </p>

        <div class="mt-10 text-center">
            <p class="text-lg text-white">Hello, welcome to my platform where you can view and upload beautiful
                photos.</p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 mt-12 py-4 text-center border-t border-gray-200 dark:border-gray-700">
        <p class="text-gray-500 dark:text-gray-400">© 2024 Your Website. All rights reserved.</p>
    </footer>
</x-app-layout>
