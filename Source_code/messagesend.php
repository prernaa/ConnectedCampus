<!DOCTYPE HTML>
<html>
<?
include "includes.php";
$user=$_GET['user'];
$log=$_SESSION['email'];
$logid=getID($log);
?>
<body>
<? if(!isset($_POST['sendmsg'])){ ?>
<form action="messagesend.php?user=<? echo $user; ?>" method="post">
To: <? echo getNamewID($user); ?> <br/>
Message: <textarea name="msgtosnd" id="msgtosnd"></textarea>
<input type="submit" name="sendmsg" id="sendmsg" value="SEND"/>
</form>
<? }//ending if
else { 
	if($_POST['msgtosnd']!=''){
		$text=$_POST['msgtosnd'];
		//echo $text;
		//echo $user;
		//echo $logid;
		mysql_query("INSERT INTO user_message (UserID, SenderID, Message) VALUES ($user,$logid, '".$text."')");
	} ?>
<br/>Message Sent! :)
<? }//ending else ?>
</body>
</html>