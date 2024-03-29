<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\PlatController;
use App\Http\Controllers\TypeController;

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

Route::apiResource('/type',TypeController::class);
Route::apiResource('/plat',PlatController::class);
Route::get('/plat/type/{id}',[PlatController::class,"getByType"]);
Route::apiResource('/menu',MenuController::class);



// Routes pour les réservations
Route::post('/reservations', [ReservationController::class, 'store']);
Route::get('/reservations', [ReservationController::class, 'index']);
Route::get('reservations/status/{status}', [ReservationController::class, 'getByStatus']);

Route::get('/reservations/accept/{id}', [ReservationController::class, 'accept']);
Route::get('/reservations/refuse/{id}', [ReservationController::class, 'refuse']);
Route::get('/reservations/annuler/{id}', [ReservationController::class, 'annuler']);




// Routes pour les utilisateurs
Route::post('/register', [UtilisateurController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();
    return response()->json(['message' => 'Logged out']);
});



// Routes pour l'historique

Route::post('/historiques', [HistoriqueController::class, 'store']);
Route::get('/historiques', [HistoriqueController::class, 'index']);

// Routes pour les avis
Route::resource('avis', AvisController::class);

// routes/api.php


Route::post('/configurations', [ConfigurationController::class, 'store']);

Route::get('/configuration', [ConfigurationController::class, 'index']);

