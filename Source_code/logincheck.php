<?php
//Start session and connect to Database
session_start();
include("dbconnect.php");
//Get email, password from database
$email=$_POST['email'];
$password=md5($_POST['password']);
//Check against database
$q=mysql_query("SELECT * FROM user_information WHERE email='".$email."' AND password='".$password."'");
//If returned true, set session
if(mysql_num_rows($q)==1)
{
$_SESSION['email']=$email;
//If coming from an URL, redirect him there
if(isset($_SESSION['url']))
{

if(!($_SESSION['url']=="/includes/fsql.php"))
{
header("location:".$_SESSION['url']."");
}
//Send him to profile_main
else
{
header("location:profile_main.php");
}
}
else
{
header("location:profile_main.php");
}


}
else
{
$_SESSION['error']=1;
header("location:index.php");
echo mysql_num_rows($q);
}
echo "</center></div>";
include("footer.php");
?>