<x-admin-layout>
    <h1 class="text-3xl font-bold mb-6">Admin Upload Beheer</h1>

    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-x-4 mb-6">
        <a href="{{ route('admin.admin-index') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Back
            to Admin Home Page</a>
        <a href="{{ route('photos.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Create
            New Photo</a>
        <a href="{{ route('photos.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">View
            All Uploads</a>
    </div>

    <h2 class="text-2xl font-semibold mb-4">All Photos</h2>
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-lg">
        <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2 text-left text-gray-600">Title</th>
            <th class="px-4 py-2 text-left text-gray-600">Uploaded By</th>
            <th class="px-4 py-2 text-left text-gray-600">Category</th>
            <th class="px-4 py-2 text-left text-gray-600">Status</th>
            <th class="px-4 py-2 text-left text-gray-600">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($photos as $photo)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $photo->title }}</td>
                <td class="px-4 py-2">{{ $photo->user->name ?? 'Unknown' }}</td>
                <td class="px-4 py-2">{{ $photo->category->leagues ?? 'No Category' }}</td>
                <td class="px-4 py-2">
                    <span class="{{ $photo->status === 'inactive' ? 'text-red-500' : 'text-green-500' }}">
                        {{ ucfirst($photo->status) }}
                    </span>
                </td>
                <td class="px-4 py-2">
                    <form action="{{ route('photos.toggle-status', $photo->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:text-blue-800">
                            {{ $photo->deleted_at ? 'Restore' : 'Deactivate' }}
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-admin-layout>
