<?php

use App\Http\Controllers\Cards\CardsController;
use App\Http\Controllers\Folders\FoldersController;
use App\Http\Controllers\Groups\GroupsController;
use App\Http\Controllers\Lists\ListsController;
use App\Http\Controllers\Users\UsersController;
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

Route::prefix('/v1')->group(function(){
    Route::resource("/users"  ,   UsersController::class);
    Route::resource("/cards"  ,   CardsController::class);
    Route::resource("/lists"  ,   ListsController::class);
    Route::resource("/folders", FoldersController::class);
    Route::resource("/groups" ,  GroupsController::class);
});
