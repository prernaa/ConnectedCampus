<?php

if(!$auth)

 {$auth=1;

 }

include('includes.php');

$aid=$_POST["aid"];//Retrieve answer id

$qid=$_POST["qid"];//Retrieve question id

$rat=$_POST["rating"];//Retrieve new rating
//Retrieve question  details
$postInf=mysql_fetch_array(mysql_query("SELECT * FROM forum_question WHERE ID='".$qid."'"));
//Retrieve answer details
$ansInf=mysql_fetch_array(mysql_query("SELECT * FROM forum_answer WHERE A_ID='".$aid."' AND Question_ID='".$qid."'"));
//Retrieve original rating
$rating = mysql_fetch_array(mysql_query("SELECT * FROM forum_ratings WHERE qid='".$qid."' AND aid='".$aid."' AND usrID='".getID($_SESSION['email'])."'"));

$flag=0;
$n=0;

if($rating)

{//Update the User's rating
 $query = mysql_query("UPDATE forum_ratings SET ratings=".$rat." WHERE qid='".$qid."' AND aid='".$aid."' AND usrID='".getID($_SESSION['email'])."'");


 if(!$query)

 {echo("Update error!!");

 }

}

else
//Otherwise insert a new rating
{$query=mysql_query("INSERT INTO forum_ratings VALUES(null,'".getID($_SESSION['email'])."','".$aid."','".$qid."','".$rat."')");
$flag=1;
 if(!$query)

  {echo("Insert error!!");

  } 

}

$tags=explode(",",$postInf['Tags']);


$i;
for($i=0;$i<count($tags);$i++)

{$t=$tags[$i];
//Update the user ratings for each tag
 $row=mysql_fetch_array(mysql_query("SELECT * FROM forum_tags WHERE tagname='".$t."' AND userid='".getID($ansInf['A_Email'])."'"));

 if($row)
 {$frat;
  if($flag)
   {$frat=($rat+($row['rating_ans']*($row['num_ans'])))/($row['num_ans']+1);
    $query = mysql_query("UPDATE forum_tags SET num_ans='".($row['num_ans']+1)."' WHERE tagname='".$t."' AND userid='".getID($ansInf['A_Email'])."'");
   }
  else
  {$frat=($rat-$rating['ratings']+($row['rating_ans']*($row['num_ans'])))/($row['num_ans']);
  }
  $query = mysql_query("UPDATE forum_tags SET rating_ans='".$frat."' WHERE tagname='".$t."' AND userid='".getID($ansInf['A_Email'])."'");

 if(!$query)

 {echo("Update error!!");

 }

 }

 else

 {$query=mysql_query("INSERT INTO forum_tags VALUES(null,'".$t."','".getID($ansInf['A_Email'])."','1','".$rat."')");

 if(!$query)

  {echo("Insert error!!");

  } 

 }

}

include("dispRating.php");

