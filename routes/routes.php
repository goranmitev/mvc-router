<?php

use App\Route;



// Route::get('/patients/{asdf}/metrics/{utut}', function () {
//     echo 'Homepage';
// });

Route::resource('patients');
Route::resource('patients.metrics');

// Route::get('/clients', 'ClientController@index');