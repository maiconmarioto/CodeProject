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
Route::get('/', function(){
    return view('welcome');
});

Route::post('oauth/access_token', function(){
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware' => 'oauth'], function() {

    Route::resource('client', 'ClientController', ['except' => ['create','edit']]);

//    Route::group(['middleware' => 'CheckProjectOwner'], function()    {
    Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);
//    });
    Route::group(['prefix'=>'project'], function(){
        Route::get('{id}/note', 'ProjectNoteController@index');
        Route::post('{id}/note/', 'ProjectNoteController@store');
        Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
        Route::delete('note/{id}', 'ProjectNoteController@destroy');

        Route::get('{id}/task', 'ProjectTaskController@index');
        Route::post('{id}/task/', 'ProjectTaskController@store');
        Route::get('{id}/task/{taskId}', 'ProjectTaskController@show');
        Route::get('{id}/task/{taskId}', 'ProjectTaskController@show');
        Route::delete('task/{id}', 'ProjectTaskController@destroy');

        Route::post('{id}/addmember','ProjectController@addMember');
        Route::post('{id}/removemember','ProjectController@removeMember');
        Route::get('{id}/members','ProjectController@showMembers');
    });
});


