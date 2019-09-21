<?php

use App\Route;



// Route::get('/', function () {
//     echo 'Homepage';
// });

Route::resource('patients');
Route::resource('patients.metrics');
