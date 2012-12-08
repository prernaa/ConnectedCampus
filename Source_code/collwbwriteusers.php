<?
include "dbconnect.php"; //Connect to the database
function getNamewID($id){ // Returns name given userid
$getQuery = mysql_query("SELECT * FROM user_information WHERE userid='".$id."'");
$name = mysql_fetch_array($getQuery);
return $name['name'];
}
$GrpID=$_GET['GrpID']; //id of the whiteboard group
$LogID=$_GET['LogID']; //userid of the logged in user or user who is saving the whiteboard
?>
<table border="0">
  <tr>
    <th scope="col">Pass Pen To:-</th>
  </tr>
<? //display all group members who are active on the whiteboard excep the viewer himself
$query=mysql_query("SELECT userid FROM collwb_groupmembers WHERE GroupID=".$GrpID." AND Activity=1 AND userid<>$LogID"); 
if(!mysql_num_rows($query)) {
	echo "<tr><td>None online</td></tr>";
}
else {
	echo "<form action='' name='passform'>";
	while($memberid=mysql_fetch_array($query)) {
?>
  <tr><!--display radio buttons beside each user to give an option to the writer to pass the pen to someone else-->
    <td><input type="radio" name="passtouser" value="<? echo $memberid['userid']; ?>" /><? echo getNamewID($memberid['userid']); ?></td>
  </tr>
<? }//end of while
echo "<tr><td><input type=\"submit\" id=\"passbutton\" value=\"Pass\"/></td></tr>";
echo "</form>";
} //end of if ?>
</table>
<input type="hidden" id="GrpID" value="<? echo $GrpID; ?>"/>
<script type="text/javascript">
$(document).ready(function(){
	$("#passbutton").click(function(){  //as soon as the passbutton is pressed, this function posts to passuserpost.php which causes the logged in user to go to view mode and the user chosen here to go into write mode
		var GrpID=$("#GrpID").val();
		var nextuser=$("input:radio[name=passtouser]").val(); //Stores user input in a variable called 'usertext'
		$.post("passuserpost.php", {passtouser:nextuser, grpid:GrpID}); //send a post request to 'post.php' & 'usertext' is posted as 'text' & 'proj' is posted as 'projid'
		return false;
	});
});

</script>