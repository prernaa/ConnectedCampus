<?php
if(!$auth)
 {$auth=1;
 }
include('includes.php');
$cid=$_POST["cid"];//Retrieve class id
$rat=$_POST["rating"];//Retrieve new rating
$rating = mysql_fetch_array(mysql_query("SELECT * FROM class_rating WHERE classid='".$cid."' AND usrID='".getID($_SESSION['email'])."'"));
$ratings=0;
$n=0;
if($rating)
{$ratings=$rating['ratings']*-1;
 //Update the Class' rating
 $query = mysql_query("UPDATE class_rating SET rating=".$rat." WHERE classid='".$cid."' AND usrID='".getID($_SESSION['email'])."'");
 $n=-1;
 if(!$query)
 {echo("Update error!!");
 }
}
else
//Otherwise insert a new rating
{$query=mysql_query("INSERT INTO class_rating VALUES(null,'".$cid."','".$rat."','".getID($_SESSION['email'])."')");
 if(!$query)
  {echo("Insert error!!");
  } 
}
include("dispCRating.php");
?>