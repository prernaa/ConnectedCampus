<?
include "dbconnect.php"; //Connect to the Database
$GrpID=$_POST['GrpID']; //id of the whiteboard group
$LogID=$_POST['LogID']; //userid of the logged in user or user who is doing the delete
$query=mysql_query("SELECT Mode FROM collwb_groupmembers WHERE GroupID=".$GrpID." AND userid=".$LogID); //Fetches which mode the user is in
$currentmode=mysql_fetch_array($query);
?>
<!--A hidden textbox containing which mode the user is in... when textbox value switches then the divs will switch too from write to view & vice-versa according to the mode in this textbox-->
<input type="hidden" id="currentmode" value="<? echo $currentmode[0]; ?>"/>
