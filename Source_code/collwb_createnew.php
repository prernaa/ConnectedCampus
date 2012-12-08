<?
include "dbconnect.php"; //Connect to the database
$groupid=$_POST['GrpID']; //id of the whiteboard group
$sql="DELETE FROM collwb_event WHERE GroupID=".$groupid." AND Activewb=1"; //deletes active whiteboard for the group 
//DELETE HAS TO BE BEFORE INSERT
mysql_query($sql);
$sql2="INSERT INTO collwb_event VALUES('', ".$groupid.", '', 1, 0, '')"; //inserts new wb with no coordinates i.e. totally blank
mysql_query($sql2);
?>