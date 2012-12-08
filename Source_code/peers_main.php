<?php
// Peers Main page - Used to display common peers
$auth=1; //user must be logged in to view this page 

// Get common functions
include('includes.php');

// Check if user is ok to view this page
if(isset($_GET['userid'])){
if(getNum("user_information", "userid", $_GET['userid'])==0){ // Check Get
		header('Location: http://connectedcampus.org/errorpage.php');
}
}

// Get html
include('html_top.php');

// Get user id and email
$log=$_SESSION['email'];
$logid=getID($log);

if(isset($_GET['userid']))
{
	$user=$_GET['userid']; //Gives logged in user's email address
}
else {
	$user=$logid;
}
$userinfo=mysql_fetch_array(mysql_query("SELECT * FROM user_information where userid=".$user));

// Gets class name
function getclassname($id) {
	$sql="SELECT classname FROM class_information WHERE classid=".$id;
	$result=mysql_fetch_array(mysql_query($sql));
	return $result['classname'];
}

// Gets class image
function getclassimg($id) {
	$sql="SELECT image FROM class_information WHERE classid=".$id;
	$result=mysql_fetch_array(mysql_query($sql));
	return $result['image'];
}

// Used to check mutual friends
function checkifmutual($id, $visitor) { //if the visitor is either instructor/learner of classroom id, then returns 1
	$query=mysql_query("SELECT * FROM class_subscribed WHERE classid=".$id." AND userid=".$visitor);
	$query2=mysql_query("SELECT * FROM class_teacher WHERE classid=".$id." AND userid=".$visitor);
	if(((mysql_num_rows($query) || mysql_num_rows($query2)))>0)
		return 1;
	else
		return 0;
}
//generating array of mutual classrooms
function mutualclassgen($usr, $visitor){
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
function checkifmutualpeer($peerid, $visitor) { //if the visitor is either instructor/learner of classroom id, then returns 1
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
	return $mutualpeerarr;
}

?>
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
<?php
require("profile_header.php");
?>

<style type="text/css">
#class_contentbox{
margin-top:20px;
}
#cblog_wrap{
width:510px;
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
.psblog_pm{
width:500px;
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
.psimg_hold{
padding-left:20px;
padding-top:10px;
padding-bottom:10px;
}
.aboutme{
padding-left:40px;
padding-top:10px;
padding-bottom:10px;
font-size:12px;
}
.ps_right{
float:left;
width:190px;
margin-left:25px;
}
.ps_righthold{
width:170px;
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

.ps_righthold2{
width:180px;
background:#ffffff;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;

padding-bottom:10px;
float:left;
font-size:18px;
font-family: 'Century Gothic', sans-serif;

}

.psearch{
	border: 1px solid #dadada;
	padding: 2px;
	width: 105px;
}
.peer_pic_holder{
	text-align:center;
	font-size:11px;
	max-width: 80px;
	float:left;
	margin-right: 3px;
	border: 1px dashed #dadada;	
	height: 115px;
	max-height: 115px;
	margin-bottom: 10px;
}

.txt_hold{
	margin-top:2px;
}

.pbtn_hold{
	margin-top:-25px;
	margin-left:60px;
}
</style>
<div id="class_contentbox">
<div id="cblog_wrap">

<div class="psblog_pm">
PEERS
<hr class="psep" />
<div class="psimg_hold">

<?php
$sql = mysql_query("SELECT * FROM friends WHERE userid = '".$user."'");

// Iterate through database to fetch profile picture
while($peer=mysql_fetch_array($sql)){

?>
<div class="peer_pic_holder"><a href="profile_main.php?userid=<? echo $peer["friendid"]; ?>"><img src="<?php 
if(getPic($peer["friendid"])==""){
	// get default pic if null
	echo "img/defpic.png";
} else{
	echo getPic($peer["friendid"]);
} ?>" height="80" width="80"/>
<div class="txt_hold"><?php echo getNamewID($peer["friendid"]);?></div></a>
</div>
<?php 
}
?>
</div>
</div>


<? if($user!=$logid){  
$tryarr2=mutualpeergen($user, $logid); 
$mutualpeernum=count($tryarr2);?>
<div class="psblog_pm">
MUTUAL PEERS
<hr class="psep" />
<div class="psimg_hold">
<!-- loop starts here -->
<? foreach($tryarr2 as $valueid) { 
		$mutualpic=mysql_fetch_array(mysql_query("SELECT photo FROM user_information WHERE userid=".$valueid));?>
<div class="peer_pic_holder">
<a href="profile_main.php?userid=<? echo $valueid; ?>"><img src="<? if($mutualpic['photo']==""){echo "img/defpic.png";}else{echo $mutualpic['photo'];} ?>" width="80" height="80" class="captify" alt="<? echo getNamewID($valueid); ?>" style="cursor:pointer;"/>
<div class="txt_hold"><?php echo getNamewID($valueid);?></div></a>
</div>
<? } ?>
<!-- loop ends here-->
</div>
</div>
<? }//ending if ?>

</div>
</div>
<?php
// Check if get is null and check if the user is looking at his own profile
if(!isset($_GET['userid']) || $_GET['userid'] == $logid){
?>
<div class="ps_right">
<div class="ps_righthold">
PEERS SUGGESTIONS
<div class="space8"></div>
<div class="pimg_hold">

<?php

// Peer Suggestion Script

// Get user class
$sql = mysql_query("SELECT * FROM class_subscribed WHERE userid = '".$user."'");
$class = array();
while($cs=mysql_fetch_array($sql)){
$class[] = $cs['classid'];
}
// Get user friends
$sql = mysql_query("SELECT * FROM friends WHERE userid = '".$user."'");
$mfriends = array();
while($fd=mysql_fetch_array($sql)){
$mfriends[] = $fd['friendid'];
}
//Get user school
$inSame = fetchData('user_information', 'university', 'userid', $user);

// Search db for suitable user
$sql = mysql_query("SELECT * FROM user_information");
while($fs = mysql_fetch_array($sql)){
// check if same user
if($fs['userid']==$user){
continue;
}
// check if request sent
//Get Num	
if(fetchData2("friends_request", "status", "userid", $fs['userid'], "friendid", $user)==1){
	continue;
}
if(fetchData2("friends_request", "status", "userid", $user, "friendid", $fs['userid'])==1){
	continue;
}

//Number of same classes
$num_class = 0;
for($i=0; $i<sizeof($class); ++$i){
$num_class += getNum2("class_subscribed", "userid", $fs['userid'], "classid", $class[$i]);
}
//Number of same friends
$num_friends = 0;
for($i=0; $i<sizeof($mfriends); ++$i){
$num_class += getNum2("friends", "userid", $fs['userid'], "friendid", $mfriends[$i]);
}
//Check if same school
$fschool = fetchData("user_information", "university", "userid", $fs['userid']);
if($inSame==$fschool && $fschool!=""){
$cschool = 3;
} else {
$cschool = 2;
}
// $num_class    - number of same classes
// $num_friends  - number of same friends
// $cschool      - constant for if the person if in the same school or not

// Friend algo settings
$rslt = ((pow(4, $num_class ))*(pow(2, $num_friends)))*$cschool-2; // algo
$limit = 45;
$limit2 = 10;
$prob = 80;
$prob2=90;
$maxsize = 9;
$waitlist = array();
$cfmlist = array();

if($rslt >= $limit){

} else {
$prob = $prob*($rslt/$limit);
}
if($rslt >= $limit2){
} else {
$prob2 = $prob2*($rslt/$limit2);
}
// Generate random number
$rand = rand(1,100);

if($rand<$prob&&getNum2("friends", "userid", $user, "friendid", $fs['userid'])!=1){
$cfmlist[] = $fs['userid'];
} else {
if($rand<$prob2&&getNum2("friends", "userid", $user, "friendid", $fs['userid'])!=1){
$waitlist[] = $fs['userid'];
}
}

// Check if cfmlist overloads
if(sizeof($cfmlist)==$maxsize){
break;
}
}

if(sizeof($cfmlist)<$maxsize){
shuffle($waitlist);
for($i=0;$i<sizeof($waitlist);++$i){
$cfmlist[] = $waitlist[$i];
if(sizeof($cfmlist==$maxsize)){
break;
}
}
}

// Fill with random school people if < maxsize
if(sizeof($cfmlist)<$maxsize){
$inSame = fetchData('user_information', 'university', 'userid', $user);
$sql = mysql_query("SELECT * FROM user_information");
while($fs = mysql_fetch_array($sql)){
$fschool = fetchData("user_information", "university", "userid", $fs['userid']);
if(fetchData2("friends_request", "status", "userid", $fs['userid'], "friendid", $user)==1){
	continue;
}
if(fetchData2("friends_request", "status", "userid", $user, "friendid", $fs['userid'])==1){
	continue;
}
if($inSame==$fschool&& $fschool!=""&&getNum2("friends", "userid", $user, "friendid", $fs['userid'])!=1){
if($fs['userid']!=$logid){
$cfmlist[] = $fs['userid'];
}
}
if(sizeof($cfmlist)==$maxsize){
break;
}
}
}

for($i=0;$i<sizeof($cfmlist);++$i){
// Start printing picture
?>
<div class="peer_pic_holder"><a href="profile_main.php?userid=<? echo $cfmlist[$i]; ?>"><img src="
<?php 
// Get user profile pic
if(getPic($cfmlist[$i])==""){
	echo "img/defpic.png";
}else{
	echo getPic($cfmlist[$i]);
}
?>
" height="80" width="80" />
<div class="pbtn_hold">
<a style="cursor:pointer" onClick="sent_request('<?php echo getNamewID($cfmlist[$i]); ?>',<?php echo $cfmlist[$i]; ?>)"><img src="img/p_add2.png"/></a>
</div>
<div class="txt_hold"><?php echo getNamewID($cfmlist[$i]);?></div></a>
</div>
<?php
}

if(sizeof($cfmlist) == 0){
echo'<div class="nothing">no suggestions</div>';

}

?>

</div>
</div>

<div class="ps_righthold2">
PEERS REQUESTS
<div class="space8"></div>
<div class="pimg_hold">
<?php
// Iterate through database to check peer requests
$sql = mysql_query("SELECT * FROM friends_request WHERE userid = '".$user."' AND status='0'");
$count = 0;
while($peer=mysql_fetch_array($sql)){
// Check if data is valid
if(fetchData2("friends_request", "status", "userid", $peer['friendid'], "friendid", $user)==1){
$count ++;
// Start printing
?>
<div class="peer_pic_holder"><a href="profile_main.php?userid=<? echo $peer["friendid"]; ?>"><img src="
<?php 
// Prints avatar
if(getPic($peer["friendid"])==""){
	echo "img/defpic.png";
}else{
	echo getPic($peer["friendid"]);
} ?>
" height="80" width="80" />
<div class="pbtn_hold">
<a style="cursor:pointer" onClick="accept_request('<?php echo getNamewID($peer["friendid"]); ?>',<?php echo $peer["friendid"]; ?>)"><img src="img/p_acpt2.png"/></a>
</div>
<div class="txt_hold"><?php echo getNamewID($peer["friendid"]);?></div></a>
</div>
<?php
}
}
if($count==0){
echo '<div class="nothing">
no requests
</div>';
}	
?>
</div>
</div>

<div class="ps_righthold">
REQUESTS SENT
<div class="space8"></div>
<div class="pimg_hold">
<?php
// Iterate through database for vaid data
$sql = mysql_query("SELECT * FROM friends_request WHERE userid = '".$user."' AND status='1'");
$count = 0;	// Counter
while($peer=mysql_fetch_array($sql)){
// Checks if data is valid
if(fetchData2("friends_request", "status", "userid", $peer['friendid'], "friendid", $user)==0){
$count ++;	// incr counter
?><div class="peer_pic_holder"><a href="profile_main.php?userid=<?php echo $peer['friendid']; ?>"><img src="
		<?php 
	// Gets profile pic
	if(getPic($peer["friendid"])==""){
		echo "img/defpic.png";
	}else{
	echo getPic($peer["friendid"]);
	} ?>" height="80" width="80" />
<div class="txt_hold"><?php echo getNamewID($peer["friendid"]);?></div></a>
</div>

<?php
}
}
if($count==0){
echo '<div class="nothing">
no requests sent
</div>';
}	
?>
</div>
</div>

<div class="ps_righthold2">
PEER FINDER
<div class="space8"></div>
<div class="pbox_hold">

<script type="text/javascript">
/* function used to open a new window when onClick is invoked on the button */
function open_win() 
{
var x = document.getElementById("peerName").value;
myWindow=window.open('peers_popup.php?submit=Search&peerName='+x,'','toolbar=no, width=1320, height=605');
}
</script>
<input class="psearch" id="peerName" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></input>
<input type="submit" name="submit" value="Search" class="ccbutton" 
onClick="open_win()"
onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>

</div>
</div>
</div>
<?php } // end if ?>

<script type="text/javascript">

/* function used to send post data to fsql.php to update database, used when sending a peer request  */
function sent_request(name, id)
{
	$.post('includes/fsql.php', { postID: 'reqPeer' , userid: <?php echo getID($_SESSION['email']); ?> , peerid:id});
	alert("You have sent a request to "+name);
	window.location = ""
}
/* function used to send post data to fsql.php to update database, used when accepting a peer request  */
function accept_request(name, id)
{
	$.post('includes/fsql.php', { postID: 'accPeer' , userid: <?php echo getID($_SESSION['email']); ?> , peerid:id});
	alert("You have accepted "+name+"'s request");
	window.location = ""
}

</script>

<?php

// include bottom html
include('html_bottom.php');

?>
