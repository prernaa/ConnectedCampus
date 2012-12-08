<?php
//Start session and connect to DB
session_start();
include("dbconnect.php");
?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<?php
//If ID sent through GET, add name, directly
if(isset($_GET['touser']))
{
$g=mysql_query("SELECT * FROM user_information WHERE userid='".(int)$_GET['touser']."'");
$g=mysql_fetch_array($g);
$flag=1;
$name=$g['name'];
}
?>
<!-- AJAX Script -->
<script type='text/javascript'>
var xmlHttp;
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
var name=document.form.country.value;
var url="messagehander.php";

url=url+"?msg="+msg;
url=url+"&sid="+sid;
url=url+"&name="+name;
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
<!-- Name Suggestion Script -->
<script type='text/javascript'>
function suggest(inputString){
        if(inputString.length == 0) {
            $('#suggestions').fadeOut();
        } else {
        $('#country').addClass('load');
            $.post("suggestmsg.php", {queryString: ""+inputString+""}, function(data){
                if(data.length >0) {
                    $('#suggestions').fadeIn();
                    $('#suggestionsList').html(data);
                    $('#country').removeClass('load');
                }
            });
        }
    }
 
    function fill(thisValue) {
        $('#country').val(thisValue);
        setTimeout("$('#suggestions').fadeOut();", 600);
    }
</script>
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
</style>
<div class="msg_container">
<div class="msg_box">
Send Message
</div>
<div class="msg_box2">
<form id="form" action="#" name="form">
<div id="suggest">Receipent: <span>	&nbsp&nbsp&nbsp </span>
 <input class="msg_input" id="country" onkeyup="suggest(this.value);" type="text" name="country" <?php if($flag==1){echo "value='".$name."'";}?>  onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"/>
<div id="suggestions" class="suggestionsBox" style="display: none;">
 <img style="position: relative; top: -12px; left: 30px;" src="arrow.png" alt="upArrow" />
<div id="suggestionsList" class="suggestionList"></div>
</div>
</div>
</form>

<form name='msgfrm'>
Message: <span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><input style="margin-left:2px" type='text' class="msg_input" name='sndmsg'>
<div style="height:8px"></div>
<div style="padding-left:385px">
<input type='button'  onclick='sendMessage()' name='submit' class="ccbutton" value='Send'>
</div>
<?
echo "<input type='hidden' value='".$user_data['userid']."' name='sid'>";
?>
</form>
<div id='response'></div>
</div>
</div>
