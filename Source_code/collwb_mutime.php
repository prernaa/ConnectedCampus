<?
include "dbconnect.php"; //Connect to the database
$GrpID=$_POST['GrpID']; //id of the whiteboard group
$currenttime= date("Y-m-d G:i:s", time()); //notes the time of mouse up
$sql2="UPDATE collwb_event SET md=0 WHERE GroupID=$GrpID AND Activewb=1"; //records in the DB that the whiteboard is currently on mouse up i.e. the mouse is not down

if (!mysql_query($sql2)) {
    die(mysql_error());} 

$sql="UPDATE collwb_event SET lastmu='".$currenttime."' WHERE GroupID=$GrpID AND Activewb=1"; //posts the mouse up event along with time of mouse up to the table in the database

if (!mysql_query($sql)) {
    die(mysql_error());} 


?>