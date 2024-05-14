<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Request;


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

Route::post('/post-request', [UserController::class, 'postRequest'])->name('postRequest');
Route::get('/tambah-product', [UserController::class, 'handleRequest'])->name('form_product');
Route::get('/products', [UserController::class, 'getProduct'])->name('get_product')->middleware(['authenticate', 'role:superadmin|user']);
Route::get('/product/{product}', [UserController::class, 'editProduct'])->name('edit_product');
Route::put('/product/{product}/update', [UserController::class, 'updateProduct'])->name('update_product');
Route::post('/product/{product}/delete', [UserController::class, 'deleteProduct'])->name('delete_product');
Route::get('/profile', [UserController::class, 'getProfile'])->name('get_profile');

Route::get('/admin/list-products', [UserController::class, 'getAdmin'])->name('admin_page')->middleware(['authenticate', 'role:superadmin|user']);

Route::post('/add/user', [UserController::class, 'postUser'])->name('post_User');
Route::get('/tambah-user', [UserController::class, 'formUser'])->name('form_user');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register-user', [UserController::class, 'registerUser'])->name('register_user');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'loginUser'])->name('login_user');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/manage/users', [UserController::class, 'manageUsers'])->name('manage_user')->middleware(['authenticate', 'role:superadmin']);
Route::get('/manage/users/{user}/edit', [UserController::class, 'edit'])->name('edit_user');
Route::put('/manage/users/{user}/update', [UserController::class, 'updateUser'])->name('update_user');
Route::post('/manage/users/{user}/delete', [UserController::class, 'deleteUser'])->name('delete_user')->middleware(['authenticate', 'role:superadmin']);
