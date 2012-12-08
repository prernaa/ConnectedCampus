
<?php
//Start session and connect to DB
session_start();
include("dbconnect.php");
$uidd=$user_data['userid'];

// Get data
$q=mysql_query("SELECT * FROM user_message WHERE UserID = '$uidd'");
$i=mysql_num_rows($q);	// All Messages
$k=mysql_query("SELECT * FROM user_message WHERE UserID = '$uidd' AND ReadID='0'");
$k=mysql_num_rows($k);	// Unread Messages
?>

<?php //echo $i; echo "(".$k.")"; ?>

<?php
//Set counter for messages
$g=0;
//loop through messages
while ($row = mysql_fetch_array($q))
{
//Keep checking
$g=$g+!($row['ReadID']);
$sid=$row['SenderID'];
//Get user information
$rt=mysql_query("SELECT * FROM user_information WHERE userid='$sid'");
$rt=mysql_fetch_array($rt);
if(!($row['ReadID']))
{
//Show notification and info
echo '<div class="activity">';
echo "<a class='iframe' tabindex='1' href='viewmessage.php?id=".$row['ID']."'>New message from <b>".$rt['name']."</b></a></font><br><br></div>";
echo '</div>';
		
}

		}
if(!($g))
{
echo "No new messages";
}

?>