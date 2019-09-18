<?php

use App\Route;

Route::resource('patients');
Route::resource('patients.metrics');

Route::get('/', function () {
    echo 'Homepage';
});
