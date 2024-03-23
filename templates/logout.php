<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Disable caching to prevent back button access
echo '<script>window.location.href = "login.php";</script>';
echo '<script>window.onpageshow = function(event) { if (event.persisted) { window.location.reload(); } };</script>';
?>



