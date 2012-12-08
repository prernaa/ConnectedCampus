<?php

$auth=1; //user must be logged in to view this page 

include('includes.php'); //including "includes" file which connects to the database.
if(isset($_GET['classid']) && $_GET['classid']!=0){ //if classis is specified & not zero then check if it is a valid classid
if(getNum("class_information", "classid", $_GET['classid'])==0){ // Check Get
		header('Location: http://connectedcampus.org/errorpage.php'); //if classid is invalid, it redirects to errorpage.php
}
}
if(isset($_GET['classid']))
{
	$classid=$_GET['classid']; //Gives logged in user's email address
}
else {
	$classid=0;
}
$classID=$classid;
$classname=mysql_fetch_array(mysql_query("SELECT classname FROM class_information WHERE classid='".$classID."'"));//Classroom Name
$tchrID=mysql_fetch_array(mysql_query("SELECT userid FROM class_teacher WHERE classid='$classID'"));//ID of Instructor
$logmail=$_SESSION['email'];//E-mail of current user logged in
$logname=getName($logmail); //Name of user logged in user returned by function, given email as parameter
$logid=getID($logmail); //ID of logged in user returned by function, given email as parameter

function checkstudent($l, $c){ //Checks if logged in user is a learner of the class whose classID is given
	$q=mysql_query("SELECT * FROM class_subscribed WHERE userid=".$l." AND classid=".$c);
	return mysql_num_rows($q);
}
function tchrleft($t, $c){ //Checks if the teacher of the class whose classID is given has left the class or is still teaching the class
	$query=mysql_query("SELECT * FROM class_tchrleave WHERE classid=".$c." AND userid=".$t);
	if(mysql_num_rows($query)==0){
		return 0;
	}
	else {
		return 1;
	}
}

if($classID!=0){ //if user is viewing a classroom's whitebaord, it should only be accessible to the instructor & the learners
	if($tchrID[0]!=$logid && checkstudent($logid, $classID)==0){
		header('Location: http://connectedcampus.org/errorpage.php'); //Guests are redirected to the errorpage as they are not granted access to the whiteboard
	}
}
include('html_top.php'); ?>
<script type="text/javascript">
//validates the form for creating whiteboard
function countspace(s)
{
	var l=0;
	var i=0;
	while(i < s.length)
	{
		if(s[i]==" ") {
			l++; 
		}
		i++;
	}	
	return l;
}
function createvalidate()
{
var x=document.forms["createwbform"]["newname"].value;
if (x==null || x==""){
	alert("Group name must be filled out");
	return false;
	}
if(x.length==countspace(x)){
	alert("Group name must be filled out");
	return false;
	}
	return true;
}
</script>
<?
if(isset($_POST['joinwb'])){ //makes the logged in user a member of the whiteboard group he chooses to join
	$s4="INSERT INTO collwb_groupmembers(GroupID,userid,Mode,Activity) VALUES(".$_POST['joinid'].",".$logid.", 0, 0)";
	mysql_query($s4);
}
$created=0; //0 means not created, 1 means already exists, 2 means successfully created
if(isset($_POST['createwb'])){ //to insert the new whiteboard details into the table in the DB when the user decides to create a new whiteboard using the form
	$newname=$_POST['newname'];
	$newdesc=$_POST['newdesc'];
	$privacy=$_POST['privacy'];
	$sql="SELECT * FROM collwb_info WHERE Groupname='".$newname."' AND classid=".$classID;
	if(mysql_num_rows(mysql_query($sql))!=0){ //already exists
		$created=1;
	}
	else{
		$sql="INSERT INTO collwb_info(classid,Groupname,Privacy,GroupDesc) VALUES(".$classID.", '".$newname."',".$privacy.", '".$newdesc."')";
		mysql_query($sql);
		$newid=mysql_fetch_array(mysql_query("SELECT * FROM collwb_info WHERE Groupname='".$newname."' AND classid=".$classID));
		$sql3="INSERT INTO collwb_groupadmin(GroupID, userid) VALUES(".$newid['GroupID'].", ".$logid.")";
		mysql_query($sql3);
		$sql4="INSERT INTO collwb_groupmembers(GroupID, userid, Mode, Activity) VALUES(".$newid['GroupID'].", ".$logid.", 0, 0)";
		mysql_query($sql4);
		$created=2;
		
		
 			///////////////////// Notification ////////////////////
	
		if($classID>0 && $privacy==0) {
			$type="NewWB";
			$link="http://connectedcampus.org/main_wb.php?classid=".$classID;
			$addinfo=$newname;
	
	
	/*$sql_id="SELECT * FROM user_information WHERE email='".$email."'";
	$query_id=mysql_query($sql_id);
	$row_id=mysql_fetch_array($query_id);
	$sendto=$row_id['userid'];*/
	
			/*$sql_sender="SELECT * FROM user_information WHERE email='".$email."'";
			$query_sender=mysql_query($sql_sender);
			$row_sender=mysql_fetch_array($query_sender);*/
			$sender=$logid;

			$sql_learners="SELECT * FROM class_subscribed WHERE classid=".$classID;
			$query_learners=mysql_query($sql_learners);
	
	//echo $link;
			while($row_learners=mysql_fetch_array($query_learners)) {
				$sendto=$row_learners['userid'];
				$notification=mysql_query("INSERT INTO user_notifications VALUES('','$type','$sendto','$link','$sender','1','$addinfo')");
			}
	
			$sql_teacher="SELECT * FROM class_teacher WHERE classid=".$classID." AND userid NOT IN (SELECT userid FROM class_tchrleave WHERE classid=".$classID.")";
			$query_teacher=mysql_query($sql_teacher);
			$row_teacher=mysql_fetch_array($query_teacher);
			$sendto=$row_teacher['userid'];
			$notification=mysql_query("INSERT INTO user_notifications VALUES('','$type','$sendto','$link','$sender','1','$addinfo')");
		}
 
	}
}
if(isset($_POST['acceptwb'])){ //To add the user as a group member of the whiteboard group when he chooses to accept a whiteboard invite.
	$grp=$_POST['acceptid'];
	$s5="INSERT INTO collwb_groupmembers(GroupID,userid,Mode,Activity) VALUES(".$_POST['acceptid'].",".$logid.", 0, 0)";
	mysql_query($s5);
	$s6="DELETE FROM collwb_invite WHERE rid=".$logid." AND gid=".$grp;
	mysql_query($s6);
}
if(isset($_POST['rejectwb'])){ //To clear the invite from the DB when the user chooses to reject a whiteboard invite.
	$grp3=$_POST['acceptid'];
	$s7="DELETE FROM collwb_invite WHERE rid=".$logid." AND gid=".$grp3;
	mysql_query($s7);
}
if(isset($_POST['leavewb'])){ //To delete the user as a group member of the whiteboard group when he chooses to leave the whiteboard group.
	$grp2=$_POST['leaveid'];
	mysql_query("DELETE FROM collwb_groupmembers WHERE GroupID=".$grp2." AND userid=".$logid);
	$q3=mysql_num_rows(mysql_query("SELECT * FROM collwb_groupmembers WHERE GroupID=".$grp2));
	if($q3==0){// if no more members exist then delete the whiteboard
	mysql_query("DELETE FROM collwb_info WHERE GroupID=".$grp2);
	mysql_query("DELETE FROM collwb_groupadmin WHERE GroupID=".$grp2);
	mysql_query("DELETE FROM collwb_invite WHERE gid=".$grp2);
	}
}
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
#pbox{
	width:720px;
	height:110px;
	background: #ffffff;
	border: 1px solid #fdfdfd;
	font-family: 'Century Gothic', sans-serif;
}
#pbox_img_hold{
	float:left;
	padding:5px;
}
#pdes_hold{
	float:left;
	padding:10px;
	width:450px;
}
#pdescription{

	font-size: 12px;

}
h5{
	font-family: 'Century Gothic', sans-serif;
    font-size: 25px;
	color: #1a1a1a;
	font-weight: normal;
	margin-top: -5px;
	margin-bottom: -10px;
}
#pnav_bar{
	float:right;
	padding-top:0px;
	margin-right:-130px;
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
<? 
if($classid!=0){
include "classheaderfinal.php"; //classid=0 REFERS TO THE GENERAL WHITEBOARD WHICH IS INDEPENDENT OF CLASSROOM
//hence the header of the class is included only when the classid is not 0 i.e. the user is accessing the whiteboard of a particular class 
}?>
<style type="text/css">
#class_contentbox{
margin-top:20px;
}
#cblog_wrap{
width:450px;
float:left;
}
.pblog_p{
width:700px;
background:#ffffff;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:15px;
float:left;

}
.pblog_r{
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
.pblog_p2{
width:700px;
background:#fafafa;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:20px;
float:left;

}
.pblog_pm{
width:700px;
background:#ffffff;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:10px;
float:left;
font-size:18px;
font-family: 'Century Gothic', sans-serif;
}
.pblog_pm2{
width:700px;
background:#fafafa;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:10px;
float:left;
font-size:18px;
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
.aclass{
	margin-top:10px;
	margin-left:35px;
	margin-right:20px;
	border: 1px dashed #f0f0f0;
	padding:5px;
}
.aclass_hold{
	float:left;
}
.aclass_descr{
	float:left;
	padding-left:10px;
	font-size:12px;
	width:520px;
}
.ctitle{
font-size:20px
}
.psep{
border:0;
border-bottom: 1px dashed #dadada;	
margin-top:10px;
margin-bottom:10px;
}
.nothing{
padding-left:40px;
font-size:12px;
padding-top:10px;
padding-bottom:10px;}
.pimg_hold{
padding-left:40px;
padding-top:10px;
padding-bottom:10px;
word-spacing:10px;
}
.w_rightsub{
float:left;
font-size:12px;
}
.w_list{
float:left;
font-size:15px;
padding-top:4px;
margin-left:40px
}
.w_boxes{
float:left;
margin-left:25px;
}
.winput{
	border: 1px solid #dadada;
	padding: 2px;
	margin-top:5px;
	width: 510px;
}
.warea{
border: 1px solid #dadada;
	padding: 2px;
	width: 510px;
resize: none;
height:165px;
margin-top:-7px;
}
</style>
<script language="javascript" type="text/javascript">
//To open the whiteboard interface in a new window
function popupwb(url) {
	newwindow=window.open(url,'name','height=600,width=850, scrollbar=yes');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>
<div id="class_contentbox">
<div id="cblog_wrap">
<!-- To display a note to the user of successful/unsuccessful creation of whiteboard group-->
<? if($created==1){//already exists ?>
<div class="pblog_pm">
&nbsp;
<div class="nothing">
Whiteboard Not Created! Name Already Exists.
</div>
</div>
<? }
else if($created==2){ //successfully created?>
<div class="pblog_pm">
&nbsp;
<div class="nothing">
Whiteboard Successfully Created!
</div>
</div>
<? } ?>

<div class="pblog_pm">
MY WHITEBOARD GROUPS
<!--Displaying the whiteboard groups the user is already a part of-->
<? $s="SELECT * FROM collwb_info WHERE classid=".$classID;
$q=mysql_query($s);
$countwb=0;
while($wb=mysql_fetch_array($q)){
	$s2="SELECT * FROM collwb_groupmembers WHERE GroupID=".$wb['GroupID']." AND userid=".$logid;
	$q2=mysql_query($s2);
	if(mysql_num_rows($q2)!=0){
		$countwb=$countwb+1;
?>
<form action="main_wb.php?classid=<? echo $classID; ?>" method="post">
<div class="aclass">
<div class="aclass_descr">
<p class="ctitle"><a href="new_collwb.php?groupid=<? echo $wb['GroupID']; ?>" onclick="return popupwb('new_collwb.php?groupid=<? echo $wb['GroupID']; ?>')"><? echo $wb['Groupname']; ?></a></p>
<div class="space8"></div>
<? echo $wb['GroupDesc']; ?>
</div>
<div class="w_rightsub">
<!--option to leave a whiteboard group he has created or joined. A whiteboard group is deleted once all the members leave it-->
<input type="hidden" name="leaveid" value="<? echo $wb['GroupID']; ?>" /><br/>
<input style="cursor:pointer;" type="submit" name="leavewb" value="Leave Group" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>
</div>
<div class="clear"></div>
</div>
</form>
<? }//ending if 
 } //ending while 
if($countwb==0){?>
<div class="nothing">
No Whiteboard Groups
</div>
<? }//ending if ?>

</div>


<div class="pblog_pm">
WHITEBOARD GROUP INVITES
<!--Displays whiteboard groups the user is invited to-->
<? $s="SELECT * FROM collwb_invite WHERE rid=".$logid;
$q=mysql_query($s);
if (mysql_num_rows($q)==0){ ?>
<div class="nothing">
No Whiteboard Groups
</div>
<? }//ending if
else {
	$count=0;
while($wb=mysql_fetch_array($q)){
	$s2="SELECT * FROM collwb_info WHERE GroupID=".$wb['gid']." AND classid=".$classID;
	$q2=mysql_query($s2);
	if(mysql_num_rows($q2)!=0){
		$count=$count+1;
		$wbinfo=mysql_fetch_array($q2);?>
<form action="main_wb.php?classid=<? echo $classID; ?>" method="post">
<div class="aclass">
<div class="aclass_descr">
<p class="ctitle"><? echo $wbinfo['Groupname']; ?></p>
<div class="space8"></div>
<? echo $wbinfo['GroupDesc']; ?>
</div>
<div class="w_rightsub">
<!--option to accept or reject a whiteboard group the user is invited to-->
<input type="hidden" name="acceptid" value="<? echo $wbinfo['GroupID']; ?>" /><br/>
<input style="cursor:pointer;" type="submit" name="acceptwb" value="Accept" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>
<input style="cursor:pointer;" type="submit" name="rejectwb" value=" Reject" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>

</div>
<div class="clear"></div>
</div>
</form>
<? }//ending inner if 
 } //ending while
if($count==0){ ?>
<div class="nothing">
No Whiteboard Groups
</div>
<? }
}//ending outer else
?>
</div>

<div class="pblog_pm">
PUBLIC WHITEBOARD GROUPS
<!--Displaying the whiteboard groups with "global" privacy setting so the user can join it-->
<? $s="SELECT * FROM collwb_info WHERE classid=".$classID." AND Privacy=0";
$q=mysql_query($s);
//echo $classID;
//echo mysql_num_rows($q);
$countwb=0;
while($wb=mysql_fetch_array($q)){
	$s2="SELECT * FROM collwb_groupmembers WHERE GroupID=".$wb['GroupID']." AND userid=".$logid;
	$q2=mysql_query($s2);
	if(mysql_num_rows($q2)==0){
		$countwb=$countwb+1;
?>
<form action="main_wb.php?classid=<? echo $classID; ?>" method="post">
<div class="aclass">
<div class="aclass_descr">
<p class="ctitle"><? echo $wb['Groupname']; ?></p>
<div class="space8"></div>
<? echo $wb['GroupDesc']; ?>
</div>
<div class="w_rightsub">
<!--option to join a globally available whiteboard group-->
<input type="hidden" name="joinid" value="<? echo $wb['GroupID']; ?>" /><br/>
<input style="cursor:pointer;" type="submit" name="joinwb" value="Join Group" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>
</div>
<div class="clear"></div>
</div>
</form>
<? }//ending if 
 } //ending while 
if($countwb==0){?>
<div class="nothing">
No Whiteboard Groups
</div>
<? }//ending if ?>
</div>




<form action="main_wb.php?classid=<? echo $classID; ?>" method="post" name="createwbform" onsubmit="return createvalidate()" />
<div class="pblog_pm">
<!--Displays the form to create a new whiteboard group-->
<p>CREATE NEW GROUP</p>
<div class="space8"></div>
<div class="w_list">
GROUP<br/>
NAME<br/>
<div style="height:6px;"></div>
PRIVACY<br />
SETTINGS
<div style="height:14px;"></div>
DESCRIPTION
</div>
<div class="w_boxes">
<!-- displays the form to create a new whiteboard group -->
<input class="winput" type="text" name="newname" style="margin-top:15px" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"><br/>
<div class="space8"></div>
<div class="space8"></div>

<div style="margin-top:-3px; font-size:16px;">
<input type="radio" checked="checked" name="privacy" value="0" style="margin-right:5px;" />
<? if($classID!=0) echo "Open to all classmates"; else echo "Open to all users"; ?>  <br/>
<input type="radio" name="privacy" value="1" style="margin-right:5px;"/> Invite by Creator only
</div><br/>
<textarea class="warea" name="newdesc" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></textarea><br/>
<div style="height:5px;"></div>
<input style="cursor:pointer;" type="submit" name="createwb" value="Create Now" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>
</div>
</div>
</form>
</div>
</div>
<?php

include('html_bottom.php'); //including the bottom footer

?>