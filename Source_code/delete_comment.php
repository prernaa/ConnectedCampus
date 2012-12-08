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

			//////////////// Deleting Comments on Replies In The Forum /////////////////

$qid=$_GET['qid'];
$A_ID=$_GET['aid'];
$C_ID=$_GET['cid'];
$sql_drc="DELETE FROM forum_comments WHERE q_id=".$qid." AND a_id=".$A_ID." AND comment_id=".$C_ID;
$result_drc=mysql_query($sql_drc);
if($result_drc){
echo "<meta http-equiv='Refresh' content='0; URL=view_topic.php?ID=".$qid."'>";

}
else {
echo "ERROR";
}

mysql_close();
?>