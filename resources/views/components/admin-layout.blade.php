<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<!-- Navigation Bar -->
<nav class="bg-gray-800 p-4 text-white">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-lg font-semibold">Admin Dashboard</div>
        <div class="space-x-4">
            <a href="{{ route('photos.index') }}" class="hover:underline">View all Uploads</a>
            <a href="{{ route('dashboard') }}" class="hover:underline">Log in</a>
            <a href="{{ route('admin.photos-index') }}" class="hover:underline">Upload Overview</a>
        </div>
    </div>
</nav>

<!-- Main Content Wrapper -->
<div class="container mx-auto p-6">
    {{ $slot }}
</div>

</body>
</html>


