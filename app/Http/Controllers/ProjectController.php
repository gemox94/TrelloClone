<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Team;
use \Exception;
use Validator;

class ProjectController extends Controller
{

    /*
     * Retrieve all projects or pass project_id to retrieve a single one
     * METHOD: GET
     * URI: /projects, /projects/{project_id}
     * PARAMS: project_id?
     * QUERY PARAMS: team_id?
     * RETURN: JSON
     */
    public function get(Request $request, $project_id=null) {
        try {

            $user = $request->user();
            if ($project_id) {
                if (Project::where('id', $project_id)->exists()) {
                    $status = 200;
                    $response = ['project' => Project::find($project_id)];
                
                } else {
                    $status = 404;
                    $response = ['error' => 'Project not found!'];
                }

            } else {
                $projects = Project::where('admin_id', $user->id)->get();
                $status = 200;
                $response = ['projects' => $projects];
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
            $validator = Validator::make($request->all(), ['name' => 'required']);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $project = new Project;
            $project->name = $request->get('name');
            $project->admin()->associate($user);
            $project->save();

            $status = 200;
            $response = ['project' => $project];


        } catch (Exception $e) {

            $status = 500;
            $response = ['error' => $e->getMessage()];
        }

        return response()->json($response, $status);
    }

    public function update(Request $request, $project_id) {
        try {
            $user = $request->user();
            if (!Project::where('id', $project_id)->exists()) {
                $status = 404;
                $response = ['error' => 'Project not found!'];

            } else {
                $project = Project::find($project_id);
                if ($request->has('name')) {
                    $project->name = $request->get('name');
                }

                if ($request->has('admin_id') && User::where('id', $request->get('admin_id'))->exists()) {
                    $project->admin()->associate(User::find($request->admin_id));
                }

                if ($request->has('team_id') && Team::where('id', $request->get('team_id'))->exists()) {
                    $project->team()->associate(Team::find($request->get('team_id')));  
                }

                $project->save();
                $status = 200;
                $response = ['project' => $project];

            }

        } catch (Exception $e) {
            $status = 500;
            $response = ['error' => $e->getMessage()];
            
        }

        return response()->json($response, $status);
    }
}