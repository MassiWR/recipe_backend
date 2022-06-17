<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;


class AuthController extends Controller
{
    public function getAllUsers(Request $request)
    {
        return response(User::all()->toJson(JSON_PRETTY_PRINT), 200);
    }

    public function getResponse($data)
    {
        $response = [
            'success' => true,
            'data' => $data,

        ];
        return response()->json($response, 200);
    }


    public function getErrors($error, $errorMessage = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessage)) {
            $response['data'] = $errorMessage;
        }
        return response()->json($response, $code);
    }


    // register controller function
    public function register(Request $request)
    {
        $fields = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',

        ]);

        if ($fields->fails()) {
            return $this->getErrors($fields->errors());
        }
        ;

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $success['token'] = $user->createToken('token')->plainTextToken;
        $success['name'] = $user->name;
        $success['email'] = $user->email;
        $success['user_id'] = $user->id;

        return $this->getResponse($success);

    }


    // login controller function
    public function login(Request $request)
    {
        $fields = $request->validate([

            'email' => 'required|string',
            'password' => 'required|string',

        ]);

        // check email

        $user = User::Where('email', $fields['email'])->first();

        // check password

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'invalid credentials'
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'user_id' => $user->id];

        return response()->json($response, 200);
    }


    // log out function

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logged out'
        ];
    }
}
