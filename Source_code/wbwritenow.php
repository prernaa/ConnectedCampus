<?
include "dbconnect.php"; //Connect to the database
$GrpID=$_POST['GrpID']; //id of the whiteboard group
$LogID=$_POST['LogID']; //userid of the logged in user or user who is saving the whiteboard
$currenttime= date("Y-m-d G:i:s", time()); //gets the current time
mysql_query("UPDATE collwb_groupmembers SET Mode=0 WHERE GroupID=".$GrpID); //Returns all users to view mode. To ensure only 1 user is on write mode at a time
mysql_query("UPDATE collwb_groupmembers SET Mode=1 WHERE GroupID=".$GrpID." AND userid=".$LogID); //Changes userid clicking on "write now" to write mode
$sql="UPDATE collwb_event SET lastmu='".$currenttime."' WHERE GroupID=$GrpID AND Activewb=1"; //records this time as mouseup time since mouse up time indicates nothing but activity

if (!mysql_query($sql)) {
    die(mysql_error());} 

?>
