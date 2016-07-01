<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('tasks.index');
});

Route::auth();

Route::get('/auth/{provider}', function (string $provider) {
    $provider = ucfirst($provider);
    return "Auth\\AuthController@redirectTo$provider";
});
Route::get('/auth/{provider}/callback', function (string $provider) {
    $providerCallback = ucfirst($provider).'Callback';
    return "Auth\\AuthController@handle$providerCallback";
});

/**
 * Teamwork routes
 */
Route::group(['prefix' => 'teams', 'namespace' => 'Teamwork'], function ()
{
    Route::get('/', 'TeamController@index')->name('teams.index');
    Route::get('create', 'TeamController@create')->name('teams.create');
    Route::post('teams', 'TeamController@store')->name('teams.store');
    Route::get('edit/{id}', 'TeamController@edit')->name('teams.edit');
    Route::put('edit/{id}', 'TeamController@update')->name('teams.update');
    Route::delete('destroy/{id}', 'TeamController@destroy')->name('teams.destroy');
    Route::get('switch/{id}', 'TeamController@switchTeam')->name('teams.switch');

    Route::get('members/{id}', 'TeamMemberController@show')->name('teams.members.show');
    Route::get('members/resend/{invite_id}', 'TeamMemberController@resendInvite')->name('teams.members.resend_invite');
    Route::post('members/{id}', 'TeamMemberController@invite')->name('teams.members.invite');
    Route::delete('members/{id}/{user_id}', 'TeamMemberController@destroy')->name('teams.members.destroy');

    Route::get('accept/{token}', 'AuthController@acceptInvite')->name('teams.accept_invite');
});

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth, role:admin']], function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::group(['prefix' => 'user'], function () {
       Route::resource('/', 'UserController');
    });
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/
Route::group(['prefix' => 'api', 'middleware' => ['api', 'auth:api']], function () {
    /**
     * Task Routes...
     */
    Route::get('/teams/{team}/tasks', 'API\TaskController@all');
    Route::post('/teams/{team}/tasks', 'API\TaskController@store');
    Route::get('/teams/{team}/tasks/{task}', 'API\TaskController@show');
    Route::delete('/teams/{team}/tasks/{task}', 'API\TaskController@destroy');
});