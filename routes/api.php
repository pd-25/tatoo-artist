<?php

use App\Http\Controllers\Api\artist\ArtistController;
use App\Http\Controllers\Api\artwork\ArtworkController;
use App\Http\Controllers\Api\auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class, 'loginUser']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/artist', [ArtistController::class, 'artistInfo']);
    Route::post('/artist-update/{id}', [ArtistController::class, 'artistUpdate']);
    Route::post('/upload-artwork', [ArtworkController::class, 'artworkUpload']);
    Route::delete('/delete-artwork/{id}', [ArtworkController::class, 'artworkdelete']);
    Route::post('/upload-banner', [ArtworkController::class, 'artworkBanner']);
    Route::delete('/delete-banner/{id}', [ArtworkController::class, 'bannerdelete']);

    Route::post('/like', [ArtworkController::class, 'like']);
    Route::get('/like-list/{id}', [ArtworkController::class, 'likeList']);

    Route::post('/comment', [ArtworkController::class, 'comment']);
    Route::get('/comment-list/{id}', [ArtworkController::class, 'commentList']);

    Route::post('/view', [ArtworkController::class, 'view']);
    Route::delete('/delete-comment/{id}', [ArtworkController::class, 'deleteComment'])->name('comment.delete');
    Route::post('/quote', [ArtworkController::class, 'quoteSave']);
    Route::post('/appointment', [ArtworkController::class, 'saveAppointment']);

});
Route::get('/subjects', [ArtistController::class, 'subjects']);
Route::get('/placements', [ArtistController::class, 'placements']);
Route::get('/styles', [ArtistController::class, 'styles']);

Route::get('/all-artworks', [ArtworkController::class, 'allArtwork'])->name('allArtwork');
Route::get('/all-artists', [ArtistController::class, 'allArtist'])->name('allArtist');
Route::get('/artist/{username}', [ArtistController::class, 'artistGet']);
