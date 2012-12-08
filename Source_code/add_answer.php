<?php				//////////////////Add answer/////////////////////
$auth=1;
include('includes.php');
include('html_top.php');


$tbl_name="forum_answer"; 	// Table name

				/////////////////// Acquiring Data from Form Submission //////////////
$id=$_GET['ID'];
$classid=$_GET['classid'];
$topic=$_GET['Q_Title'];
$q_email=$_GET['Q_Email'];
$a_email=$_GET['A_Email'];
$a_answer=$_GET['A_Answer']; 

				// Find highest answer number. 
$sql="SELECT MAX(A_ID) AS Maxa_id FROM $tbl_name WHERE Question_ID='$id'";
$result=mysql_query($sql);		
$rows=mysql_fetch_array($result);

				// add + 1 to highest answer number and keep it in variable name "$Max_id". if there no answer yet set it = 1 
if ($rows) {
$Max_id = $rows['Maxa_id']+1;
}
else {
$Max_id = 1;
}

$sql5="SELECT * FROM user_information WHERE email='$a_email'";
$result1=mysql_query($sql5);
$rows1=mysql_fetch_array($result1);

$datetime=date("d/m/y H:i:s"); // create date and time

				// Insert answer 
$sql2="INSERT INTO $tbl_name(Question_ID, A_ID, A_Email, A_Answer, A_DateTime)VALUES('$id', '$Max_id', '$a_email', '$a_answer', '$datetime')";
$result2=mysql_query($sql2);

$uid=$rows1['userid'];
$num_ans=1;
				//////////////// Using tags ////////////////////
$tag=$_GET['tag'];
$tags=explode(",",$tag);
$count=count($tags);
$i=0;

while ($i<$count)
{	

	$tagtoenter=ltrim($tags[$i]," ");
	
	$sql11="SELECT * FROM forum_tags WHERE tagname='$tagtoenter' AND userid='$uid'";
	$result11=mysql_query($sql11);
	$rows11=mysql_fetch_array($result11);
	if ($rows11)
	{		
		$sql12="UPDATE forum_tags SET num_ans='$num_count' WHERE tagname='$tagtoenter' AND userid='$uid'";
		$result12=mysql_query($sql12);
	}
	else
	{
		$sql10="INSERT INTO forum_tags VALUES ('', '$tagtoenter', '$uid', '$num_ans', '')";
		$result10=mysql_query($sql10);
	}
	$i++;
}

				///////////////////// Notification ////////////////////

	
	$type="QReply";
	$link="http://connectedcampus.org/view_topic.php?ID=".$id."&classid=".$classid;
	$addinfo=$topic;
	
	$sql_id="SELECT * FROM user_information WHERE email='".$q_email."'";
	$query_id=mysql_query($sql_id);
	$row_id=mysql_fetch_array($query_id);
	$sendto=$row_id['userid'];
	
	$sql_sender="SELECT * FROM user_information WHERE email='".$a_email."'";
	$query_sender=mysql_query($sql_sender);
	$row_sender=mysql_fetch_array($query_sender);
	$sender=$row_sender['userid'];

	$notification=mysql_query("INSERT INTO user_notifications VALUES('','$type','$sendto','$link','$sender','1','$addinfo')");

if($result2){
echo "<meta http-equiv='Refresh' content='0; URL=view_topic.php?ID=".$id."&classid=".$classid."'>";

// If added new answer, add value +1 in reply column 
$tbl_name2="forum_question";
$sql3="UPDATE $tbl_name2 SET Reply='$Max_id' WHERE ID='$id'";
$result3=mysql_query($sql3);



}
else {
echo "ERROR";
}

mysql_close();
?>


<?php
include('html_bottom.php');
?>