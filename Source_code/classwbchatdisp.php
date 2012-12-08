<style type="text/css">
.tdr {
	width:240px;
	white-space: pre-wrap;/* css-3 */
	white-space: -moz-pre-wrap;/* Mozilla, since 1999 */
	white-space: -pre-wrap; /* Opera 4-6 */
	white-space: -o-pre-wrap; /* Opera 7 */
	word-wrap: break-word; /* Internet Explorer 5.5+ */
	/*white-space: normal;*/
}
.wrapdiv {
	width:240px;
	word-wrap:break-word;
}

.tdl {
	width:150px;
	font-weight:bold;
}
</style>
<?
include "dbconnect.php"; //Connect to the Database
function getNamewID($id){ // Returns name given userid
$getQuery = mysql_query("SELECT * FROM user_information WHERE userid='".$id."'");
$name = mysql_fetch_array($getQuery);
return $name['name'];
}

//CODE TO DIAPLAY CHAT MESSAGES IN THE "chatbox" DIV
$GrpID=$_GET['GrpID'];
$query=mysql_query("SELECT * FROM classwb_chat WHERE GroupID='".$GrpID."' ORDER BY 4");
echo "<table border=0 class='chattbl'>";
if (mysql_num_rows($query)==0){ ?>
	<tr><td>NO CHAT MESSAGES YET</td></tr>
<?
}//closing if
else {
while($chatdisp=mysql_fetch_array($query)){ //Looping rows to display chat messages written by members of that wb group
$datesplit=explode(' ', $chatdisp['StoreTime']);

?>
<!-- DISPLAYING CHAT MESSAGES -->
  <tr class="trt">
    <td class="tdl"><? echo getNamewID($chatdisp['ByUserID']); ?>:<!--<br/>--><? //echo $datesplit[0]; ?></td>
    <td class="tdr"><div class="wrapdiv"><? echo $chatdisp['Msg']; ?></div></td>
  </tr>
<?php } //closing while
}//closing else
echo "</table>";
?>
