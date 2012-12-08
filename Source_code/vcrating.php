<?php //view topic
if(!$auth)
 {$auth=1;
 include('includes.php');
 }
$query = mysql_query("SELECT * FROM forum_ratings WHERE qid='".$qid."' AND aid='".$aid."' AND usrID='".getID($_SESSION['email'])."'");
$sum=0;
$rating = mysql_fetch_array($query);
if($rating)
 $sum=$rating['ratings'];
echo('<div style=\'display:none;\' id=\''.$aid.'n\'>'.$sum.'</div>');
$i=0;
//Display ratings for the view change ratings part
for($i;$i<$sum;$i++)
{if($i%2==0)
 echo('<img src="images/starfinalLeft.png" width="11.75" height="21.49" id=\''.$aid.'sr'.$i.'\' onMouseOver="ratingFill(\''.$aid.'sr'.$i.'\')" onClick="setRating(\''.$aid.'sr'.$i.'\')" onMouseOut="resetRating(\''.$aid.'\')">');
 else
 echo('<img src="images/starFinalRight.png" width="11.75" height="21.49" id=\''.$aid.'sr'.$i.'\' onMouseOver="ratingFill(\''.$aid.'sr'.$i.'\')" onClick="setRating(\''.$aid.'sr'.$i.'\')" onMouseOut="resetRating(\''.$aid.'\')">');
}
for($i;$i<10;$i++)
{if($i%2==0)
 {echo('<img src="images/staroutLeft.png" width="11.75" height="21.49" id=\''.$aid.'sr'.$i.'\'onMouseOver="ratingFill(\''.$aid.'sr'.$i.'\')" onClick="setRating(\''.$aid.'sr'.$i.'\')" onMouseOut="resetRating(\''.$aid.'\')">');
 }
 else
 echo('<img src="images/staroutRight.png" width="11.75" height="21.49" id=\''.$aid.'sr'.$i.'\'onMouseOver="ratingFill(\''.$aid.'sr'.$i.'\')" onClick="setRating(\''.$aid.'sr'.$i.'\')" onMouseOut="resetRating(\''.$aid.'\')">');
}
?>
