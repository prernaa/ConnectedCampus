<style type="text/css">
html { 
overflow: scroll; 
} 
body {overflow:scroll;}
.ccbutton2{
	font-family: 'Century Gothic', sans-serif;
	background:#ffffff;
	border: 1px solid #dadada;
	outline:none;
	cursor:pointer;
	font-size:12px;
	font-weight:bold;
	padding:3px;
}
.tooltip { position:relative; z-index:24; }

.tooltip span { display:none;}

.tooltip:hover {z-index:25;}

.tooltip:hover span {
	display:block;
	position:absolute;
	width:120px;
	top:25px;
	left:20px;
	background-color:#ffffff;
	border:1px solid #3b5998;
	padding:5px;
	font-size:9px;
	color:#3b5998;
	text-decoration:none;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
.winput{
	border: 1px solid #dadada;
	padding: 2px;
	margin-top:5px;
	width: 150px;
	float:left;
	position:relative;
	bottom:5px;
}
</style>
<?php
$auth=1; //user must be logged in to view this page 
include('includes.php'); //including "includes" file which connects to the database.
if(!isset($_GET['groupid'])|| getNum("collwb_info", "GroupID", $_GET['groupid'])!=1){ // Check Get
header('Location: http://connectedcampus.org/userHome.php'); //If groudid is not sent as GET or is wrong then redirect to error page
}
include('wbtop.php'); //including the jQuery files, etc i.e. everything in html_top except the left & top bar
$logmail=$_SESSION['email'];//E-mail of current user logged in
$logname=getName($logmail); //Name of user logged in user returned by function, given email as parameter
$logid=getID($logmail); //ID of logged in user returned by function, given email as parameter
$groupid=$_GET['groupid'];
//Making logged in user active in table collwb_groupmembers
$sql="UPDATE collwb_groupmembers SET Activity=1 where GroupID=$groupid AND userid=$logid";
mysql_query($sql);
$sql2="SELECT * FROM collwb_event WHERE GroupID=$groupid AND Activewb=1";
if(mysql_num_rows(mysql_query($sql2))==0) {
	mysql_query("INSERT INTO collwb_event (GroupID, Activewb) VALUES('".$groupid."', 1)"); //if the group is being used for the first time, a new row is inserted to store the coordinates of the new active whiteboard
}
$currenttime=date("Y-m-d G:i:s", time());
$sql3="UPDATE collwb_groupmembers SET LastUserActivity='".$currenttime."' where GroupID=$groupid AND userid=$logid"; //updates the user's latest activity
mysql_query($sql3);
?>
<? $sql="SELECT eventarray FROM collwb_event WHERE GroupID=$groupid AND Activewb=1"; //get the array of coordinates of the current active whiteboard
$eventgetold=mysql_fetch_array(mysql_query($sql));  ?>
<link rel="stylesheet" href="wbstylesheet.css" type="text/css"/><!-- WB stylesheet -->
<div id="wbcontent">
<div id="groupinfoheader">
<? $groupinfo=mysql_fetch_array(mysql_query("SELECT * FROM collwb_info WHERE GroupID=".$groupid)); //fetches information about the whiteboard group
$admin=mysql_fetch_array(mysql_query("SELECT * FROM collwb_groupadmin WHERE GroupID=".$groupid)); //fetches information about the creator of that whiteboard group?>
<div class="pblog_pm">
<div class="nothing">
<? echo "<strong>".$groupinfo['Groupname']."</strong>";?>
&nbsp;&nbsp;<? if($groupinfo['Privacy']==0||$logid==$admin['userid']){?><a class="iframe" href="invite_popup.php?action=wb&wbid=<? echo $groupid."&classid=".$groupinfo['classid']; ?>">INVITE</a><? } ?><br/>
<? echo $groupinfo['GroupDesc']; ?>
</div>
</div>
<br/>
<input type="hidden" id="grpid" value="<? echo $groupid; ?>" /><input type="hidden" id="loginid" value="<? echo $logid; ?>" />
</div>

<br/>
<div id="viewmode">
<div style="clear:both"></div>
<div id="viewcanvas"><!--view canvas inserted here by jQuery script--></div>
<div id="viewright"><!--active member list inserted here by jQuery script--></div>
<div style="clear:both"></div>
<div id="viewtools"><!--view options inserted here by jQuery script--></div>
</div>
<div id="writemode">
<div style="clear:both"></div>
<div id="writecanvas">
<!--write canvas inserted here by jQuery script-->
</div>
<div id="writeright"><!--active member inserted here by jQuery script--></div>
<div style="clear:both"></div>
<div id="writetools">
<!-- all write tools provided here-->
<div style="width:800px; text-align:center;">
<table style="padding-top:20px;">
<tr>
<td style=" padding-bottom:5px;">
<div id="loaddiv" style="float:left;">
<!--LOAD list inserted here by jQuery script -->
</div>
<div id="LDbuttondiv" style="float:left;">
<!--option to load the whiteboard selected in the LOAD LIST-->
<a href="#" class="tooltip"><span>Load selected whiteboard</span><img src="img/load.png" width="20" height="20" style="cursor:pointer;" id="loadbutton" /></a>
<!--option to delete the whiteboard selected in the LOAD LIST-->
<a href="#" class="tooltip"><span>Delete selected whiteboard</span><img src="img/delete.png" width="16" height="16" style="cursor:pointer;" id="deletebutton" /></a>
</div>
</td>
<td style="padding-left:40px;">
<div id="savediv" style="float:left;">
<!--option to save a new whiteboard -->
    <input type="text" class="winput" id="newwbname" value="" placeholder="Whiteboard Name" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"/>
    <a href="#" class="tooltip"><span>Name &amp; save whiteboard</span><img src="img/savewb.png" width="20" height="20" style="cursor:pointer; float:left;" id="savebutton" /></a>
</div>
</td>
<td style="padding-left:40px; padding-bottom:5px;">
<div id="createnewdiv" style="float:left;">
    <a href="#" class="tooltip"><span>Create new whiteboard</span><img src="img/newwb.png" width="20" height="20" style="cursor:pointer; float:left;" id="createnewbutton" /></a>
</div>
</td>
</tr>
</table>
</div>
<div id="timetemp" style="float:left;"></div>
<div id="tempdiv" style="float:left;"></div>
<div id="msgondel" style="float:left;"></div>
<div id="msgtousr" style="float:left;"></div>
</div>
</div> <!--writemode closed -->
</div> <!--wbcontent closed -->
<div id="switchdiv" style="float:left;"></div>
<div style="clear:both;"></div>
<div id="makeactive">
</div>
<div style="clear:both;"></div>
<br/>
<div id="chatbox" style="float:left;"><!--CHAT inserted by jQuery script here--></div>
<div id="formchat" style="float:right">
<!--display form to send chat messages-->
<form action="" name="message">
<textarea id="usermsg" name="urtext" cols="35" rows="5">
</textarea><br/>
<input class="ccbutton2" id="submitmsg" type="submit" name="chattext" value="Send" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'">
</form>
</div>
<div style="clear:both;"></div>

<script type="application/javascript" src="collwbworking.js"></script><!--jQuery script for whiteboard working-->
<script type="application/javascript" src="classwbchatscript.js"></script><!--jQuery script for chat working-->

<?php
include('html_bottom.php'); //including the footer
?>