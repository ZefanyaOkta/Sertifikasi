<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Katalog</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>

<body>
    {{-- EDIT KATALOG --}}
    <h1>Edit Katalog</h1>
    <form action="/edit-catalog/{{$catalog->id}}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="title" value="{{$catalog->title}}" placeholder="Judul">
        <input type="text" name="genre" value="{{$catalog->genre}}" placeholder="Genre">
        <input type="text" name="author" value="{{$catalog->author}}" placeholder="Penulis">
        <input type="text" name="page" value="{{$catalog->page}}" placeholder="Halaman">
        <button>Save Changes</button>
    </form>
</body>

</html>
