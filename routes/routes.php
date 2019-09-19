<?php

use App\Route;



Route::get('/', function () {
    echo 'Homepage';
});

Route::resource('patients');
Route::resource('patients.metrics');

// Route::get('/patients/{id}', function() {
//     echo 'getting one patient with ID={}';
// });
