<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/posts', [ApiController::class, 'index']);
Route::get('/posts/{id}', [ApiController::class, 'show']);
Route::get('/posts/search/{title}', [ApiController::class, 'search']);
Route::get('/posts/searchByCategory/{cat_id}', [ApiController::class, 'searchByCategory']);
Route::get('/categories', [ApiController::class, 'allCategories']);
Route::get('/categories/{id}', [ApiController::class, 'findCategoryById']);
// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/posts', [ApiController::class, 'store']);
    Route::put('/posts/{id}', [ApiController::class, 'update']);
    Route::delete('/posts/{id}', [ApiController::class, 'destroy']);
    Route::post('/logout', [ApiController::class, 'logout']);

});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
