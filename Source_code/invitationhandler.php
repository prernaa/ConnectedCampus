<?php
//File handles data sent from users recieving class invites
//Start Session and connect to database
session_start();
include("dbconnect.php");
//If invite accepted
if($_GET['action']=="1")
{
//Store Classid and UserID
$uid=$user_data['userid'];
$cid=$_GET['cid'];
//Make database Entry
$q=mysql_query("INSERT INTO class_subscribed VALUES(NULL,'$uid','$cid',0,'0000-00-00')");
if($q)
{
echo "Successfuly Joined";
}

}
//Then remove entry from invites, if not accepted, only remove entry
$q=mysql_query("DELETE FROM class_invite WHERE rid='$uid' AND cid='$cid'");
echo "<meta http-equiv=refresh content='2; url=classinvitepopup.php'>";
?>