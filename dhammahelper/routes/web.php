<?php

Route::get('/', 'PagesController@index');

Route::get('/about', 'PagesController@about');

Route::get('/meditate', 'PagesController@meditate');

Route::get('/account', 'PagesController@account');

Route::get('/timed', 'PagesController@timed');

Route::get('/random', 'PagesController@random');

Route::post('/finished', array('uses' => 'MeditationController@finished'));

Route::post('/timed', array('uses' => 'MeditationController@timed'));

Route::post('/random', array('uses' => 'MeditationController@random'));

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/journal', array('uses' => 'MeditationController@journal'));

Route::get('/log', 'PagesController@log');

Route::get('/view/{id}', ['uses' => 'PagesController@view']);

Route::post('/audioSave', array('uses' => 'MeditationController@audioSave'));

Route::post('/audioDelete', array('uses' => 'MeditationController@audioDelete'));

Route::post('/friendsearch', array('uses' => 'FriendsController@search'));

Route::post('/sendInvite', array('uses' => 'FriendsController@sendInvite'));

Route::get('/notifications', 'PagesController@notifications');

Route::post('/resolve', array('uses' => 'PagesController@resolve'));

Route::post('/loadChart', array('uses' => 'HomeController@loadChart'));

Route::post('/reloadChart', array('uses' => 'HomeController@reloadChart'));

Route::post('/averageMeditationLength', array('uses' => 'HomeController@averageMeditationLength'));

Route::post('/averageMinutesPerDay', array('uses' => 'HomeController@averageMinutesPerDay'));

Route::post('/longestRun', array('uses' => 'HomeController@longestRun'));

Route::post('/currentRun', array('uses' => 'HomeController@currentRun'));

Route::get('/redirect', 'SocialAuthFacebookController@redirect');

Route::get('/callback', 'SocialAuthFacebookController@callback');

Route::get('/details', 'PagesController@details');

Route::post('/changeUsername', array('uses' => 'PagesController@changeUsername'));

Route::get('/googleRedirect', 'SocialAuthGoogleController@googleRedirect');

Route::get('/google', 'SocialAuthGoogleController@google');

Route::post('/checkForUsername', array('uses' => 'HomeController@checkForUsername'));

Route::post('/incrementLogin', array('uses' => 'PagesController@incrementLogin'));

Route::get('/timeline', 'PagesController@timeline');