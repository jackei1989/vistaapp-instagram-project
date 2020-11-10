<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Auth\RegisterController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Login and Register Routes
Route::prefix('auth')->group(function(){
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
});

// Users Route
Route::middleware('auth:api')->prefix('panel')->group(function(){
    Route::get('user', [UserController::class, 'index']); 
    Route::get('{user_name}', [UserController::class, 'show']);
    Route::get('{user_name}/edit', [UserController::class, 'edit']);
    Route::put('{user_name}', [UserController::class, 'update']);
    Route::delete('{user_name}',  [UserController::class, 'destroy']);
});