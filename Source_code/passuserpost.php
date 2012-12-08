<?
include "dbconnect.php"; //Connect to the database
$nextuser=$_POST['passtouser']; //userid of the user whom the pen or write mode has been passed to
$grpid=$_POST['grpid']; //id of the whiteboard group
mysql_query("UPDATE collwb_groupmembers SET Mode=0 WHERE GroupID=".$grpid);//returns all users to view (for double check reasons that no 2 users can be write at 1 time)
mysql_query("UPDATE collwb_groupmembers SET Mode=1 WHERE GroupID=".$grpid." AND userid=".$nextuser); //Then puts this user into the write mode
?>