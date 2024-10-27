<h1>Admin Foto Beheer</h1>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<a href="{{ route('admin.admin-index') }}">Back to Admin Home Page</a>
<a href="{{ route('photos.create') }}">Maak Nieuwe Foto</a>
<a href="{{route('photos.index')}}">View all Uploads</a>

<h2>Alle Foto's</h2>
<table>
    <thead>
    <tr>
        <th>Titel</th>
        <th>Geüpload door</th>
        <th>Categorie</th>
        <th>Status</th>
        <th>Acties</th>
    </tr>
    </thead>
    <tbody>
    @foreach($photos as $photo)
        <tr>
            <td>{{ $photo->title }}</td>
            <td>{{ $photo->user->name ?? 'Onbekend' }}</td>
            <td>{{ $photo->category->leagues ?? 'Geen Categorie' }}</td>
            <td>
        <span class="{{ $photo->status === 'inactive' ? 'text-red-500' : 'text-green-500' }}">
            {{ ucfirst($photo->status) }}
        </span>
            </td>
            <td>
                <form action="{{ route('photos.toggle-status', $photo->id) }}" method="POST">
                    @csrf
                    <button type="submit">{{ $photo->deleted_at ? 'Herstellen' : 'Deactiveren' }}</button>
                </form>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
