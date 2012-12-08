<?php
$auth=1; //user must be logged in to view this page 
include('includes.php');
if(!isset($_GET['classid'])|| getNum("class_information", "classid", $_GET['classid'])!=1){ // Check Get
header('Location: http://connectedcampus.org/userhome.php');
}
$classID=$_GET['classid'];
$tchrID=mysql_fetch_array(mysql_query("SELECT userid FROM class_teacher WHERE classid='$classID'"));//ID of Instructor
$tchrname=mysql_fetch_array(mysql_query("SELECT name FROM user_information WHERE userid='$tchrID[0]'"));//Instructor's Name

$logmail=$_SESSION['email'];//E-mail of current user logged in
$logname=getName($logmail); //Name of user logged in user returned by function, given email as parameter
$logid=getID($logmail); //ID of logged in user returned by function, given email as parameter
function checkstudent($l, $c){
	//Checks if logged in user is a learner of the class whose classID is given
	$q=mysql_query("SELECT * FROM class_subscribed WHERE userid=".$l." AND classid=".$c);
	return mysql_num_rows($q);
}

if(($tchrID[0]!=$logid) && checkstudent($logid, $classID)!=1){ //only the learners and the teacher can see who are the other learners in the classroom
	header('Location: http://connectedcampus.org/userhome.php');
}
?>
<html>
<head>
<style type="text/css">
body {
	text-align:center;
	padding-top:10px;
	background: #f7f7f7;
}
.gradient {
       filter: none;
    }
td.name {
	width:150px;
	font-size: 15px;
	color: #1A1A1A;
	font-family: 'Century Gothic', sans-se	padding:5px;
}
td.imgpm {
	padding:5px;
	padding:5px;
}
td.sno{
	padding:5px;
	padding:5px;
}
</style>
</head>
<body class="gradient">

<br/>

<? $sql="SELECT * FROM class_subscribed WHERE classid=".$classID; 
$q=mysql_query($sql);
$sno=1;
?>
<span style="font-size:22px; font-weight:bold; text-decoration:underline; color:#1A1A1A;">Learners</span>
<table border="0" style="margin-left:auto; margin-right:auto;">
   <? while($learner=mysql_fetch_array($q)){ ?>

   <tr>
   <!--Learners are displayed linked to their profile page. From this page the user can choose to send a message to any learner-->
    <td class="name"><a target="_parent" style="text-decoration:none; color:#3B5998;" href="profile_main.php?userid=<? echo $learner['userid']; ?>"> <? echo getNamewID($learner['userid']); ?></a></td>
    <td class="imgpm"><a href="newmessage.php?touser=<? echo $learner['userid']; ?>">
    <img src="img/add_message.png"/>
    </a></td>
  </tr>
  
  <? } ?>
</table>

</body>
</html>

