<?php				////////////////// Add_Comment /////////////////////////////
$auth=1;
include('includes.php');
include('html_top.php');

				////////////////// Acquiring Data from Form Submission ///////////////
$Q_ID=$_GET['QID'];
$A_ID=$_GET['AID'];
$classid=$_GET['classid'];
$topic=$_GET['Q_Title'];
$Comment=$_GET['Comment'];
$c_email=$_GET['c_email'];
$datetime=date("d/m/y H:i:s"); // create date and time
$sql1="INSERT INTO forum_comments VALUES('', '$Q_ID', '$A_ID', '$Comment', '$c_email','$datetime')";
$result1=mysql_query($sql1);


				///////////////////// Notification ////////////////////

	//echo "notification";
	$type="RComment";
	$link="http://connectedcampus.org/view_topic.php?ID=".$Q_ID."&classid=".$classid;
	$addinfo=$topic;
	
	$sql_email="SELECT * FROM forum_answer WHERE A_ID=".$A_ID." AND Question_ID=".$Q_ID;
	$query_email=mysql_query($sql_email);
	$row_email=mysql_fetch_array($query_email);
	$a_email=$row_email['A_Email'];
	//echo $A_ID;
	
	$sql_id="SELECT * FROM user_information WHERE email='".$a_email."'";
	$query_id=mysql_query($sql_id);
	$row_id=mysql_fetch_array($query_id);
	$sendto=$row_id['userid'];
	
	$sql_sender="SELECT * FROM user_information WHERE email='".$c_email."'";
	$query_sender=mysql_query($sql_sender);
	$row_sender=mysql_fetch_array($query_sender);
	$sender=$row_sender['userid'];

	$notification=mysql_query("INSERT INTO user_notifications VALUES('','$type','$sendto','$link','$sender','1','$addinfo')");


if($result1){
echo "<meta http-equiv='Refresh' content='0; URL=view_topic.php?ID=".$Q_ID."&classid=".$classid."'>";

}
else {
echo "ERROR";
}

mysql_close();
?>


<?php
include('html_bottom.php');
?>