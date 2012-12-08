<?
//Start Session
session_start();
//Unset variables and destroy session
unset($_SESSION['email']); 
unset($_SESSION['url']);
session_unset();     
session_destroy();
//Redirect to index
header("location:index.php");

?>