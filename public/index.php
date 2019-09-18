<?php

header('Content-Type: text');

use App\Route;

require __DIR__.'/../vendor/autoload.php';

require '../routes/routes.php';

// Route::get('/patients', function() {
//     echo 'getting all patients';
// });

Route::get('/patients/{id}', function() {
    echo 'getting one patient with ID={}';
});

Route::handle(new App\Request());
