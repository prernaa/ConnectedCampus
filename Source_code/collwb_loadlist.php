<? include "dbconnect.php";
$GrpID=$_POST['GrpID']; //id of the whiteboard group
$LogID=$_POST['LogID']; //id of the logged in user
$query=mysql_query("SELECT * FROM collwb_archive WHERE GroupID=".$GrpID); //Fetches all saved whiteboards for that particular whiteboard group
if(!mysql_num_rows($query)) echo "No saved whiteboards"; 
else {
	echo "<select id='wbselect' name='wbselectname' size='1'>"; //displays all the saved whiteboard of that whiteboard group as a drop-down
	while($archive=mysql_fetch_array($query)) {?>
   <option value="<? echo $archive['archID']; ?>"><? echo $archive['archname']; ?></option>
<? }//end of while
echo "</select>";
}//end of else ?>
