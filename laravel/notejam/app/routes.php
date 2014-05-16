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

