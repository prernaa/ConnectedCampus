<?php

$auth=1; //user must be logged in to view this page 

include('includes.php');

include('html_top.php');
$tbl_name="forum_question"; ///////////// Table name  /////////////////

$_Email=$_SESSION['email'];
//echo $_Email;
			/////////////// get value of id sent from address bar  /////////////
$id=$_GET['ID'];
$topic;
			////////////// Retrieving Topic of Discussion from DB //////////////
$sql="SELECT * FROM $tbl_name WHERE ID='$id'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);


$classID  = $_GET["classid"];
$em=$rows['Email'];
			///////////// Retrieving User Details from DB  //////////////////////
$sqlqname="SELECT * FROM user_information WHERE email='$em'";
$resultqname=mysql_query($sqlqname);
$rowsqname=mysql_fetch_array($resultqname);


function tchrleft($t, $c){
	$query=mysql_query("SELECT * FROM class_tchrleave WHERE classid=".$c." AND userid=".$t);
	if(mysql_num_rows($query)==0){
		return 0;
	}
	else {
		return 1;
	}
}
function checkstudent($l, $c){
	$q=mysql_query("SELECT * FROM class_subscribed WHERE userid=".$l." AND classid=".$c);
	return mysql_num_rows($q);
	//if(mysql_num_rows($q)!=1) return 0;
	//else return 1; //1-->is a student
}
?>
<script type="text/javascript">
			///////////////// Ratings for Answers ////////////////////
function emptyRating(ids)
{for(i=0;i<=9;i++)
 {if(i%2==0)		 
   document.getElementById(ids.substring(0,ids.length-1)+i).src="images/staroutLeft.png";
  else
  document.getElementById(ids.substring(0,ids.length-1)+i).src="images/staroutRight.png";
 }
}
function setRating(ids)
{emptyRating(ids);
 var n=ids.charAt(ids.length-1);
 for(i=0;i<=n;i++)
 {if(i%2==0)
   document.getElementById(ids.substring(0,ids.length-1)+i).src="images/starfinalLeft.png";
  else
  document.getElementById(ids.substring(0,ids.length-1)+i).src="images/starFinalRight.png";
 }
 document.getElementById(ids.substring(0,ids.length-3)+"n").innerHTML=(parseInt(n)+1);
  $.post('updateRating.php',{qid:<?php echo($id); ?>,aid:ids.substring(0,ids.length-3),rating:(parseInt(n)+1)},function(output){ $('#r'+ids.substring(0,ids.length-3)).html(output).show(); } );
}
function resetRating(ids)
{emptyRating(ids+"sr0");
 var n=parseInt(document.getElementById(ids+"n").innerHTML);
 for(i=0;i<n;i++)
 {if(i%2==0)
   document.getElementById(ids+"sr"+i).src="images/starfinalLeft.png";
  else
  document.getElementById(ids+"sr"+i).src="images/starFinalRight.png";
 }
}
function ratingFill(ids)
{emptyRating(ids);
 var n=ids.charAt(ids.length-1);
 for(i=0;i<=n;i++)
 {if(i%2==0)
   document.getElementById(ids.substring(0,ids.length-1)+i).src="images/starhoverLeft.png";
  else
  document.getElementById(ids.substring(0,ids.length-1)+i).src="images/starhoverRight.png";
 }
 alert(s);
}
</script>

				<!-- /////////////// Stylesheet //////////////// -->
<style type="text/css">
.aclass{
	margin-top:10px;
	margin-left:35px;
	margin-right:20px;
	border: 1px dashed #f0f0f0;
	padding:5px;
}
.aclass_hold{
	float:left;
}
.aclass_descr{
	float:left;
	padding-left:10px;
	font-size:12px;
	width:540px;
}
.w_rightsub{
float:right;
font-size:12px;
}
#classbox{
	width:720px;
	height:110px;
	background: #ffffff;
	border: 1px solid #fdfdfd;
}
#classbox_img_hold{
	float:left;
}
#classbox_des_hold{
	float:left;
	padding:10px;
	width:450px;
}
#classbox_description{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;

}
#class_ratings{
	margin-left: -65px;
	background: #27d865;
	padding:0 7px 0 7px;
	width:33px;
	height:32px;
	font-size:25px;
	font-family: 'Century Gothic', sans-serif;
	float:left;
}
h5{
	font-family: 'Century Gothic', sans-serif;
    font-size: 25px;
	color: #1a1a1a;
	font-weight: normal;
	margin-top: -5px;
	margin-bottom: -10px;
}
#class_nav_bar{
	float:right;
	padding-top:20px;
	margin-right:-25px;
}
.class_nav_btn{
	background:#f7f7f7;
	height:15px;
	padding:5px 20px 5px 20px;
	float:right;
	margin-left:10px;
	border: 1px solid #ffffff;
}
</style>


<? if($classID!=0)		//////////////// Options within a Class ////////////////
include "classheaderfinal.php";
?>


<style type="text/css">
#class_contentbox{
margin-top:20px;
}
#cblog_wrap{
width:450px;
float:left;
}
.fblog_p{
width:700px;
background:#ffffff;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:15px;
float:left;

}
.fblog_r{
width:625px;
background:#ffffff;
margin-top:-20px;
margin-bottom:10px;
padding-left:85px;
padding-top:10px;
padding-right:10px;
padding-bottom:20px;
float:left;

}
.fblog_p2{
width:700px;
background:#fafafa;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:20px;
float:left;

}
.fblog_pm{
width:700px;
background:#ffffff;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:10px;
float:left;
font-size:14px;
font-family: 'Century Gothic', sans-serif;
}
.bloghead{
    font-size: 15px;
	color: #1a1a1a;
	font-weight: normal;
	margin-top: -5px;
	margin-bottom: -10px;
	margin-right: 3px;
	font-family: 'Century Gothic', sans-serif;
}
.blogheadComment{
    font-size: 15px;
	color: #1a1a1a;
	font-weight: normal;
	margin-top: 5px;
	margin-bottom: 10px;
	margin-right: 3px;
	font-family: 'Century Gothic', sans-serif;
}
.blogdesc{
    font-size: 10px;
	color: #7a7a7a;
	font-weight: normal;
	font-family: 'Century Gothic', sans-serif;
}
.crhead{
    font-size: 18px;
	color: #1a1a1a;
	font-weight: normal;
	margin-top: -5px;
	margin-bottom: -10px;
	margin-right: 3px;
	font-family: 'Century Gothic', sans-serif;
}
.space5{
	height:5px;
}
.space8{
	height:8px;
}
#cright_wrap{
	margin-left:25px;
	float:left;
	min-width:245px;
	max-width:245px;
	}
.blogtags{
	font-size: 12px;
	color: #7a7a7a;
	font-style:italic;
	word-spacing:3px;
	font-family: 'Century Gothic', sans-serif;
}
.c_box{
	max-width:240px;
	height:120px;
	background:#fafafa;
	padding:10px;
	margin-bottom:20px;
}
.c_box2{
	max-width:240px;
	height:120px;
	background:#ffffff;
	padding:10px;
	margin-bottom:20px;
}
#cimg_hold{
	float:left;
	width:70px;
	height:90px;
}
#cinst_hold{
	max-width:140px;
	float:left;
	margin-left:10px;
}
.cint_name{
	font-size: 15px;
	color: #1a1a1a;
	font-family: 'Century Gothic', sans-serif;
}
#cinst_ratings{
	background: #27d865;
	margin-left: -42px;
	width: 20px;
	padding: 2px 5px 2px 5px;
}
#cint_det{
	font-size:12px;
}
.fcomment{
	border: 1px solid #dadada;
	padding: 2px;
	width: 610px;
}
.ccbutton{
	
font-family: 'Century Gothic', sans-serif;
	background:#ffffff;
border: 1px solid #dadada;
outline:none;

}
.fsep{
border:0;
border-bottom: 1px dashed #dadada;	
margin-top:20px;
margin-bottom:3px;
}
.ftarea{
border: 1px solid #dadada;
	padding: 2px;
	width: 690px;
resize: none;
height:165px;
}
</style>


<div id="class_contentbox">
<div id="cblog_wrap">
				
<div class="fblog_pm">
Forum > <? echo $rows['Topic']; ?>
</div>
				<!-- ////////////// Forum Topic ///////////  -->
<div class="fblog_p2">
<span class="bloghead"><? $topic=$rows['Topic']; echo $rows['Topic']; ?></span>
<span class="blogdesc">posted by <? echo $rowsqname['name']; ?>  at <? echo $rows['DateTime']; ?></span></br>
<span class="blogtags"><? echo $rows['Tags']; ?></span></br>
<div class="space8"></div>
<div style="font-size:20px"><? echo $rows['Detail']; ?></div>
</div>


<script type="text/javascript">
function popup(url) {
	newwindow=window.open(url,'name','height=600,width=830, scrollbar=no');
	if (window.focus) {newwindow.focus()}
	return false;
}
function enter(id)
{document.getElementById('s'+id).style.display="inherit";
 document.getElementById('v'+id).style.display="none";
}
function exit(id)
{document.getElementById('v'+id).style.display="inherit";
 document.getElementById('s'+id).style.display="none";
}
</script>


<script type="text/javascript">
var i=1;
function enter1(id)
{document.getElementById('s'+id).style.display="inherit";
 document.getElementById('v'+id).style.display="none";
}
function exit1(id)
{document.getElementById('v'+id).style.display="inherit";
 document.getElementById('s'+id).style.display="none";
}
</script>


<?php
$tag=$rows['Tags'];
$tbl_name2="forum_answer"; // Switch to table "forum_answer"
				/////////////////  Fetching Answers  //////////////////
$sql2="SELECT * FROM $tbl_name2 WHERE Question_ID='$id'";
$result2=mysql_query($sql2);
$counter=0;
while($rows=mysql_fetch_array($result2)){
$counter+=1;
$eml=$rows['A_Email'];
$sqlaname="SELECT * FROM user_information WHERE email='$eml'";
$resultaname=mysql_query($sqlaname);
$rowsaname=mysql_fetch_array($resultaname);
$qid=$id;
?>

<div class="fblog_p">
<div class="space8"></div>
<div style="float:right" class="bloghead">
				<!-- //////////// Deletion of Answers By Answerer  /////////// -->
<? if($rows['A_Email']==$_Email) {
?>
<a href="delete_reply.php?qid=<? echo $rows['Question_ID']; ?>&aid=<? echo $rows['A_ID']; ?>" ><img src="img/blog_cross.png"/></a>
<? } ?>
</div>

				<!-- ///////////// Forum Answers  ////////////////////  -->
<div class="space8"></div>
<div class="space8"></div>
<span class="bloghead">
<div style="float:right">
<table>
<tr>
<td>
<a id="r<? echo $rows['A_ID']; ?>" style="float:right;">
<? include('dispRating.php'); ?>
</a>
</td>
</tr>
<tr>
<td>
<a style="float:right"onmouseover="enter('<? echo $rows['A_ID']; ?>');" onmouseout="exit('<? echo $rows['A_ID']; ?>');"><div id="v<? echo $rows['A_ID']; ?>" style="font-size:10px">View/Change Rating</div><div style="display:none;" id="s<? echo $rows['A_ID']; ?>"><? include('vcrating.php'); ?></div></a>
</td>
</tr>
</table>
</div>
Reply : <? echo $counter; ?></span>
<span class="blogdesc">posted by <a href="profile_main.php?userid=<? echo getID($rowsaname['userid']);  ?>"><? echo $rowsaname['name']; ?></a> at <? echo $rows['A_DateTime']; ?></span></br>
<div class="space8"></div>
<div style="font-size:16px; width:570px;"><? echo $rows['A_Answer']; ?></div>

				<!-- ////////////// Adding Comments to Answers //////////////   -->
<div class="space8"></div>
<div class="space8"></div>
<form name="forum_comment" method="get" action="add_comment.php" >
<input class="fcomment" name="Comment" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></input>
<!--<input type="submit" name="submit" value="Comment" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>-->
<div class="space8"></div>
<div class="space8"></div><input style="cursor:pointer;" type="submit" name="comment1" value="Comment" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>&nbsp;&nbsp;<input style="cursor:pointer;"  onclick="popup('formulae.html')" type="button" name="comment" value="Add Formula" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'" />
<input name="QID" type="hidden" value="<? echo $id; ?>">
	<input name="AID" type="hidden" value="<? echo $rows['A_ID']; ?>">
	<input name="c_email" type="hidden" value="<? echo $_Email; ?>">
	<input name="classid" type="hidden" value="<? echo $classID; ?>">
	<input name="Q_Title" type="hidden" value="<? echo $topic; ?>">
</form>


				<!-- ////////////// Forum Comments on Answers  ////////// -->
<hr class="fsep"/>              <!-- /////////////// only if there are comments /////////-->
</div>
<div style="padding-top:100;">

<?php
$tbl_name3="forum_comments"; // Switch to table "forum_answer"
$a_id=$rows['A_ID'];
				/////////////////// Retrieval of Comments  /////////////
$sql_comments="SELECT * FROM $tbl_name3 WHERE q_id='$id' AND a_id='$a_id'";
$result3=mysql_query($sql_comments);
if($rows1=mysql_fetch_array($result3))
{echo('<span class="blogheadComment">Comments</p></span>');
while($rows1){
$comment_email=$rows1['email'];
$sqlcname1="SELECT * FROM user_information WHERE email='$comment_email'";
$resultcname1=mysql_query($sqlcname1);
$rowscname1=mysql_fetch_array($resultcname1);
?>
				<!-- //////////// Deletion of comments by Commentor ////////// -->
<div class="fblog_r">
<div class="aclass">
<div class="space8"></div>
<div style="float:right" class="bloghead">
<? if($comment_email==$_Email) {
?>
<a href="delete_comment.php?qid=<? echo $rows1['q_id']; ?>&aid=<? echo $rows1['a_id']; ?>&cid=<? echo $rows1['comment_id']; ?>" ><img src="img/blog_cross.png"/></a>
<? } ?>
</div>
<div class="space8"></div>
<div class="aclass_descr">
<? echo $rows1['comment']; ?>
</div>
<span class="blogdesc" style="float:right">
By <a href="profile_main.php?userid=<? echo getID($rows1['email']); ?>"><? echo getName($rows1['email']); ?></a>at <? echo $rows['A_DateTime']; ?></span>
<div class="clear"></div>
</div>
</div> 
<?
$rows1=mysql_fetch_array($result3);
}}
?>


<?
}
mysql_close();
?>

					<!-- //////////// Adding An Answer  ///////////////  -->
<div class="fblog_p2">
<span class="bloghead">Post a Reply</span>
<div class="space8"></div>
<form name="form1" method="get" action="add_answer.php" >
<input name="A_Email" type="hidden" id="A_Email" value="<?php echo $_Email; ?>" size="45">
<div style="float:left;"  >
<textarea name="A_Answer" id="A_Answer" class="ftarea" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></textarea>
</div>
<input name="ID" type="hidden" value="<? echo $id; ?>">
<input name="Q_Title" type="hidden" value="<? echo $topic; ?>">
<input name="Q_Email" type="hidden" value="<? echo $em; ?>">
<input name="classid" type="hidden" value="<? echo $classID; ?>">
<input name="tag" type="hidden" value="<? echo $tag; ?>">
<div style="margin-right:3px; margin-top: 5px; float:right;"  >
<input style="cursor:pointer;" type="button" onclick="popup('formulae.html')" name="comment" value="Add Formula" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>&nbsp;&nbsp;<input  type="submit" name="submit" value="Reply" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>
</span>
</div>

</form>
</div>
</div>
</div>
</div>
<?php

include('html_bottom.php');

?>