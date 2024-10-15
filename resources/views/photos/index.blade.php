<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Photos</title>
</head>
<body>
<h1>Photos</h1>
@foreach($photos as $photo) @endforeach
<div>
    <h2>{{ $photos->title }}</h2>
    <p>{{ $photos->description }}</p>

</div>

</body>
</html>
