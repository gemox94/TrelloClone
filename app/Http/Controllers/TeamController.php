<?php

namespace App\Http\Controllers;

use App\Role;
use App\Team;
use Illuminate\Http\Request;
use \Exception;
use Validator;

class TeamController extends Controller
{

    private $team_deleted_status = 'deleted';

    public function get(Request $request, $team_id = null) {
        try {
            $user = $request->user();
            $admin_role = Role::where('name', 'Admin')->first();
            if ($user && $user['role_id'] === $admin_role['id']) {
                if ($team_id) {

                    $team = Team::whereNull('status')->find($team_id);
                    if ($team) {

                        $status = 200;
                        $response = ['team' => $team];
                    } else {

                        $status = 404;
                        $response = ['error' => 'Team with id '.$team_id.' not found'];
                    }

                } else {

                    $teams = Team::where('admin_id', $user['id'])->whereNull('status')->get();
                    $status = 200;
                    $response = ['teams' => $teams];
                }
            } else {

                $status = 401;
                $response = ['error' => 'Unauthenticated'];
            }
        } catch (Exception $e) {

            $status = 500;
            $response = ['error' => $e->getMessage()];
        }

        return response()->json($response, $status);
    }

    public function create(Request $request) {

        try {
            $user = $request->user();
            $admin_role = Role::where('name', 'Admin')->first();
            if ($user && $user['role_id'] === $admin_role['id']) {

                $validator = Validator::make($request->all(), ['name' => 'required']);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }

                $team = new Team;
                $team->name = $request->get('name');
                $team->admin()->associate($user);
                $team->save();

                $status = 200;
                $response = ['team' => $team];
            } else {
                $status = 401;
                $response = ['error' => 'Unauthenticated'];
            }
        } catch (Exception $e) {
            $status = 500;
            $response = ['error' => $e->getMessage()];
        }

        return response()->json($response, $status);
    }

    public function update(Request $request, $team_id) {
        try{
            $user = $request->user();
            $admin_role = Role::where('name', 'Admin')->first();
            if ($user && $user['role_id'] === $admin_role['id']) {

                $team = Team::find($team_id);

                if ($team && !$team->status) {
                    $validator = Validator::make($request->all(), ['name' => 'required']);

                    if ($validator->fails()) {
                        return response()->json(['errors' => $validator->errors()], 400);
                    }

                    $team->name = $request->get('name');
                    $team->save();
                    $status = 200;
                    $response = ['team' => $team];

                } else {

                    $status = 404;
                    $response = ['error' => 'Team with id '.$team_id.' not found'];
                }



            } else {

                $status = 401;
                $response = ['error' => 'Unauthenticated'];
            }

        } catch (Exception $e) {

            $status = 500;
            $response = ['error' => $e->getMessage()];
        }

        return response()->json($response, $status);
    }

    public function delete(Request $request, $team_id) {
        try{
            $user = $request->user();
            $admin_role = Role::where('name', 'Admin')->first();
            if ($user && $user['role_id'] === $admin_role['id']) {

                $team = Team::find($team_id);

                if ($team) {

                    $team->status = $this->team_deleted_status;
                    $team->save();
                    $status = 200;
                    $response = ['team' => $team];

                } else {

                    $status = 404;
                    $response = ['error' => 'Team with id '.$team_id.' not found'];
                }



            } else {

                $status = 401;
                $response = ['error' => 'Unauthenticated'];
            }

        } catch (Exception $e) {

            $status = 500;
            $response = ['error' => $e->getMessage()];
        }

        return response()->json($response, $status);
    }
}
