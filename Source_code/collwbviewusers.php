<? 
include "dbconnect.php"; //Connect to the database
function getNamewID($id){ // Returns name given userid
$getQuery = mysql_query("SELECT * FROM user_information WHERE userid='".$id."'");
$name = mysql_fetch_array($getQuery);
return $name['name'];
}
$GrpID=$_GET['GrpID']; //id of the whiteboard group
$query=mysql_query("SELECT userid FROM collwb_groupmembers WHERE GroupID=$GrpID AND Activity=1"); //Fetches userids of users who are currently active on the whiteboard
?>
<table border="0">
  <tr>
    <th scope="col">Active Members</th>
  </tr>
<? while($activeid=mysql_fetch_array($query)) { ?>
  <tr>
    <td><? echo getNamewID($activeid['userid']); //The name of the active members are displayed?></td>
  </tr>
<? } //closing while ?>
</table>
