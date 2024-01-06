<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Peminjaman</title>
    <link rel="stylesheet" href="css/app.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>

<body>
    {{-- NAVIGATION BAR --}}
    <div class="topnav">
        <a href="/">Katalog</a>
        <a class="active" href="/peminjaman">Peminjaman</a>
        <form action="/logout" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-button">Log Out</button>
        </form>
    </div>

    {{-- INPUT PEMINJAMAN BUKU --}}
    <h2>Input Peminjaman Buku</h2>
    <form action="/input-peminjaman-buku" method="POST">
        @csrf
        <input name="nama_peminjam" type="text" placeholder="Nama anggota">
        <select name="judul_buku" id="judul_buku" required>
            <option value="" disabled selected>Pilih Judul Buku</option>
            @foreach($catalogTitles as $catalog)
            @if($catalog->status === 'available')
            <option value="{{ $catalog->id }}">{{ $catalog->title }}</option>
            @else
            <option value="{{ $catalog->id }}" disabled>{{ $catalog->title }} (Unavailable)</option>
            @endif
            @endforeach
        </select>
        <input name="tgl_pinjam" type="date" placeholder="Tanggal peminjaman" value="{{ now()->toDateString() }}" readonly>
        <input name="tgl_kembali" type="date" placeholder="Tanggal pengembalian" readonly
            value="{{ now()->addDays(7)->toDateString() }}">
        <input type="submit" name="simpan">
    </form>

    {{-- DAFTAR PEMINJAMAN BUKU --}}
    <h2>Daftar Peminjaman Buku</h2>
    <table width="1200" class="catalog-table">
        <tr class="catalog-title">
            <th width=150>Nama Peminjam</th>
            <th width=150>Judul Buku</th>
            <th width=150>Tanggal Pinjam</th>
            <th width=150>Tanggal Kembali</th>
            <th width=150>Status</th>
            <th width=150>Aksi</th>
        </tr>
        @foreach($allpeminjaman as $peminjaman)
        <tr align="center" class="table-fill">
            <td>{{$peminjaman['nama_peminjam']}}</td>
            <td>{{$peminjaman['judul_buku']}}</td>
            <td>{{$peminjaman['tgl_pinjam']}}</td>
            <td>{{$peminjaman['tgl_kembali']}}</td>
            <td>{{$peminjaman['status']}}</td>
            <td>
                @if($peminjaman['status'] != 'returned')
                <form action="/edit-status-peminjaman/{{$peminjaman->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="catalog_id" value="{{$peminjaman->catalog_id}}">
                    <button>Confirm Return</button>
                    @else

                    @endif
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>

</html>
