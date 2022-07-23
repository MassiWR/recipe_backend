<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RecipeListController extends Controller
{
    //is object the right return type of the function?
    public function responseHandler($result, $msg): object
    {
        $res = [
            'success' => true,
            'data' => $result,
            'message' => $msg
        ];

        return response()->json($res, 200);
    }

    public function errorHandler($error, $errorMsg = [], $code = 404): object
    {
        $res = [
            'success' => false,
            'data' => $error
        ];

        if (!empty($errorMsg)) {
            $res['data'] = $errorMsg;
        }
        return response()->json($res, $code);
    }

    public function getAllLists($userId)
    {
        $userList = UserList::all()->where('user_id', $userId);
        return $userList;
    }

    public function getList($id)
    {
        if (UserList::where('id', $id)->exists()) {
            $list = UserList::where('id', $id)->get();
            return response()->json([
                "data": $list;
            ], 200);
        }
        else {
            return "List not found";

        }
    }

    public function createList(Request $request)
    {
        $validator = Validator::make($request->only('title'), [
            'title' => 'required|string|between:2,50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
        }

        // request is valid, create new list
        $recipeList = auth()->user()->UserList()->create([
            'title' => $request->title
        ]);

        if ($recipeList) {
            return response()->json([
                "message" => "List {$recipeList->title} created"
            ], 200);
        }
        else {
            return response()->json([
                "message" => "{$recipeList->title} could not be created"
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserList  $recipeList
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->only('title'), [
            'title' => 'required|string|between:2,50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
        }

        $recipeList = UserList::find($id)->update([
            'title' => $request->title
        ]);

        if ($recipeList) {
            return response()->json([
                "message" => "List title updated"
            ], 201
            );
        }
        else {
            return response()->json([
                "message" => "List could not be update"
            ], 401);
        }
    }


    public function deleteList($id)
    {
        $userList = UserList::find($id);
        if (is_null($userList)) {
            return $this->errorHandler($userList, 'List not found');
        }
        $userList->delete();

        if ($userList) {
            return response()->json([
                "message" => "{$userList->title} deleted"
            ], 201);
        }
        else {
            return response()->json([
                "message" => "{$userList->title} could not be deleted"
            ], 401);
        }
    }
}
