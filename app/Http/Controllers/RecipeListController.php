<?php

namespace App\Http\Controllers;

use App\Models\user_list;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;


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

    public function index($userId)
    {
        $userList = user_list::all()->where('user_id', $userId);

        return $this->responseHandler(($userList), 'User lists retrieved');
    }

    public function getList($id)
    {
        if (user_list::where('id', $id)->exists()) {
            $list = user_list::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($list, 200);
        }
        else {
            return response()->json([
                "message" => "List not found"
            ], 404);
        }


    }

    public function createList(Request $request)
    {
        $list = new user_list();
        $list->user_id = $request->user_id;
        $list->title = $request->title;
        $list->save();

        return response()->json([
            "message" => "List record has been created"
        ], 200);
    }

    public function getAllLists($user_id)
    {
        if (user_list::where('user_id', $user_id)->exists()) {
            $lists = user_list::where('user_id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($lists, 200);
        }
        else {
            return response()->json([
                "message" => "Users list are empty"
            ]);
        }
    }



    public function deleteList($id)
    {

        $userList = user_list::find($id);
        if (is_null($userList)) {
            return $this->errorHandler($userList, 'List not found');
        }
        $userList->delete();

        return $this->responseHandler([], 'List deleted');
    }
}
