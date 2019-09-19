<?php

header('Content-Type: text');

require __DIR__.'/../vendor/autoload.php';

require '../routes/routes.php';

$app = new App\Application();

$app->handle(new App\Request());
