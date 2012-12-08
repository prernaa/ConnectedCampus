<?
include "dbconnect.php"; //Connect to the database
$GrpID=$_POST['GrpID']; //id of the whiteboard group
$sql2="UPDATE collwb_event SET md=1 WHERE GroupID=$GrpID AND Activewb=1"; //records the mouse down event in the table in the database

if (!mysql_query($sql2)) {
    die(mysql_error());} 

?>