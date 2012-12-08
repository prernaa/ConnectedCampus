<?php //view topic

if(!$auth)

 {$auth=1;

 include('includes.php');

 }

$aid=$_POST["aid"];//Retrieve the Id of the answer

$qid=$_POST["qid"];//Retrieve the Id of the answer

if(!$aid)

{$aid=$rows['A_ID'];//If this page has not been posted to and merely included

}

if(!$qid)

{$qid=$id;//If this page has not been posted to and merely included

}

$query = mysql_query("SELECT * FROM forum_ratings WHERE qid='".$qid."' AND aid='".$aid."'");

$sum=0.0;

$num=0;
//find the sum of the ratings given by all the users
while($rating = mysql_fetch_array($query))

{$sum+=$rating['ratings'];

 $num+=1;

}

if($num!=0)

{$sum=round($sum/$num);//find the average of the ratings given by all users

}

$i=0;

//Drawing the rating stars
for($i;$i<$sum;$i++)

{if($i%2==0)

 echo('<img src="images/starfinalLeft.png" width="11.75" height="21.49" id=\''.$aid.'s'.$i.'\'>');

 else

 echo('<img src="images/starFinalRight.png" width="11.75" height="21.49" id=\''.$aid.'s'.$i.'\'>');

}

for($i;$i<10;$i++)

{if($i%2==0)

 {echo('<img src="images/staroutLeft.png" width="11.75" height="21.49" id=\''.$aid.'s'.$i.'\'>');

 }

 else

 echo('<img src="images/staroutRight.png" width="11.75" height="21.49" id=\''.$aid.'s'.$i.'\'>');

}

?>

