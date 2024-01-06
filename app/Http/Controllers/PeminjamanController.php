<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Input Peminjaman
    public function inputPeminjaman(Request $request) {
        $incomingFields = $request->validate([
            'nama_peminjam' => 'required',
            'judul_buku' => 'required|integer',
            'tgl_pinjam' => 'required',
            'tgl_kembali' => 'required'
        ]);

        // judul_buku nyimpan ID Catalog || Update status buku yang dipinjam jadi unavailable
        $catalog = Catalog::find($incomingFields['judul_buku']);
        if ($catalog) {
            $catalog->update(['status' => 'unavailable']);
        }

        $incomingFields['nama_peminjam'] = strip_tags($incomingFields['nama_peminjam']);
        $incomingFields['catalog_id'] = strip_tags($incomingFields['judul_buku']);
        $incomingFields['judul_buku'] = Catalog::where('id', $incomingFields['judul_buku'])->value('title');
        $incomingFields['tgl_pinjam'] = strip_tags($incomingFields['tgl_pinjam']);
        $incomingFields['tgl_kembali'] = strip_tags($incomingFields['tgl_kembali']);
        $incomingFields['status'] = 'due';
        Peminjaman::create($incomingFields);

        return redirect('/peminjaman');
    }

    // update status peminjaman jadi returned (sudah dikembalikan) dan update status buku jadi available (bisa dipinjam)
    public function updateStatusPeminjaman(Request $request, Peminjaman $peminjaman) {
        $peminjaman->status = 'returned';
        $peminjaman->save();

        $catalogId = $request->input('catalog_id');
        
        $catalog = Catalog::find($catalogId);
        if ($catalog) {
        $catalog->status = 'available';
        $catalog->save();
    }
        return redirect('/peminjaman');
    }
}
