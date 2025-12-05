<?php

date_default_timezone_set("Asia/Jakarta");

use App\Core\Env;

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
Env::load(__DIR__ . '/../.env');

require __DIR__."/../routes/web.php";

App\Core\Router::dispatch();