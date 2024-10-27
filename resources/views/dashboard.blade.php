<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    <a href="{{route('home')}}">Go to Home Page</a>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <a href="{{ route('admin.admin-index') }}"
                           class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                            Admin Page
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
