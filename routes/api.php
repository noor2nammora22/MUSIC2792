<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\clientcontroller;
use App\Http\Controllers\RecordingController;
use Illuminate\Http\Request;

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

Route::get('/recordings', [RecordingController::class, 'index']);
Route::post('/recordings', [RecordingController::class, 'store']);
Route::get('/recordings/{id}', [RecordingController::class, 'show']);
Route::put('/recordings/{id}', [RecordingController::class, 'update']);
Route::delete('/recordings/{id}', [RecordingController::class, 'destroy']);
Route::get('/userlist', [clientcontroller::class, 'index']);
Route::post('/users', [clientcontroller::class, 'store']);
Route::get('/users/{id}', [clientcontroller::class, 'show']);
Route::put('/users/{id}', [clientcontroller::class, 'update']);
Route::delete('/users/{id}', [clientcontroller::class, 'destroy']);


Route::post('/login', [clientcontroller::class, 'login']);
Route::post('/signup', [clientcontroller::class, 'signup']);
  

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
