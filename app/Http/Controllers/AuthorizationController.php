<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use GuzzleHttp;
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
            $user->password = bcrypt($pass);
            $user->role()->associate($role_admin);
            $user->save();

            $status_code = 200;
            $response = ['user' => $user];

        } catch (Exception $e) {
            $status_code = 500;
            $response = ['error' => $e->getMessage()];
        }

        return response()->json($response, $status_code);
    }


    public function login(Request $request) {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $email = $request->get('email');
            $pass = $request->get('password');

            $http = new GuzzleHttp\Client;
            $response = $http->post(env('PROJECT_URL').'/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => 2,
                    'client_secret' => '2ZexhBO7K760aw2RxaGF6i1x2yfv8kpGwSE1O4kq',
                    'username' => 'gerardo.mx.rz@gmail.com',
                    'password' => 'password',
                    'scope' => '',
                ],
            ]);

            $status_code = 200;
            $response = ['auth' => json_decode((string) $response->getBody(), true)];

        } catch(Exception $e) {
            $status_code = 500;
            $response = ['error' => $e->getMessage()];
        }

        return response()->json($response, $status_code);
    }
}
