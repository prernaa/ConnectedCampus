<?php

$auth=1; //user must be logged in to view this page 

include('includes.php'); //including "includes" file which connects to the database.
if(isset($_GET['userid'])){ //if userid is sent via GET, then the logged in user will see the profile of the user whose userid is sent
if(getNum("user_information", "userid", $_GET['userid'])==0){ // Check Get
		header('Location: http://connectedcampus.org/errorpage.php'); //If userid is sent as GET and is wrong then redirect to error page
}
}
include('html_top.php');
$log=$_SESSION['email']; //Gives logged in user's email address
$logid=getID($log);

if(isset($_GET['userid']))
{
	$user=$_GET['userid']; 
}
else {
	$user=$logid; //if no userid is sent via GET, the logged in user is viewing his own profile
}
$userinfo=mysql_fetch_array(mysql_query("SELECT * FROM user_information where userid=".$user)); 
//fetches user's info from the DB i.e. the user whose profile is being displayed.


if(isset($_POST['acceptclass'])){ //When user accepts a class's invite, he is subscribed as a learner to that classroom 
	mysql_query("DELETE FROM class_invite WHERE rid=".$_POST['logaccrej']." AND cid=".$_POST['acceptrejectid']);
	if($_POST['logaccrej']!=$_POST['accrejtchr']){
	$q=mysql_query("SELECT * FROM class_subscribed WHERE userid=".$_POST['logaccrej']." AND classid=".$_POST['acceptrejectid']);
	if(mysql_num_rows($q)==0){
		$s="INSERT INTO class_subscribed(userid,classid,status) VALUES(".$_POST['logaccrej'].", ".$_POST['acceptrejectid'].",0)";
		mysql_query($s);
	}
	}
	else{ //When user accepts a class's invite, & had been the instructor of the class before leaving it, he is made the instructor again
	$q2=mysql_query("SELECT * FROM class_tchrleave WHERE classid=".$_POST['acceptrejectid']." AND userid=".$_POST['logaccrej']);
	if(mysql_num_rows($q2)!=0){
		$s2="DELETE FROM class_tchrleave WHERE classid=".$_POST['acceptrejectid']." AND userid=".$_POST['logaccrej'];
		mysql_query($s2);
	}
	}
}
if(isset($_POST['rejectclass'])){ //Deletes the invite from DB when the user rejects it
	mysql_query("DELETE FROM class_invite WHERE rid=".$_POST['logaccrej']." AND cid=".$_POST['acceptrejectid']);
}
function gettchrid($cid){ //Returns the userid of the instructor of the classid passed as parameter
	$sql="SELECT * FROM class_teacher WHERE classid=".$cid;
	$teacher=mysql_fetch_array(mysql_query($sql));
	return $teacher['userid'];
}
function getclassname($id) { //Returns the name of the class whose classid is passed as parameter
	$sql="SELECT classname FROM class_information WHERE classid=".$id;
	$result=mysql_fetch_array(mysql_query($sql));
	return $result['classname'];
}
function getclassimg($id) { /* Returns the filename of the class image whose classid is passed as parameter */
	$sql="SELECT image FROM class_information WHERE classid=".$id;
	$result=mysql_fetch_array(mysql_query($sql));
	return $result['image'];
}
function checkifmutual($id, $visitor) { //if the visitor is either instructor/learner of classroom id, then returns 1 else it returns 0
//This function checks if the logged in user is also a learner/instructor of the classroom the user whose profile is being viewed is
	$query=mysql_query("SELECT * FROM class_subscribed WHERE classid=".$id." AND userid=".$visitor);
	$query2=mysql_query("SELECT * FROM class_teacher WHERE classid=".$id." AND userid=".$visitor);
	if(((mysql_num_rows($query) || mysql_num_rows($query2)))>0)
		return 1;
	else
		return 0;
}

function mutualclassgen($usr, $visitor){
	//This function generates an array of mutual classrooms between the logged in user & the user whose profile is being viewed
	$mutualclass=0;
	$query=mysql_query("SELECT classid FROM class_teacher WHERE userid=".$usr); //all classes taught by the user
	while($class=mysql_fetch_array($query)) {
		if(checkifmutual($class['classid'], $visitor)) {$mutualclassarr[$mutualclass]=$class['classid']; $mutualclass+=1; }
	}
	$query2=mysql_query("SELECT classid FROM class_subscribed WHERE userid=".$usr); //all classes subscribed by the user
	while($class2=mysql_fetch_array($query2)) {
		if(checkifmutual($class2['classid'], $visitor)) {$mutualclassarr[$mutualclass]=$class2['classid']; $mutualclass+=1; }
	}
	return $mutualclassarr;
}
function checkifmutualpeer($peerid, $visitor) { //Checks if the two userids passed as parameters are peers
	$query=mysql_query("SELECT * FROM friends WHERE friendid=".$peerid." AND userid=".$visitor);
	if(mysql_num_rows($query)>0)
		return 1;
	else
		return 0;
}
function mutualpeergen($usr, $visitor){ //usr:whose profile we're seeing. visitor:from session variable (the viewer)
	$mutualpeer=0;
	$query=mysql_query("SELECT friendid FROM friends WHERE userid=".$usr); //all classes taught by the user
	while($peer=mysql_fetch_array($query)) {
		if(checkifmutualpeer($peer['friendid'], $visitor)) {$mutualpeerarr[$mutualpeer]=$peer['friendid']; $mutualpeer+=1; }
	}
	return $mutualpeerarr; //Returns a generated array of userids of mutual peers between the viewer & the user whose profile is being viewed
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
		html: 'You can change your privacy settings',
		buttons: { Next: 1 },
		focus: 1,
		position: { container: '#im_settings', x: 20, y: 23, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
	{
		html: 'Connect to experts on any topic',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#im_expert', x: 50, y: 23, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},

	{
		html: 'Events can be created or joined',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#im_event', x: 8, y: 23, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
	{
		html: 'Collaborative Whiteboard',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#im_wb', x: 20, y: 23, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
		{
		html: 'Discussion Forum to have a discussion on a topic',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#im_forum', x: 10, y: 23, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
		{
		html: 'Your Peers',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#im_peers', x: 4, y: 23, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
	{
		html: 'Profile page',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#im_profile', x: 0, y: 23, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
	{
		html: 'About you',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#aboutmeid', x: 120, y: -5, width: 300, arrow: 'lm' },
		submit: tourSubmitFunc
	},
	 {
		html: 'Classes Subscribed by you',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#classsubscribed', x: -340, y: 5, width: 300, arrow: 'rt' },
		submit: tourSubmitFunc
	},

    {
		html: 'Classes Created by you',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#classcreated', x: -340, y: 5, width: 300, arrow: 'rt' },
		submit: tourSubmitFunc
	},
	{
		html: 'Featured Classes',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#featuredclass', x: -340, y: 5, width: 300, arrow: 'rt' },
		submit: tourSubmitFunc
	},
	{
		html: 'Suggested Classes',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#suggestedclass', x: 420, y: 0, width: 300, arrow: 'lm' },
		submit: tourSubmitFunc
		
	},
	{
		html: 'Your Messages',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#msg', x: 30, y: 25, width: 300, arrow: 'tl' },
		submit: tourSubmitFunc
		
	},
		{
		html: 'Display tags, likes and comments',
		buttons: { Done: 2 },
		focus: 1,
		position: { container: '#acthold', x: 30, y: 25, width: 300, arrow: 'tl' },
		submit: tourSubmitFunc
		
	}

];
$.prompt(tourStates, { opacity: 0.3 });
    }

</script>
<style type="text/css">
#profile{ }
#peers{ }
#forum{ }
#whiteboard{ }
#events{ }
#findexpert{ }
#classsubscribed{ }
#classcreated{ }
#featuredclass{ }
#suggestedclass{ }
#Settings{ }
#aboutmeid{ }
</style>

<style type="text/css">
#pbox{
	width:720px;
	height:125px;
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
$usermail=$userinfo['email']; //email address of user whose profile is being viewed

//Below, $privacybday, $privacypic, $privacypeers, $privacyabt contain privacy settings of the user for birthday, profile pic, peers, about, etc
//0 means global, 1 means peer & 2 means only the user himself & no one else
$qp1=mysql_query("SELECT * FROM privacy_user WHERE email='".$usermail."' AND property='bday'");
if(mysql_num_rows($qp1)==0){
	$privacybday=0;
}
else{
	$prbday=mysql_fetch_array($qp1);
	$privacybday=$prbday['setting'];
}
$qp2=mysql_query("SELECT * FROM privacy_user WHERE email='".$usermail."' AND property='pic'");
if(mysql_num_rows($qp2)==0){
	$privacypic=0;
}
else{
	$prbpic=mysql_fetch_array($qp2);
	$privacypic=$prbpic['setting'];
}
$qp3=mysql_query("SELECT * FROM privacy_user WHERE email='".$usermail."' AND property='peers'");
if(mysql_num_rows($qp3)==0){
	$privacypeers=0;
}
else{
	$prpeers=mysql_fetch_array($qp3);
	$privacypeers=$prpeers['setting'];
}
$qp4=mysql_query("SELECT * FROM privacy_user WHERE email='".$usermail."' AND property='abtme'");
if(mysql_num_rows($qp4)==0){
	$privacyabt=0;
}
else{
	$prabt=mysql_fetch_array($qp4);
	$privacyabt=$prabt['setting'];
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


?>

<!--<button onclick="popup()">Click</button>-->

<div id="pbox">
<div id="pbox_img_hold">
<!--displays picture of the user whose profile is being viewed along with his other details considering his privacy settings-->
<img src="<? if($userinfo['photo']==""){echo "img/defpic.png";}else{if($privacypic==0||($privacypic==1 && checkpeer($logid, $user)==1)|| ($privacypic==2 && $logid==$user)) {echo $userinfo['photo'];}else echo "img/defpic.png"; } ?>" height="100" width="100"></div>
<div id="pdes_hold">
<h5><? echo $userinfo['name']; ?>
<a style="text-decoration:none;" class='iframe' tabindex='1' href='newmessage.php?touser=<? echo $userinfo['userid']; ?>'> <img src='img/add_message.png'></a> 

<? $query2=mysql_query("SELECT * FROM friends WHERE userid=".$user." AND friendid=".$logid);
$query3=mysql_query("SELECT * FROM friends_request WHERE userid=".$user." AND friendid=".$logid);
if($user!=$logid){
	//If the logged in user is viewing another users profile, he will see appropriate options like 'remove peer', 'add peer' 'accept request', 'peer request sent'
	//The code for these options is in profile_options.php
if(mysql_num_rows($query2)!=0){ //i.e. confirmed friend ?>
<a href="profile_options.php?<? echo "userid=".$user."&action=3"; ?>"><img src="img/p_del2.png" width="18" height="18"/></a>
<? } //ending if
else if(mysql_num_rows($query3)==0){ ?>
<a href="profile_options.php?<? echo "userid=".$user."&action=1"; ?>"><img src="img/p_add2.png" width="18" height="18"/></a>
<? } else{ 
$statuspeer=mysql_fetch_array($query3);
if($statuspeer['status']==1){?>
<a href="profile_options.php?<? echo "userid=".$user."&action=2"; ?>"><img src="img/p_acpt2.png" width="18" height="18"/></a>
<? } 
elseif($statuspeer['status']==0){?>
<img src="img/p_sent2.png" width="18" height="18"/>
<? }
} 
}?>
</h5><br/>
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
<? if($logid==$user){ 
//If the user is viewing his own profile, he will see a "Start Tutorial" box which will start a tour for the webpage?>
<div id="helpbox" onclick="popup()">
Start Tutorial<br/>
<div style="height:5px"></div>
<input name="submit" value="Yes" class="hbutton"  onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'" type="submit">
</div>
<? } ?>
<!--Displaying further details about the user whose profile is being viewed -->
<div id="pdescription">
<? if($userinfo['university']!=""){echo $userinfo['university'];} ?><br/>
<? if($userinfo['occupation']!="") {echo $userinfo['occupation']." in ";} ?><? if($userinfo['fieldofstudy']!="") {echo $userinfo['fieldofstudy'].", ";} ?>
<? if(($userinfo['graduationyr']!="") && ($userinfo['graduationyr']!=0)) {echo "Class of ".$userinfo['graduationyr'];} ?><br/>
<? if($userinfo['city']!="") {echo $userinfo['city'].", ";} if($userinfo['country']!="") {echo $userinfo['country'];} ?><br />
<? $birthday=$userinfo['bday']; $birthmonth=$userinfo['bmonth']; $birthyear=$userinfo['byear']; 
  if($birthday[1]=="1") {$bdaysup="st";} 
  else if($birthday[1]=="2") {$bdaysup="nd";}
  else if($birthday[1]=="3") {$bdaysup="rd";}
  else $bdaysup="th";?>
<? if($privacybday==0||($privacybday==1 && checkpeer($logid, $user)==1)|| ($privacybday==2 && $logid==$user)){ if(($birthday!="") && ($birthmonth!="")) {echo "B'day: ".$birthday."<sup>".$bdaysup."</sup>"." ".$birthmonth." ".$birthyear;}} ?><br/>
</div>
<div id="pnav_bar">
<!--Displaying Navigation bar-->
<? if($user==$logid){
	//User can only edit his own avatar or change his own profile settings?>
<div class = "class_nav_btn">
<a class="iframe" href="picupdate.php"/>Edit avatar</a>
</div>
<div class = "class_nav_btn">
<a href='settings_template.php'>Profile Settings</a>
</div>
<? }//ending if ?>
<? //Display option to go the peers page based on the user's privacy settings
if($privacypeers==0||($privacypeers==1 && checkpeer($logid, $user)==1)|| ($privacypeers==2 && $logid==$user)) { ?>
<div class = "class_nav_btn" id="peers">
<a href="peers_main.php?userid=<? echo $user; ?>">Peers</a>
</div>
<? } ?>
</div>
</div>

</div>

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
	width:450px;
}
.buttonclass{
	float:right;
	width:100px;
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
.aboutme{
padding-left:40px;
padding-top:10px;
padding-bottom:10px;
font-size:12px;
}
</style>
</style>
<style type="text/css">
/*CSS FOR jQUERY IMPROMTU i.e. USED TO CREATE A TUTORIAL*/
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
<div id="class_contentbox">
<div id="cblog_wrap">
<!--////Display user's "about me" info according to privacy setting///-->
<? if ($userinfo['abtme']!=""){ 
if($privacyabt==0||($privacyabt==1 && checkpeer($logid, $user)==1)|| ($privacyabt==2 && $logid==$user)){ ?>
<div class="pblog_pm" id="aboutmeid">
ABOUT ME
<div class="aboutme">
<? echo $userinfo['abtme'];?>
</div>
</div>
<? } 
}//ending if ?>

<?
//$user contains userid of the person who's profile we are viewing
$sql="SELECT classid FROM class_subscribed WHERE userid=".$user; 
$query=mysql_query($sql);
$numbersubs=mysql_num_rows($query);
//fethcing & displaying the user's subscribed classes
?>
<div class="pblog_pm" id="classsubscribed">
Classes Subscribed&nbsp;&nbsp; <? if($logid==$user){?><a class="iframe" style="cursor:pointer;" href="searchclass.php"><img src="img/searchclass.png" height="16" width="16" /></a><? } ?>
<?
if($numbersubs==0) {
?>
<div class="nothing">
No Classes Subscribed
</div>
<? } //ending if
else{ 
while ($class=mysql_fetch_array($query)){?>
<div class="aclass">
<div class="aclass_hold">
<a href="main_class.php?classid=<? echo $class['classid']; ?>">
<img src="<? echo "classimages/".getclassimg($class['classid']); ?>" width="160" height="80" alt="<? echo getclassname($class['classid']); ?>" style="cursor:pointer;"/>
</a>
</div>
<div class="aclass_descr">
<p class="ctitle"><a href="main_class.php?classid=<? echo $class['classid']; ?>"><? echo getclassname($class['classid']); ?></a></p>
<div class="space8"></div>
&nbsp; 
</div>
<div class="clear"></div>
</div>
<? } //ending while 
}//ending else ?>

</div>

<?
//$user contains userid of the person who's profile we are viewing
$sql="SELECT classid FROM class_teacher WHERE userid=".$user; 
$query=mysql_query($sql);
$numbertch=0;
//fethcing & displaying the user's classes created
?>
<div class="pblog_pm" id="classcreated">
Classes Created&nbsp;&nbsp; <? if($logid==$user){?><a style="cursor:pointer;" href="create_class.php" class="iframe" id="iframe"><img src="img/addclass.png" height="16" width="16"/></a><? } ?>
<?
while ($class=mysql_fetch_array($query)){
	if(tchrleft($user, $class['classid'])==0){
		$numbertch=$numbertch+1;?>
<div class="aclass">
<div class="aclass_hold">
<a href="main_class.php?classid=<? echo $class['classid']; ?>">
<img src="<? echo "classimages/".getclassimg($class['classid']); ?>" width="160" height="80" alt="<? echo getclassname($class['classid']); ?>" style="cursor:pointer;"/>
</a>
</div>
<div class="aclass_descr">
<p class="ctitle"><a href="main_class.php?classid=<? echo $class['classid']; ?>"><? echo getclassname($class['classid']); ?></a></p>
<div class="space8"></div>
&nbsp; 
</div>
<div class="clear"></div>
</div>
<? }
} //ending while 
if($numbertch==0){ ?>
<div class="nothing">
No Classes Created
</div>
	
<? }?>

</div>

<?
if($user!=$logid){  
$tryarr=mutualclassgen($user, $logid); 
$mutualclassnum=count($tryarr);
//fethcing & displaying the mutual classrooms between the logged in id & the user whose profile he is viewing
?>
<div class="pblog_pm">
Mutual Classes 
<?
if($mutualclassnum==0) {
?>
<div class="nothing">
No Mutual Classes
</div>
<? } //ending if
else{ 
foreach($tryarr as $value) { ?>
<div class="aclass">
<div class="aclass_hold">
<a href="main_class.php?classid=<? echo $value; ?>">
<img src="<? echo "classimages/".getclassimg($value); ?>" width="160" height="80" alt="<? echo getclassname($value); ?>" style="cursor:pointer;"/>
</a>
</div>
<div class="aclass_descr">
<p class="ctitle"><a href="main_class.php?classid=<? echo $value; ?>"><? echo getclassname($value); ?></a></p>
<div class="space8"></div>
&nbsp; 
</div>
<div class="clear"></div>
</div>
<? } //ending while 
}//ending else ?>
</div>
<? }//ending if ?>

<? if($user==$logid) { //Featured, Suggested Classrooms & Class Invites should only show if the user is on his own profile
?>
<div class="pblog_pm">
Class Invites
<? $sql2="SELECT * FROM class_invite WHERE rid=".$user; 
$queryinvite=mysql_query($sql2);
$countinvite=0;
//fetching & displaying classrooms the user has been invited to. option to "accept" or "reject" the invite is given too
while($class=mysql_fetch_array($queryinvite)){
	$countinvite=$countinvite+1; ?>
<form action="profile_main.php" method="post">
<div class="aclass">
<div class="aclass_hold">
<a href="main_class.php?classid=<? echo $class['cid']; ?>">
<img src="<? echo "classimages/".getclassimg($class['cid']); ?>" width="160" height="80" alt="<? echo getclassname($class['cid']); ?>" style="cursor:pointer;"/>
</a>
</div>
<div class="aclass_descr">
<p class="ctitle"><a href="main_class.php?classid=<? echo $class['cid']; ?>"><? echo getclassname($class['cid']); ?></a></p>
<div class="space8"></div>
Invited by <a href="profile_main.php?userid=<? echo $class['sid']; ?>"><? echo getNamewID($class['sid']); ?></a>
<div class="buttonclass">
<input type="hidden" name="logaccrej" value="<? echo $user; ?>" />
<input type="hidden" name="accrejtchr" value="<? echo gettchrid($class['cid']); ?>" />
<input type="hidden" name="acceptrejectid" value="<? echo $class['cid']; ?>"/>
<input style="cursor:pointer;" type="submit" name="acceptclass" value="Accept" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/> &nbsp;&nbsp;
<input style="cursor:pointer;" type="submit" name="rejectclass" value="Reject" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>
</div>
<div style="clear:both;"></div>
</div>
<div class="clear"></div>
</div>
</form>
<? }//ending while 
if($countinvite==0){
?>
<div class="nothing">
No Invites
</div>
<? }//ending if ?>
</div>
<?php

?>
<div class="pblog_pm" id="featuredclass">
Featured Classrooms
<?php
// Size for rating threshold
$rand = rand(0,100)-50;
$rating_thres = 8 + $rand/50;

// Get classroom ratings
$class = array();

// append data into array
$query = mysql_query("SELECT * FROM class_rating WHERE usrID != '0' AND classid != '0' ORDER BY rand()");

// number of classrooms on the screen;
$num_screen = 3;
while($c = mysql_fetch_array($query)){
	if($num_screen==0){
		break;
	}
	// Checks if user is subscribed to the current classroom
	if(getNum('class_subscribed', 'classid', $c['classid'], 'userid', $logid)>0){
		continue;
	}
	$class_t = $c['classid'];
	
	// check if class is private
	if(getNum2('class_information', 'classid', $class_t, 'privacy', 1)>0){
		continue;
	}
	
	// if thing exists
	if(!in_array($class_t,  $class)){
		// Get class mean ratings
		$query_t = mysql_query("SELECT * FROM class_rating WHERE classid = '".$class_t."'");
		
		$n = 0; // number
		$sum = 0; // ratings sum
		
		while($c_t = mysql_fetch_array($query_t)){
			$sum = $sum + $c_t['rating'];
			$num = num + 1;
		}
		
		$mean = $sum/$num;

		if($mean>=$rating_thres){
			$class[] = $class_t;
			$num_screen --;
		}	
	}
}
if(sizeof($class)==0){
?>
<div class="nothing">
No Featured Classrooms!
</div>
<?
}
// iterate through array
for($i=0; $i<sizeof($class); $i++){
?>
<div class="aclass">

<div class="aclass_hold">
<a href="main_class.php?classid=<? echo $class[$i]; ?>">
<img src="classimages/<?php
$img = fetchData("class_information", "image", "classid", $class[$i]); 
if($img!=''){
	echo $img;
} else {
	echo 'default.jpg';
}
?>" width="160" height="80" />
</div>
<div class="aclass_descr">
<p class="ctitle"><?php echo fetchData("class_information", "classname", "classid", $class[$i]); ?></p>
</a>
<div class="space8"></div>
<?php
$descr = fetchData("class_descr", "desc", "classid", $class[$i]);

if($descr!=''){
	echo $desc;
} else {
	echo '<div class="nothing">&nbsp;</div>';
}
?>
</div>
<div class="clear"></div>
</div>
<?php

}
?>
</div>
<?php
// Suggested classroom criteria
// num of friends subscribing
// class has same category
// ratings
// (1.5)^$num_friends*(3)^$cat_interested*($class_rat/10)*$d

// Pre constants
// modifier
$d=10;
// max number of classes
$num_class = 3;
$nc = $num_class;
// Take mean data
// num_friends = 0
// cat_interested = 1
// rating = 5
// high_bound = 1.5^0*3*0.5 = 15
$high_bound = 15;

// Take low data
// num_friends = 1
// cat_interested = 0
// rating = 5
// high_bound = 1.5^1*1*0.5 = 7
$low_bound = 7;

$suc_queue = array();
$low_queue = array();

// Iterate through the database
$query = mysql_query("SELECT * FROM class_information ORDER by RAND()");
while($c=mysql_fetch_array($query)){
	if($nc==0){
		break;
	}
	// Gets current inspected class
	$class = $c['classid'];
	
	// check if class is private
	if(getNum2('class_information', 'classid', $class, 'privacy', 1)>0){
		continue;
	}
	
	// Check if class already subscribed
	if(getNum2("class_subscribed", "userid", $logid, "classid", $class)>0){
		continue;
	}
	
	// Check if currently teaching the class
	if(getNum2("class_teacher", "userid", $logid, "classid", $class)>0){
		continue;
	}
	// Get num of friends subscribing
	
	// iterate through friend array
	$qf_t = mysql_query("SELECT * FROM friends WHERE userid = '".$logid."'");
	$num_friends = 0;
	
	// check if the friend is subscribed to the current class, incr counter if more found
	while($f_t=mysql_fetch_array($qf_t)){
		if(getNum2("class_subscribed", "userid", $f_t['friendid'], "classid", $class)>0){
			$num_friends ++;
		}
	}
	
	// get user interested category
	$cat_interested = 0;
	// get current class category
	$class_cat = fetchData("class_information", "catid", "classid", $class);
	
	// check if user is interested in the class category
	$qs_t = mysql_query("SELECT * FROM class_subscribed WHERE userid = '".$logid."'");
	while($s_t=mysql_fetch_array($qs_t)){
		// Get the sub inspected class cat
		$subclass_cat = fetchData("class_information", "catid", "classid", $s_t['classid']);
		if($subclass_cat==$class_cat){
			$cat_interested ++;
		}
	}
	
	// Get class rating
	$qr_t = mysql_query("SELECT * FROM class_rating WHERE classid='".$class."' AND usrID != '0' ORDER BY rand()");
	$n = 0;
	$sum = 0;
	while($r_t = mysql_fetch_array($qr_t)){
		$sum = $sum + $r_t['rating'];
		$n ++;
	}
	$class_rat = $sum/$n;
	
	// Friends subscribed $num_friends
	// Interested category $cat_interested
	// Class rating $class_rat
	// (1.5)^$num_friends*(3)^$cat_interested*($class_rat/10)*$d

	$alg = pow((1.5),$num_friends)*pow((3),$cat_interested)*($class_rat/10)*$d;
	
	if($alg>=$high_bound){
		$suc_queue[] = $class;
		$nc--;
	} else if ($alg>=$low_bound){
		$low_queue[] = $class;
	}
}
// fill $suc_queue
$left = $num_class-sizeof($suc_queue);
for($i=0; $i<($left); $i++){
	$suc_queue[] = $low_queue[$i];
}

?>
<div class="pblog_pm" id="suggestedclass">
Suggested Classrooms
<?php

// Print results
if($suc_queue[0]=="" && $suc_queue[1]=="" && $suc_queue[2]==""){
?>
<div class="nothing">
No Suggestions yet! Participate more to tell us your choices,
</div>
<?
}
else {
for($i=0; $i<sizeof($suc_queue); $i++){
?>
<div class="aclass">
<div class="aclass_hold">
<?php
$img = fetchData("class_information", "image", "classid", $suc_queue[$i]); 
if($img!=''){
	echo "<a href='main_class.php?classid=".$suc_queue[$i]."'><img style='cursor:pointer;' src='classimages/".$img."' width='160' height='80'></a>";
} else {
	echo "<img src='classimages/default.jpg' width='160' height='80'>";
}
?>
</div>
<div class="aclass_descr">
<a href="main_class.php?classid=<? echo $suc_queue[$i]; ?>">
<p class="ctitle"><?php echo fetchData("class_information", "classname", "classid", $suc_queue[$i]); ?></p>
</a>
<div class="space8"></div>
<?php
$descr = fetchData("class_descr", "desc", "classid", $suc_queue[$i]);

if($descr!=''){
	echo $desc;
} else {
	echo '<div class="nothing">&nbsp;</div>';
}
?>
</div>
<div class="clear"></div>
</div>
<?php } 
}?>
</div>
<? }//ending if ?>

<!--<button onclick="$.prompt(tourStates, { opacity: 0.3 });" title="Example 19">Click</button>-->

</div>
</div>


<?php

include('html_bottom.php'); //including the bottom footer

?>