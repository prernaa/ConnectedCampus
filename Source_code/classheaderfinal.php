<?php $classID=$_GET['classid']; //classid is sent via GET variable
$classname=mysql_fetch_array(mysql_query("SELECT classname FROM class_information WHERE classid='".$classID."'"));//Classroom Name

?>
<!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script-->
<script type="text/javascript">
//Empties all the rating stars of ids//
function emptyCRating(ids)
{for(i=0;i<=9;i++)
 {if(i%2==0)
   document.getElementById(ids.substring(0,ids.length-1)+i).src="images/staroutLeft.png";
  else
  document.getElementById(ids.substring(0,ids.length-1)+i).src="images/staroutRight.png";
 }
}
//Sets the new rating of the viewer
function setCRating(ids)
{emptyCRating(ids);
 var n=ids.charAt(ids.length-1);
 for(i=0;i<=n;i++)
 {if(i%2==0)
   document.getElementById("Csr"+i).src="images/starfinalLeft.png";
  else
  document.getElementById("Csr"+i).src="images/starFinalRight.png";
 }
 document.getElementById("Cn").innerHTML=(parseInt(n)+1);
  $.post('updateCRating.php',{cid:<?php echo($classID); ?>,rating:(parseInt(n)+1)},function(output){ $('#Cr').html(output).show(); } );
}
//Refresh the ratings
function resetCRating()
{emptyCRating("Csr0");
 var n=parseInt(document.getElementById("Cn").innerHTML);
 for(i=0;i<n;i++)
 {if(i%2==0)
   document.getElementById("Csr"+i).src="images/starfinalLeft.png";
  else
  document.getElementById("Csr"+i).src="images/starFinalRight.png";
 }
}
//Fill the rating stars as per the rating
function ratingCFill(ids)
{emptyCRating(ids);
 var n=ids.charAt(ids.length-1);
 //each image represents half a star
 for(i=0;i<=n;i++)
 {if(i%2==0)
   document.getElementById(ids.substring(0,ids.length-1)+i).src="images/starhoverLeft.png";
  else
  document.getElementById(ids.substring(0,ids.length-1)+i).src="images/starhoverRight.png";
 }
}
</script>
<script type="text/javascript">
//To Toggle between "View/Change rating Text and Rating editor//
var i=1;
function Center()
{document.getElementById('Cs').style.display="inherit";
 document.getElementById('Cv').style.display="none";
}
function Cexit()
{document.getElementById('Cv').style.display="inherit";
 document.getElementById('Cs').style.display="none";
}
</script>
<?
function getclassimg($id) {
	//this function returns the class images's filename
	$sql="SELECT image FROM class_information WHERE classid=".$id;
	$result=mysql_fetch_array(mysql_query($sql));
	return $result['image'];
}
?>
<div id="classbox">
<div id="classbox_img_hold">
<!--Class image is displayed here-->
<a href="main_class.php?classid=<? echo $classID; ?>"><img src="<? echo "classimages/".getclassimg($classID); ?>" width="160" height="80" alt="<? echo $classname[0]; ?>" style="cursor:pointer;"/></a>

</div>

<div id="classbox_des_hold">
<br/>
<div id="classbox_description">
<!--ratings are displayed-->
<div style="width:50%; height:45px; display:inline-block; float:left;">
<table><tr><td><div id="Cr"><? include('dispCRating.php'); ?></div></td></tr>
<tr><td width="22%" onmouseover="Center();" onmouseout="Cexit();"><div id="Cv">View/Change Rating</div><div style="display:none;" id="Cs"><? include('vcCrating.php'); ?></div></td></tr></table>
</div>
<div style="width:50%; height:45px; display:inline-block; float:left">
<span class="crhead"><? echo $classname[0]; //classname displayed ?></span>
</div>
<div style="clear:both;"></div>
</div>
<div id="class_nav_bar">
<? //invite to show if privacy=0 (global) then to all learners & instructor OR if privacy=1 i.e. private then to instructor only if instructor has not left class
$classprivacy=mysql_fetch_array(mysql_query("SELECT privacy FROM class_information WHERE classid='".$classID."'"));
if(($classprivacy[0]==0 && checkstudent($logid, $classID)!=0)||($classprivacy[0]==0 && $logid==$tchrID[0] && tchrleft($tchrID[0], $classID)==0)|| ($classprivacy[0]==1 && $logid==$tchrID[0] && tchrleft($tchrID[0], $classID)==0)||($classprivacy[0]==1 && checkstudent($logid, $classID)!=0 && tchrleft($tchrID[0], $classID)==1)){?>

<div class = "class_nav_btn">
<a class="iframe" href="invite_popup.php?action=class&classid=<? echo $classID; ?>">Invite</a>
</div>

<? }//ending if of invites ?>


<? if(($logid==$tchrID[0] && tchrleft($tchrID[0], $classID)==0)||checkstudent($logid, $classID)!=0){ 
//Only learners and the instructor have access to the forum and whiteboard. Instructor has access only if he/she has not left the classroom?>
<div class = "class_nav_btn">
<a href="main_forum.php?classid=<? echo $classID; ?>">Forum</a>
</div>
<div class = "class_nav_btn">
<a href="main_wb.php?classid=<? echo $classID; ?>">Whiteboard</a>
</div>
<? } ?>	
<!--Evenyone i.e. learners, instructors as well as guests have access to the class's main page and can view the posts of the classroom-->
<div class = "class_nav_btn">
<a href="main_class.php?classid=<? echo $classID; ?>">Main</a>
</div>


</div>
</div>
</div>
