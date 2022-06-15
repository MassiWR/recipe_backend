<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeListController;
use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/* |-------------------------------------------------------------------------- | API Routes |-------------------------------------------------------------------------- | | Here is where you can register API routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | is assigned the "api" middleware group. Enjoy building your API! | */

Route::post('/register', [AuthController::class , 'register']);
Route::post('/login', [AuthController::class , 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('logout', [AuthController::class , 'logout']);

    /* RECIPIES */
    Route::get('recipies/{listid}', [RecipeController::class , 'getAllRecipies']);
    //Route::get('recipies/{id}', [RecipeController::class, 'getRecipe']);
    Route::post('recipies', [RecipeController::class , 'createRecipe']);
    Route::put('recipies/{id}', [RecipeController::class , 'updateRecipe']);
    Route::delete('recipies/{id}', [RecipeController::class , 'deleteRecipe']);

    /* LISTS */
    Route::get('lists/{id}', [RecipeListController::class , 'getAllLists']);
    Route::get('list/{id}', [RecipeListController::class , 'getList']);
    Route::post('lists', [RecipeListController::class , 'createList']);
    Route::put('lists/{id}', [RecipeListController::class , 'updateList']);
    Route::delete('lists/{id}', [RecipeListController::class , 'deleteList']);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
