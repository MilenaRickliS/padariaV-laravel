<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

// Rotas de autenticação
Auth::routes();

// Rota principal
Route::get('/', [ProductController::class, 'cardapio'])->name('products.cardapio');


Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');

// Rotas de produtos (protegidas por autenticação)
Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->where('id', '[0-9]+')->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->where('id', '[0-9]+')->name('products.update');
    Route::patch('/products/{id}', [ProductController::class, 'update'])->where('id', '[0-9]+')->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->where('id', '[0-9]+')->name('products.destroy');
});

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add/{id}', [CartController::class, 'add']);
Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::get('/cart/remove/{id}', [CartController::class, 'remove']);
Route::get('/cart/checkout', [CartController::class, 'checkout']);
Route::post('/order', function (Request $request) {
    return redirect()->route('/')->with('success', 'Compra finalizada com sucesso!');
})->middleware('checkLogin');