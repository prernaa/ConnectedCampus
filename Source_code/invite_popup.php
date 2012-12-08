<?php
//Shows popup to invite peers
//Start session, check if logged in, connect to Database
session_start();
if(!(isset($_SESSION['email'])))
{
header('Location: index.php');
}
echo "<title>Invite</title>";
include("dbconnect.php");
//Store Userid
$uid=$user_data['userid'];
//If invite sent from whiteboard
if($_GET['action']=="wb")
{
//Store whiteboard data, groupid and classid
$wbid=$_GET['wbid'];
$wbcid=$_GET['classid'];
//Fetch more info about the whiteboard
$y=mysql_query("SELECT * FROM collwb_info WHERE GroupID='$wbid'");
$y=mysql_fetch_array($y);
//Display name
echo "Invite users to ".$y['Groupname']." !<br><br>";
}
//If invite was sent from event
if($_GET['action']=="event")
{
//Store event id
$eid=$_GET['eventid'];
//Fetch more event info
$y=mysql_query("SELECT * FROM eventsinterface WHERE eventid='$eid'");
$y=mysql_fetch_array($y);
//Check event privacy
$event_privacy = $y['privacy'];
//If event is closed and the inviting user is not the creator, exit
if($event_privacy==1 && $uid!=$y['byuserid'])
{
echo "Not Authorized !";
exit();
}
//Display name
echo "Invite users to ".$y['Event_Name']." !<br><br>";
}
//If invite was sent from class
if($_GET['action']=="class")
{
//Store class data
$cid=$_GET['classid'];
//Fetch class information
$y=mysql_query("SELECT * FROM class_information WHERE classid='$cid'");
$y=mysql_fetch_array($y);
//Get list of teachers and students
$j=mysql_query("SELECT * FROM class_teacher WHERE classid='$cid' AND userid='$uid'");
$m=mysql_query("SELECT * FROM class_subscribed WHERE classid='$cid' AND userid='$uid'");
//If privacy is closed then check whether 
if($y['privacy']==1)
{
//If the user is not a teacher, exit
if((!mysql_num_rows($j)))
{
echo "Not Authorized";
exit();
}
}
//If the user is not a student of the class, exit
if((!mysql_num_rows($j)) && (!mysql_num_rows($m)))
{
echo "Not Authorized";
exit();
}
//Display name
echo "Invite users to ".$y['classname']." !<br><br>";
}
//Select all peers
$q=mysql_query("SELECT * FROM friends WHERE userid='$uid'");

echo "<form name='invite' method='post' action='classinvite.php'><table name='invite'><tr><th></th><th></th><th>Name</th></tr>";
//Loop through friends
while($row=mysql_fetch_array($q))
{
$fid=$row['friendid'];
//Get friend information
$g=mysql_query("SELECT * FROM user_information WHERE userid='$fid'");
$g=mysql_fetch_array($g);
//If its class
if($_GET['action']=="class")
{
//Check if already subscribed
$r=mysql_query("SELECT * FROM class_subscribed WHERE userid='$fid' AND classid='$cid'");
//Check if already invited
$checking=mysql_query("SELECT * FROM class_invite WHERE rid='$fid' AND cid='$cid'");
if(mysql_num_rows($checking))
{
$flag=2;
}
}
else if($_GET['action']=="event")
{
//Check if already invited
$r=mysql_query("SELECT * FROM events_invitees WHERE userid='$fid' AND eventid='$eid'");

}
else if($_GET['action']=="wb")
{
//Check if already invited
$checking=mysql_query("SELECT * FROM collwb_invite WHERE rid='$fid' AND gid='$wbid'");
if(mysql_num_rows($checking))
{
$flag=2;
}
//If classid not set, check if from the group
if($wbcid=='0')
{
$r=mysql_query("SELECT * FROM collwb_groupmembers WHERE userid='$fid' AND GroupID='$wbid'");
}
else
{
$flag=1;
//Check if in class or group
$r=mysql_query("SELECT * FROM class_subscribed WHERE userid='$fid' AND classid='$wbcid'");
$y=mysql_query("SELECT * FROM collwb_groupmembers WHERE userid='$fid' AND GroupID='$wbid'");
}
}
//Display as checkbox, disable which is not appropriate
echo "<tr><td><input type='checkbox' name='friend[]' value='".$fid."' ";if($flag==2){echo"disabled='disabled'";}else if($flag==1){if(!(mysql_num_rows($r)) || (mysql_num_rows($y))){echo "disabled='disabled'";}}else{if(mysql_num_rows($r)){echo "disabled='disabled'"; }}echo "/></td><td><img src='";if(($g['photo'])==""){echo "img/defpic.png";}else{echo $g['photo'];}echo "' width='32' height='32'></td><td>".$g['name']."</td></tr>";
}
echo "</table>";
//If class, POST value of class
if($_GET['action']=="class")
{
echo "<input type='hidden' name='classid' value='".$cid."'>";
}
//If whiteboard, post value of whiteboard
else if($_GET['action']=="wb")
{
echo "<input type='hidden' name='wbid' value='".$wbid."'>";
}
//If event, post value of event
else if($_GET['action']=="event")
{
echo "<input type='hidden' name='eventid' value='".$eid."'>";
}
echo "<input type='submit' name='invite' value='Invite'>";

?>