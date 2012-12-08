<?php				////////////////// Add_Topic ///////////////////
$auth=1;
include('includes.php');

if(isset($_GET['classid'])){
$class=$_GET['classid'];
}
else{
	$class=0;
}

$logmail=$_SESSION['email'];	//E-mail of current user logged in
$logid=getID($logmail);		//ID of logged in user returned by function, given email as parameter

if($class!=0){
	$tchrID=mysql_fetch_array(mysql_query("SELECT userid FROM class_teacher WHERE classid=$class"));//ID of Instructor
	if(($tchrID[0]!=$logid) && (getNum2("class_subscribed", "classid", $_GET['classid'], "userid", getID($_SESSION['email']))!=1)){
		header('Location: http://connectedcampus.org/profile_main.php');
	}
}


include('html_top.php');

if($classID!=0){
	include "classheader.php";
}

$tbl_name="forum_question"; 	// Table name

				//////////////////// Acquiring Data from Form Validation /////////////
$topic=$_GET['Topic'];		
$detail=$_GET['Detail'];
$tags=$_GET['Tags'];
$email=$_GET['Email'];
$class=$_GET['classid'];

$datetime=date("d/m/y h:i:s"); 	//create date time

$sql="INSERT INTO $tbl_name(Class_ID, Topic, Detail, Email, Tags, DateTime)VALUES($class, '$topic', '$detail', '$email', '$tags', '$datetime')";
$result=mysql_query($sql);

 $sql1="INSERT INTO class_alerts VALUES ('',$class,$logid,'1')";
 $result1=mysql_query($sql1);
 
 
 				///////////////////// Notification ////////////////////
	
if($class>0) {
	$type="NewTopicL";
	$link="http://connectedcampus.org/main_forum.php?classid=".$class;
	$addinfo=$topic;
	
		
	$sql_sender="SELECT * FROM user_information WHERE email='".$email."'";
	$query_sender=mysql_query($sql_sender);
	$row_sender=mysql_fetch_array($query_sender);
	$sender=$row_sender['userid'];

	$sql_learners="SELECT * FROM class_subscribed WHERE classid=".$class;
	$query_learners=mysql_query($sql_learners);
		
	while($row_learners=mysql_fetch_array($query_learners)) {
		$sendto=$row_learners['userid'];
		$notification=mysql_query("INSERT INTO user_notifications VALUES('','$type','$sendto','$link','$sender','1','$addinfo')");
	}
	
	$sql_teacher="SELECT * FROM class_teacher WHERE classid=".$class." AND userid NOT IN (SELECT userid FROM class_tchrleave WHERE classid=".$class.")";
	$query_teacher=mysql_query($sql_teacher);
	$row_teacher=mysql_fetch_array($query_teacher);
	$sendto=$row_teacher['userid'];
	$notification=mysql_query("INSERT INTO user_notifications VALUES('','$type','$sendto','$link','$sender','1','$addinfo')");
}
 
 
 
 
 
 
if($result){

echo "<meta http-equiv='Refresh' content='0; URL=main_forum.php?classid=$class'>";
}
else {
echo "ERROR";
}
mysql_close();

?>

<?php
include('html_bottom.php');
?>