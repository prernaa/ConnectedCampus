<?php
$auth=1;
include('includes.php');
if(isset($_GET['userid'])){
if(getNum("user_information", "userid", $_GET['userid'])==0){ // Check Get
		header('Location: http://connectedcampus.org/errorpage.php');
}
}

include('html_top.php');
$log=$_SESSION['email'];
$logid=getID($log);

if(isset($_GET['userid']))
{
	$user=$_GET['userid']; //Gives logged in user's email address
}
else {
	$user=$logid;
}
			 ///////  Inserting attendance details   ///////////
$userinfo=mysql_fetch_array(mysql_query("SELECT * FROM user_information where userid=".$user));
$status=$_GET['status'];
$eventid=$_GET['id'];
$set=$_GET['set'];
if ($set=="0"){
			////////////  If the Attendance Value has never been Set Before //////////////
$sql_e="INSERT INTO events_invitees VALUES ('','$eventid','$user','$status')";
}
else{
			////////////  If the Attendance Value has been Set Before //////////////
$sql_e="UPDATE events_invitees SET status=".$status." WHERE eventid=".$eventid." AND userid=".$user;
}

$result_e=mysql_query($sql_e);


if($result_e){
echo "<meta http-equiv='Refresh' content='0; URL=event_template.php'>";
//echo "<a href='view_topic.php?ID=".$id."'>View your answer</a>";

// If added new answer, add value +1 in reply column 

}
else {
echo "ERROR";
}

mysql_close();
?>