<x-app-layout>
    <div class="container mx-auto py-12 bg-white rounded-lg shadow-md">

        <!-- Header Section -->
        <div class="flex flex-col items-center mb-8 px-6">
            <h2 class="text-3xl font-bold text-black">Welcome to My Football Hub</h2>
            <p class="mt-2 text-gray-700">
                Dive into the world of football! Check out the latest uploads and photos.
            </p>
        </div>

        <!-- Intro Section -->
        <div class="text-center px-6 mb-8">
            <h2 class="text-4xl font-bold mb-4 text-black">Explore Top Football Leagues!</h2>
            <p class="mb-8 text-gray-700">
                Discover exciting moments and highlights from recent uploads by our community.
            </p>
            <p class="text-lg text-black">Browse and share your favorite football moments
                here.</p>

            <p class="font-semibold text-blue-950">
                * Note: To create a post, you must be logged in and have liked at least 5 posts.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4 mb-6 px-6">
            <div class="mb-4">

                <a href="{{ route('photos.index') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 ease-in-out shadow-md">
                    View All Uploads
                </a>

                @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.admin-index') }}"
                       class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition duration-200 ease-in-out shadow-md">
                        Admin Page
                    </a>
                @endif

            </div>


        </div>


        <!-- User Role Info -->
        <p class="text-gray-700 text-center mb-4">
            User Role: <span
                class="font-semibold text-black">{{ auth()->check() ? auth()->user()->role : 'Guest' }}</span>
        </p>

    </div>
</x-app-layout>
