<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
//        $this->middleware('auth');
    }

    public function login(Request $request) {
        $user = \App\User::where('email', $request->email)->first();
        if ($user && \Hash::check($request->password, $user->password)) {
            return response()->json([
                        'status' => "done",
                        "token" => encrypt($user->id)
            ]);
        }
        return response()->json([
                    "status" => "failed",
                    "msg" => "Emal or Password is wrong"
        ]);
    }

    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
                    'name' => 'required|min:2|max:50',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6',
                    'confirm_password' => 'required|min:6|max:20|same:password',
        ]);
        if ($validator->fails())
            return response()->json([
                        "status" => "failed",
                        "errors" => $validator->errors()
            ]);

        $requestData = $request->all();

        $requestData['password'] = bcrypt($requestData['password']);

        \App\User::create($requestData);

        return response()->json([
                    "status" => "done"
        ]);
    }

}
