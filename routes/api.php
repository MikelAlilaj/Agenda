<?php

use App\Http\Controllers\Api\AgendaController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/agendas', [AgendaController::class, 'index']);
Route::post('/agendas/add-new', [AgendaController::class, 'store']);
Route::get('/agenda/{id}', [AgendaController::class, 'show']);
Route::patch('/update/{id}', [AgendaController::class, 'update']);
Route::delete('/delete/{id}', [AgendaController::class, 'destroy']);
