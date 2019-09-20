<?php

use App\Route;



Route::get('/', function () {
    echo 'Homepage';
});

Route::get('/patients/{patientId}/metrics/{metricId}');

// Route::resource('patients');
// Route::resource('patients.metrics');

// Route::get('/loans/{id}', function() {
//     echo 'getting one loan with ID={}';
// });
