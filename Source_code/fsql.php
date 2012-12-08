<?php
// fsql.php - sql file linker
// used to link php posts, commonly used for jquery
// can also be used to be a displayer
// authentication function
$auth=1;

// include normal functions and database
include('../includes.php');

// Check if post to the file is invoked
if(isset($_POST['postID'])){

// Function to fetch activities
if ($_POST['postID']=="updateNotification"){
?>

<?php
// Fetch activities
$query = mysql_query("SELECT * FROM user_notifications WHERE UserID='".getID($_SESSION['email'])."' AND Unread = '1' ORDER BY ID DESC");
while($not=mysql_fetch_array($query)){
// Print activities
?>
<div class="activity">
<a OnClick="CleanActivity(<?php echo $not['ID']; ?>);" href="<?php echo $not['Link']; ?>"><?php echo setNotiText($not['Type'],getNamewID($not['AddUserID']), $not['AddInfo']) ?></a>
</div>
<?php } 
if(mysql_num_rows($query)==0){
echo "No new activities";
}
?>
	
<?php

// Function used to request a person to be his peer
} elseif($_POST['postID']=="reqPeer"){
	$sql = "INSERT INTO friends_request values (NULL ,'".$_POST['userid']."','".$_POST['peerid']."', '1')";
	mysql_query($sql);
	$sql = "INSERT INTO friends_request values (NULL ,'".$_POST['peerid']."','".$_POST['userid']."', '0')";
	mysql_query($sql);

//  Function used to accept a peer request
} elseif($_POST['postID']=="accPeer"){
	$sql = "INSERT INTO friends values (NULL ,'".$_POST['userid']."','".$_POST['peerid']."')";
	mysql_query($sql);
	$sql = "INSERT INTO friends values (NULL ,'".$_POST['peerid']."','".$_POST['userid']."')";
	mysql_query($sql);
	updateDB2("friends_request", "status", 1, "userid", $_POST['userid'], "friendid", $_POST['peerid']); 

//	Function used to unset an activity as active
} elseif($_POST['postID']="unsetNotification"){
	updateDB("user_notifications", "Unread", '0', 'ID', $_POST['actID']);
} 
}

?>