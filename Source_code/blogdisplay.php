<?php

$auth=1; //user must be logged in to view this page 

include('includes.php'); //including "includes" file which connects to the database.

if(!isset($_GET['classid'])|| getNum("class_information", "classid", $_GET['classid'])!=1){ // Check Get

header('Location: http://connectedcampus.org/errorpage.php'); //If classid is not sent as GET or is wrong then redirect to error page
} 
if(!isset($_GET['blogid'])|| getNum("class_blog", "blogID", $_GET['blogid'])!=1){ // Check Get

header('Location: http://connectedcampus.org/errorpage.php'); //If blogid is not sent as GET or is wrong then redirect to error page
} 

include('html_top.php'); //including the top bar & left bar

?>
<style type="text/css">
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
<? 
$classID=$_GET['classid'];
$classname=mysql_fetch_array(mysql_query("SELECT classname FROM class_information WHERE classid='".$classID."'"));//Classroom Name
$tchrID=mysql_fetch_array(mysql_query("SELECT userid FROM class_teacher WHERE classid='$classID'"));//ID of Instructor
$logmail=$_SESSION['email'];//E-mail of current user logged in
$logname=getName($logmail); //Name of user logged in user returned by function, given email as parameter
$logid=getID($logmail); //ID of logged in user returned by function, given email as parameter

function checkstudent($l, $c){ //Checks if logged in user is a learner of the class whose classID is given
	$q=mysql_query("SELECT * FROM class_subscribed WHERE userid=".$l." AND classid=".$c);
	return mysql_num_rows($q);
}
function tchrleft($t, $c){ //Checks if the teacher of the class whose classID is given has left the class or is still teaching the class
	$query=mysql_query("SELECT * FROM class_tchrleave WHERE classid=".$c." AND userid=".$t);
	if(mysql_num_rows($query)==0){
		return 0;
	}
	else {
		return 1;
	}
}
if(isset($_POST['comment'])){
	//inserts comments of that particular post into the DB
	$commentin=$_POST['commenthold'];
	mysql_query("INSERT INTO class_blog_comments (blogID,userid,comments) VALUES(".$_GET['blogid'].", ".$logid.", '".$commentin."')");
}

include "classheaderfinal.php"; //including header of the class
?>

<style type="text/css">
#class_contentbox{
margin-top:20px;
}
#cblog_wrap{
width:450px;
float:left;
}
.cblog_p{
width:700px;
background:#ffffff;
min-height:150px;
margin-bottom:20px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:10px;
float:left;

}
.cblog_p2{
width:440px;
background:#fafafa;
min-height:150px;
margin-bottom:20px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:10px;
float:left;

}
.bloghead{
    font-size: 20px;
	color: #1a1a1a;
	font-weight: normal;
	margin-top: -5px;
	margin-bottom: -10px;
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
.ccbutton{
	
font-family: 'Century Gothic', sans-serif;
font-size:12px;
	background:#ffffff;
	padding-left:3px;
	padding-right:3px;
border: 1px solid #dadada;
outline:none;

}
.w_boxes{
float:left;
margin-left:35px;
}
.winput{
	border: 1px solid #dadada;
	padding: 2px;
	margin-top:5px;
	width: 510px;
}
.aclass{
	margin-top:10px;
	margin-left:35px;
	margin-right:20px;
	border: 1px dashed #f0f0f0;
	padding:5px;
}
.w_rightsub{
float:left;
font-size:12px;
width:120px;
}
.crossdiv{
	width:12px;
	height:12px;
	float:right;
}
.nothing{
padding-left:40px;
font-size:12px;
padding-top:10px;
padding-bottom:10px;}
.aclass_descr{
	float:left;
	padding-left:10px;
	font-size:12px;
	width:490px;
}

</style>
<?
function allowedit($blog, $lgid, $class){
	/*Checks whether the logged in user is allowed to edit the blog whose ID is passed as GET*/
	$sql="SELECT * FROM class_blog WHERE blogID=".$blog." AND byuserid=".$lgid." AND classID=".$class;
	if(mysql_num_rows(mysql_query($sql))==0){
		return 0;
	}
	else{
		return 1;
	}

}
$blogid=$_GET['blogid'];
$s="SELECT * FROM class_blog WHERE blogID=".$blogid." AND classID=".$classID;
$bloginfo=mysql_fetch_array(mysql_query($s)); //fetches information of the post which is stored in the DB


?>
<script type="text/javascript">
//To confirm whether the user want to delete the blog post or not.
function confirmDelete()
{
var agree=confirm("Are you sure you want to delete the post?");
if (agree)
	return true ;
else
	return false ;
}
</script>
<script type="text/javascript">
//To validate the comments i.e. the user cannot enter a blank comment or a comment of only spaces
function countspace(s)
{
	var l=0;
	var i=0;
	while(i < s.length)
	{
		if(s[i]==" ") {
			l++; 
		}
		i++;
	}	
	return l;
}
function validateComment()
{
	
	var x=document.forms["blogcomment"]["commenthold"].value;	
	if (x==null || x=="")
  	{
  		alert("You haven't said anything!");
  		return false;
  	}
  	if(x.length==countspace(x)){
		alert("You didn't say anything!");
		return false;
	}
	return true;
	
}
</script>
<div id="class_contentbox">
<div id="cblog_wrap">
<div class="cblog_p">
<!--Displaying the post. If logged in user has written that post, he can edit/delete it too-->
<form action="main_class.php?classid=<? echo $classID; ?>" method="post" onsubmit="return confirmDelete()"/>
<div style="text-align:center; width:100%;">
<span class="bloghead"><? echo $bloginfo['blogname']; ?></span>
<span class="blogdesc">By: <? echo getNamewID($bloginfo['byuserid']); ?></span>
&nbsp;&nbsp; <? if(allowedit($blogid, $logid, $classID)==1) { ?>
<input type="hidden" name="postdeleteid" value="<? echo $blogid; ?>"/>
<a href="blog_post.php?<? echo "classid=".$classID."&blogid=".$blogid; ?>"><input style="cursor:pointer;" type="button" name="editpost" value="EDIT" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/></a>
<input style="cursor:pointer;" type="submit" name="deletepost" value="DELETE" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>
<? }//ending if ?>
</br><br/>
<!--files attached are displayed-->
<? if($bloginfo['file1']!=""){ ?>
<a target="_blank" href="<? echo $bloginfo['file1']; ?>"><img src="img/attach.png" height="18" width="18"/><? echo $bloginfo['filename1'];?></a>&nbsp;&nbsp;&nbsp;
<? } ?>
<? if($bloginfo['file2']!=""){ ?>
<a target="_blank" href="<? echo $bloginfo['file2']; ?>"><img src="img/attach.png" height="18" width="18"/><? echo $bloginfo['filename2'];?></a>&nbsp;&nbsp;&nbsp;
<? } ?>
<? if($bloginfo['file3']!=""){ ?>
<a target="_blank" href="<? echo $bloginfo['file3']; ?>"><img src="img/attach.png" height="18" width="18"/><? echo $bloginfo['filename3'];?></a>&nbsp;&nbsp;&nbsp;
<? } ?>
</div></form>
<div class="space8"></div>
<br/>
<p><strong>Summary:</strong>&nbsp;&nbsp;<? echo $bloginfo['summary']; ?></p><br/>
<br/><p><? echo $bloginfo['blogmain']; ?></p><br/><br/>
<p><strong>Source:</strong>&nbsp;&nbsp;<? echo $bloginfo['source']; ?></p><br/>
</div>

<!--Comments are displayed-->
<div class="cblog_p">
<span class="bloghead">Comments</span>
<span class="blogdesc">&nbsp;</span>
<div class="space8"></div>
<? $sql2="SELECT * FROM class_blog_comments WHERE blogid=".$blogid." ORDER BY dt";
$query2=mysql_query($sql2);
if(mysql_num_rows($query2)==0){?>
<div class="aclass">
<div class="nothing">
No Comments Yet!
</div>
</div>
<? } 
else { 
while($comment=mysql_fetch_array($query2)){?>
<div class="aclass">
<div class="crossdiv">
<? 
	if($logid==$bloginfo['byuserid'] || $logid==$comment['userid']) /*if the logged in user has written the blog post, he can delete any comments on it. Also, users are allowed to delete their own comments */
	{?>
		<a href="delete_blog_comment.php?ID=<? echo $comment['ID'];?>&blogid=<?echo $comment['blogID'];?>&classid=<? echo $classID;?>"><img src="img/w_cross.png" /></a>
	<? } 
?>
</div>
<div style="clear:both;"></div>
<div class="aclass_descr">
<? echo $comment['comments']; ?>
</div>
<div class="w_rightsub">
By <a href="profile_main.php?userid=<? echo $comment['userid']; ?>"><? echo getNamewID($comment['userid']); ?></a>
</div>
<div class="clear"></div>
</div>
<? }//ending while
}//ending else ?>

<? if($tchrID[0]==$logid || checkstudent($logid, $classID)==1){ //only instructor or learners can comment, guests are NOT allowed to comment ?>
<form action="blogdisplay.php?<? echo "classid=".$classID."&blogid=".$blogid; ?>" method="post" name="blogcomment" onsubmit="return validateComment()">
<div class="w_boxes">
<input name="commenthold" type="text" class="winput" style="margin-top:15px" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'" autocomplete="off"><br/>
<div class="space8"></div>
<div class="space8"></div>
<input style="cursor:pointer;" type="submit" name="comment" value="Comment" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>
</div>
</form>
<? }//ending if ?>


</div><!--closing cblog_p-->


</div>
</div>


<?php

include('html_bottom.php'); //including the footer

?>