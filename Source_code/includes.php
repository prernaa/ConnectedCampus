<?php
// Includes.php

// Starting session
session_start();

// Connect database
include("dbconnect.php");

// Authentication check
// auth flags
// 1 - > Redirects if user isnt logged in
// 2 - > Redirect if user is logged in

$logged=0;

if(isset($_SESSION['email'])){
$sql="SELECT * FROM user_information WHERE email = '".$_SESSION['email']."'"; //prevent hijacking
$query=mysql_query($sql);
$logged=1;
}

if($auth==1){ // user has to be logged on
if(($logged!=1)||(mysql_num_rows($query)!=1)){ // user isnt logged in
	header('Location: http://connectedcampus.org/');
}
} else {
if(($logged==1)){ // user is logged in
	header('Location: http://connectedcampus.org/profile_main.php');
}
}

/*Remove when adding the variable $auth is done*/
//FUNCTION FOR CLASS ALERTS
function classalertyn($class, $usr){
$q=mysql_query("SELECT * FROM class_alerts WHERE classid=".$classID." AND userid=".$logid);
if(mysql_num_rows($q)==0)
	return 1;
else {
	$alertval=mysql_fetch_array($q);
	if($alertval['alertyn']==0)
		return 0;
	else
		return 1;
}
}

// Basic Functions
function getName($email){ // Returns name given email
$getQuery = mysql_query("SELECT * FROM user_information WHERE email='".$email."'");
$name = mysql_fetch_array($getQuery);

return $name['name'];
}

function getNamewID($id){ // Returns name given ID
$getQuery = mysql_query("SELECT * FROM user_information WHERE userid='".$id."'");
$name = mysql_fetch_array($getQuery);

return $name['name'];
}

function getID($email){ // Returns name given email
$getQuery = mysql_query("SELECT * FROM user_information WHERE email='".$email."'");
$name = mysql_fetch_array($getQuery);

return $name['userid'];
}

function getEmail($id){ // Returns email given ID
$getQuery = mysql_query("SELECT * FROM user_information WHERE userid='".$id."'");
$name = mysql_fetch_array($getQuery);

return $name['email'];
}

function getPic($id){ // Returns avatar given ID
$getQuery = mysql_query("SELECT * FROM user_information WHERE userid='".$id."'");
$name = mysql_fetch_array($getQuery);

return $name['photo'];
}

function fetchData($table, $col, $colrq, $colrqcrit){ // Fetches data
$query = mysql_query("SELECT * FROM ".$table." WHERE ".$colrq."='".$colrqcrit."'");
$data = mysql_fetch_array($query);
return $data[$col];
}
function fetchData2($table, $col, $colrq, $colrqcrit, $colrq2, $colrq2crit){ // Fetches data
$query = mysql_query("SELECT * FROM ".$table." WHERE ".$colrq."='".$colrqcrit."' AND ".$colrq2."='".$colrq2crit."'");
$data = mysql_fetch_array($query);
return $data[$col];
}

function fetchDataL($table, $col){ // Lite Version of fetchData
$query = mysql_query("SELECT * FROM ".$table."");
$data = mysql_fetch_array($query);
return $data[$col];
}

function getNum($table, $col, $colcrit){   // Gets number of rows
$query = mysql_query("SELECT * FROM ".$table." WHERE ".$col."='".$colcrit."'");
return mysql_num_rows($query);
}
function getNum2($table, $col, $colcrit, $col2, $colcrit2){   // Gets number of rows
$query = mysql_query("SELECT * FROM ".$table." WHERE ".$col."='".$colcrit."' AND  ".$col2."='".$colcrit2."'");
return mysql_num_rows($query);
}
function updateDB($table, $col, $data, $colrq, $colrqcrit){
$query = mysql_query("UPDATE ".$table." SET ".$col."='".$data."' WHERE ".$colrq."='".$colrqcrit."'");
mysql_query($query);
}
function updateDB2($table, $col, $data, $colrq, $colrqcrit, $colrq2, $colrq2crit){
$query = mysql_query("UPDATE ".$table." SET ".$col."='".$data."' WHERE ".$colrq."='".$colrqcrit."' AND ".$colrq2."='".$colrq2crit."'");
mysql_query($query);
}
function deleteRow($table, $col, $colcrit){ // Delete row
$query = mysql_query("DELETE FROM ".$table." WHERE ".$col." = '".$colcrit."' ");
mysql_query($query);
}
//Functions for Whiteboard
function checkMember($idlog, $groupid) { //Function checks if user is member of groupid
	$sql="SELECT * from collwb_groupmembers WHERE GroupID=$groupid AND userid=$idlog";
	if(mysql_num_rows(mysql_query($sql)))
		return 1;
	else
		return 0;
}
function checkAdmin($idlog, $groupid) { //Function checks if user is admin of groupid
	$sql="SELECT * FROM collwb_groupadmin WHERE GroupID=$groupid AND userid=$idlog";
	if(mysql_num_rows(mysql_query($sql)))
		return 1;
	else
		return 0;
}
function checkwbActive($groupid) { //function to check if a groupid has an active wb
	$sql="SELECT * FROM collwb_event WHERE GroupID=$groupid AND Activewb=1";
			if(mysql_num_rows(mysql_query($sql)))
		return 1;
	else
		return 0;

}
// Preset notification types
// AnsChosen(Answer Chosen), AnsLiked(Answer liked), QuesAnsd(Question answered)
function setNotification($type, $userID, $link, $addUserID, $addInfo){ //Notification type, User who received the notifications, url to page, resulting user, additional info(array)
//addInfo = serialize($addInfo);
$query = "INSERT INTO user_notifications VALUES ('', '".$type."','".$userID."','".$link."','".$addUserID."', '1', '".$addInfo."')";
mysql_query($query);
}

function setNotiText($type,$addUserID, $addinfo){
//$addinfo = unserialize($addinfo);
if($type=="AnsLiked"){
echo "".$addUserID." liked your answer on ".$addinfo;
}
if($type=="RComment"){
echo "".$addUserID." commented on a reply in ".$addinfo;
}

if($type=="NewClass"){
echo "".$addUserID." created a new class - ".$addinfo;
}

if($type=="QReply"){
echo "".$addUserID." posted a reply on the topic - ".$addinfo;
}

if($type=="NewTopicL"){
echo "".$addUserID." created a new topic - ".$addinfo;
}

if($type=="Invitee"){
echo "".$addUserID." invited you to - ".$addinfo;
}

if($type=="BComment"){
echo "".$addUserID." commented on the blog - ".$addinfo;
}

if($type=="NewWB"){
echo "".$addUserID." created a new Whiteboard group - ".$addinfo;
}

if($type=="NewPost"){
echo "".$addUserID." posted on - ".$addinfo;
}
if($type=="PeerAccept"){
echo "".$addUserID." accepted your peer request.";
}
if($type=="PeerRequest"){
echo "".$addUserID." sent you a peer request.";
}
}

function inText($text, $spec){ //Checks if word in string, returns word location and length
$text = strtolower($text);
$spec = strtolower($spec);
$len = strlen($text);
$lenSpec = strlen($spec);
$found = 0;

for($i=0; $i<($len-$lenSpec)+1; $i++){
if (substr($text, $i, $lenSpec)==$spec){
$found = 1;
return $i;
break;
}
}

if($found==0){
return -1;
}
}
function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 } 
?>