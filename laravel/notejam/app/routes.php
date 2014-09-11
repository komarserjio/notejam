<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('before' => 'auth'), function()
{
    Route::get('/', array(
        'as' => 'all_notes', 'uses' => 'NoteController@index'
        )
    );

    # user related routes (authed)
    Route::get('settings', array(
        'as' => 'settings', 'uses' => 'UserController@settings'
        )
    );
    Route::post('settings', array(
        'as' => 'settings.update', 'uses' => 'UserController@updateSettings'
        )
    );
    Route::get('signout', array('as' => 'signout', function() {
        Auth::logout();
        return Redirect::route('signin');
    }));

    # customized pad resource controller
    Route::post('pads/{id}/update', array(
        'as' => 'pads.update', 'uses' => 'PadController@update'
        )
    );
    Route::get('pads/{id}/delete', array(
        'as' => 'pads.delete', 'uses' => 'PadController@delete'
        )
    );
    Route::post('pads/{id}/delete', array(
        'as' => 'pads.destroy', 'uses' => 'PadController@destroy'
        )
    );
    Route::resource('pads', 'PadController',
        array('except' => array('destroy', 'index', 'update')));

    # customized note resource controller
    Route::post('notes/{id}/update', array(
        'as' => 'notes.update', 'uses' => 'NoteController@update'
        )
    );
    Route::get('notes/{id}/delete', array(
        'as' => 'notes.delete', 'uses' => 'NoteController@delete'
        )
    );
    Route::post('notes/{id}/delete', array(
        'as' => 'notes.destroy', 'uses' => 'NoteController@destroy'
        )
    );
    Route::resource('notes', 'NoteController',
        array('except' => array('destroy', 'index', 'update')));
});

# user related routes (anonymous)
Route::get(
    'signup',
    array('as' => 'signup', 'uses' => 'UserController@signup')
);
Route::post(
    'signup',
    array('as' => 'user.store', 'uses' => 'UserController@store')
);

Route::get(
    'signin',
    array('as' => 'signin', 'uses' => 'UserController@signin')
);
Route::post(
    'signin',
    array('as' => 'signin.process', 'uses' => 'UserController@processSignin')
);
Route::match(
    array('GET', 'POST'),
    'forgot-password',
    array('as' => 'forgot_password', 'uses' => 'UserController@forgotPassword')
);

