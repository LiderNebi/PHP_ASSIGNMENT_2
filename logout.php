<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Unseting all session variables
$_SESSION = array();


session_destroy();

// Directing to login
header("Location: login.php");
exit;
?>