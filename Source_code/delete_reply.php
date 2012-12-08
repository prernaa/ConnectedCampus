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

			////////////// Deleting Replies //////////////

$qid=$_GET['qid'];
$A_ID=$_GET['aid'];
$sql_dr="DELETE FROM forum_answer WHERE Question_ID=".$qid." AND A_ID=".$A_ID;
$result_dr=mysql_query($sql_dr);

			////////////// Deleting Accompanying Comments /////////////////////
$sql_drc="DELETE FROM forum_comments WHERE q_id=".$qid." AND a_id=".$A_ID;
$result_drc=mysql_query($sql_drc);

if($result_dr){
echo "<meta http-equiv='Refresh' content='0; URL=view_topic.php?ID=".$qid."'>";

}
else {
echo "ERROR";
}

mysql_close();
?>