<?php

use App\Http\Controllers\PublicApiController;
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

// Public API routes for the public site
Route::prefix('public')->group(function () {
    Route::get('/rooms', [PublicApiController::class, 'getRooms']);
    Route::get('/rooms/{id}', [PublicApiController::class, 'getRoom']);
    Route::get('/gallery', [PublicApiController::class, 'getGallery']);
    Route::get('/menu', [PublicApiController::class, 'getMenu']);
    Route::get('/services', [PublicApiController::class, 'getServices']);
});
