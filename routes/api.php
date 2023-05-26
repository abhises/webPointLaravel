<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//getAllContact
Route::get('/getAllContact', [ContactController::class, 'getAllContact']);
//createContact
Route::post('/createContact', [ContactController::class, 'createContact']);
//deleteContact
Route::delete('/deleteContact/{id}', [ContactController::class, 'deleteContact']);
//updateContact
Route::put('/updateContact/{id}', [ContactController::class, 'updateContact']);