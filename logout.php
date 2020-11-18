<?php
//session_start();
//session_destroy();
//echo "<script>window.open('index.php','_self')</script>";

// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: login1.php");
exit;
?>