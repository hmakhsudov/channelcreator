<?php
// Start or resume the session
session_start();

// Destroy the session
session_destroy();

// Redirect the user to the login page or any other desired location
header("Location: login.html");
exit;
?>
