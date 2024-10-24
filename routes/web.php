<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Auth;

// Rotas de autenticação
Auth::routes();

// Rota principal
Route::get('/', [ProductController::class, 'cardapio'])->name('products.cardapio');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rotas de produtos (protegidas por autenticação)
Route::middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->where('id', '[0-9]+')->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->where('id', '[0-9]+')->name('products.update');
    Route::patch('/products/{id}', [ProductController::class, 'update'])->where('id', '[0-9]+')->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->where('id', '[0-9]+')->name('products.destroy');
});

// Rotas de carrinho
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add/{id}', [CartController::class, 'add']);
Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::get('/cart/remove/{id}', [CartController::class, 'remove']);

// Rotas para usuários normais
Route::middleware(['auth'])->group(function () {
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::post('/pedidos', [PedidoController::class, 'pedidos'])->name('pedidos.store'); 
});