<?php				////////////////////Main Forum////////////////////

$auth=1; //user must be logged in to view this page 

include('includes.php');
				///////////////////Checking if the Class ID is set/////////////////
if(isset($_GET['classid'])){
$classID=$_GET['classid'];
}
else{
	$classID=0;
}

$logmail=$_SESSION['email'];   //////////////////E-mail of current user logged in
$logid=getID($logmail);        //////////////////ID of logged in user returned by function, given email as parameter


if($classID!=0){
	$tchrID=mysql_fetch_array(mysql_query("SELECT userid FROM class_teacher WHERE classid=$classID"));//ID of Instructor
	if(($tchrID[0]!=$logid) && (getNum2("class_subscribed", "classid", $_GET['classid'], "userid", getID($_SESSION['email']))!=1)){
		header('Location: http://connectedcampus.org/userhome.php');
	}
}
function checkstudent($l, $c){
	$q=mysql_query("SELECT * FROM class_subscribed WHERE userid=".$l." AND classid=".$c);
	return mysql_num_rows($q);
	//if(mysql_num_rows($q)!=1) return 0;
	//else return 1; //1-->is a student
}
function tchrleft($t, $c){
	$query=mysql_query("SELECT * FROM class_tchrleave WHERE classid=".$c." AND userid=".$t);
	if(mysql_num_rows($query)==0){
		return 0;
	}
	else {
		return 1;
	}
}


$classname=mysql_fetch_array(mysql_query("SELECT classname FROM class_information WHERE classid='".$classID."'"));//Classroom Name

include('html_top.php');

if($classID!=0){
	include "classheaderfinal.php";
}
$tbl_name="forum_question"; 	/////////////////// Table name //////////////////////////
$tbl_name_a="forum_answer";	/////////////////// Table name //////////////////////////

				////////////////// Retrieving Forum Topics from DB //////////////////
$sql="SELECT * FROM $tbl_name WHERE Class_ID=".$classID." ORDER BY ID DESC";   
$result=mysql_query($sql);

//echo $classID;
?>
<style type="text/css">
#classbox{
	width:720px;
	height:110px;
	background: #ffffff;
	border: 1px solid #fdfdfd;
}
#classbox_img_hold{
	float:left;
}
#classbox_des_hold{
	float:left;
	padding:10px;
	width:450px;
}
#classbox_description{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;

}
#class_ratings{
	margin-left: -65px;
	background: #27d865;
	padding:0 7px 0 7px;
	width:33px;
	height:32px;
	font-size:25px;
	font-family: 'Century Gothic', sans-serif;
	float:left;
}
h5{
	font-family: 'Century Gothic', sans-serif;
    font-size: 25px;
	color: #1a1a1a;
	font-weight: normal;
	margin-top: -5px;
	margin-bottom: -10px;
}
#class_nav_bar{
	float:right;
	padding-top:20px;
	margin-right:-25px;
}
.class_nav_btn{
	background:#f7f7f7;
	height:15px;
	padding:5px 20px 5px 20px;
	float:right;
	margin-left:10px;
	border: 1px solid #ffffff;
}
</style>


<style type="text/css">
#class_contentbox{
margin-top:20px;
}
#cblog_wrap{
width:450px;
float:left;
}
.fview_p{
width:700px;
background:#ffffff;

padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:15px;
float:left;

}
.fblog_r{
width:625px;
background:#ffffff;
margin-top:-20px;
margin-bottom:10px;
padding-left:85px;
padding-top:10px;
padding-right:10px;
padding-bottom:20px;
float:left;

}
.fview_p2{
width:700px;
background:#fafafa;

padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:10px;
float:left;

}
.fblog_pm{
width:700px;
background:#ffffff;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:10px;
float:left;
font-size:14px;
font-family: 'Century Gothic', sans-serif;
}
.bloghead{
    font-size: 20px;
	color: #1a1a1a;
	font-weight: normal;
	margin-top: -5px;
	margin-bottom: -10px;
	margin-right: 3px;
	font-family: 'Century Gothic', sans-serif;
}
.blogdesc{
    font-size: 10px;
	color: #7a7a7a;
	font-weight: normal;
	font-family: 'Century Gothic', sans-serif;
}
.crhead{
    font-size: 18px;
	color: #1a1a1a;
	font-weight: normal;
	margin-top: -5px;
	margin-bottom: -10px;
	margin-right: 3px;
	font-family: 'Century Gothic', sans-serif;
}
.space5{
	height:5px;
}
.space8{
	height:8px;
}
#cright_wrap{
	margin-left:25px;
	float:left;
	min-width:245px;
	max-width:245px;
	}
.blogtags{
	font-size: 12px;
	color: #7a7a7a;
	font-style:italic;
	word-spacing:3px;
	font-family: 'Century Gothic', sans-serif;
}
.c_box{
	max-width:240px;
	height:120px;
	background:#fafafa;
	padding:10px;
	margin-bottom:20px;
}
.c_box2{
	max-width:240px;
	height:120px;
	background:#ffffff;
	padding:10px;
	margin-bottom:20px;
}
#cimg_hold{
	float:left;
	width:70px;
	height:90px;
}
#cinst_hold{
	max-width:140px;
	float:left;
	margin-left:10px;
}
.cint_name{
	font-size: 15px;
	color: #1a1a1a;
	font-family: 'Century Gothic', sans-serif;
}
#cinst_ratings{
	background: #27d865;
	margin-left: -42px;
	width: 20px;
	padding: 2px 5px 2px 5px;
}
#cint_det{
	font-size:12px;
}
.fcomment{
	border: 1px solid #dadada;
	padding: 2px;
	width: 610px;
}
.ccbutton{
	
font-family: 'Century Gothic', sans-serif;
	background:#ffffff;
border: 1px solid #dadada;
outline:none;

}
.fsep{
border:0;
border-bottom: 1px dashed #dadada;	
margin-top:20px;
margin-bottom:3px;
}
.ftarea{
border: 1px solid #dadada;
	padding: 2px;
	width: 690px;
resize: none;
height:165px;
}
.blogreply{
font-family: 'Century Gothic', sans-serif;
float:right;
margin-top:5px;
margin-right:5px;
min-width:65px;
text-align:center;	
padding: 2px 5px 2px 5px;
background: #efefef;
}
.fsettings{
font-size:11px;
padding: 2px 5px 2px 5px;
margin-right:5px;
float:right;
background: #efefef;
}
</style>



<div id="class_contentbox">
<div id="cblog_wrap">
<div class="fblog_pm">
Forum				 <!--  /////////////// Forum ////////////////  -->
				 <!--  /////////////// Create Classroom /////  -->
<span class="fsettings"><a href="create_topic.php?classid=<? echo $classID; ?>">Create Topic</a></span>
</div>

<?php
$i=0;
while($rows=mysql_fetch_array($result)){ ///////// Start looping table row /////////////
$i+=1;
$idu=$rows['ID'];
					////////// Counting Replies ////////////////////
$sqlu="SELECT COUNT(*) AS Num FROM $tbl_name_a WHERE Question_ID='$idu'";
$resultu=mysql_query($sqlu);
$rowsu=mysql_fetch_array($resultu);
$emailmatch=$rows['Email'];
$sqln="SELECT * FROM user_information WHERE email='$emailmatch'";
$resultn=mysql_query($sqln);
$rowsn=mysql_fetch_array($resultn); 
if($i%2==1)
echo("<div class=\"fview_p2\">");
else				//////////////////// Fetch and Display Topics //////////////////
echo("<div class=\"fview_p\">");
echo("<span class=\"bloghead\"><a href=\"view_topic.php?ID=".$rows['ID']."&classid=".$classID."\">".$rows['Topic']."</a></span>
<span class=\"blogdesc\">posted by ".$rowsn['name']." at ".$rows['DateTime']."</span>
<span class=\"blogreply\">".$rowsu['Num']." replies</span>
</div>");
}
mysql_close();
?>


</div>
</div>

<?php

include('html_bottom.php');

?>