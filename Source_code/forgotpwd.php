<?php
//Connect to Database and start session
include("dbconnect.php");
$title="Reset Password | Connected Campus";
include("wbtop.php");
echo "<center>";
session_start();
//If user Logged in redirect
if(isset($_SESSION['email']))
{
echo "Logged in already..Redirecting..";
echo "<meta http-equiv='Refresh' content='2; URL=profile_main.php'>";
}
else
{
//Check if form submitted
if(!(isset($_POST['email'])))
{
//Get the email from the form
echo "Enter e-mail : <br>";
echo "<form method='post' action='forgotpwd.php'><input type='text' name='email'><input class='myButton' type='submit' name='submit'></form>";
}
else
{
//Store email after recieving from form
$email=$_POST['email'];
//Select Password
$q=mysql_query("SELECT password FROM user_information WHERE email='$email'");
$r=mysql_fetch_array($q);
//Check if login using SNS
if($r['password']=="")
{
echo "You have registered using Facebook/Google, you can't retrieve password using this site";
echo "<meta http-equiv='Refresh' content='2; URL=index.php'>";
}
else
{
//Generate newpassword
echo "New password has been generated and sent to your email address";
function generatePassword($length=9, $strength=8) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}
//Store the generated Password
$pass=generatePassword();
//Send Mail to user with new password
$subject="Reset Password for Connected Campus";
$message="Dear User,

Password has been reset: ".$pass."

Thank You,
Support Team,
Connected Campus.
";
$from = "webmaster@connectedcampus.org";
$headers = "From:" . $from;

mail($email, $subject, $message, $headers, "-f".$from);

$pass=md5($pass);
//Update password
$q=mysql_query("UPDATE user_information SET password='$pass' WHERE email='$email'");

}
}
}
echo "</center>";

?>