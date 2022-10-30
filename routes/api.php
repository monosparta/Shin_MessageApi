<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\ReplyController;


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

// Route::prefix('v1')->middleware('auth:api')->group(function () {
//     Route::post('login', [AuthController::class, 'login']);
//     Route::post('register', [AuthController::class, 'register']);
// });

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refreshToken', [AuthController::class, 'refreshToken']);
    // Route::get('/getCSRFToken', [AuthController::class, 'getCSRFToken']);
});

Route::middleware('auth:api')->group(function () {
    //留言
    Route::post('/comments', [CommentController::class, 'store']);  /* C */
    Route::put('/comments/{comment}', [CommentController::class, 'update']);  /* U */
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);  /* D */

    //回覆
    Route::get('/comments/{comment}/replies', [ReplyController::class, 'show']);  /* R */
    Route::put('/replies/{reply}', [ReplyController::class, 'update']);  /* U */
    Route::delete('/replies/{reply}', [ReplyController::class, 'destroy']);  /* D */
});

//留言（不需要認證）
Route::get('/comments', [CommentController::class, 'index']);
Route::post('/replies', [ReplyController::class, 'store']);  /* C */
Route::get('/comments/{comment}', [CommentController::class, 'show']);  /* R */
Route::get('/author/{user}/comments', [CommentController::class, 'getUserComments']);  /* R */
