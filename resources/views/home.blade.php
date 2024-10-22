<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
</head>
<body>
<h2>welcome to my home page</h2>
<a href="{{route('photos.index')}}">View all Uploads</a>
<a href="{{route('dashboard')}}">Log in</a>
<a href="{{route('photos.create')}}">Create photo</a>
@if(auth()->check() && auth()->user()->isAdmin())
    <a href="{{ route('admin.admin-index') }}" class="btn btn-primary">Admin page</a>
@endif

<p>Gebruikersrol: {{ auth()->check() ? auth()->user()->role : 'Niet ingelogd' }}</p>

<p>hallo</p>
</body>
</html>




