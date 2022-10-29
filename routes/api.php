<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\V1\AuthController;


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
    Route::get('/getCSRFToken', [AuthController::class, 'getCSRFToken']);
});

// Route::get('/getCSRFToken', [HomeController::class, 'getCSRFToken']);
Route::get('/token', function (Request $request) {
    $token = $request->session()->token();
    $token = csrf_token();
    return $token;
});

//留言
Route::get('/comments', [CommentController::class, 'index']);
Route::post('/comment', [CommentController::class, 'store']);  /* C */
Route::get('/comments/{comment}', [CommentController::class, 'show']);  /* R */
Route::put('/comments/{comment}', [CommentController::class, 'update']);  /* U */
Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);  /* D */
Route::get('/author/{user}/comments', [CommentController::class, 'getUserComments']);  /* R */

//回覆留言的訊息
Route::get('/replies/{comment}', [CommentController::class, 'index']);
