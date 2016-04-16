<?php

Route::get('/', function () {
    return view('app');
});

Route::post('oauth/access_token', function () {
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware' => 'oauth'], function () {

    Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);

    Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);

    Route::group(['prefix' => 'project/{id}'], function () {
//		Route::resource('note', 'ProjectNoteController', ['except' => ['create', 'edit']]);

        Route::get('/member','ProjectMemberController@index');
        Route::post('/addmember','ProjectMemberController@store');
        Route::delete('/member/{memberId}', 'ProjectMemberController@destroy');
        Route::get('/member/{memberId}', 'ProjectMemberController@show');




        Route::get('/note', 'ProjectNoteController@index');
        Route::post('/note', 'ProjectNoteController@store');
        Route::put('/note/{idNote}', 'ProjectNoteController@update');
        Route::get('/note/{idNote}', 'ProjectNoteController@show');
        Route::delete('/note/{idNote}', 'ProjectNoteController@destroy');


        Route::resource('task', 'ProjectTaskController', ['except' => ['create', 'edit']]);
        //Route::resource('member', 'ProjectMemberController', ['except' => ['create', 'edit']]);

        Route::get('file/{fileId}', 'ProjectFileController@show');
        Route::post('file', 'ProjectFileController@store');
        Route::delete('file/{fileId}', 'ProjectFileController@destroy');

    });

    Route::get('/user/authenticated', 'UserController@authenticated');
});

//        Route::get('/note', 'ProjectNoteController@index');
//        Route::post('/note/', 'ProjectNoteController@store');
//        Route::get('/note/{noteId}', 'ProjectNoteController@show');
//        Route::delete('/note/{noteId}', 'ProjectNoteController@destroy');

//        Route::get('{id}/task', 'ProjectTaskController@index');
//        Route::post('{id}/task/', 'ProjectTaskController@store');
//        Route::get('{id}/task/{taskId}', 'ProjectTaskController@show');
//        Route::delete('{id}/task/{taskId}', 'ProjectTaskController@destroy');
