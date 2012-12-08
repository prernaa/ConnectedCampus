<?php
//Start Session and connect to database
session_start();
include("dbconnect.php");
$email=$user_data['email'];
//If password is changed, then change
if(isset($_POST['password']))
{
$p=$_POST['password'];
$p=md5($p);
$f=mysql_query("UPDATE user_information SET password = '$p' WHERE email='$email'");
}
//Get POST Data
$name=$_POST['name'];
$occ=$_POST['occupation'];
$fos=$_POST['fieldofstudy'];
$uni=$_POST['uni'];
$grad=$_POST['graduationyr'];
$country=$_POST['parentdrop1'];
$city=$_POST['childdrop4f5cb8a6e68e3'];
$bday=$_POST['childdrop4f5cbbed28c77'];
$bmonth=$_POST['bmonth'];
$byear=$_POST['byear'];
$abtme=$_POST['abtmebox'];
//Update MYSQL data
$f=mysql_query("UPDATE user_information SET name = '$name' WHERE email='$email'");
$f=mysql_query("UPDATE user_information SET occupation = '$occ' WHERE email='$email'");
$f=mysql_query("UPDATE user_information SET fieldofstudy = '$fos' WHERE email='$email'");
$f=mysql_query("UPDATE user_information SET university = '$uni' WHERE email='$email'");
$f=mysql_query("UPDATE user_information SET graduationyr = '$grad' WHERE email='$email'");
$f=mysql_query("UPDATE user_information SET city = '$city' WHERE email='$email'");
$f=mysql_query("UPDATE user_information SET byear = '$byear' WHERE email='$email'");
$f=mysql_query("UPDATE user_information SET bmonth = '$bmonth' WHERE email='$email'");
$f=mysql_query("UPDATE user_information SET bday = '$bday' WHERE email='$email'");
$f=mysql_query("UPDATE user_information SET country = '$country' WHERE email='$email'");
$f=mysql_query("UPDATE user_information SET abtme = '$abtme' WHERE email='$email'");
//Get Privacy data
$bday=(int)$_POST['bday'];
$pic=(int)$_POST['pic'];
$peers=(int)$_POST['peers'];
$abtme=(int)$_POST['abtme'];

$u=$_SESSION['email'];
//Check if user has privacy settings already
$t=mysql_query("SELECT * FROM privacy_user WHERE email='$u'");
$t=mysql_num_rows($t);
//If Yes, Update
if($t)
{
$t=mysql_query("UPDATE privacy_user SET setting='$bday' WHERE property='bday' AND email='$u'");

$t=mysql_query("UPDATE privacy_user SET setting='$pic' WHERE property='pic' AND email='$u'");
$t=mysql_query("UPDATE privacy_user SET setting='$peers' WHERE property='peers' AND email='$u'");
$t=mysql_query("UPDATE privacy_user SET setting='$abtme' WHERE property='abtme' AND email='$u'");
header("location:profile_main.php");
}
//If not, make new entry
else
{
$r=mysql_query("INSERT INTO privacy_user VALUES('$u','bday','$bday')");
$r=mysql_query("INSERT INTO privacy_user VALUES('$u','pic','$pic')");
$r=mysql_query("INSERT INTO privacy_user VALUES('$u','peers','$peers')");
$r=mysql_query("INSERT INTO privacy_user VALUES('$u','abtme','$abtme')");
header("location:profile_main.php");
}

mysql_close($con);
?>