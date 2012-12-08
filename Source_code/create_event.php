<?php			////////////////// Create_Event /////////////////
$auth=1;
include('includes.php');


if(isset($_GET['userid'])){
if(getNum("user_information", "userid", $_GET['userid'])==0){ // Check Get
		header('Location: http://connectedcampus.org/errorpage.php');
}
}

include('html_top.php');

$log=$_SESSION['email'];	///////////  User's Email ID /////////////

$logid=getID($log);		/////////// UserID ///////////////////////

if(isset($_GET['userid']))
{
	$user=$_GET['userid']; //Gives logged in user's email address
}
else {
	$user=$logid;
}

$userinfo=mysql_fetch_array(mysql_query("SELECT * FROM user_information where userid=".$user));
$user_name=$userinfo['name'];	// user name
$date=date("d/m/y"); 		// create date 
$time=date("H:i");		// time
$datetime=date("Y/m/d H:i:s"); 	// create date and time
?>

				
<script>
function fetch(output)
{
	$('#activities').html(output).show();
}
</script>

				<!-- //////////// Form Validation //////////// -->
<script type="text/javascript">
function validateLoginForm()
{
fetch("Event Created");
var x=document.forms["create_event_form"]["event_name"].value;
var y=document.forms["create_event_form"]["event_location"].value;
//var u=document.forms["create_event_form"]["event_time"].value;
var z=document.forms["create_event_form"]["hours"].value;
var w=document.forms["create_event_form"]["minutes"].value;
var year=document.forms["create_event_form"]["year"].value;
var month=document.forms["create_event_form"]["month"].value;
var day=document.forms["create_event_form"]["day"].value;
month--;
var de=new Date();
de.setDate(day);
de.setMonth(month);
de.setYear(year);
de.setHours(z);
de.setMinutes(w);
de.setSeconds(0);
//alert(de);
var dn=new Date();

				
if (x==null || x=="")
  {
  alert("Title must be filled out");
  return false;
  }
if (y==null || y=="")
  {
  alert("Location must be filled out");
  return false;
  }  
  
if (z==null || z=="")
  {
  alert("Please fill in a valid time");
  return false;
  }
if (z>24 || z<0)
  {
  alert("There are just 24 hours in a day!");
  return false;
  }
if (w==null || w=="")
  {
  
  alert("Please fill in a valid time");
  return false;
  }

			//////////////// Minutes Validation ////////////////
if (w>60 || w<0)
  {
  alert("There are 60 minutes in an hour!");
  return false;
  }
  
switch(month)
{
	case 1: if(year%4==0) { 
			if (day>29) { 
				alert("Please enter a valid date");
				return false;
			}
		}
		else {
			if(day>28) {
				alert("Please enter a valid date");
				return false;
			}
		}
		break;
	case 3:
	case 5:
	case 8:
	case 10: if(day>30) {
			alert ("Please enter a valid date");
			return false;
		 }
		 break;
}
	 

  			/////////////////// Creating Events in the Past is Disallowed ///////////
if (de<dn)
{
alert("You can't create an event in the past unless you have a TIME MACHINE!");
return false;
}
 
 return true;
}
</script>



<? 
if($classid!=0){
include "classheaderfinal.php";
}?>
<style type="text/css">
#class_contentbox{
margin-top:20px;
}
#cblog_wrap{
width:450px;
float:left;
}
.pblog_p{
width:700px;
background:#ffffff;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:15px;
float:left;

}
.pblog_r{
width:625px;
background:#ffffff;
margin-top:-20px;
margin-bottom:10px;
padding-left:85px;
padding-top:10px;
padding-right:10px;
padding-bottom:20px;
float:left;

}
.pblog_p2{
width:700px;
background:#fafafa;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:20px;
float:left;

}
.pblog_pm{
width:700px;
background:#ffffff;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:10px;
float:left;
font-size:18px;
font-family: 'Century Gothic', sans-serif;
}
.pblog_pm2{
width:700px;
background:#fafafa;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:10px;
float:left;
font-size:18px;
font-family: 'Century Gothic', sans-serif;
}
.bloghead{
    font-size: 20px;
	color: #1a1a1a;
	font-weight: normal;
	margin-top: -5px;
	margin-bottom: -10px;
	margin-right: 3px;
	font-family: 'Century Gothic', sans-serif;
}
.blogdesc{
    font-size: 10px;
	color: #7a7a7a;
	font-weight: normal;
	font-family: 'Century Gothic', sans-serif;
}
.crhead{
    font-size: 18px;
	color: #1a1a1a;
	font-weight: normal;
	margin-top: -5px;
	margin-bottom: -10px;
	margin-right: 3px;
	font-family: 'Century Gothic', sans-serif;
}
.space5{
	height:5px;
}
.space8{
	height:8px;
}
#cright_wrap{
	margin-left:25px;
	float:left;
	min-width:245px;
	max-width:245px;
	}
.blogtags{
	font-size: 12px;
	color: #7a7a7a;
	font-style:italic;
	word-spacing:3px;
	font-family: 'Century Gothic', sans-serif;
}
.c_box{
	max-width:240px;
	height:120px;
	background:#fafafa;
	padding:10px;
	margin-bottom:20px;
}
.c_box2{
	max-width:240px;
	height:120px;
	background:#ffffff;
	padding:10px;
	margin-bottom:20px;
}
#cimg_hold{
	float:left;
	width:70px;
	height:90px;
}
#cinst_hold{
	max-width:140px;
	float:left;
	margin-left:10px;
}
.cint_name{
	font-size: 15px;
	color: #1a1a1a;
	font-family: 'Century Gothic', sans-serif;
}
#cinst_ratings{
	background: #27d865;
	margin-left: -42px;
	width: 20px;
	padding: 2px 5px 2px 5px;
}
#cint_det{
	font-size:12px;
}
.ccbutton{
	
font-family: 'Century Gothic', sans-serif;
	background:#ffffff;
border: 1px solid #dadada;
outline:none;


}
.fsep{
border:0;
border-bottom: 1px dashed #dadada;	
margin-top:20px;
margin-bottom:3px;
}
.ftarea{
border: 1px solid #dadada;
	padding: 2px;
	width: 690px;
resize: none;
height:165px;
}
.aclass{
	margin-top:10px;
	margin-left:35px;
	margin-right:20px;
	border: 1px dashed #f0f0f0;
	padding:5px;
}
.aclass_hold{
	float:left;
}
.aclass_descr{
	float:left;
	padding-left:10px;
	font-size:12px;
	width:520px;
}
.ctitle{
font-size:20px
}
.psep{
border:0;
border-bottom: 1px dashed #dadada;	
margin-top:10px;
margin-bottom:10px;
}
.nothing{
padding-left:40px;
font-size:12px;
padding-top:10px;
padding-bottom:10px;}
.pimg_hold{
padding-left:40px;
padding-top:10px;
padding-bottom:10px;
word-spacing:10px;
}
.w_rightsub{
float:left;
font-size:12px;
}
.w_list{
float:left;
font-size:15px;
padding-top:4px;
margin-left:40px
}
.w_boxes{
float:left;
margin-left:25px;
}
.winput{
	border: 1px solid #dadada;
	padding: 2px;
	margin-top:5px;
	width: 510px;
}
.warea{
border: 1px solid #dadada;
	padding: 2px;
	width: 510px;
resize: none;
height:65px;
margin-top:-7px;
}
</style>

				<!-- ////////////// Creating New Event /////////////////  -->

<form action="event_created.php" method="get" id="create_event_form" onsubmit="return validateLoginForm()" >
<div class="pblog_pm">
<p>CREATE NEW EVENT</p>
<div class="space8"></div>

<div class="w_list">
<div style="height:10px;"></div>
TITLE <br/>
<div style="height:10px;"></div>
DETAILS <br/>
<div style="height:55px;"></div>
WHERE<br />

<div style="height:4px;"></div>
WHEN
<div style="height:4px;"></div>
INVITATION BY
</div>

			<!-- ///////////////// Inputting Event Name ///////////////// -->
<div class="w_boxes">
<input class="winput" type="text" id="event_name" title="event_name"  name="event_name"  style="margin-top:15px" Placeholder="eg. Photoshop Workshop" size="40" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"><br/>
<div class="space8"></div>
<div class="space8"></div>

			<!-- ///////////////// Inputting Event Description ///////////////// -->
<div style="margin-top:-3px; font-size:16px;">
<textarea name="event_details" rows="2" cols="36" placeholder="Add more info..." class="warea"  onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></textarea><br/>
<div style="height:1px;"></div>
			
			<!-- ///////////////// Inputting Event Location ///////////////// -->
<input class="winput" type="text" id="event_location" title="event_location"  name="event_location"  style="margin-top:4px" Placeholder="Add a place" size="40" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"><br/>

			<!-- ///////////////// Inputting Event Date ///////////////// -->
<div style="height:3px;"></div>
					<select name="day" >
					 	<? for ($i=1;$i<=31;$i++) { ?>
							<option value='<?echo $i?>'><?echo $i?></option>
						<? } ?>
						
					</select>
					<select name="month" >
					 	<? for ($i=1;$i<=12;$i++) { ?>
							<option value='<?echo $i?>'><?echo $i?></option>
						<? } ?>
						
					</select>
					<select name="year" >
					 	<? for ($i=2012;$i<=2022;$i++) { ?>
							<option value='<?echo $i?>'><?echo $i?></option>
						<? } ?>
						
					</select>
					
			<!-- ///////////////// Inputting Event Time ///////////////// -->
					<input style="margin-left:20px;" type="text" name="hours" placeholder="HH" size="1"/> :
					<input type="text" name="minutes" placeholder="MM" size="1"/>
<div style="height:5px;"></div>

			<!-- ///////////////// Input who can send Invites ///////////////// -->
<select name="privacy" style="width:145px;">
	<option value=0 style="width:30px;">Creator</option>
	<option value=1 style="width:30px;">Anyone</option>
</select>
<input type="hidden" name="user_id" value='<? echo $user ?>' /> 
<input type="hidden" name="date_time" value='<? echo  $datetime ?>' />
<div style="height:3px;"></div>
<div style="margin-left:370px"><input style="cursor:pointer;" type="submit" name="createwb" value="Create Now" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>
<a href="event_template.php" ><input style="cursor:pointer; margin-left:10px;" type="button" name="createwb" value="Cancel" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/></a></div>
</div>
</div>
</form>



















<!--<tr >
		<td style="font-weight:bold;"> When </td>
		<td>
			<table>
				<tr><td>
	  				<input type="text" name="event_date" size=17 placeholder="YY/MM/DD" /></td>
			            <td><input type="text" name="event_time" size=16 placeholder="HH:MM"  /></td></tr>
			</table>    
		</td>
	</tr>-->