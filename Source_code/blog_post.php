<?php

$auth=1; //user must be logged in to view this page 

include('includes.php');

if(!isset($_GET['classid'])|| getNum("class_information", "classid", $_GET['classid'])!=1){ // Check Get

header('Location: http://connectedcampus.org/errorpage.php'); //if GET variable is not set, re-direct to error page
} 
$classid=$_GET['classid'];
$classID=$classid;

$tchrID=mysql_fetch_array(mysql_query("SELECT userid FROM class_teacher WHERE classid=$classid"));//tchrID[0] is ID of Instructor
$logmail=$_SESSION['email'];//E-mail of current user logged in
$logid=getID($logmail); //ID of logged in user returned by function, given email as parameter
$edit=0;

if(($tchrID[0]!=$logid) && (getNum2("class_subscribed", "classid", $_GET['classid'], "userid", getID($_SESSION['email']))!=1)){
	header('Location: http://connectedcampus.org/main_class.php?classid=$classid'); /*If the logged in user is a guest (not an instructor or learner then redirect to
	the class's main page */
}
function allowedit($blog, $lgid, $class){
	/*Checks whether the logged in user is allowed to edit the blog whose ID may be passed as GET*/
	$sql="SELECT * FROM class_blog WHERE blogID=".$blog." AND byuserid=".$lgid." AND classID=".$class;
	if(mysql_num_rows(mysql_query($sql))==0){
		return 0;
	}
	else{
		return 1;
	}

}
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
if(isset($_GET['blogid']) && allowedit($_GET['blogid'],$logid, $classid)==1){
	//If blogID is sent as GET variable and the logged in user is allowed to edit the blog whose blogID is specified then we retrieve old blog post information from the DB
	$edit=1;
	$blogid=$_GET['blogid'];
	$s="SELECT * FROM class_blog WHERE blogID=".$blogid." AND byuserid=".$logid." AND classID=".$classid;
	$bloginfo=mysql_fetch_array(mysql_query($s));
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
<? include "classheaderfinal.php"; //including the class header
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
font-size:16px;
	background:#ffffff;
	padding-left:5px;
	padding-right:5px;
border: 1px solid #dadada;
outline:none;

}
</style>
<!--//Editor's jQuery files included-->
<script type="text/javascript" src="/ckeditor/ckeditor.js"></script> 
<script type="text/javascript" src="/ckeditor/adapters/jquery.js"></script>
<script src="jquery.MultiFile.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
//validating the blog post form
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
function postblogvalidate()
{
var x=document.forms["blogeditform"]["postname"].value;
if (x==null || x=="")
{
	alert("Post Title must be filled out");
	return false;
}
if(x.length==countspace(x))
{
	alert("Post Title must be filled out");
	return false;
}
return true;
}
</script>

<div id="class_contentbox">
<div id="cblog_wrap">
<div class="cblog_p">
<span class="bloghead">&nbsp;</span>
<span class="blogdesc">&nbsp;</span></br>
<div class="space8"></div>
<?

function emptyfilefield($b){//Upto 3 files can be attached to every post. To store the filenames in the DB, we need to check which column in the DB table is empty 
	$blogf=mysql_fetch_array(mysql_query("SELECT * FROM class_blog WHERE blogID=".$b));
	if($blogf['file1']==NULL || $blogf['file1']==""){
	return 1;} //column file1 in table empty
	else if($blogf['file2']==NULL || $blogf['file2']==""){
	return 2;} //column file2 in table empty 
	else if($blogf['file3']==NULL || $blogf['file3']==""){
	return 3;} //column file3 in table empty
	else return 0;
}
//PHP code for feeding data into DB
if(isset($_POST['blogpostsubmit'])){
	$posttitle=$_POST['postname'];
	$postmain=$_POST['blogeditor'];
	$postsummary=$_POST['postsummary'];
	$postsource=$_POST['postsource'];
	$uniqueid=time().$posttitle;
	if(!isset($_GET['blogid'])){
	$sql2="INSERT INTO class_blog(blogname,classID,byuserid,blogmain,summary,source, uniqueid) VALUES('".$posttitle."', ".$classid.", ".$logid.", '".$postmain."', '".$postsummary."', '".$postsource."', '".$uniqueid."')";
	
	if($edit!=1){
		$type="NewPost";
		$link="http://connectedcampus.org/main_class.php?classid=".$classid;
		$addinfo=$posttitle;
	
	
	/*$sql_id="SELECT * FROM user_information WHERE email='".$email."'";
	$query_id=mysql_query($sql_id);
	$row_id=mysql_fetch_array($query_id);
	$sendto=$row_id['userid'];*/
	
		/*$sql_sender="SELECT * FROM user_information WHERE email='".$email."'";
		$query_sender=mysql_query($sql_sender);
		$row_sender=mysql_fetch_array($query_sender);*/
		//$sender=$row_sender['userid'];
		$sender=$logid;

		$sql_learners="SELECT * FROM class_subscribed WHERE classid=".$classid;
		$query_learners=mysql_query($sql_learners);
	
	//echo $link;
		while($row_learners=mysql_fetch_array($query_learners)) {
			$sendto=$row_learners['userid'];
			$notification=mysql_query("INSERT INTO user_notifications VALUES('','$type','$sendto','$link','$sender','1','$addinfo')");
		}
		
		$sql_teacher="SELECT * FROM class_teacher WHERE classid=".$classid." AND userid NOT IN (SELECT userid FROM class_tchrleave WHERE classid=".$classid.")";
		$query_teacher=mysql_query($sql_teacher);
		$row_teacher=mysql_fetch_array($query_teacher);
		$sendto=$row_teacher['userid'];
		$notification=mysql_query("INSERT INTO user_notifications VALUES('','$type','$sendto','$link','$sender','1','$addinfo')");
	
	}
	
	
	
	
	
	}
	else{
		$sql2="UPDATE class_blog SET blogname='".$posttitle."', blogmain='".$postmain."', summary='".$postsummary."', source='".$postsource."' WHERE blogID=".$blogid." AND classID=".$classid." AND byuserid=".$logid;
	}
	$query=mysql_query($sql2);
	if (!$query) {
    	die('Invalid query: ' . mysql_error());
	}
	else{
		echo "Successfully posted! <a href='main_class.php?classid=".$classid."'>Click</a> to return to main";
	}
//Below is PHP code for multiple file upload (we allow upto 3
if($_FILES['userfile']['size'][0]>0 ){ //if for files begins
	/*FILE UPLOAD CODE*/
    $count=0;
	$totalsize=0;
	
	if($edit==1){
		$totalsize=$bloginfo['filesize1']+$bloginfo['filesize2']+$bloginfo['filesize3']; //total file size of attachments per post should not be more than 10MB
	}
	foreach ($_FILES['userfile']['size'] as $filesize) 
            {         
               $totalsize=$totalsize+$filesize;
            }
	if($totalsize>10000000){
		echo "<br/>You've already attached files of 10MB. Only 10MB per post is allowed.<br/>";
	}
	foreach ($_FILES['userfile']['name'] as $filename) 
            { //32 mime types allowed. This will disallow any harmful script to be uploaded. Hence this check is important
				if($_FILES['userfile']['type'][$count]!='image/gif' &&  $_FILES['userfile']['type'][$count]!='image/jpeg' && $_FILES['userfile']['type'][$count]!='image/pjpeg' && $_FILES['userfile']['type'][$count]!='image/png' && $_FILES['userfile']['type'][$count]!='image/tif' && $_FILES['userfile']['type'][$count]!='image/tiff' && $_FILES['userfile']['type'][$count]!='image/bmp' && $_FILES['userfile']['type'][$count]!='application/pdf' && $_FILES['userfile']['type'][$count]!='text/plain' && $_FILES['userfile']['type'][$count]!='text/rtf' && $_FILES['userfile']['type'][$count]!='text/richtext' && $_FILES['userfile']['type'][$count]!='application/msword' && $_FILES['userfile']['type'][$count]!='application/vnd.openxmlformats-officedocument.wordprocessingml.document' && $_FILES['userfile']['type'][$count]!='application/vnd.openxmlformats-officedocument.wordprocessingml.template' && $_FILES['userfile']['type'][$count]!='application/vnd.ms-excel' && $_FILES['userfile']['type'][$count]!='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && $_FILES['userfile']['type'][$count]!='application/vnd.openxmlformats-officedocument.spreadsheetml.template' && $_FILES['userfile']['type'][$count]!='application/vnd.ms-powerpoint' && $_FILES['userfile']['type'][$count]!='application/vnd.openxmlformats-officedocument.presentationml.presentation' && $_FILES['userfile']['type'][$count]!='application/vnd.openxmlformats-officedocument.presentationml.template' && $_FILES['userfile']['type'][$count]!='application/vnd.openxmlformats-officedocument.presentationml.slideshow' && $_FILES['userfile']['type'][$count]!='image/vnd.adobe.photoshop' && $_FILES['userfile']['type'][$count]!='video/mp4' && $_FILES['userfile']['type'][$count]!='application/ogg' && $_FILES['userfile']['type'][$count]!='video/x-msvideo' && $_FILES['userfile']['type'][$count]!='video/quicktime' && $_FILES['userfile']['type'][$count]!='video/mpeg' && $_FILES['userfile']['type'][$count]!='application/x-shockwave-flash' && $_FILES['userfile']['type'][$count]!='audio/x-wav' && $_FILES['userfile']['type'][$count]!='application/zip' && $_FILES['userfile']['type'][$count]!='audio/mpeg' ){
					
					echo "<br/>".$_FILES['userfile']['name'][$count]." is not an allowed file type!<br/>"; //firstly, we check file type
				}
				else{
						if($totalsize+$_FILES['userfile']['size'][$count]>10000000){ //check size allowed
							echo "<br/>".$_FILES['userfile']['name'][$count]." not uploaded because total size of all files in a post must be less than 10MB<br/>";
							//secondly, check if total size of files is less than 10MB
						}
						else{
							$uniquetime=time();
							if(!isset($_GET['blogid'])){ //for attaching files to NEW POSTS
								$move=move_uploaded_file($_FILES['userfile']['tmp_name'][$count], 'blogfiles/'.$uniquetime.$_FILES['userfile']['name'][$count]);
								if($move){
									echo "<br/>".$_FILES['userfile']['name'][$count]." Successfully Uploaded";
									$totalsize=$totalsize+$_FILES['userfile']['size'][$count];
									if($count==0){
										mysql_query("UPDATE class_blog SET file1='http://connectedcampus.org/blogfiles/".$uniquetime.$_FILES['userfile']['name'][$count]."', filename1='".$_FILES['userfile']['name'][$count]."', filesize1=".$_FILES['userfile']['size'][$count]." WHERE uniqueid='".$uniqueid."'");
									}
									else if($count==1){
										mysql_query("UPDATE class_blog SET file2='http://connectedcampus.org/blogfiles/".$uniquetime.$_FILES['userfile']['name'][$count]."', filename2='".$_FILES['userfile']['name'][$count]."', filesize2=".$_FILES['userfile']['size'][$count]." WHERE uniqueid='".$uniqueid."'");
									}
									else if($count==2){
										mysql_query("UPDATE class_blog SET file3='http://connectedcampus.org/blogfiles/".$uniquetime.$_FILES['userfile']['name'][$count]."', filename3='".$_FILES['userfile']['name'][$count]."', filesize3=".$_FILES['userfile']['size'][$count]." WHERE uniqueid='".$uniqueid."'");
									}
									else echo "<br/>Error<br/>";
								}//ending if
							}//ending if
							else{
								if(emptyfilefield($blogid)==0){//no empty field
									echo "<br/>".$_FILES['userfile']['name'][$count]." not uploaded, because you already have 3 files attached to your post<br/>";
								}
								else{ //For attaching files to OLD POSTS OR posts which are being edited.
								$move=move_uploaded_file($_FILES['userfile']['tmp_name'][$count], 'blogfiles/'.$uniquetime.$_FILES['userfile']['name'][$count]);
								if($move){
									echo "<br/>".$_FILES['userfile']['name'][$count]." Successfully Uploaded";
									$totalsize=$totalsize+$_FILES['userfile']['size'][$count];
								if(emptyfilefield($blogid)==1){
										mysql_query("UPDATE class_blog SET file1='http://connectedcampus.org/blogfiles/".$uniquetime.$_FILES['userfile']['name'][$count]."', filename1='".$_FILES['userfile']['name'][$count]."', filesize1=".$_FILES['userfile']['size'][$count]." WHERE blogID=".$blogid);
									}
									else if(emptyfilefield($blogid)==2){
										mysql_query("UPDATE class_blog SET file2='http://connectedcampus.org/blogfiles/".$uniquetime.$_FILES['userfile']['name'][$count]."', filename2='".$_FILES['userfile']['name'][$count]."', filesize2=".$_FILES['userfile']['size'][$count]." WHERE blogID=".$blogid);
									}
									else if(emptyfilefield($blogid)==3){
										mysql_query("UPDATE class_blog SET file3='http://connectedcampus.org/blogfiles/".$uniquetime.$_FILES['userfile']['name'][$count]."', filename3='".$_FILES['userfile']['name'][$count]."', filesize3=".$_FILES['userfile']['size'][$count]." WHERE blogID=".$blogid);
									}
									else echo "<br/>Error<br/>";
									
								}
								}
							}
						}
				
					} //ending else
				$count=$count+1; // to move loop counter      
            }//ending while
	//echo $totalsize;
}//if for files ends
}//if for post ends
else{

?>
<div id="postformdiv">
<form name="blogeditform" method="post"  onsubmit="return postblogvalidate()" enctype="multipart/form-data" action="blog_post.php?classid=<? echo $classID; if($edit==1) echo "&blogid=".$blogid; ?>">
<!--form name="blogeditform" method="post" action="blogposttest.php"-->
Title: <input type="text" id="postname" name="postname" size="80" <? if($edit==1) echo "value='".$bloginfo['blogname']."'"; ?>/><br/><br/>
<textarea class="blogeditor" name="blogeditor"><? if($edit==1) echo stripslashes($bloginfo['blogmain']); ?></textarea>
<!--KEEP THE CODE FOR EDITOR BELOW THE TEXTAREA... Although window.onload() is used... It's better! :)-->
<script type="text/javascript">
				//replaces the textarea with the editor
			
				CKEDITOR.replace( 'blogeditor' );
</script>
<br/><br/>
<table border="0" style="margin-left:auto; margin-right:auto;">
  <tr>
    <td style="text-align:left;">Summary:</td>
    <td style="text-align:left;"><input type="text" id="postsummary" name="postsummary" size="80" <? if($edit==1) echo "value='".$bloginfo['summary']."'"; ?>/></td>
  </tr>
  <tr>
    <td style="text-align:left;">Source:</td>
    <td style="text-align:left;"><input type="text" id="postsource" name="postsource" size="80" <? if($edit==1) echo "value='".$bloginfo['source']."'"; ?>/></td>
  </tr>
</table>
<br/><br/>
<div style="width:50%; text-align:left; float:left; height:80px;">
<input name="userfile[]" type="file" class="multi" maxlength="3" accept="gif|jpg|png|bmp|tiff|tif|pdf|txt|rtf|rtx|doc|docx|ppt|pptx|xls|xlsx|dot|dotx|pot|potx|xlt|xltx|pps|ppsx|psd|mp4|ogg|avi|mov|mpeg|swf|wav|zip|mp3"/>
<!--FIlE extensions allowed. To use jQuery Multi file plugin to give the user a prompt before the server upload-->
</div>
<div style="width:50%; text-align:left; float:left;  height:80px;">
<? if($edit==1){ 
echo "<input type='hidden' id='bid' value=$blogid>";
echo "<input type='hidden' id='lid' value=$logid>";
if($bloginfo['file1']!=""){ ?>
<div id="file1div">
<img id="removefile1" style="cursor:pointer;" src="img/blog_cross.png"/>&nbsp;
<a target="_blank" href="<? echo $bloginfo['file1']; ?>"><img src="img/attach.png" height="18" width="18"/><? echo $bloginfo['filename1'];?></a>
<br/></div>
<? } ?>
<? if($bloginfo['file2']!=""){ ?>
<div id="file2div">
<img id="removefile2" style="cursor:pointer;" src="img/blog_cross.png"/>&nbsp;
<a target="_blank" href="<? echo $bloginfo['file2']; ?>"><img src="img/attach.png" height="18" width="18"/><? echo $bloginfo['filename2'];?></a>
<br/></div>
<? } ?>
<? if($bloginfo['file3']!=""){ ?>
<div id="file3div">
<img id="removefile3" style="cursor:pointer;" src="img/blog_cross.png"/>&nbsp;
<a target="_blank" href="<? echo $bloginfo['file3']; ?>"><img src="img/attach.png" height="18" width="18"/><? echo $bloginfo['filename3'];?></a>
<br/></div>
<? } 
}?>
</div>
<div style="clear:both;"></div>
<br/><br/>

<input style="cursor:pointer;" type="submit" name="blogpostsubmit" value="PUBLISH" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>

</form>
<br/><br/>
</div>
<? 
}//ending else
?>
<script type="text/javascript">
$(document).ready(function(){
	//TO HANDLE REMOVING OF FILES IN CASE OF EDIT POST
	$("#removefile1").click(function(){
		var agree=confirm("Are you sure you want to delete the post?");
		if (agree){
			$('#file1div').hide();
			var blog=$("#bid").val();
			var logid=$("#lid").val(); //on removing the file, it executes another file to delete it
			$.post("blogeditfile.php", {blogID:blog, File:1, logid:logid}); 
			return false;
		}
	});
	$("#removefile2").click(function(){
		var agree=confirm("Are you sure you want to delete the post?");
		if (agree){
			$('#file2div').hide();
			var blog=$("#bid").val();
			var logid=$("#lid").val(); //on removing the file, it executes another file to delete it
			$.post("blogeditfile.php", {blogID:blog, File:2, logid:logid}); 
			return false;
		}
	});
	$("#removefile3").click(function(){
		var agree=confirm("Are you sure you want to delete the post?");
		if (agree){
			$('#file3div').hide();
			var blog=$("#bid").val();
			var logid=$("#lid").val(); //on removing the file, it executes another file to delete it
			$.post("blogeditfile.php", {blogID:blog, File:3, logid:logid}); 
			return false;
		}
	});
});//end of $(document).ready()
</script>
</div>
</div>
</div>


<?php

include('html_bottom.php'); //including the botton footer

?>