<?php
$auth=1;
include('includes.php');
if(isset($_GET['userid'])){
if(getNum("user_information", "userid", $_GET['userid'])==0){ // Check Get
		header('Location: http://connectedcampus.org/errorpage.php');
}
}

include('html_top.php');
$log=$_SESSION['email'];
$logid=getID($log);
$todays_date=date("y-m-d");
$today=strtotime($todays_date);
$tomorrow=strtotime('+1 day',$today);
$later_this_week=strtotime('next sunday',$today);
if(isset($_GET['userid']))
{
	$user=$_GET['userid']; //Gives logged in user's email address
}
else {
	$user=$logid;
}
$userinfo=mysql_fetch_array(mysql_query("SELECT * FROM user_information where userid=".$user));
?>


<div id="topHead" >
	<table>
		<tr>
			<td><img src="calendar.png" alt="Calendar" height="15" width="15"/> </td>
			<td style="font-size:15px"><b>Events</b></td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td align="right"><a href="create_event.php" ><input type="button" value=" + Create Event " Name="Create Event" /> </a></td>
		</tr>
	</table>
</div>
<br/>
<hr width="488px"/>
<div id="Today">
	
	<div style="background:#DDDDDD; font-weight:bold; width:490px">
			Today
	</div>
	<br/>
	<table>
		<?
			$sql1="SELECT * FROM eventsinterface ORDER BY dateofevent";
			$result1=mysql_query($sql1);
			
			while($rows1=mysql_fetch_array($result1))
			{
				$events_date=$rows1['dateofevent'];
				$event=strtotime($events_date);
				if($event==$today)
				{
		?>
		<tr> 
			
			<td style="color:#0000BB; font-weight:bold">
				<a style="color:#0000BB;" href="event_page.php?id=<? echo $rows1['eventid'];?>"> <? echo $rows1['Event_Name']; ?></a>
			</td>
			
		</tr>
		<tr>
			<td style="font-size:11px"><? echo $rows1['venue']; ?></td>
		</tr>
		<tr>
			<td style="font-size:11px"><? echo date("d-M-Y",$event); ?></td>
		</tr>
		<tr>
			<td style="font-size:11px"><? echo date("h:i A",strtotime($rows1['timeofevent'])); ?></td>
		</tr>
		<tr><td><br/></td></tr>
		<tr>
			<? 
			$sql6="SELECT * FROM events_invitees WHERE userid=".$user." AND eventid=".$rows1['eventid'];
			$result6=mysql_query($sql6);
			$rows6=mysql_fetch_array($result6);
			//echo $rows6['status'];
			if ($rows6['status']=="1") {
			?>
				<td id="today-attend" style="font-size:10px">You are attending this event | <a href="event_attendance.php?status=2&set=1&id=<? echo $rows1['eventid'];?>">Maybe</a> | <a href="event_attendance.php?status=0&set=1&id=<? echo $rows1['eventid'];?>" >Not Attending </a></td>			
			<? }
			else if ($rows6['status']=="0") {
			?>
				<td id="today-attend" style="font-size:10px">You are not attending this event | <a href="event_attendance.php?status=1&set=1&id=<? echo $rows1['eventid'];?>"> Attending </a> | <a href="event_attendance.php?status=2&set=1&id=<? echo $rows1['eventid'];?>">Maybe</a></td>
			<? }
			else if ($rows6['status']=="2") {
			?>
				<td id="today-attend" style="font-size:10px"><a href="event_attendance.php?status=1&set=1&id=<? echo $rows1['eventid'];?>"> Attending </a> | <a href="event_attendance.php?status=0&set=1&id=<? echo $rows1['eventid'];?>" >Not Attending </a></td>
			<? }
			else {
			?>	
				<td id="today-attend" style="font-size:10px"><a href="event_attendance.php?status=1&set=0&id=<? echo $rows1['eventid'];?>"> Attending </a> | <a href="event_attendance.php?status=2&set=0&id=<? echo $rows1['eventid'];?>">Maybe</a> | <a href="event_attendance.php?status=0&set=0&id=<? echo $rows1['eventid'];?>" >Not Attending </a></td>
			<? } ?>	
			
		</tr>
		<tr><td><br/></td></tr>
		<?
			 	}
			 	
			 }
		?>
	</table>
</div>

<br/>
<hr width="488px"/>
<div id="Tomorrow">
	<div style="background:#DDDDDD; font-weight:bold; width:490px">
			Tomorrow	
	</div>
	<br/>
	<table>
		
		<?
			$sql2="SELECT * FROM eventsinterface ORDER BY dateofevent";
			$result2=mysql_query($sql2);
			
			while($rows2=mysql_fetch_array($result2))
			{
				$events_date=$rows2['dateofevent'];
				$event=strtotime($events_date);
				if($event==$tomorrow)
				{
		?>
		<tr> 
			<td style="color:#0000BB; font-weight:bold">
				<a style="color:#0000BB;" href="event_page.php?id=<? echo $rows2['eventid'];?>"> <? echo $rows2['Event_Name']; ?></a>
			</td>
		</tr>
		<tr>
			<td style="font-size:11px"><? echo $rows2['venue']; ?></td>
		</tr>
		<tr>
			<td style="font-size:11px"><? echo date("d-M-Y",$event); ?></td>
		</tr>
		<tr>
			<td style="font-size:11px"><? echo date("h:i A",strtotime($rows2['timeofevent'])); ?></td>
		</tr>
		<tr><td><br/></td></tr>
		<tr>
			<? 
			$sql4="SELECT * FROM events_invitees WHERE userid=".$user." AND eventid=".$rows2['eventid'];
			$result4=mysql_query($sql4);
			$rows4=mysql_fetch_array($result4);
			//echo $rows4['status'];
			if ($rows4['status']=="1") {
			?>
				<td id="today-attend" style="font-size:10px">You are attending this event | <a href="event_attendance.php?status=2&set=1&id=<? echo $rows2['eventid'];?>">Maybe</a> | <a href="event_attendance.php?status=0&set=1&id=<? echo $rows2['eventid'];?>" >Not Attending </a></td>			
			<? }
			else if ($rows4['status']=="0") {
			?>
				<td id="today-attend" style="font-size:10px">You are not attending this event | <a href="event_attendance.php?status=1&set=1&id=<? echo $rows2['eventid'];?>"> Attending </a> | <a href="event_attendance.php?status=2&set=1&id=<? echo $rows2['eventid'];?>">Maybe</a></td>
			<? }
			else if ($rows4['status']=="2") { 
			?>
				<td id="today-attend" style="font-size:10px"><a href="event_attendance.php?status=1&set=1&id=<? echo $rows2['eventid'];?>"> Attending </a> | <a href="event_attendance.php?status=0&set=1&id=<? echo $rows2['eventid'];?>" >Not Attending </a></td>
			<? }
			else {
			?>	
				<td id="today-attend" style="font-size:10px"><a href="event_attendance.php?status=1&set=0&id=<? echo $rows2['eventid'];?>"> Attending </a> | <a href="event_attendance.php?status=2&set=0&id=<? echo $rows2['eventid'];?>">Maybe</a> | <a href="event_attendance.php?status=0&set=0&id=<? echo $rows2['eventid'];?>" >Not Attending </a></td>
			<? } ?>	
		</tr>
		<tr><td><br/></td></tr>
		<?
			 	}
			 	
			 }
		?>
	</table>
</div>

<br/>

<hr width="488px"/>
<div id="later_this_week">
	<div style="background:#DDDDDD; font-weight:bold; width:490px">
			Later This Week	
	</div>	
	<br/>
	<table>
		
		<?
			$sql3="SELECT * FROM eventsinterface ORDER BY dateofevent";
			$result3=mysql_query($sql3);
			
			while($rows3=mysql_fetch_array($result3))
			{
				$events_date=$rows3['dateofevent'];
				$event=strtotime($events_date);
				if($event>$tomorrow && $event<=$later_this_week)
				{
		?>
		<tr> 
			
			<td style="color:#0000BB; font-weight:bold">
				<a style="color:#0000BB;" href="event_page.php?id=<? echo $rows3['eventid'];?>"> <? echo $rows3['Event_Name']; ?></a>
			</td>
			
		</tr>
		<tr>
			<td style="font-size:11px"><? echo $rows3['venue']; ?></td>
		</tr>
		<tr>
			<td style="font-size:11px"><? echo date("d-M-Y",$event); ?></td>
		</tr>
		<tr>
			<td style="font-size:11px"><? echo date("h:i A",strtotime($rows3['timeofevent'])); ?></td>
		</tr>
		<tr><td><br/></td></tr>
		<tr>
			<? 
			$sql5="SELECT * FROM events_invitees WHERE userid=".$user." AND eventid=".$rows3['eventid'];
			$result5=mysql_query($sql5);
			$rows5=mysql_fetch_array($result5);
			//echo $rows5['status'];
			if ($rows5['status']=="1") {
			?>
				<td  style="font-size:10px">You are attending this event | <a href="event_attendance.php?status=2&set=1&id=<? echo $rows3['eventid'];?>">Maybe</a> | <a href="event_attendance.php?status=0&set=1&id=<? echo $rows3['eventid'];?>" >Not Attending </a></td>			
			<? }
			else if ($rows5['status']=="0") {
			?>
				<td  style="font-size:10px">You are not attending this event | <a href="event_attendance.php?status=1&set=1&id=<? echo $rows3['eventid'];?>"> Attending </a> | <a href="event_attendance.php?status=2&set=1&id=<? echo $rows3['eventid'];?>">Maybe</a></td>
			<? }
			else if ($rows5['status']=="2") {
			?>
				<td  style="font-size:10px"><a href="event_attendance.php?status=1&set=1&id=<? echo $rows3['eventid'];?>"> Attending </a> | <a href="event_attendance.php?status=0&set=1&id=<? echo $rows3['eventid'];?>" >Not Attending </a></td>
			<? }
			else {
			?>	
				<td  style="font-size:10px"><a href="event_attendance.php?status=1&set=0&id=<? echo $rows3['eventid'];?>"> Attending </a> | <a href="event_attendance.php?status=2&set=0&id=<? echo $rows3['eventid'];?>">Maybe</a> | <a href="event_attendance.php?status=0&set=0&id=<? echo $rows3['eventid'];?>" >Not Attending </a></td>
			<? } ?>	
		</tr>
		<tr><td><br/></td></tr>
		<?
			 	}
			 	
			 }
		?>
	</table>
</div>
<?php
include('html_bottom.php');
?>