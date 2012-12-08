<? include "dbconnect.php"; //Connect to the database
$GrpID=$_POST['GrpID']; //id of the whiteboard group
$LogID=$_POST['LogID']; //userid of the logged in user or user who is saving the whiteboard
$WBname=$_POST['WBname']; //name to save the whiteboard with...as given by the user
$SaveArray=$_POST['SaveArray']; //the array of coordinates to save
$sql="SELECT * FROM collwb_archive WHERE archname='".$WBname."' AND GroupID=".$GrpID; 
if(mysql_num_rows(mysql_query($sql))) {
	echo "<script type='text/javascript'>alert('Name already exists. Choose Another!')</script>"; //Error if that name already exists in that particular whiteboard group
}
else {
	mysql_query("INSERT INTO collwb_archive VALUES ('', '".$WBname."', ".$LogID.", ".$GrpID.", '".$SaveArray."')"); 
	//inserting it into the collwb_archive table in the database
	echo "<script type='text/javascript'>alert('Whiteboard ".$WBname." successfully saved!')</script>";
}
?>
