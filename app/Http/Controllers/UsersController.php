<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                    "status" => "Email or Password is wrong"
        ]);
    }

}
