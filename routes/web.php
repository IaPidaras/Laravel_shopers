<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Стандартные роуты авторизации Laravel (с включенной верификацией)
Auth::routes(['verify' => true]);

// Явно указываем имя роута 'login' для страницы входа
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');

// Общие пользовательские роуты (доступны всем гостям)
Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index');
Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about');
Route::get('/catalog', [App\Http\Controllers\WebController::class, 'catalog'])->name('catalog');
Route::get('/where', [App\Http\Controllers\WhereController::class, 'index'])->name('where');
Route::get('/product', [App\Http\Controllers\ProductController::class, 'index'])->name('product');
Route::get('/catalog/{id_product}', [App\Http\Controllers\WebController::class, 'show'])->name('product.show');

// ЗАЩИЩЕННАЯ АДМИНКА: Доступ только авторизованным (auth) пользователям (проверка роли внутри контроллера)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
    Route::post('/admin/store', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.store');
    Route::put('/admin/update/{id_product}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/destroy/{id_product}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.destroy');
});


// ЗАЩИЩЕННАЯ КОРЗИНА И ПРОФИЛЬ: Доступ только для авторизованных пользователей
Route::middleware(['auth'])->group(function () {
    // Страница профиля (Личный кабинет)
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    
    // Удаление (отмена) заказа пользователем по ТЗ
    Route::delete('/profile/order/{id_order}', [App\Http\Controllers\ProfileController::class, 'cancelOrder'])->name('order.cancel');

    // Роуты корзины
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id_product}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id_product}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id_product}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
});
