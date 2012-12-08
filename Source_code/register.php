<?php
//Start Session and Connect to Database
session_start();

include("dbconnect.php");
//Get POST data
$email=$_POST['email'];
$password=md5($_POST['password']);
$name=$_POST['name'];

//Check if email already registered, if yes, send to main page, with error
$q=mysql_query("SELECT * FROM user_information WHERE email='$email'");
if(mysql_num_rows($q)==1)
{
$_SESSION['error']=2;
header("location:index.php");
exit();
}
else
{
//Make entry to database
$q=mysql_query("INSERT INTO user_information VALUES(null,'$password','$email','$name','','','','','','1','','','','','','')");
//Start session, send to profile_main
$_SESSION['email']=$email;

header("location:profile_main.php");
exit();
}
echo "</center></div>";
include("footer.php");
?>