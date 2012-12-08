<?php
$auth=1;
include('includes.php');
if(isset($_GET['userid'])){
if(getNum("user_information", "userid", $_GET['userid'])==0){ // Check Get
		header('Location: http://connectedcampus.org/errorpage.php');
}
}
				/////////////////  Event Details  /////////////////
include('html_top.php');
$name=$_GET['event_name'];
$details=$_GET['event_details'];
$location=$_GET['event_location'];
$current_datetime=$_GET['date_time'];
$date=$_GET['event_date'];
$time=$_GET['event_time'];
$user=$_GET['user_id'];
$privacy=$_GET['privacy'];
$event_time=$_GET['hours'].":".$_GET['minutes'];
$day=$_GET['day'];
$month=$_GET['month'];
$year=$_GET['year'];

$newDate=date("Y-m-d",mktime(0,0,0,$month,$day,$year));

				////////////////// Insert event /////////////////////
$sql="INSERT INTO eventsinterface VALUES('','$name','$user', '$current_datetime', '$newDate', '$event_time', '$details', '$privacy', '$location')";
$result=mysql_query($sql);

if($result){

	echo "<meta http-equiv='Refresh' content='0; URL=event_template.php'>";
}
else 
{
	echo "ERROR";
}

mysql_close();

?>