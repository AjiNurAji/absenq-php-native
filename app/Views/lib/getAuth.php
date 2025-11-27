<?php

// start session if not already started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// check if user is logged in
if (isset($_SESSION["username"])) {
  $auth = $_SESSION["username"];
} elseif (isset($_SESSION["student_id"])) {
  $auth = $_SESSION;
} else {
  $auth = null;
}

// make $auth variable available globally in views
$GLOBALS["auth"] = $auth;