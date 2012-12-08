<?php
include("dbconnect.php");
				 ////////////// Access Permission /////////////////
session_start();
if(!(isset($_SESSION['email'])))
{
echo "You are not allowed to access this resource";
echo "<meta http-equiv='Refresh' content='2; URL=index.php'>";
exit;
}
				/////////////// Class and User Information //////////////
$email=$_SESSION['email'];
$q=mysql_query("SELECT * FROM user_information WHERE email='$email'");
$q=mysql_fetch_array($q);
$userid=$q['userid'];
$name=$_GET['classname'];
$t=mysql_query("SELECT * FROM class_information WHERE classname='$name'");

				/////////////// Inserting into DB  ///////////////////
if(mysql_num_rows($t)==0)
{
$cat=$_GET['box1'];
$subcat=$_GET['box2'];
$date=date("Y-m-d h:m:s");
$privacy=$_GET['privacy'];
				/////////////// Insertion of Category /////////////////
$catinfo=mysql_query("INSERT INTO class_category VALUES ('','$cat')");
$catex=mysql_query("SELECT * FROM class_category WHERE catname='$cat'");
$catex=mysql_fetch_array($catex);
$catid=$catex['catid'];
				/////////////// Insertion of Sub-Category /////////////////
$subcatinfo=mysql_query("INSERT INTO class_subcat VALUES ('','$subcat','$catid')");
$subcatex=mysql_query("SELECT * FROM class_subcat WHERE subcatname='$subcat'");
$subcatex=mysql_fetch_array($subcatex);
$subcatid=$subcatex['subcatid'];
$img="default.jpg";
				/////////////// Default Image Based on Category ///////////////
if($cat=="Business")
{
	$img="Business.jpg";
}
else if($cat=="Arts, Humanities, Social Sciences")
{
	$img="AHSS.jpg";
}
else if($cat=="Computing")
{
	$img="Computing.jpg";
}
else if($cat=="Medical")
{
	$img="Medical.jpg";
}
else if($cat=="Design & Environmental")
{
	$img="Environment.jpg";
}
else if($cat=="Engineering")
{
	$img="Engineering.jpg";
}
else if($cat=="Law")
{
	$img="Law.jpg";
}
else if($cat=="Music")
{
	$img="Music.jpg";
}
else if($cat=="Science")
{
	$img="Science.jpg";
}
else if($cat=="Art, Design & Media")
{
	$img="ADM.jpg";
}
else if($cat=="Education")
{
	$img="Education.png";
}
else if($cat=="Sports, Science & Management")
{
	$img="sports.gif";
}
else if($cat=="Research")
{
	$img="Research.jpg";
}
//echo "notification";
				///////////////////// Insertiopn of Class Information ////////////////////
$classinfo=mysql_query("INSERT INTO class_information VALUES('','$name','$catid','$subcatid','$date','$privacy','$img')");
$nu=mysql_query("SELECT * FROM class_information WHERE classname='$name'");
$nj=mysql_fetch_array($nu);
$classid=$nj['classid'];
				///////////////////// Insertiopn of Class Teacher Information ////////////////////
$ui=mysql_query("INSERT INTO class_teacher VALUES('','$classid','$userid','','')");
				///////////////////// Insertiopn of Rating ////////////////////
$rating=$_GET['rating'];
$c_rating=mysql_query("INSERT INTO class_rating VALUES('','$classid','$rating')");

				///////////////////// Notification ////////////////////
if($privacy=="0") {
//echo "notification";
$type="NewClass";
$link="http://connectedcampus.org/main_class.php?classid=".$classid;
$addinfo=$name;

$sql_loop="SELECT * FROM friends WHERE userid=".$userid;
$query_loop=mysql_query($sql_loop);
//echo $link;
while($loop=mysql_fetch_array($query_loop)) {
$friend=$loop['friendid'];
$notification=mysql_query("INSERT INTO user_notifications VALUES('','$type','$friend','$link','$userid','1','$addinfo')");
 }
}
echo "<center>Class created successfully..Redirecting</center>";
echo "<script type='text/javascript'>
    self.parent.location.href='profile_main.php';
</script>";
exit;
}
else
{
echo "<center>Class with the same name exists..Choose another one..Redirecting</center>";
echo "<script type='text/javascript'>
    self.parent.location.href='profile_main.php';
</script>";
exit;
}