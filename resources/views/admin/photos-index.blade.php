<x-layout>
    <h1>Admin Photo Management</h1>

    <a href="{{ route('photos.create') }}">Create New Photo</a>

    <h2>All Photos</h2>

    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Uploaded By</th>
            <th>Category</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($photos as $photo)
            <tr>
                <td>{{ $photo->title }}</td>
                <td>{{ $photo->user ? $photo->user->name : 'Unknown User' }}</td>
                <td>{{ $photo->category->leagues ?? 'No Category' }}</td>
                <td>
                    @if ($photo->trashed())
                        <span style="color: red;">Deleted</span>
                    @else
                        <span style="color: green;">Active</span>
                    @endif
                </td>
                <td>
                    @if ($photo->trashed())
                        <!-- Restore button -->
                        <form action="{{ route('photos.restore', $photo->id) }}" method="POST">
                            @csrf
                            <button type="submit">Restore</button>
                        </form>
                    @else
                        <a href="{{ route('photos.edit', $photo) }}">Edit</a>
                        <form action="{{ route('photos.destroy', $photo) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this photo?');">Delete
                            </button>
                        </form>
                    @endif
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
</x-layout>
