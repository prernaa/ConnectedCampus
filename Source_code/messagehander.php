<?php
//Start session and connect to database
session_start();
include("dbconnect.php");
//Store POST variables
$msg=$_GET['msg'];
$sid=$_GET['sid'];
$rid=$_GET['rid'];
//IF name sent, get userid
if(isset($_GET['name']))
{
$h=mysql_query("SELECT * FROM user_information WHERE name='".$_GET['name']."'");
$h=mysql_fetch_array($h);
$rid=$h['userid'];
}
//Make a database entry
$q=mysql_query("INSERT INTO user_message VALUES(NULL,'$rid','$sid',0,'$msg',NOW())");
if($q)
{
//Display success, redirect to message
$f=mysql_query("SELECT * FROM user_message WHERE UserID='$rid' AND SenderID='$sid' AND Message='$msg'");
$f=mysql_fetch_array($f);

echo "<font color='green'>Sent Successfully</font>";

echo "<META HTTP-EQUIV=Refresh CONTENT='2; URL=viewmessage.php?id=".$f['ID']."'>";
}
else
{
echo "<font color='red'>Sending Failed</font>";
}
?>