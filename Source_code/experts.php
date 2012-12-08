<?php
$auth=1;
include('includes.php');
$tags=explode(",",$_POST['tags']);
$location=$_POST['loc'];
$university=$_POST['uni'];
$experts=array();

if($tags)
{$query = "SELECT * FROM forum_tags WHERE tagname='".$tags[0]."'";
 for($i=1;$i<count($tags);$i++)
 {$query=$query." OR tagname = '".$tags[$i]."'";
 }//adding multiple tags to search query
 $sql = mysql_query($query);
 $e=array();
 
// Search db for suitable experts in the presented tags
while($e=mysql_fetch_array($sql)){
	$i=0;
	for(;$i<count($experts);$i++)
	{if($experts[$i]==$e['userid'])
	  break;
	}
	if($i==count($experts))
	  $experts[] = $e['userid'];
}
if(!$experts)
{echo("No results match your query<br/>Try expanding your search terms");
 return;
}
}
$cfmlist = array();
$rlist = array();
// Filtering the found experts, by provided university and location
for($i=0;$i<count($experts);$i++){
if(($experts[$i]==getID($_SESSION['email']))||(!($university==="")&&!($university===fetchData("user_information","university","userid",$experts[$i])))||(!($location==="")&&!($location===fetchData("user_information","city","userid",$experts[$i])||$location===fetchData("user_information","country","userid",$experts[$i])))){
continue;
}
$fs=mysql_fetch_array(mysql_query("SELECT * FROM user_information WHERE userid = '".$experts[$i]."'"));
$rating=1;
$sql=mysql_query("SELECT * FROM forum_tags WHERE userid = '".$experts[$i]."'");
while($tag=mysql_fetch_array($sql)){
$rating +=$tag['rating_ans'];//Obtaining the sum of the expert's rating for the provided tags
}
$num_posts = 0;
//Obtaining the total number of posts by the expert on all the tags
$sql=mysql_query("SELECT * FROM forum_question");
while($q=mysql_fetch_array($sql))
{$tagQ=explode(",",$q['Tags']);
 $flag=0;
 for($j=0;$j<count($tagQ)&&!$flag;$j++)
 {for($k=0;$k<count($tags);$k++)
  {if($tagQ[$j]==$tags[$k])
    {$flag=1;
	 break;
	}
  }
 }
 if($flag)
 $num_posts+=getNum2('forum_answer','A_Email',$fs['email'],$q['ID']);
}
$rslt = ((pow(4, $rating ))*(pow(2, $num_posts)))-2; // a result which is used to prioritize experts
$cfmlist[]=$experts[$i];
$rlist[]=$rslt;
//Inserting experts into list in order of priority
for($j=0;$j<count($cfmlist)-1;$j++)
{if($rlist[$j]<$rslt)
  {for($k=count($cfmlist)-1;$k>$j;$k--)
   {$cfmlist[$k]=$cfmlist[$k-1];
    $rlist[$k]=$rlist[$k-1];
   }
   $cfmlist[$j]=$experts[$i];
   $rlist[$j]=$rslt;
   break;
  }
 }
}
if(!$cfmlist){//If no experts found
echo("No results match your query<br/>Try expanding your search terms");
}
else
{//Displaying the found experts
for($i=0;$i<count($cfmlist);++$i){
?>
<div class="friend_holder">
<a href="http://connectedcampus.org/profile_main.php?userid=<?php echo $cfmlist[$i] ?>">
<img src="
<?php 

if(getPic($cfmlist[$i])==""){
echo "img/defpic.png";
}else{
echo getPic($cfmlist[$i]);
}
?>
"  height="100" width="120" />	</a>
<p	 align="center"><?php echo getNamewID($cfmlist[$i]); ?></p>
</div>
<?php
}
}

?>
