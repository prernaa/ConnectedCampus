<?php 

$auth=1; //user must be logged in to view this page 
include "includes.php"; 

$logmail=$_SESSION['email'];//E-mail of current user logged in
$logname=getName($logmail);//Name of logged in user
$byuser=mysql_fetch_array(mysql_query("SELECT * FROM user_information WHERE email='".$logmail."'"));
$text=$_POST['text']; //now we take the "usertext" which is stored in $_POST['text']
$GrpID=$_POST['grpid'];
$text=trim($text);
$currenttime=date("Y-m-d G:i:s", time());
//Makes the member writing the chat message in the wb group active in the table in the db
$sql2="UPDATE collwb_groupmembers SET Activity=1 WHERE GroupID=".$GrpID." AND userid=".$byuser['userid'];
if (!mysql_query($sql2)) {
    die(mysql_error());} 
//records the date & time of the latest activity of the user writing the chat message in the whiteboard group
$sql3="UPDATE collwb_groupmembers SET LastUserActivity='".$currenttime."' WHERE GroupID=".$GrpID." AND userid=".$byuser['userid'];
if (!mysql_query($sql3)) {
    die(mysql_error());} 


if($byuser['userid']==''){
	header('Location: http://connectedcampus.org/errorpage.php');
}
if($text!=''){ //if the chat message is not blank then insert it to table in database
$sql="INSERT INTO classwb_chat(GroupID, ByUserID, StoreTime, Msg) VALUES('".$GrpID."', '".$byuser['userid']."', '".$currenttime."', '".$text."')";

if (!mysql_query($sql)) {
    die(mysql_error());} 
}
?>
