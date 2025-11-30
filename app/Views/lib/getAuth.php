<?php

// start session if not already started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// check if user is logged in
$auth = $_SESSION["user"] ?? null;

// make $auth variable available globally in views
$GLOBALS["auth"] = $auth;