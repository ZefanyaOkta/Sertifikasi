<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/app.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>

<body>

    @auth
    {{-- NAVIGATION BAR --}}
    <div class="topnav">
        <a class="active" href="#">Katalog</a>
        <a href="/peminjaman">Peminjaman</a>
        <form action="/logout" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-button">Log Out</button>
        </form>
    </div>

    {{-- INPUT KATALOG BUKU --}}
    <h2>Input Katalog Buku</h2>
    <form action="/create-catalog" method="POST" enctype="multipart/form-data">
        @csrf
        <input name="title" type="text" placeholder="Judul">
        <input name="genre" type="text" placeholder="Genre">
        <input name="author" type="text" placeholder="Penulis">
        <input name="page" type="number" placeholder="Halaman">
        <input name="image" type="file" placeholder="Cover">
        <input type="submit" name="upload">
    </form>

    {{-- DAFTAR KATALOG BUKU --}}
    <h2>Katalog Buku</h2>
    <table width="1200" class="catalog-table">
        <tr class="catalog-title">
            <th width=150>Judul</th>
            <th width=150>Genre</th>
            <th width=150>Penulis</th>
            <th width=150>Halaman</th>
            <th width=150>Cover</th>
            <th width=150>Status</th>
            <th width=150>Aksi</th>
        </tr>
        @foreach($catalogs as $catalog)
        <tr align="center" class="table-fill">
            <td>{{$catalog['title']}}</td>
            <td>{{$catalog['genre']}}</td>
            <td>{{$catalog['author']}}</td>
            <td>{{$catalog['page']}}</td>
            <td><img src="{{ asset('storage/images/'. $catalog->image) }}" alt="Catalog Image" height="100" >
            </td>
            <td>{{$catalog['status']}}</td>
            <td><button><a href="/edit-catalog/{{$catalog->id}}">Edit</a></button>
                <form action="/delete-catalog/{{$catalog->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    @else

    {{-- REGISTER --}}
    <h2>Register</h2>
    <form action="/register" method="POST">
        @csrf
        <input name="name" type="text" placeholder="name">
        <input name="email" type="email" placeholder="email">
        <input name="password" type="password" placeholder="password">
        <button>Register</button>
    </form>

    {{-- MESSAGE REGISTER BERHASIL --}}
    @if(Session::has('success'))
    <p class="alert alert-success">{{ Session::get('success') }}</p>
    @endif

    {{-- LOGIN --}}
    <h2>Login</h2>
    <form action="/login" method="POST">
        @csrf
        <input name="loginemail" type="text" placeholder="email">
        <input name="loginpassword" type="password" placeholder="password">
        <button>Login</button>
    </form>
    @endauth
</body>

</html>
