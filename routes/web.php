<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/home', function () {
//    return view('profile.home');
//})->name('home');

Route::get('/', [HomeController::class, 'index']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//admins + users
Route::middleware('auth')->group(function () {
    Route::resource('photos', PhotoController::class)->except(['index']);
    Route::get('/profile/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// guests and users
Route::get('/photos/{photo}', [PhotoController::class, 'show'])->name('photos.show');
Route::get('/photos', [PhotoController::class, 'index'])->name('photos.index');

//je moet ingelogd zijn to create
//Route::get('products/create', [PhotoController::class, 'create'])
//    ->middleware('auth')
//    ->name('products.create');

//restore deleted pics
Route::post('/photos/{photo}/restore', [PhotoController::class, 'restore'])->name('photos.restore');

// edit and update
Route::get('/photos/{photo}/edit', [PhotoController::class, 'edit'])->name('photos.edit');
Route::put('/photos/{photo}', [PhotoController::class, 'update'])->name('photos.update');

//admin role pages
Route::middleware('auth')->group(function () {
    Route::get('/admin/admin-index', [AdminController::class, 'manageUsers'])->name('admin.admin-index');

    // Route voor het beheren van foto's
    Route::get('/admin/photos', [AdminController::class, 'adminPhotosIndex'])->name('admin.photos-index');

    // Route voor het herstellen van foto's
    Route::post('/admin/photos/{id}/restore', [AdminController::class, 'restorePhoto'])->name('photos.restore');
});

//likes unlikes
Route::post('/photos/{photo}/like', [PhotoController::class, 'like'])->name('photos.like');
Route::delete('/photos/{photo}/unlike', [PhotoController::class, 'unlike'])->name('photos.unlike');

// toggle status
Route::post('/photos/{photo}/toggle-status', [PhotoController::class, 'toggleStatus'])->name('photos.toggle-status');


require __DIR__ . '/auth.php';

