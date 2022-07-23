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

    Route::get('user-profile', [AuthController::class , 'getUser']);
    Route::post('logout', [AuthController::class , 'logout']);


    Route::get('recipies/{listid}', [RecipeController::class , 'getList']);
    // add a recipe to a list
    Route::post('recipies', [RecipeController::class , 'create']);
    // delete a recipe from a list
    Route::delete('recipies/{id}', [RecipeController::class , 'delete']);
    // Get a specific list of a user by id
    Route::get('list/{listid}', [RecipeListController::class , 'getList']);
    // get all lists of a user by user_id
    Route::get('lists/{id}', [RecipeListController::class , 'getAllLists']);
    // create a list
    Route::post('list', [RecipeListController::class , 'createList']);
    // update a list
    Route::put('list/{list_id}', [RecipeListController::class , 'update']);
    // delete a list
    Route::delete('list/{id}', [RecipeListController::class , 'deleteList']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
