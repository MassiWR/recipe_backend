<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    public function getAllRecipies($listid)
    {
        $recipies = Recipe::where('list_id', $listid)->get()->toJson(JSON_PRETTY_PRINT);
        /*  $recipies = Recipe::whereIn('id', $id)->get()->get()->toJson(JSON_PRETTY_PRINT); */
        //return response(["id" => $id, "recipes" => $recipies], 200);
        return response($recipies, 200);
    }

    /*
     public function getRecipe($id){
     if(Recipe::where('id', $id)->exists()) {
     $recipe = Recipe::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
     return response($recipe, 200);
     } else {
     return response()->json([
     "message" => "Recipe not found"
     ], 404);
     }
     }*/

    public function createRecipe(Request $request)
    {
        if (Recipe::where('recipe_id', $request->recipe_api_id)->where('list_id', $request->list_id)->exists()) {
            return response()->json([
                "message" => "Recipe already in the list"
            ]);
        }
        else {
            $recipe = new Recipe;
            $recipe->recipe_id = $request->recipe_id;
            $recipe->label = $request->label;
            $recipe->img_url = $request->img_url;
            $recipe->list_id = $request->list_id;
            $recipe->save();

            return response()->json([
                "message" => "Recipe record has been created"
            ]);
        }


    }

    /* public function updateRecipe(Request $request, $id){
     if(Recipe::where('id', $id)->exists()) {
     $recipe = Recipe::find($id);
     $recipe->recipe_api_id = is_null($request->recipe_api_id) ? $recipe->recipe_api_id : $request->recipe_api_id;
     $recipe->label = is_null($request->label) ? $recipe->label : $request->label;
     $recipe->photo_url = is_null($request->photo_url) ? $recipe->photo_url : $request->photo_url;
     $recipe->save();
     return response()->json([
     "message" => "Recipe records updated successfully"
     ], 200);
     } else {
     return response()->json([
     "message" => "Recipe not found"
     ], 404);
     }
     } */

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
