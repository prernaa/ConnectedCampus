<?php
//Start session and connect to DB
session_start();
include("dbconnect.php");
?>
<style type="text/css">
body{
	margin:0;
	padding:0;
	background:#f7f7f7;
}
#iheader{
	min-height:27px;
	border-bottom:1px solid #B7B7B7;
	background:#F7F7F7;
}	
</style>
<body>
	<!-- header START -->
	
	<!-- header END -->
<style type="text/css">
#index_container{
	background:#f7f7f7;
	padding: 1px 0px 1px 0px;
	min-height:610px;

}

#i_container{
	max-width:1002px;
	margin:0 auto;
	margin-top:10px;
	min-height:590px;
}

.head{
font-family: 'Century Gothic', serif;
	color:#aaaaaa;
	font-size:20px;
}
.descr{
	font-family: 'Century Gothic', serif;
	font-size:14px;
	color:#dadada;
}
.ibox{
	padding: 10px;
	background:#ffffff;
	width:977px;
	height:180px;
	margin-bottom:20px;
}
.ibox_descr{
	font-family: 'Century Gothic', serif;
	width:548px;
	padding-left:5px;
	color:#a0a0a0;
	float:left;
	padding-right:20px;
	border-right: 1px dashed #dadada;
}
.ibox_login{
	padding-left:20px;
	float:left;
	font-family: 'Century Gothic', serif;
	color:#a0a0a0;
	margin-bottom: 15px;
}
.iinput{
	font-family: 'Century Gothic', serif;
	color: #a0a0a0;
	border: 1px solid #dadada;
	padding: 2px;
	margin-top:5px;
	width: 185px;
}
.ccbutton{
	font-family: 'Century Gothic', sans-serif;
	background:#ffffff;
	border: 1px solid #dadada;
	outline:none;
}
</style>
<!-- Include jquery and javascript function for sending Message using AJAX -->
<script src="http://baijs.nl/tinyscrollbar/js/jquery.tinyscrollbar.min.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type='text/javascript'>
var xmlHttp;
$(document).ready(function() {
$('#scrollbar1').tinyscrollbar();
});
function sendMessage()
{ 

xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request");
 return;
 }
var msg=document.msgfrm.sndmsg.value;
var sid=document.msgfrm.sid.value;
var rid=document.msgfrm.rid.value;
var url="messagehander.php";

url=url+"?msg="+msg;
url=url+"&sid="+sid;
url=url+"&rid="+rid;
url=url+"&did="+Math.random();

xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
 document.getElementById('response').innerHTML=xmlHttp.responseText;
 } 
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
</script>


<?php
//If viewing inbox
if(isset($_GET['all']))
{
?>
<style>
body{
	background-color:#FFFFFF;
	margin: 0;
}
#result {
	height:20px;
	font-size:16px;
	font-family:Arial, Helvetica, sans-serif;
	color:#333;
	padding:5px;
	margin-bottom:10px;
	background-color:#FFFF99;
}
#country{
}
.suggestionsBox {
	position: absolute;
	left: 85px;
	top:15px;
	margin: 26px 0px 0px 0px;
	width: 200px;
	padding:0px;
	background-color: #000;
	border-top: 3px solid #000;
	color: #fff;
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
ul {
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#FFF;
	padding:0;
	margin:0;
}

.load{
background-image:url(loader.gif);
background-position:right;
background-repeat:no-repeat;
}

#suggest {
	position:relative;
}
.msg_container{
	background:#FAFAFA;
	margin-left:35px;
	width:485px;
	min-height:320px;
	padding:10px;
}
.msg_box{
	font-family: 'Century Gothic', sans-serif;
	background:#FFFFFF;
	width:465px;
	padding:10px;
	font-size:15px;
}
.msg_box2{
	font-family: 'Century Gothic', sans-serif;
	background:#FFFFFF;
	width:465px;
	padding:10px;
	padding-bottom:0px;
	font-size:12px;
	margin-top:10px;
}
.msg_input{
	border: 1px solid #dadada;
	padding: 2px;
	width: 355px;
}
.ccbutton{
	font-size:12px;
	font-family: 'Century Gothic', sans-serif;
	background:#ffffff;
	border: 1px solid #dadada;
	outline:none;
}
.msg_name{
	font-size:15px;
}
.msg_date{
	color:#bababa;
	font-size:11px;
}
.msg_text{
	padding-left:10px;
}
a:link {
	text-decoration: none;
	color:rgb(112,146,190);
}
a:hover {
	text-decoration: none;
	color:rgb(208,219,234);
}
a:visited {
	text-decoration: none;
	color:rgb(47,70,102);
}
</style>
<div class="msg_container">
<div class="msg_box">
<a href="#">Messages</a>  
</div>
<?
//Select own id and Loop through all messages where Reciever is Me.
$myid=$user_data['userid'];
$f=mysql_query("SELECT DISTINCT SenderID FROM user_message WHERE UserID= '$myid' ORDER BY Time DESC");
echo "<table>";
while($row=mysql_fetch_array($f))
{
//Get Sender Information and get Message Information
$ssid=$row['SenderID'];
$ks=mysql_query("SELECT * FROM user_message WHERE SenderID='$ssid' AND UserID= '$myid' ORDER BY TIME DESC");
$query=mysql_fetch_array($ks);
$std=mysql_query("SELECT * FROM user_information WHERE userid='$ssid'");
$std=mysql_fetch_array($std);
//Display information
?><div class="msg_box2">
<form id="form" action="#" name="form">
<div id="suggest"> <span class="msg_name"><? echo $std['name']; ?></span> <span class="msg_date"><? echo $query['Time']; ?></span>
<div style="height:8px"></div>
<div class="msg_text"><? echo $query['Message'];?></div>
</div>
<div style="height:3px"></div>
<div style="padding-left:430px"><a href='viewmessage.php?id=<? echo $query['ID']; ?>#msg_box_replyf'>Reply</a></div>
<div style="height:5px"></div>
</form>
</div>
<?  
}
//End code execution
exit();
}
//If Viewing individual Message
if(isset($_GET['id']))
{
?>
<style>
body{
	background-color:#FFFFFF;
	margin: 0;
}
#result {
	height:20px;
	font-size:16px;
	font-family:Arial, Helvetica, sans-serif;
	color:#333;
	padding:5px;
	margin-bottom:10px;
	background-color:#FFFF99;
}
#country{
}
.suggestionsBox {
	position: absolute;
	left: 85px;
	top:15px;
	margin: 26px 0px 0px 0px;
	width: 200px;
	padding:0px;
	background-color: #000;
	border-top: 3px solid #000;
	color: #fff;
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
ul {
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#FFF;
	padding:0;
	margin:0;
}

.load{
background-image:url(loader.gif);
background-position:right;
background-repeat:no-repeat;
}

#suggest {
	position:relative;
}
.msg_container{
	background:#FAFAFA;
	margin-left:35px;
	width:485px;
	min-height:320px;
	padding:10px;
}
.msg_box{
	font-family: 'Century Gothic', sans-serif;
	background:#FFFFFF;
	width:465px;
	padding:10px;
	font-size:15px;
}
.msg_box2{
	font-family: 'Century Gothic', sans-serif;
	background:#FFFFFF;
	width:465px;
	padding:10px;
	padding-bottom:0px;
	font-size:12px;
}
.msg_box3{
	font-family: 'Century Gothic', sans-serif;
	background:#FCFCFC;
	width:465px;
	padding:10px;
	padding-bottom:0px;
	font-size:12px;
	margin-top:10px;
}
.msg_box_re{
	font-family: 'Century Gothic', sans-serif;
	background:#FFFFFF;
	width:435px;
	padding:10px;
	padding-bottom:0px;
	padding-left:40px;
	font-size:12px;
}
.msg_box_replyf{
	font-family: 'Century Gothic', sans-serif;
	background:#FFFFFF;
	width:465px;
	padding:10px;
	padding-bottom:0px;
	margin-top:10px;
	font-size:12px;
}
.msg_input{
	border: 1px solid #dadada;
	padding: 2px;
	width: 365px;
	font-size:12px;
	font-family: 'Century Gothic', sans-serif;
}
.ccbutton{
	font-size:12px;
	font-family: 'Century Gothic', sans-serif;
	background:#ffffff;
	border: 1px solid #dadada;
	outline:none;
}
.msg_name{
	font-size:15px;
}
.msg_date{
	color:#bababa;
	font-size:11px;
}
.msg_text{
	padding-left:10px;
}
a:link {
	text-decoration: none;
	color:rgb(112,146,190);
}
a:hover {
	text-decoration: none;
	color:rgb(208,219,234);
}
a:visited {
	text-decoration: none;
	color:rgb(47,70,102);
}
.form{
	margin:0;
}
.fsep{
border:0;
border-bottom: 1px dashed #dadada;	
margin-top:10px;
margin-bottom:0px;
padding:0;
}
</style>
<?
//Get Message ID
$mid=$_GET['id'];
$q=mysql_query("SELECT * FROM user_message WHERE ID = '$mid'");
//Get Message Data from DB using Message ID
$q=mysql_fetch_array($q);
$rid=$q['UserID'];
$sid=$q['SenderID'];
//Get Sender and Reciever Information
$rt=mysql_query("SELECT * FROM user_information WHERE userid='$rid'");
$vb=mysql_query("SELECT * FROM user_information WHERE userid='$sid'");
$vb=mysql_fetch_array($vb);
$rt=mysql_fetch_array($rt);


if(($_SESSION['email']!=$rt['email']) && ($_SESSION['email']!=$vb['email']))
{
echo "<center>Trying to access something you are not allowed to</center>";
exit;
}
$ssid=$q['SenderID'];
$std=mysql_query("SELECT * FROM user_information WHERE userid='$ssid'");
$std=mysql_fetch_array($std);
$uid=$user_data['userid'];
if($rid==$uid)
{
$u=mysql_query("UPDATE user_message SET ReadID=1 WHERE ID='$mid'");
}
?>
<div class="msg_box">
<a href="viewmessage.php?all=set">Messages</a> - <? echo $std['name']; ?> 
</div>
<div class="msg_box3">

<div id="suggest"> <span class="msg_name"><? echo $std['name']; ?></span> <span class="msg_date"><? echo $q['time']; ?></span>
<div style="height:8px"></div>
<div class="msg_text"><? echo $q['Message']; ?></div>
</div>
<hr class="fsep" />
<div style="height:3px"></div>
</div>
<?

//echo "<center><h3>Messages</h3></center><br>";
$check=mysql_query("SELECT * FROM user_message WHERE (UserID='$rid' AND SenderID='$ssid') OR (SenderID='$rid' AND UserID='$ssid') ORDER BY Time ASC");
if(mysql_num_rows($check))
{
?>
<div class="msg_container">
<?
while($row=mysql_fetch_array($check))
{
$ssd=$row['SenderID'];
$sstd=mysql_query("SELECT * FROM user_information WHERE userid='$ssd'");
$sstd=mysql_fetch_array($sstd);
$xrid=$row['UserID'];
$xrt=mysql_query("SELECT * FROM user_information WHERE userid='$xrid'");
$xrt=mysql_fetch_array($xrt);
?>


<?if($sstd['name']==$user_data['name'])
{
echo "<div style='font-weight:bold;'>";
}
?>

<div class="msg_box_re" >

<form id="form" class="form" action="#" name="form">
<div id="suggest"> <span class="msg_name"><? echo $sstd['name']; ?></span> <span class="msg_date"><? echo $row['Time']; ?> </span>
<div style="height:8px"></div>
<div class="msg_text"><? echo $row['Message']; ?></div>
</div>
<div style="height:10px"></div>
</form>
</div>
<?if($sstd['name']==$user_data['name'])
{
echo "</div>";
}
?>

<?
/*if($sstd['name']==$user_data['name'])
{
echo "<div style='background:#D1D1D1;text-align:right;'>";
}
else
{
echo "<div style='background:#BFDFFF;'>";
}
echo "From: ".$sstd['name']."<br>".$row['Message']." on ".$row['Time']."<br><br></div>";*/
}
}

?>
</div>
<div class="msg_box_replyf">

<form name='msgfrm'>
<div id="suggest"> <span class="msg_name">Reply</span> 
<input style="margin-left:3px" class="msg_input" type="text"  name='sndmsg' onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"/>
<input type='button' name='submit' onclick='sendMessage()' class="ccbutton" value='Send'><input type='hidden' value='<? echo $ssid; ?>' name='rid'><input type='hidden' value='<? echo $rid; ?>' name='sid'>
<div style="height:10px"></div>
</form>
</div>
<?

echo "<div id='response'></div>";
}
else
{
echo "<center>Trying to access something you are not allowed to</center>";
exit;
}
?>

