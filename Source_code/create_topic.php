<?php			/////////////// Create_Topic ///////////////////////////
$auth=1;
include('includes.php');

if(isset($_GET['classid'])){
$classID=$_GET['classid'];
}
else{
	$classID=0;
}


$logmail=$_SESSION['email'];	//E-mail of current user logged in
$logid=getID($logmail); 	//ID of logged in user returned by function, given email as parameter

if($classID!=0){
	$tchrID=mysql_fetch_array(mysql_query("SELECT userid FROM class_teacher WHERE classid=$classID"));//ID of Instructor
	if(($tchrID[0]!=$logid) && (getNum2("class_subscribed", "classid", $_GET['classid'], "userid", getID($_SESSION['email']))!=1)){
		header('Location: http://connectedcampus.org/userhome.php');
	}
}

			/////////////////// Checking if a Teacher Has Left the Classroom ////////////

function tchrleft($t, $c){
	$query=mysql_query("SELECT * FROM class_tchrleave WHERE classid=".$c." AND userid=".$t);
	if(mysql_num_rows($query)==0){
		return 0;
	}
	else {
		return 1;
	}
}

			///////////////////// Checking if a Student Still Belongs to a Class /////////////////////

function checkstudent($l, $c){
	$q=mysql_query("SELECT * FROM class_subscribed WHERE userid=".$l." AND classid=".$c);
	return mysql_num_rows($q);
	//if(mysql_num_rows($q)!=1) return 0;
	//else return 1; //1-->is a student
}
$classid=$classID;
include('html_top.php');?>




<style type="text/css">
.suggestionsBox {
	position: absolute;
top: 150px;

	margin: 26px 0px 0px 0px;
	width: 200px;
padding: 0px;
background-color: #C8C8D0;
border-top: #C8C8D0;
color: #000;
font-size: small;
}
.suggestionList {
	margin: 0px;
	padding: 0px;
}
.suggestionList ul li {
	list-style:none;
	margin: 0px;
	padding: 6px;
	border-bottom:1px dotted #666;
	cursor: pointer;
}
.suggestionList ul li:hover {
	background-color: #FC3;
	color:#000;
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
	width:540px;
}
.w_rightsub{
float:right;
font-size:12px;
}
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
#event_contentbox{
margin-top:-5px;
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
	width:515px;
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
padding-top:8px;
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
.winput, .Tags{
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


<script type="text/javascript">
				////////////////// Popup ///////////////////////

function popup(url) {
	newwindow=window.open(url,'name','height=600,width=830, scrollbar=no');
	if (window.focus) {newwindow.focus()}
	return false;
}
function fetch()
{
$.post('add_topic.php', { alertyn: '1' }, function(output){ $('#activities').html(output).show(); } );
}

				///////////////// Form Validation ///////////////////

function createvalidate()
{
var x=document.forms["newforumtopic"]["Topic"].value;
//var y=document.forms["newforumtopic"]["event_location"].value;
var z=document.forms["newforumtopic"]["Detail"].value;

if (x==null || x=="")
  {
  alert("Topic must be filled out");
  return false;
  }
  
if (z==null || z=="")
  {
  alert("Please fill in some detail");
  return false;
  }

 return true;
}
</script>

<?
if($classID!=0){
	include "classheaderfinal.php";
}

$_email=$_SESSION['email'];

?>

			<!--  ////////////////// Creating a New Topic ///////////////// -->

<form action="add_topic.php" method="get" name="newforumtopic" onsubmit="return createvalidate()" />
<div class="pblog_pm">
<p>CREATE NEW TOPIC</p>

<div style="height:10px;"></div>
<div class="w_list">
TOPIC<br/>

<div style="height:6px;"></div>
TAGS<br />
<span style="font-size:10px;">(separated <br/>by commas)</span>
<br/>

<div style="height:10px;"></div>
DESCRIPTION
</div>
<div class="w_boxes">

			<!-- ///////////////////// Inputting Topic ///////////////////// -->
<input class="winput" type="text" id="Topic" name="Topic" style="margin-top:5px" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"><br/>

			<!-- ///////////////////// Inputting Tags ///////////////////// -->
<input autocomplete="off" onkeyup="suggest(this.value);" id="Tags" class="Tags" type="text" name="Tags" style="margin-top:5px" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"><div id="suggestions" class="suggestionsBox" style="display: none;"> 
 <!--img style="position: relative; top: -12px; left: 30px;" src="arrow.png" alt="upArrow" />
<div id="suggestionsList" class="suggestionList"></div-->
</div><br/>

			<!-- ///////////////////// Inputting Description ///////////////////// -->
<textarea class="warea" style="margin-top:5px" name="Detail" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></textarea><br/>
<div style="height:5px;"></div>
<input style="cursor:pointer;" type="submit" name="createtopic" value="Create Now" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>
<a href="main_forum.php" ><input style="cursor:pointer;" type="button" name="goback" value="Cancel" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/></a>
<input style="cursor:pointer;"  onclick="popup('formulae.html')" type="button" name="comment" value="Add Formula" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'" />
</div>
<input name="Email" type="hidden" id="Email" value="<?php echo $_email; ?>" />
<input name="classid" type="hidden" id="classid" value="<? echo $classID; ?>" />
</div>
</form>

<?php
include('html_bottom.php');
?>














































<!--		OLD STUFF
<table class="tableresource" width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
<tr>
<form id="form1" name="form1" method="get" action="add_topic.php">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td colspan="3" bgcolor="#E6E6E6"><strong>Create New Topic</strong> </td>
</tr>
<tr>
<td width="14%"><strong>Topic</strong></td>
<td width="2%">:</td>
<td width="100%"><input name="Topic" type="text" id="Topic" size="65" /></td>
</tr>
<tr>
<td width="14%"><strong>Tags</strong></td>
<td width="2%">:</td>
<td width="100%"><input name="Tags" type="text" id="Topic" size="65" /></td>
</tr>
<tr>
<td valign="top"><strong>Detail</strong></td>
<td valign="top">:</td>
<td><textarea name="Detail" cols="50" rows="6" id="Detail"></textarea></td>
</tr>
<!--<tr>
<td><strong>Name</strong></td>
<td>:</td>
<td><input name="Name" type="text" id="Name" size="50" /></td>
</tr>
<tr>
<td><strong>Email</strong></td>
<td>:</td>--><!--
<td><input name="Email" type="hidden" id="Email" value="<?php echo $_email; ?>" />
<input name="classid" type="hidden" id="classid" value="<? echo $classID; ?>" /></td>

<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Submit" /> <input type="reset" name="Submit2" value="Reset" /><a class='iframe' href='formulae.html' style='text-decoration: none;cursor:pointer;'><input type="button" name="Add Formula" value="Add Formula"/></a></td>
</tr>
</table>
</td>
</form>
</tr>
</table>
-->