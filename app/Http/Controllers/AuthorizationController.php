<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use \Exception;
use Validator;

class AuthorizationController extends Controller
{
    public function signup(Request $request) {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'name' => 'required',
                'last_name' => 'required',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $name = $request->get('name');
            $last_name = $request->get('name');
            $email = $request->get('email');
            $pass = $request->get('password');

            $role_admin = Role::where('name', 'Admin')->first();

            $user = new User;
            $user->name = $name;
            $user->last_name = $last_name;
            $user->email = $email;
            $user->password = encrypt($pass);
            $user->role()->associate($role_admin);
            $user->save();

            $status_code = 200;
            $response = ['token' => $user->createToken('signup')];

        } catch (Exception $e) {
            $status_code = 500;
            $response = ['error' => $e->getMessage()];
        }

        return response()->json($response, $status_code);
    }
}
