<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    // SOFT DELETE CATALOG, UBAH AVAILABILITYNYA JADI REMOVED
    public function deleteCatalog(Catalog $catalog) {
        $catalog->availability = 'removed';
        $catalog->save();
        return redirect('/');
    }

    // UPDATE CATALOG
    public function actuallyUpdateCatalog(Catalog $catalog, Request $request) {
        // if (auth()->user()->id !== $post['user_id']) {
        //     return redirect('/');
        // }

        $incomingFields = $request->validate([
            'title' => 'required',
            'genre' => 'required',
            'author' => 'required',
            'page' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['genre'] = strip_tags($incomingFields['genre']);
        $incomingFields['author'] = strip_tags($incomingFields['author']);
        $incomingFields['page'] = strip_tags($incomingFields['page']);

        $catalog->update($incomingFields);
        return redirect('/');
    }

    // NAMPILIN EDIT CATALOG
    public function showEditScreen(Catalog $catalog) {
        // if (auth()->user()->id !== $post['user_id']) {
        //     return redirect('/');
        // }
        return view('edit-catalog', ['catalog' => $catalog]);
    }

    // CREATE A CATALOG
    public function createCatalog(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'genre' => 'required',
            'author' => 'required',
            'page' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['genre'] = strip_tags($incomingFields['genre']);
        $incomingFields['author'] = strip_tags($incomingFields['author']);
        $incomingFields['page'] = strip_tags($incomingFields['page']);

        // $size = $request->file('image')->getSize();
        $name = $request->file('image')->getClientOriginalName();

        $imagePath = $request->file('image')->storeAs('public/images/', $name);
       
        $catalog = new Catalog($incomingFields);

        $catalog->status = 'available';
        $catalog->availability = 'available';

        $catalog->image = basename($imagePath);
        // $catalog->user_id = auth()->id();
        $catalog->save();

        // $incomingFields['user_id'] = auth()->id();
        // Catalog::create($incomingFields);
        return redirect('/');
    }
}
