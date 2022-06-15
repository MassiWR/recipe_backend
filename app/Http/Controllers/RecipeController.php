<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    public function getAllRecipies($listid)
    {
        $recipies = Recipe::where('log_id', $listid)->get()->toJson(JSON_PRETTY_PRINT);
        return response($recipies, 200);
    }


    public function createRecipe(Request $request)
    {
        if (Recipe::where('recipe_id', $request->recipe_id)->where('user_list_id', $request->user_list_id)->exists()) {
            return response()->json([
                "message" => "Recipe already in the list"
            ]);
        }
        else {
            $recipe = new Recipe;
            $recipe->recipe_id = $request->recipe_id;
            $recipe->label = $request->label;
            $recipe->photo_url = $request->photo_url;
            $recipe->user_list_id = $request->user_list_id;
            $recipe->save();

            return response()->json([
                "message" => "Recipe record has been created"
            ]);
        }


    }


    public function deleteRecipe($id)
    {
        if (Recipe::where('id', $id)->exists()) {
            $recipe = Recipe::find($id);
            $recipe->delete();

            return response()->json([
                "message" => "Recipe deleted"
            ]);
        }
        else {
            return response()->json([
                "message" => "Recipe not found"
            ], 404);
        }
    }
}
