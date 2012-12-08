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
$blogid=$_GET['blogid'];
$classid=$_GET['classid'];
if(isset($_GET['userid']))
{
	$user=$_GET['userid']; //Gives logged in user's email address
}
else {
	$user=$logid;
}


				////////////////// Deleting Blog Comments /////////////////
$blogcommentID=$_GET['ID'];
$sql_drc="DELETE FROM class_blog_comments WHERE ID=".$blogcommentID;
$result_drc=mysql_query($sql_drc);

if($result_drc){
echo "<meta http-equiv='Refresh' content='0; URL=blogdisplay.php?blogid=".$blogid."&classid=".$classid."'>";


// If added new answer, add value +1 in reply column 

}
else {
echo "ERROR";
}

mysql_close();
?>