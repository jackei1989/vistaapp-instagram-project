<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;

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

/**
 * 
 * Login and Registery Routes
 * 
 */
Route::prefix('auth')->group(function(){
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
});

/**
 * 
 * Routes for Show Update and Delete Users
 * 
 */
Route::middleware('auth:api')->prefix('panel')->group(function(){
    Route::get('user', [UserController::class, 'index']); 
    Route::get('user/{user_name}', [UserController::class, 'show']);
    Route::get('user/{user_name}/edit', [UserController::class, 'edit']);
    Route::put('user/{user_name}', [UserController::class, 'update']);
    Route::delete('user/{user_name}',  [UserController::class, 'destroy']);
}); 

/**
 * 
 * Routes for Show Update and Delete Posts
 * 
 */
Route::middleware('auth:api')->prefix('post')->group(function(){
    Route::get('user', [PostController::class, 'index']); 
    Route::get('user/{user_name}', [PostController::class, 'show']);
    // Route::get('user/create', [PostController::class, 'create']); // check
    Route::post('user/store', [PostController::class, 'store']);
    Route::get('{user_name}/edit', [PostController::class, 'edit']); 
    Route::put('/user/{post_id}', [PostController::class, 'update']);
    Route::delete('/user/{post_id}',  [PostController::class, 'destroy']);
});

/**
 * 
 * Route for Search by User Name
 * 
 */
Route::any('search', [SearchController::class, 'search']);

/**
 * 
 * Route for Show User's Posts
 * 
 */
Route::get('posts/user/{user_name}', [UserController::class, 'postsUser']);

/**
 * 
 * Route for Followe other Users
 * 
 */
Route::get('following/{user_id}', [UserController::class, 'following'])->middleware('auth:api');

/**
 * 
 * Route for like posts
 * 
 */
Route::get('like/{post_id}', [PostController::class, 'likePost'])->middleware('auth:api');

/**
 * 
 * Route for Sort Posts By Most Like
 * 
 */
Route::any('sortpostmostlike', [PostController::class, 'sortPostByMostLike']);

/**
 * 
 * Route for Sort Posts By Most Like
 * 
 */
Route::post('post/comment', [CommentController::class, 'store'])->middleware('auth:api');
Route::get('post/comment/{post_id}/like', [CommentController::class, 'likeComment'])->middleware('auth:api');

/**
 * 
 * Route for user archives
 * 
 */
Route::get('archive/{post_id}', [ArchiveController::class, 'save'])->middleware('auth:api');
Route::get('search/archive', [SearchController::class, 'searchInArchive'])->middleware('auth:api');