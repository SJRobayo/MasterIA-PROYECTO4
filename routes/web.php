<?php
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Livewire\CartPage;
use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProductosController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/dashboard', HomePage::class)->name('dashboard');
    // Route::get('/dashboard', [ProductosController::class, 'dashboard'])->name('dashboard');

    Route::get('/products', [ProductosController::class, 'index'])->name('products.index');
    
    Route::get('/buscar', [SearchController::class, 'search'])->name('buscar');

    Route::get('/cart', CartPage::class)->name('cart');

    Route::post('/cart/add/{id}', function ($id) {
        dd($id); // esto mostrará el ID del producto enviado
    })->name('cart.add');
    

});

require __DIR__.'/auth.php';
