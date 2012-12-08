<?php

$auth=1; //user must be logged in to view this page 

include('includes.php'); //including "includes" file which connects to the database.
if(!isset($_GET['classid'])|| getNum("class_information", "classid", $_GET['classid'])!=1){ // Check Get
header('Location: http://connectedcampus.org/errorpage.php'); //If classid is not sent as GET or is wrong then redirect to error page
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
if(isset($_POST['joinclass'])){ //If the joinclass button is set, the logged in user will be subscribed to the classroom
	mysql_query("DELETE FROM class_invite WHERE rid=".$_POST['postlog']." AND cid=".$_POST['postclass']);
	if($_POST['postlog']!=$_POST['posttchr2']){
	$q=mysql_query("SELECT * FROM class_subscribed WHERE userid=".$_POST['postlog']." AND classid=".$_POST['postclass']);
	if(mysql_num_rows($q)==0){
		$s="INSERT INTO class_subscribed(userid,classid,status) VALUES(".$_POST['postlog'].", ".$_POST['postclass'].",0)";
		mysql_query($s);
	}
	}
	else{
	$q2=mysql_query("SELECT * FROM class_tchrleave WHERE classid=".$_POST['postclass']." AND userid=".$_POST['postlog']);
	if(mysql_num_rows($q2)!=0){
		$s2="DELETE FROM class_tchrleave WHERE classid=".$_POST['postclass']." AND userid=".$_POST['postlog'];
		mysql_query($s2);
	}
	}
}
function returnwbclass($g){ //Returns which classid the groupid of the whiteboards passed as a parameter belongs to
	$query=mysql_query("SELECT classid FROM collwb_info WHERE GroupID=".$g);
	$wbclass=mysql_fetch_array($query);
	return $wbclass[0];
}
if(isset($_POST['leaveclass'])){ //if the leaveclass button is set the logged in user is considered to have unsubscribed as a learner or left the class as an Instructor 
	$query2=mysql_query("SELECT * FROM collwb_groupmembers WHERE userid=".$_POST['postlog2']);
	while($grp=mysql_fetch_array($query2)){
		if(returnwbclass($grp['GroupID'])==$_POST['postclass2']){
			mysql_query("DELETE FROM collwb_groupmembers WHERE GroupID=".$grp['GroupID']." AND userid=".$_POST['postlog2']);
		}
	}
	if($_POST['posttchr']!=$_POST['postlog2']){
	mysql_query("DELETE FROM class_subscribed WHERE userid=".$_POST['postlog2']." AND classid=".$_POST['postclass2']);
	}
	else{
		mysql_query("INSERT INTO class_tchrleave(classid, userid) VALUES(".$_POST['postclass2'].", ".$_POST['postlog2'].")");
	}
}



$classID=$_GET['classid'];
$classname=mysql_fetch_array(mysql_query("SELECT classname FROM class_information WHERE classid='".$classID."'"));//Classroom Name
$classprivacy=mysql_fetch_array(mysql_query("SELECT privacy FROM class_information WHERE classid='".$classID."'")); //Classroom's privacy
$classrating=mysql_fetch_array(mysql_query("SELECT rating FROM class_teacher WHERE classid='".$classID."'"));//Classroom's Rating
$tchrID=mysql_fetch_array(mysql_query("SELECT userid FROM class_teacher WHERE classid='$classID'"));//ID of Instructor
$tchrname=mysql_fetch_array(mysql_query("SELECT name FROM user_information WHERE userid='$tchrID[0]'"));//Instructor's Name
$tchrmail=mysql_fetch_array(mysql_query("SELECT email FROM user_information WHERE userid='$tchrID[0]'"));//Instructor's Email

$tchruni=mysql_fetch_array(mysql_query("SELECT university FROM user_information WHERE userid='$tchrID[0]'"));//Instructor's University
$tchrplace=mysql_fetch_array(mysql_query("SELECT country FROM user_information WHERE userid='$tchrID[0]'"));//Instructor's Country
$logmail=$_SESSION['email'];//E-mail of current user logged in
$logname=getName($logmail); //Name of user logged in user returned by function, given email as parameter
$logid=getID($logmail); //ID of logged in user returned by function, given email as parameter

function checkstudent($l, $c){ //Checks if logged in user is a learner of the class whose classID is given
	$q=mysql_query("SELECT * FROM class_subscribed WHERE userid=".$l." AND classid=".$c);
	return mysql_num_rows($q);
}
if(isset($_POST['deletepost'])){
	//The blogdisplay.php page returns to this page when a post is deleted, the code below deletes all information of that posts along with the files attached to it
	$postid=$_POST['postdeleteid'];
	$delinfo=mysql_fetch_array(mysql_query("SELECT * FROM class_blog WHERE blogID=".$postid." AND byuserid=".$logid));
	if($delinfo['file1']!="" && $delinfo['file1']!=NULL){
		unlink(substr($delinfo['file1'],27));
	}
	if($delinfo['file2']!="" && $delinfo['file2']!=NULL){
		unlink(substr($delinfo['file2'],27));
	}
	if($delinfo['file3']!="" && $delinfo['file3']!=NULL){
		unlink(substr($delinfo['file3'],27));
	}
	$qdel=mysql_query("DELETE FROM class_blog WHERE blogID=".$postid." AND byuserid=".$logid);
	if($qdel){
		mysql_query("DELETE FROM class_blog_comments WHERE blogID=".$postid);
	}
}

include('html_top.php'); //including the top & left bar

?>
<!-- the jQuery files below are for the jQuery impromptu plugin-->
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery-impromptu.4.0.min.js"></script>
<script type="text/javascript" src="jquery.corner.js"></script>
<script type="text/javascript" src="common.js"></script>

<script type="text/javascript">
//This is he code for the jQuery impromptu plugin which is used to create the tutorial
 function popup()
 {
 var tourSubmitFunc = function(e,v,m,f){
			if(v === -1){
				$.prompt.prevState();
				return false;
			}
			else if(v === 1){
				$.prompt.nextState();
				return false;
			}
 },
tourStates = [
   {
		html: 'Classroom Name',
		buttons: { Next: 1 },
		focus: 1,
		position: { container: '#instr_info', x: -90, y: -90, width: 300, arrow: 'tl' },
		submit: tourSubmitFunc
	},
	
	{
		html: 'Articles, Notes or Video links posted by the instructer',
		
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#post_instr', x: 20, y: 27, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
	{
		html: 'Articles, Notes or Video links posted by the instructer',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#post_learner', x: 50, y: 27, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},

	{
		html: 'You can view instructor information',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#instr_info', x: 8, y: 27, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
	{
		html: 'Invite other users to join this classroom',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#instr_info', x: 100, y: -16, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
		{
		html: 'Discussion Forum to have a discussion on a topic',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#instr_info', x: 20, y: -16, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
		{
		html: 'Collaborative Whiteboard',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#instr_info', x: -80, y: -16, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
	{
		html: 'Main Class',
		buttons: { Done: 2 },
		focus: 1,
		position: { container: '#instr_info', x: -200, y: -16, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	}

];
$.prompt(tourStates, { opacity: 0.3 });
    }

</script>
<style type="text/css">
/*BELOW IS THE CSS FOR jQuery Impromptu Plugin Used*/
div.jqi{ 
	width: 400px; 
	/*font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; */
	position: absolute; 
	background-color: #000000;
	opacity:0.8;
	filter:alpha(opacity=80);
	font-size: 11px; 
	text-align: left; 
	border: solid 1px #eeeeee;
	border-radius: 10px;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	padding: 7px;
}
div.jqi .jqicontainer{ 
	font-weight: bold; 
}
div.jqi .jqiclose{ 
	position: absolute;
	top: 4px; right: -2px; 
	width: 18px; 
	cursor: default; 
	color: #bbbbbb; 
	font-weight: bold; 
}
div.jqi .jqimessage{ 
	padding: 10px; 
	line-height: 20px; 
	/*color: #444444; */
	color:#f0f0f0;
}
div.jqi .jqibuttons{ 
	text-align: right; 
	padding: 5px 0 5px 0; 
	border: solid 1px #eeeeee; 
	background-color: #f4f4f4;
}
div.jqi button{ 
	padding: 3px 10px; 
	margin: 0 10px; 
	background-color: #2F6073; 
	border: solid 1px #f4f4f4; 
	color: #ffffff; 
	font-weight: bold; 
	font-size: 12px; 
}
div.jqi button:hover{ 
	background-color: #728A8C;
}
div.jqi button.jqidefaultbutton{
	background-color: #BF5E26;
}
.jqiwarning .jqi .jqibuttons{ 
	background-color: #BF5E26;
}

.jqi .jqiarrow{ position: absolute; height: 0; width:0; line-height: 0; font-size: 0; border: solid 10px transparent;}

.jqi .jqiarrowtl{ left: 10px; top: -20px; border-bottom-color: #000000; }
.jqi .jqiarrowtc{ left: 50%; top: -20px; border-bottom-color: #000000; margin-left: -10px; }
.jqi .jqiarrowtr{ right: 10px; top: -20px; border-bottom-color: #000000; }

.jqi .jqiarrowbl{ left: 10px; bottom: -20px; border-top-color: #000000; }
.jqi .jqiarrowbc{ left: 50%; bottom: -20px; border-top-color: #000000; margin-left: -10px; }
.jqi .jqiarrowbr{ right: 10px; bottom: -20px; border-top-color: #000000; }

.jqi .jqiarrowlt{ left: -20px; top: 10px; border-right-color: #000000; }
.jqi .jqiarrowlm{ left: -20px; top: 50%; border-right-color: #000000; margin-top: -10px; }
.jqi .jqiarrowlb{ left: -20px; bottom: 10px; border-right-color: #000000; }

.jqi .jqiarrowrt{ right: -20px; top: 10px; border-left-color: #000000; }
.jqi .jqiarrowrm{ right: -20px; top: 50%; border-left-color: #000000; margin-top: -10px; }
.jqi .jqiarrowrb{ right: -20px; bottom: 10px; border-left-color: #000000; }

/*
------------------------------
	impromptu
------------------------------
*/
.impromptuwarning .impromptu{ background-color: #aaaaaa; }
.impromptufade{
	position: absolute;
	background-color: #000000;
}
div.impromptu{
    position: absolute;
	background-color: #cccccc;
	padding: 10px; 
	width: 300px;
	text-align: left;
}
div.impromptu .impromptuclose{
    float: right;
    margin: -35px -10px 0 0;
    cursor: pointer;
    color: #213e80;
}
div.impromptu .impromptucontainer{
	background-color: #213e80;
	padding: 5px; 
	color: #000000;
	font-weight: bold;
}
div.impromptu .impromptumessage{
	background-color: #415ea0;
	padding: 10px;
}
div.impromptu .impromptubuttons{
	text-align: center;
	padding: 5px 0 0 0;
}
div.impromptu button{
	padding: 3px 10px 3px 10px;
	margin: 0 10px;
}

/*
------------------------------
	columns ex
------------------------------
*/
.colsJqifadewarning .colsJqi{ background-color: #b0be96; }
.colsJqifade{
	position: absolute;
	background-color: #ffffff;
}
div.colsJqi{
    position: absolute;
	background-color: #d0dEb6;
	padding: 10px; 
	width: 400px;
	text-align: left;
}
div.colsJqi .colsJqiclose{
    float: right;
    margin: -35px -10px 0 0;
    cursor: pointer;
    color: #bbbbbb;
}
div.colsJqi .colsJqicontainer{
	background-color: #e0eEc6;
	padding: 5px; 
	color: #ffffff;
	font-weight: bold;
	height: 160px;
}
div.colsJqi .colsJqimessage{
	background-color: #c0cEa6;
	padding: 10px;
	width: 280px;
	height: 140px;
	float: left;
}
div.colsJqi .jqibuttons{
	text-align: center;
	padding: 5px 0 0 0;
}
div.colsJqi button{
	background: url(../images/button_bg.jpg) top left repeat-x #ffffff;
	border: solid #777777 1px;
	font-size: 12px;
	padding: 3px 10px 3px 10px;
	margin: 5px 5px 5px 10px;
	width: 75px;
}
div.colsJqi button:hover{
	border: solid #aaaaaa 1px;
}

/*
------------------------------
	brown theme
------------------------------
*/
.brownJqiwarning .brownJqi{ background-color: #cccccc; }
.brownJqifade{
	position: absolute;
	background-color: #ffffff;
}
div.brownJqi{
	position: absolute;
	background-color: transparent;
	padding: 10px;
	width: 300px;
	text-align: left;
}
div.brownJqi .brownJqiclose{
    float: right;
    margin: -20px 0 0 0;
    cursor: pointer;
    color: #777777;
    font-size: 11px;
}
div.brownJqi .brownJqicontainer{
	position: relative;
	background-color: transparent;
	border: solid 1px #5F5D5A;
	color: #ffffff;
	font-weight: bold;
}
div.brownJqi .brownJqimessage{
	position: relative;
	background-color: #F7F6F2;
	border-top: solid 1px #C6B8AE;
	border-bottom: solid 1px #C6B8AE;
}
div.brownJqi .brownJqimessage h3{
	background: url(../images/brown_theme_gradient.jpg) top left repeat-x #ffffff;
	margin: 0;
	padding: 7px 0 7px 15px;
	color: #4D4A47;
}
div.brownJqi .brownJqimessage p{
	padding: 10px;
	color: #777777;
}
div.brownJqi .brownJqimessage img.helpImg{
	position: absolute;
	bottom: -25px;
	left: 10px;
}
div.brownJqi .brownJqibuttons{
	text-align: right;
}
div.brownJqi button{
	background: url(../images/brown_theme_gradient.jpg) top left repeat-x #ffffff;
	border: solid #777777 1px;
	font-size: 12px;
	padding: 3px 10px 3px 10px;
	margin: 5px 5px 5px 10px;
}
div.brownJqi button:hover{
	border: solid #aaaaaa 1px;
}

/*
*------------------------
*   clean blue ex
*------------------------
*/
.cleanbluewarning .cleanblue{ background-color: #acb4c4; }`
.cleanbluefade{ position: absolute; background-color: #aaaaaa; }
div.cleanblue{ font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; position: absolute; background-color: #ffffff; width: 300px; font-size: 11px; text-align: left; border: solid 1px #213e80; }
div.cleanblue .cleanbluecontainer{ background-color: #ffffff; border-top: solid 14px #213e80; padding: 5px; font-weight: bold; }
div.cleanblue .cleanblueclose{ float: right; width: 18px; cursor: default; margin: -19px -12px 0 0; color: #ffffff; font-weight: bold; }
div.cleanblue .cleanbluemessage{ padding: 10px; line-height: 20px; font-size: 11px; color: #333333; }
div.cleanblue .cleanbluebuttons{ text-align: right; padding: 5px 0 5px 0; border: solid 1px #eeeeee; background-color: #f4f4f4; }
div.cleanblue button{ padding: 3px 10px; margin: 0 10px; background-color: #314e90; border: solid 1px #f4f4f4; color: #ffffff; font-weight: bold; font-size: 12px; }
div.cleanblue button:hover{ border: solid 1px #d4d4d4; }

/*
*------------------------
*   Ext Blue Ex
*------------------------
*/
.extbluewarning .extblue{ border:1px red solid; }
.extbluefade{ position: absolute; background-color: #ffffff; }
div.extblue{ border:1px #6289B6 solid; position: absolute; background-color: #CAD8EA; padding: 0; width: 300px; text-align: left; }
div.extblue .extblueclose{ background-color: #CAD8EA; margin:2px -2px 0 0; cursor: pointer; color: red; text-align: right; }
div.extblue .extbluecontainer{ background-color: #CAD8EA; padding: 0 5px 5px 5px; color: #000000; font:normal 11px Verdana; }
div.extblue .extbluemessage{ background-color: #CAD8EA; padding: 0; margin:0 15px 15px 15px; }
div.extblue .extbluebuttons{ text-align: center; padding: 0px 0 0 0; }
div.extblue button{ padding: 1px 4px; margin: 0 10px; background-color:#cccccc; font-weight:normal; font-family:Verdana; font-size:10px; }

/*
*------------------------
*   smooth Ex
*------------------------
*/
.jqismoothfade{ position: absolute; background-color: #333333; }
div.jqismooth{ width: 350px; font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; position: absolute; background-color: #ffffff; font-size: 11px; text-align: left; border: solid 3px #e2e8e6; -moz-border-radius: 10px; -webkit-border-radius: 10px; padding: 7px; }
div.jqismooth .jqismoothcontainer{ font-weight: bold; }
div.jqismooth .jqismoothclose{ position: absolute; top: 0; right: 0; width: 18px; cursor: default; text-align: center; padding: 2px 0 4px 0; color: #727876; font-weight: bold; background-color: #e2e8e6; -moz-border-radius-bottomLeft: 5px; -webkit-border-bottom-left-radius: 5px; border-left: solid 1px #e2e8e6; border-bottom: solid 1px #e2e8e6;  }
div.jqismooth .jqismoothmessage{ padding: 10px; line-height: 20px; color: #444444; }
div.jqismooth .jqismoothbuttons{ text-align: right; padding: 5px 0 5px 0; border: solid 1px #e2e8e6; background-color: #f2f8f6; }
div.jqismooth button{ padding: 3px 10px; margin: 0 10px; background-color: #2F6073; border: solid 1px #f4f4f4; color: #ffffff; font-weight: bold; font-size: 12px; }
div.jqismooth button:hover{ background-color: #728A8C; }
div.jqismooth button.jqismoothdefaultbutton{ background-color: #BF5E26; }
.jqismoothwarning .jqismooth .jqismoothbuttons{ background-color: #BF5E26; }


</style>

<style type="text/css">
#helpbox{
position:fixed;
right:0;
width:130px;
height:60px;
opacity:0.8;
filter:alpha(opacity=80);
background:#000;
font-size:16px;
font-family: 'Century Gothic', sans-serif;
color:#f0f0f0;
padding:5px;
padding-left:15px;
}
.hbutton{
	font-family: 'Century Gothic', sans-serif;
	background:#ffffff;
	border: 1px solid #dadada;
	outline:none;
	font-size:11px;
}
</style>
<!--the "Start Tutorial" option is displayed for all-->
<? //if($logid==$user){ ?>
<div id="helpbox" onclick="popup()">
Start Tutorial<br/>
<div style="height:5px"></div>
<input name="submit" value="Yes" class="hbutton"  onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'" type="submit">
</div>
<? //} ?>


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
	height: 50px;
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
<? include "classheaderfinal.php"; ?>
<style type="text/css">
#class_contentbox{
margin-top:20px;
}
#cblog_wrap{
width:450px;
float:left;
}
.cblog_p{
width:440px;
background:#ffffff;
min-height:150px;
margin-bottom:20px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:10px;
float:left;

}
.cblog_p2{
width:440px;
background:#fafafa;
min-height:150px;
margin-bottom:20px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:10px;
float:left;

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
.c_box{
	max-width:240px;
	height:120px;
	background:#fafafa;
	padding:10px;
	margin-bottom:20px;
}
.c_box2{
	max-width:240px;
	height:200px;
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
width:130px;
font-size:18px;
}
</style>
<div id="class_contentbox">
<div id="cblog_wrap">
<div class="cblog_p">
<!--Posts by the instructor are displayed below-->
<span class="bloghead" id="post_instr">Posts by Instructor</span>
<span class="blogdesc">&nbsp;&nbsp;&nbsp;<? if ($logid==$tchrID[0] && tchrleft($tchrID[0], $classID)==0) echo "<a href='blog_post.php?classid=".$classID."'>NEW POST</a>"; ?></span></br>
<div class="space8"></div>
<?php 
$sql="SELECT * FROM class_blog WHERE classID=".$classID." AND byuserid=".$tchrID[0]." ORDER BY dt";
$query=mysql_query($sql); 
if (mysql_num_rows($query)==0){ 
echo "No Posts Yet";
}
else{ ?>
<table>
	<? while($blog=mysql_fetch_array($query)){?>
<tr>
	<td style="width:200px;">
    	<a href="blogdisplay.php?blogid=<?php echo $blog['blogID'];?>&classid=<? echo $classID; ?>"><?php echo $blog['blogname']; ?></a>
    </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;<? //echo " by ".getNamewID($blog['byuserid']); ?></td>
</tr>

<? } //ending while
echo "</table>";
}//ending else ?>
</div>
<div class="cblog_p2">
<!--Posts by the learners are displayed below-->
<span class="bloghead" id="post_learner">Posts by Learners</span>
<span class="blogdesc">&nbsp;&nbsp;&nbsp;<? if (checkstudent($logid, $classID)==1) echo "<a href='blog_post.php?classid=".$classID."'>NEW POST</a>"; ?></span></br>
<div class="space8"></div>
<?php 
$sql="SELECT * FROM class_blog WHERE classID=".$classID." AND byuserid!=".$tchrID[0]." ORDER BY dt";
$query=mysql_query($sql); 
if (mysql_num_rows($query)==0){ 
echo "No Posts Yet";
}
else{ ?>
<table>
	<? while($blog=mysql_fetch_array($query)){?>
<tr>
	<td style="width:200px;">
    	<a href="blogdisplay.php?blogid=<?php echo $blog['blogID'];?>&classid=<? echo $classID; ?>"><?php echo $blog['blogname']; ?></a>
    </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo " by ".getNamewID($blog['byuserid']); ?></td>
</tr>

<? } //ending while
echo "</table>";
}//ending else ?>
</div>
</div>
<?
$usermail=$tchrmail[0]; //The teacher's email address
//Retrieves privacy of the instructor's image
$qp2=mysql_query("SELECT * FROM privacy_user WHERE email='".$usermail."' AND property='pic'");
if(mysql_num_rows($qp2)==0){
	$privacypic=0;
}
else{
	$prbpic=mysql_fetch_array($qp2);
	$privacypic=$prbpic['setting'];
}
function checkpeer($l, $u){ //checks if two userids passed as parameters are peers of each other
	$query=mysql_query("SELECT * FROM friends WHERE userid=".$u." AND friendid=".$l);
	if(mysql_num_rows($query)==1){
		return 1;
	}
	else{
		return 0;
	}
}
function checkifinvited($l, $c){ //checks if the userid passed as parameter has been invited to join the classid passed as parameter
	$sql="SELECT * FROM class_invite WHERE rid=".$l." AND cid=".$c;
	$query=mysql_query($sql);
	if(mysql_num_rows($query)>0){
		return 1;
	}
	else {
		return 0;
	}
}
function getuserpic($id){ //returns the link to the profile picture of the user whose id is passed as parameter
	$sql="SELECT photo FROM user_information WHERE userid=".$id;
	$result=mysql_fetch_array(mysql_query($sql));
	return $result['photo'];
}
?>
<div id="cright_wrap">
<? if(tchrleft($tchrID[0], $classID)==0){ //display instructor info only if Instructor did not leave the classroom?>
<div class="c_box">
<span class="crhead" id="instr_info">Instructor's info&nbsp;&nbsp;</span>
<a style="text-decoration:none;" class="iframe" tabindex="1" href="newmessage.php?touser=<? echo $tchrID[0]; ?>">
<img src="img/add_message.png"/></a><br />
<div class="space8"></div>
<div id="cimg_hold">
<a href="profile_main.php?userid=<? echo $tchrID[0]; ?>">
<!--Displays profile picture of the Instructor according to the privacy settings in the Instructor's profile-->
<img src="<? if(getuserpic($tchrID[0])==""){echo "img/defpic.png";}else{if($privacypic==0||($privacypic==1 && checkpeer($logid, $tchrID[0])==1)|| ($privacypic==2 && $logid==$tchrID[0])) {echo getuserpic($tchrID[0]);}else echo "img/defpic.png"; } ?>" height="90" width="70"></a></div>
<div id="cinst_hold">
<span class="cint_name"><a href="profile_main.php?userid=<? echo $tchrID[0]; ?>"><? echo $tchrname[0]; ?></a></span><br />
<div class="space5"></div>
<div id="cint_det">
</div>
</div>
</div>
<? } else { ?>
<div class="c_box">
<span class="crhead" id="instr_info">Instructor's info&nbsp;&nbsp;</span>
<br />
<div class="space8"></div>
<div id="cimg_hold">
<img src="img/defpic.png" height="90" width="70"></div>
<div id="cinst_hold">
<span class="cint_name">Instructor Left Class</span><br />
<div class="space5"></div>
<div id="cint_det">
</div>
<!--<div id="cinst_ratings">8.5</div>-->
</div>
</div>
<? } ?>
<div class="c_box2">
<span class="crhead">Options</span><br/><br/>
<? 
//Privacy setting of the classroom displayed
if($classprivacy[0]==0){
	echo "Global Classroom<br/>Anyone can join";
}
else{
	if(tchrleft($tchrID[0],$classID)==1){
		echo "Private Classroom<br/>Invite by any Learner";
	}else{
		echo"Private Classroom<br/>Invite by Instructor only";
	}
} ?>
<br/>
<br/>
<?
if((($logid!=$tchrID[0]) && checkstudent($logid, $classID)==0  && $classprivacy[0]==0)||($logid==$tchrID[0] && tchrleft($tchrID[0],$classID)==1)||checkifinvited($logid, $classID)==1){ //if the logged in user in neither Instructor nor Learner then "join class" option will appear depending on the privacy setting of course
?>

<form name="joinclassform" action="main_class.php?classid=<? echo $classID; ?>" method="post">
<input type="hidden" name="posttchr2" value="<? echo $tchrID[0]; ?>"/>
<input type="hidden" name="postlog" value="<? echo $logid; ?>"/>
<input type="hidden" name="postclass" value="<? echo $classID; ?>"/>
<input style="cursor:pointer;" type="submit" name="joinclass" value="Join Class" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>
</form>
<br/>

<? }
if(($logid==$tchrID[0] && tchrleft($tchrID[0], $classID)==0)||checkstudent($logid, $classID)==1) { // if he is either the Instructor or a learner then "Leave Class" option will appear?>
<form name="leaveclassform" action="main_class.php?classid=<? echo $classID; ?>" method="post"  onsubmit="return confirm('Are you sure you want to leave? You will no longer be a member of any whiteboard groups you created.')">
<input type="hidden" name="posttchr" value="<? echo $tchrID[0]; ?>"/>
<input type="hidden" name="postlog2" value="<? echo $logid; ?>"/>
<input type="hidden" name="postclass2" value="<? echo $classID; ?>"/>
<input style="cursor:pointer;" type="submit" name="leaveclass" value="Leave Class" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>
</form><br/>
<? }//ending if ?>

<? if(($logid==$tchrID[0] && tchrleft($tchrID[0], $classID)==0)||(checkstudent($logid, $classID)==1)){
	//The learners & the instructor will see an option to view other learners?>
<a class="iframe" href="classlearners.php?classid=<? echo $classID; ?>"><input style="cursor:pointer;" type="button" name="viewlearners" value="View Learners" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/></a>
<? }//ending if ?>

<!--Display button to allow edit of the class's image-->
<? if($logid==$tchrID[0]){ ?>
<br/><br/>
<a class="iframe" href="classimage.php?classid=<? echo $classID; ?>"><input style="cursor:pointer;" type="submit"value="Class Image" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/></a>
<? } ?>
<div>
</div>
</div>
</div>
</div>

<?php

include('html_bottom.php'); //including the footer of the page

?>