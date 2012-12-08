<?
include "dbconnect.php"; //Connect to the database
$GrpID=$_POST['GrpID']; //id of the whiteboard group
$LogID=$_POST['LogID']; //userid of the logged in user or user who is saving the whiteboard
$currenttime= date("Y-m-d G:i:s", time()); //updates the last user activity in the table in the database. Indicates user activity
$sql="UPDATE collwb_groupmembers SET Activity=1, LastUserActivity='".$currenttime."' WHERE GroupID=".$GrpID." AND userid=".$LogID;
if (!mysql_query($sql)) {
    die(mysql_error());} 
?>
