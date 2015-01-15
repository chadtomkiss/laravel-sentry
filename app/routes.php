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

Route::get('/', 'HomeController@getIndex');

Route::group(array('prefix' => 'account'), function() {

	Route::get('/', array('as' => 'account', 'uses' => 'AccountController@getIndex'));

    Route::get('signup', array('as' => 'account.signup', 'uses' => 'AccountController@getSignup'));
    Route::post('signup', array('as' => 'account.signup.post', 'uses' => 'AccountController@postSignup'));

    Route::get('login', array('as' => 'account.login', 'uses' => 'AccountController@getLogin'));
    Route::post('login', array('as' => 'account.login.post', 'uses' => 'AccountController@postLogin'));
});