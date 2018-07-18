<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('test-token/user', function(Request $request) {
    $user = $request->user();
    return response()->json(['user' => $user]);
});

Route::middleware(['auth:api'])->group(function () {

    /*
 * Teams endpoints
 */

    Route::get('/teams', 'TeamController@get');
    Route::post('/teams', 'TeamController@create');
    Route::get('/teams/{team_id}', 'TeamController@get');
    Route::put('/teams/{team_id}', 'TeamController@update');
    Route::delete('/teams/{team_id}', 'TeamController@delete');

});
/*
 *  Authorization endpoints
 */
Route::post('/login', 'AuthorizationController@login');
Route::post('/signup', 'AuthorizationController@signup');
Route::get('/logout', 'AuthorizationController@logout');


/*
 * Users endpoints
 */
Route::get('/users/{user_id}', 'UserController@get');
Route::put('/users/{user_id}', 'UserController@update');

/*
 * Users Team endpoints
 */

Route::get('/teams/{team_id}/users', 'UserTeamController@get');
Route::post('/teams/users', 'UserTeamController@create');

/*
 * Projects endpoints
 */

Route::get('/projects', 'ProjectController@get');
Route::post('/projects', 'ProjectController@create');
Route::get('/projects/{project_id}', 'ProjectController@get');
Route::put('/projects/{project_id}', 'ProjectController@update');
Route::delete('/projects/{project_id}', 'ProjectController@delete');

/*
 * Boards endpoints
 */

Route::get('/boards', 'BoardController@get');
Route::post('/boards', 'BoardController@create');
Route::get('/boards/{board_id}', 'BoardController@get');
Route::put('/boards/{board_id}', 'BoardController@update');
Route::delete('/boards/{board_id}', 'BoardController@delete');

/*
 * Teams endpoints
 */

Route::get('/cards', 'CardController@get');
Route::post('/cards', 'CardController@create');
Route::get('/cards/{card_id}', 'CardController@get');
Route::put('/cards/{card_id}', 'CardController@update');
Route::delete('/cards/{card_id}', 'CardController@delete');

/*
 * Roles endpoints
 */

Route::get('/roles', 'RoleController@get');
Route::post('/roles', 'RoleController@create');
Route::get('/roles/{role_id}', 'RoleController@get');
Route::put('/roles/{role_id}', 'RoleController@update');
Route::delete('/roles/{role_id}', 'RoleController@delete');
