<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\MahasiswaController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Wajib ketika berhubungan dengan api url, wajib menambahkan /api terlebih dahulu
// Contoh http://localhost/api/mahasiswa

Route::get('/mahasiswa', [MahasiswaController::class , 'index']); // https://localhost/api/mahasiswa
Route::get('/mahasiswa/{id}', [MahasiswaController::class , 'showById']);
Route::post('/mahasiswa', [MahasiswaController::class , 'store']);

Route::match(['put' , 'patch'],'/mahasiswa/{id}' , [MahasiswaController::class , 'update']); // ambil request put dan patch
Route::delete('/mahasiswa/{id}', [MahasiswaController::class , 'delete']);