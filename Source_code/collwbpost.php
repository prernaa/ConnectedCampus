<?
include "dbconnect.php"; //Connect to the database
$eventdata=$_POST['eventstore']; //gets the array of coordinates drawn
$GrpID=$_POST['GrpID']; //id of the whiteboard group
$sql="UPDATE collwb_event SET eventarray='".$eventdata."mu/' WHERE GroupID=$GrpID AND Activewb=1"; //puts the new coordinates into the table in the database

if (!mysql_query($sql)) {
    die(mysql_error());} 
?>