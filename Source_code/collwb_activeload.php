<?
//This file loads the already saved whiteboard which the user wishes to open 
include "dbconnect.php"; //Connect to the Database
$groupid=$_POST['GrpID']; //id of the whiteboard group
$archid=$_POST['archid']; //id of whiteboard to be loaded
$archive=mysql_fetch_array(mysql_query("SELECT * FROM collwb_archive WHERE GroupID=".$groupid." AND archID=". $archid)); 
//fetches the coordinates of that saved whiteboard which is to be loaded

$sql="DELETE FROM collwb_event WHERE GroupID=".$groupid." AND Activewb=1"; //deletes active whiteboard for the group
// DELETE HAS TO BE BEFORE INSERT
mysql_query($sql);
$sql2="INSERT INTO collwb_event VALUES('', ".$groupid.", '".$archive['eventarray']."', 1, 0, '')"; //inserts new wb with the coordinates of the whiteboard to be loaded
mysql_query($sql2);
?>