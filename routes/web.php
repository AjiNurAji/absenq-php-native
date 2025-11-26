<?php

use App\Core\Router;

Router::get('/', function () {
  echo 'Welcome to the Home Page!';
});