<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

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
// User Controller
// router web

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::get('/', [HomeController::class, 'home'])->name('home');
// Route::get('/manager-user', [UserController::class, 'managerUser'])->name('manager-user');
Route::get('/create-user', [UserController::class, 'createUser'])->name('create-user');
Route::get('/manager-user', [UserController::class, 'getAllUser'])->name('manager-user');



// url Api 
Route::post('/register', [UserController::class, 'postRegister']);
Route::post('/login', [UserController::class, 'loginApi']);
Route::post('/create-user', [UserController::class, 'createUserApi'])->name('user.create-user');

Route::get('/edit-user/{id}', [UserController::class, 'editUserApi'])->name('user.edit');
Route::post('/update-user/{id}', [UserController::class, 'updateUserApi'])->name('user.update');
Route::post('/delete-user/{id}', [UserController::class, 'deleteUserApi'])->name('user.destroy');

