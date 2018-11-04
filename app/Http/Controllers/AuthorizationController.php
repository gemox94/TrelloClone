<?php

namespace App\Http\Controllers;

// Dependencies
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp;
use \Exception;
use Validator;

// Models
use App\Role;
use App\User;

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

            $oauth_client = DB::table('oauth_clients')->where('id', 2)->first();

            if (!$oauth_client) {
                return response()->json(['error' => 'Passport not working properly!'], 500);
            }

            $http = new GuzzleHttp\Client;
            $response = $http->post(env('PROJECT_URL').'/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $oauth_client->id,
                    'client_secret' => $oauth_client->secret,
                    'username' => $email,
                    'password' => $pass,
                    'scope' => '',
                ],
            ]);

            $auth_token = json_decode((string) $response->getBody(), true);

            $user->access_token = $auth_token['access_token'];
            $user->refresh_token = $auth_token['refresh_token'];
            $user->save();

            $status_code = 200;
            $response = ['auth' => $user->access_token];

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
                return response()->json(['errors' => $validator->errors()], 401);
            }

            $email = $request->get('email');
            $pass = $request->get('password');
            $credentials = ['email' => $email, 'password' => $pass];
            if (Auth::once($credentials)) {
                $user = User::where('email', $email)->first();
                $status_code = 200;
                $response = ['auth' => $user->access_token];
            } else {
                $status_code = 401;
                $response = ['error' => 'Bad Credentials!'];
            }

            /* $oauth_client = DB::table('oauth_clients')->where('id', 2)->first();

            if (!$oauth_client) {
                return response()->json(['error' => 'Passport not working properly!'], 500);
            }

            $http = new GuzzleHttp\Client;
            $response = $http->post(env('PROJECT_URL').'/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $oauth_client->id,
                    'client_secret' => $oauth_client->secret,
                    'username' => $email,
                    'password' => $pass,
                    'scope' => '',
                ],
            ]);

            $status_code = 200;
            $response = ['auth' => json_decode((string) $response->getBody(), true)]; */

        } catch(Exception $e) {
            $status_code = 500;
            $response = ['error' => $e->getMessage()];
        }

        return response()->json($response, $status_code);
    }
}
