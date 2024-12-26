<?php
// logout.php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the login page with a message
header("Location: login.php?logout=success");
exit;
?>
