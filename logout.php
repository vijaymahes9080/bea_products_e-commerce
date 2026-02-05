<?php
session_start();

// Destroy session data
session_unset();
session_destroy();

// Redirect to sign-in page
header("Location: signin.php");
exit();
?>
