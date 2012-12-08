<?
$auth=1; //user must be logged in to view this page 
include('includes.php'); //including "includes" file which connects to the database.

if(!isset($_GET['userid'])){ // is userid is not sent via GET variable then redirect to error page
		header('Location: http://connectedcampus.org/errorpage.php');
}
if(!isset($_GET['action'])||($_GET['action']!=1 && $_GET['action']!=2 && $_GET['action']!=3)){
		header('Location: http://connectedcampus.org/errorpage.php'); // is "appropriate" 'action' is not sent via GET variable then redirect to error page
}
if(isset($_GET['userid'])){
if(getNum("user_information", "userid", $_GET['userid'])==0){ // Check Get
		header('Location: http://connectedcampus.org/errorpage.php'); //if userid sent via GET variable is wrong, redirect to errorpage
}
}
$log=$_SESSION['email']; //Gives logged in user's email address
$logid=getID($log); //gives logged in user's userid

$user=$_GET['userid']; //gives userid of the user whose profile is being viewed. This is sent as GET variable
$action=$_GET['action']; //action=1 means "add peer" i.e. send request, action=2 means "accept request", action=3 means "remove peer"

if($_GET['action']==1){ //if action is 1, $logid (logged in user) will be sending a peer request to $user (user whose profile is being viewed)
	$q3=mysql_query("SELECT * FROM friends_request WHERE userid=".$user." AND friendid=".$logid);
	$q4=mysql_query("SELECT * FROM friends_request WHERE userid=".$logid." AND friendid=".$user);
	//logid is viewer who sends a request to usrid i.e. whose profile it is. logid-->usrid status1 in DB usrid-->logid status0 in DB
	$s="INSERT INTO friends_request (userid, friendid, status) VALUES(".$logid.", ".$user.", 1)";
	$s2="INSERT INTO friends_request (userid, friendid, status) VALUES(".$user.", ".$logid.", 0)";
	if(mysql_num_rows($q3)==0 && mysql_num_rows($q4)==0){ //To deal with double form submission. Entry will only be once
		mysql_query($s);
		mysql_query($s2);
	}
}
if($_GET['action']==2){ //if action is 1, $user (user whose profile is being viewed) will be accepting the peer request of $logid (logged in user) 
	$q5=mysql_query("SELECT * FROM friends WHERE userid=".$user." AND friendid=".$logid);
	$q6=mysql_query("SELECT * FROM friends WHERE userid=".$logid." AND friendid=".$user);
	//logid is viewer who accepts a request sent by usrid
	//currently usrid-->logid status1 logid-->usrid status0
	$q=mysql_query("SELECT * FROM friends_request WHERE userid=".$user." AND friendid=".$logid." AND status=1");
	$q2=mysql_query("SELECT * FROM friends_request WHERE userid=".$logid." AND friendid=".$user." AND status=0");
	if(mysql_num_rows($q5)==0 && mysql_num_rows($q6)==0){ //To deal with double form submission
	if(mysql_num_rows($q)==1 && mysql_num_rows($q2)==1) {
		mysql_query("INSERT INTO friends(userid, friendid) VALUES(".$user.", ".$logid.")");
		mysql_query("INSERT INTO friends(userid, friendid) VALUES(".$logid.", ".$user.")");
		mysql_query("DELETE FROM friends_request WHERE userid=".$user." AND friendid=".$logid);
		mysql_query("DELETE FROM friends_request WHERE userid=".$logid." AND friendid=".$user);
	}
	}
}
if($_GET['action']==3){ //if action is 1, $user (user whose profile is being viewed) & $logid (logged in user) will not be considered peers anymore. They will be removed as peers
	mysql_query("DELETE FROM friends WHERE userid=".$user." AND friendid=".$logid);
	mysql_query("DELETE FROM friends WHERE userid=".$logid." AND friendid=".$user);
}
echo "<meta http-equiv='Refresh' content='0; URL=profile_main.php?userid=".$user."'>";
?>