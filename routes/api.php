<?php

use App\Http\Controllers\Cards\CardsController;
use App\Http\Controllers\Folders\FoldersController;
use App\Http\Controllers\Lists\ListsController;
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

Route::prefix('v1/', function(){
    Route::resource("cards", CardsController::class);
    Route::resource("lists", ListsController::class);
    Route::resource("folders", FoldersController::class);
});
