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
$eventid=$_GET['eventid'];

if(isset($_GET['userid']))
{
	$user=$_GET['userid']; //Gives logged in user's email address
}
else {
	$user=$logid;
}

			///////////////// Deleting Event Comments  /////////////////

$eventcommentID=$_GET['ID'];
$sql_drc="DELETE FROM event_comment WHERE ID=".$eventcommentID;
$result_drc=mysql_query($sql_drc);

if($result_drc){
echo "<meta http-equiv='Refresh' content='0; URL=event_template_in.php?id=".$eventid."'>";


// If added new answer, add value +1 in reply column 

}
else {
echo "ERROR";
}

mysql_close();
?>