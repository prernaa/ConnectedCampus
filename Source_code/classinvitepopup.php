<?php
//Start session, connect to Database and store userid
session_start();
include("dbconnect.php");
$uid=$user_data['userid'];
?>
<!-- Include jQuery -->
<script src="http://code.jquery.com/jquery-latest.js"></script>
<!-- Javascript for AJAX Accept/Reject -->
<script type='text/javascript'>
var xmlHttp;
function inviteHandle(a,b)
{ 

xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request");
 return;
 }
 
var url="invitationhandler.php";

url=url+"?cid="+a;
url=url+"&action="+b;
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


<?
//Loop through entries with invites for this user
$q=mysql_query("SELECT * FROM class_invite WHERE rid='$uid'");
while($row=mysql_fetch_array($q))
{
//Get information for sender and class invited
$bm=mysql_query("SELECT * FROM user_information WHERE userid='".$row['sid']."'");
$bm=mysql_fetch_array($bm);
$mn=mysql_query("SELECT * FROM class_information WHERE classid='".$row['cid']."'");
$mn=mysql_fetch_array($mn);
//Form to Accept/Reject
echo "<div id='response'><form name='i'><table><tr><td>".$bm['name']." invited you to join ".$mn['classname']."</td></tr><tr><td><input type='hidden' name='classid' value='".$row['cid']."'><input type='button' onclick='inviteHandle(".$row['cid'].",1)' value='Accept'></td><td><td><input type='button' onclick='inviteHandle(".$row['cid'].",2)' value='Reject' ></tr></table></form>";
echo "</div>";

}

?>

