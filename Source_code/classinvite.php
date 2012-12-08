<!-- Include jquery -->
<script src="http://code.jquery.com/jquery-latest.js"></script>
<?php
//Include includes.php and connect to database
include("dbconnect.php");
include("includes.php");

//Store UserID
$uid=(int)$user_data['userid'];

//Check whether input is classid
if(isset($_POST['classid']))
{
//Store classid and loop through friends array sent
$cid=(int)$_POST['classid'];
for($i=0;isset($_POST['friend'][$i]);$i++)
{
//Store the ID
$fid=$_POST['friend'][$i];
//Add entry to DB
$sql="INSERT INTO class_invite (id, rid, sid, cid)
VALUES
(NULL, '$fid','$uid','$cid')";
mysql_query($sql);
$m=mysql_query("SELECT * FROM class_information WHERE classid='$cid'");
$m=mysql_fetch_array($m);
$cname=$m['classname'];
//Use setNotification to set an alert to the recieving user
$link="http://connectedcampus.org/main_class.php?classid=".$cid;
setNotification('Invitee', $fid, $link, $uid, $cname);
}

//Close window and return to class
echo "<script type='text/javascript'>
    self.parent.location.href='main_class.php?classid=".$cid."';
</script>";
}
//Check if action selected is event
else if(isset($_POST['eventid']))
{
//Store eventid and loop through the friends array sent
$eid=(int)$_POST['eventid'];
for($i=0;isset($_POST['friend'][$i]);$i++)
{
//Store the friend id
$fid=$_POST['friend'][$i];
//Add entry to database
$sql="INSERT INTO events_invitees (ID, eventid, userid, status)
VALUES
(NULL, '$eid','$fid',3)";
mysql_query($sql);
$m=mysql_query("SELECT * FROM eventsinterface WHERE eventid='$eid'");
$m=mysql_fetch_array($m);
$ename=$m['Event_Name'];
//Use setNotification to set an alert to the recieving user
$link="http://connectedcampus.org/event_template_in.php?id=".$eid;
setNotification('Invitee', $fid, $link, $uid, $ename);
}
//Return to main event page
echo "<script type='text/javascript'>
    self.parent.location.href='event_template.php?eventid=".$eid."';
</script>";
}
//Check if event sent was whiteboard
else if(isset($_POST['wbid']))
{
//Save whiteboard ID
$wid=(int)$_POST['wbid'];
//Loop through friends array
for($i=0;isset($_POST['friend'][$i]);$i++)
{
//Save friendid
$fid=$_POST['friend'][$i];
//Add entry to Database
$sql="INSERT INTO collwb_invite (id, sid, rid, gid)
VALUES
(NULL, '$uid','$fid', '$wid')";
mysql_query($sql);
$m=mysql_query("SELECT * FROM collwb_info WHERE GroupID='$wid'");
$m=mysql_fetch_array($m);
$wname=$m['Groupname'];
$wcid=$m['classid'];
//Use setNotification to set an alert to the recieving user
$link="http://connectedcampus.org/main_wb.php?classid=".$wcid;
setNotification('Invitee', $fid, $link, $uid, $wname);
}
//Give option for the user to invite again
echo "<center>Whiteboard Invite Sent Successfully !</center><br> <a href='invite_popup.php?action=wb&wbid=".$wid."&classid=0'>Invite more ?</a>";
}
?>