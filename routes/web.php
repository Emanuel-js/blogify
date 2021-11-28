<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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




Route::resource('posts', PostController::class);
// Route::resource('roles', RoleController::class)->middleware('can:isAdmin');
// Route::resource('users', UserController::class)->middleware('role:Admin,Manager,Creator');

Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);


Route::get('/', function(){
    return view('welcome');
}
);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
