<style type="text/css">
.ccbutton{
	
font-family: 'Century Gothic', sans-serif;
	background:#ffffff;
border: 1px solid #dadada;
outline:none;
cursor:pointer;
font-size:16px;
font-weight:bold;
padding:5px;
}
</style>
<? 
include "dbconnect.php"; //Connect to the database
function getNamewID($id){ // Returns name given userid
$getQuery = mysql_query("SELECT * FROM user_information WHERE userid='".$id."'");
$name = mysql_fetch_array($getQuery);
return $name['name'];
}
$LogID=$_GET['LogID']; //userid of the logged in user
$GrpID=$_GET['GrpID']; //id of the whiteboard group
$sql="SELECT SUM(Mode) FROM collwb_groupmembers WHERE GroupID=$GrpID"; //sum of modes will be 0 when no one is in the write mode as view mode is 0 & write mode is 1
$modecheck=mysql_fetch_array(mysql_query($sql)); ?>
<div style="width:800px; text-align:center; font-weight:bold;">
<?
if(!$modecheck[0]) { //"write now" button is only displayed when no one is writing
	echo "<input class=\"ccbutton\" type=\"button\" id=\"writenow\" value=\"Write Now\" onMouseDown=\"this.style.border='1px solid #f4d040'\" onMouseUp=\"this.style.border='1px solid #dadada'\"/>";
}
else { //if one of the group members is writing, the name of the person who is writing is displayed-->
	$query=mysql_query("SELECT userid FROM collwb_groupmembers WHERE GroupID=$GrpID AND Mode=1");
	$writeid=mysql_fetch_array($query);
	echo getNamewID($writeid[0])." is writing now...";
}
?>
</div>
<input type="hidden" id="grpid" value="<? echo $GrpID; ?>" />
<input type="hidden" id="logid" value="<? echo $LogID; ?>" />
<script type="text/javascript">
$("#writenow").click(function() { //wbwritenow.php is "run"/posted to as soon as "write now" button is pressed
	var grp=$("#grpid").val();
	var login=$("#logid").val();
	$.post("wbwritenow.php", {LogID: login, GrpID:grp }); 
	return false;
});
</script>