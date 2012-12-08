<? 
include "dbconnect.php"; //Connect to the database
$GrpID=$_GET['GrpID']; //id of the whiteboard group
$sql="SELECT eventarray FROM collwb_event WHERE GroupID=$GrpID AND Activewb=1"; //fetches the array of coordinates of the active whiteboard
$eventget=mysql_fetch_array(mysql_query($sql));
?>
<canvas id="WBview" height="250" width="600">
<!--Displays the canvas in the view mode-->
    Sorry, your browser does not support the whiteboard. You must download the latest version.
    <a href="http://download.cnet.com/Google-Chrome/3000-2356_4-10881381.html" target="_blank">Click to Download Google Chrome </a>
</canvas>
<!--There is a hidden textbox in which the coordinates of the active whiteboard are inserted & updated from time to time-->
<form action="" name="DBretrieve">
<input id="eventout" type="hidden" name="eventout" size="115" value="<? echo $eventget[0];?>">
</form>
<script type="text/javascript" src="wbviewdraw.js"></script><!-- The script which causes things to be drawn on the whiteboard-->
