<?php
session_start();

// unset all sessions
$_SESSION = array();

// destroy sessions 
session_destroy();

// go back to login page if all sessions are destroyed
header("Location: ../html/login.html");
exit();

// for debugging only
echo "You have been logged out. Redirecting...";
?>

