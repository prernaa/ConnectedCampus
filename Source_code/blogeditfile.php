<?
//This file is used to delete files attached to the blog post.
//This file is run/executed when the writer of the post deletes files attached by clicking on the cross next to the files while editing the blog.
include "dbconnect.php";
$deletefile=$_POST['File']; //Whether the first, second or third file is deleted is sent through POST variable
$blogid=$_POST['blogID'];
$logid=$_POST['logid']; //double checks that it is the logged in user who has written the post & can thus edit it
$fileinfo=mysql_fetch_array(mysql_query("SELECT * FROM class_blog WHERE blogID=".$blogid." AND byuserid=".$logid));
if($deletefile==1){ 
	mysql_query("UPDATE `class_blog` SET `file1`=null,`filename1`=null,`filesize1`=null WHERE blogID=".$blogid." AND byuserid=".$logid);
	unlink(substr($fileinfo['file1'],27));
}
else if($deletefile==2){
	mysql_query("UPDATE `class_blog` SET `file2`=null,`filename2`=null,`filesize2`=null WHERE blogID=".$blogid." AND byuserid=".$logid);
	unlink(substr($fileinfo['file2'],27));
}
else if($deletefile==3){
	mysql_query("UPDATE `class_blog` SET `file3`=null,`filename3`=null,`filesize3`=null WHERE blogID=".$blogid." AND byuserid=".$logid);
	unlink(substr($fileinfo['file3'],27));
}
//in the above code we see that the appropriate file names are deleted from the database and the file is "unlinked" or deleted from the server


?>