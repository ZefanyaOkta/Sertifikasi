<?php

use App\Models\Catalog;
use App\Models\Peminjaman;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PeminjamanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    $catalogs = [];

    /// To get all catalog
    $catalogs = Catalog::where('availability', 'available')->latest()->get();

    // if (auth()->check()) {
    //     /// To get catalog ref to user id
    //     /// This one is beginning from perspective of a catalog
    //     $catalogs = Catalog::where('user_id', auth()->id())->get();
    
    //     /// This one is beginning from perspective of a user
    //     $catalogs = auth()->user()->usersCatalogs()->latest()->get();
    // }

    return view('home-view', ['catalogs' => $catalogs]);
});

// USER/ADMIN
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

// CATALOG
Route::post('/create-catalog', [CatalogController::class, 'createCatalog']);
Route::get('/edit-catalog/{catalog}', [CatalogController::class, 'showEditScreen']);
Route::put('/edit-catalog/{catalog}', [CatalogController::class, 'actuallyUpdateCatalog']);
Route::put('/delete-catalog/{catalog}', [CatalogController::class, 'deleteCatalog']);

// PEMINJAMAN
Route::get('/peminjaman', function () {
    // To get all available books (yang tidak diremoved)
    $catalogTitles = Catalog::where('availability', 'available')->get();

    $allpeminjaman = [];

    /// To get all peminjaman
    // $allpeminjaman = Peminjaman::all();
    $allpeminjaman = Peminjaman::latest()->get();
    return view('peminjaman', compact('catalogTitles', 'allpeminjaman'));
});

Route::post('/input-peminjaman-buku', [PeminjamanController::class, 'inputPeminjaman']);
Route::put('/edit-status-peminjaman/{peminjaman}', [PeminjamanController::class, 'updateStatusPeminjaman']);
