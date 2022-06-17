<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{

    public function getResponse($data)
    {
        $response = [
            'success' => true,
            'data' => $data,

        ];
        return response()->json($response, 200);
    }

    public function getList($id)
    {
        $recipes = Recipe::all()->where('user_list_id', $id);
        return $this->getResponse($recipes);
    }

    public function create(Request $request)
    {
        if (Recipe::where('recipe_id', $request->recipe_id)->where('user_list_id', $request->user_list_id)->exists()) {
            return response()->json([
                "message" => "Recipe already in the list"
            ]);
        }
        else {
            $recipe = new Recipe;
            $recipe->recipe_id = $request->recipe_id;
            $recipe->photo_url = $request->photo;
            $recipe->user_list_id = $request->user_list_id;
            $recipe->title = $request->title;
            $recipe->save();

            return response()->json([
                "message" => "Recipe created"
            ]);
        }


    }

    public function delete($id)
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
