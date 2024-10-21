@props(['photo'])

    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Photos</title>
    @vite(['resources/css/app.css'])
</head>
<body>
<div>
    <h2>{{ $photo->title }}</h2>
    <p>{{ $photo->description }}</p>
</div>
</body>
</html>

