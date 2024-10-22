<?php
// Start or resume the session
session_start();

// Destroy the session and unset all session variables
session_destroy();
session_unset();

// Redirect the user to the login page after logout
header("Location: login.php");
exit;
?>
