<?
include "dbconnect.php"; //Connect to the database
$groupid=$_POST['GrpID']; //id of the whiteboard group
$archid=$_POST['archid']; //id of whiteboard to be deleted
$logid=$_POST['LogID']; //userid of the logged in user or user who is doing the delete
//only the creator or the person who has saved the whiteboard can delete it
function checkadmin($log, $grp) { //checks if the logged is the creator of the class or not
	$sql="SELECT * FROM collwb_groupadmin WHERE GroupID=".$grp." AND userid=".$log;
	if(!mysql_num_rows(mysql_query($sql))) {
		return 0; //not an admin
	}
	else {
		return 1; //is an admin
	}
}
function checksavedby($log, $arch) { //check if the whiteboard the logged in user is attempting to delete was saved by him as well
	$sql="SELECT * FROM collwb_archive WHERE savedby=".$log." AND archID=".$arch;
		if(!mysql_num_rows(mysql_query($sql))) {
		return 0; //not an admin
	}
	else {
		return 1; //is an admin
	}
}
if (checkadmin($logid, $groupid) || checksavedby($logid, $archid)) { //if user has either saved the chosen wb himself OR he is the admin of the group, then only the whiteboard will be deleted
	$sql="DELETE FROM collwb_archive WHERE archID=".$archid;
	mysql_query($sql);
	echo "<script type='text/javascript'>alert('Delete Successful!'); </script>";
}
else {//else, an alert will be shown to the user telling him that he is not authorized to delete it
	echo "<script type='text/javascript'>alert('Sorry, you are not authorized to delete it!');</script>";
}
?>
