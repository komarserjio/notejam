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
    Route::get('settings', array(
        'as' => 'settings', 'uses' => 'UserController@settings'
        )
    );
    Route::get('signout', array('as' => 'signout', function() {
        Auth::logout();
        return Redirect::route('signin');
    }));

    Route::match(array('GET', 'POST'), 'pads/create', array(
        'as' => 'create_pad', 'uses' => 'PadController@create'
        )
    );
    Route::match(array('GET', 'POST'), 'pads/{id}/edit', array(
        'as' => 'edit_pad', 'uses' => 'PadController@edit'
        )
    );
    Route::match(array('GET', 'POST'), 'pads/{id}/delete', array(
        'as' => 'delete_pad', 'uses' => 'PadController@delete'
        )
    );

    Route::match(array('GET', 'POST'), 'notes/create', array(
        'as' => 'create_note', 'uses' => 'NoteController@create'
        )
    );
    Route::match(array('GET', 'POST'), 'notes/{id}/edit', array(
        'as' => 'edit_note', 'uses' => 'NoteController@edit'
        )
    );
});

Route::match(
    array('GET', 'POST'),
    'signup',
    array(
        'as' => 'signup',
        'uses' => 'UserController@signup'
    )
);
Route::match(
    array('GET', 'POST'),
    'signin',
    array(
        'as' => 'signin',
        'uses' => 'UserController@signin'
    )
);

