<?php

$auth=1; //user must be logged in to view this page 

include('includes.php');

include('html_top.php');

				///////////////// Checking if User ID is Set ///////////////
if(isset($_GET['userid'])){
if(getNum("user_information", "userid", $_GET['userid'])==0){ // Check Get
		header('Location: http://connectedcampus.org/errorpage.php');
	}
}

$log=$_SESSION['email'];
$logid=getID($log);

				
$todays_date=date("y-m-d");		// Today's date in date time format
$today=strtotime($todays_date);		// Today's date in TimeStamp format
$tomorrow=strtotime('+1 day',$today);   // Tomorrow's date in TimeStamp format
$later_this_week=strtotime('next sunday',$today);	// Week after tomorrow Until Sunday


if(isset($_GET['userid']))
{
	$user=$_GET['userid']; //Gives logged in user's email address
}
else {
	$user=$logid;
}
$userinfo=mysql_fetch_array(mysql_query("SELECT * FROM user_information where userid=".$user));

?>


<style type="text/css">
#pbox{
	width:720px;
	height:110px;
	background: #ffffff;
	border: 1px solid #fdfdfd;
	font-family: 'Century Gothic', sans-serif;
}
#pbox_img_hold{
	float:left;
	padding:5px;
}
#pdes_hold{
	float:left;
	padding:10px;
	width:450px;
}
#pdescription{

	font-size: 12px;

}
h5{
	font-family: 'Century Gothic', sans-serif;
    font-size: 25px;
	color: #1a1a1a;
	font-weight: normal;
	margin-top: -5px;
	margin-bottom: -10px;
}
#pnav_bar{
	float:right;
	padding-top:0px;
	margin-right:-130px;
}
.class_nav_btn{
	background:#f7f7f7;
	height:15px;
	padding:5px 20px 5px 20px;
	float:right;
	margin-left:10px;
	border: 1px solid #ffffff;
}
</style>
<style type="text/css">
#event_contentbox{
margin-top:-5px;
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
	width:515px;
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
padding-top:8px;
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
height:165px;
margin-top:-7px;
}
</style>
<style type="text/css">
div.jqi{ 
	width: 400px; 
	/*font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; */
	position: absolute; 
	background-color: #000000;
	opacity:0.8;
	filter:alpha(opacity=80);
	font-size: 11px; 
	text-align: left; 
	border: solid 1px #eeeeee;
	border-radius: 10px;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	padding: 7px;
}
div.jqi .jqicontainer{ 
	font-weight: bold; 
}
div.jqi .jqiclose{ 
	position: absolute;
	top: 4px; right: -2px; 
	width: 18px; 
	cursor: default; 
	color: #bbbbbb; 
	font-weight: bold; 
}
div.jqi .jqimessage{ 
	padding: 10px; 
	line-height: 20px; 
	/*color: #444444; */
	color:#f0f0f0;
}
div.jqi .jqibuttons{ 
	text-align: right; 
	padding: 5px 0 5px 0; 
	border: solid 1px #eeeeee; 
	background-color: #f4f4f4;
}
div.jqi button{ 
	padding: 3px 10px; 
	margin: 0 10px; 
	background-color: #2F6073; 
	border: solid 1px #f4f4f4; 
	color: #ffffff; 
	font-weight: bold; 
	font-size: 12px; 
}
div.jqi button:hover{ 
	background-color: #728A8C;
}
div.jqi button.jqidefaultbutton{
	background-color: #BF5E26;
}
.jqiwarning .jqi .jqibuttons{ 
	background-color: #BF5E26;
}

.jqi .jqiarrow{ position: absolute; height: 0; width:0; line-height: 0; font-size: 0; border: solid 10px transparent;}

.jqi .jqiarrowtl{ left: 10px; top: -20px; border-bottom-color: #000000; }
.jqi .jqiarrowtc{ left: 50%; top: -20px; border-bottom-color: #000000; margin-left: -10px; }
.jqi .jqiarrowtr{ right: 10px; top: -20px; border-bottom-color: #000000; }

.jqi .jqiarrowbl{ left: 10px; bottom: -20px; border-top-color: #000000; }
.jqi .jqiarrowbc{ left: 50%; bottom: -20px; border-top-color: #000000; margin-left: -10px; }
.jqi .jqiarrowbr{ right: 10px; bottom: -20px; border-top-color: #000000; }

.jqi .jqiarrowlt{ left: -20px; top: 10px; border-right-color: #000000; }
.jqi .jqiarrowlm{ left: -20px; top: 50%; border-right-color: #000000; margin-top: -10px; }
.jqi .jqiarrowlb{ left: -20px; bottom: 10px; border-right-color: #000000; }

.jqi .jqiarrowrt{ right: -20px; top: 10px; border-left-color: #000000; }
.jqi .jqiarrowrm{ right: -20px; top: 50%; border-left-color: #000000; margin-top: -10px; }
.jqi .jqiarrowrb{ right: -20px; bottom: 10px; border-left-color: #000000; }

/*
------------------------------
	impromptu
------------------------------
*/
.impromptuwarning .impromptu{ background-color: #aaaaaa; }
.impromptufade{
	position: absolute;
	background-color: #000000;
}
div.impromptu{
    position: absolute;
	background-color: #cccccc;
	padding: 10px; 
	width: 300px;
	text-align: left;
}
div.impromptu .impromptuclose{
    float: right;
    margin: -35px -10px 0 0;
    cursor: pointer;
    color: #213e80;
}
div.impromptu .impromptucontainer{
	background-color: #213e80;
	padding: 5px; 
	color: #000000;
	font-weight: bold;
}
div.impromptu .impromptumessage{
	background-color: #415ea0;
	padding: 10px;
}
div.impromptu .impromptubuttons{
	text-align: center;
	padding: 5px 0 0 0;
}
div.impromptu button{
	padding: 3px 10px 3px 10px;
	margin: 0 10px;
}

/*
------------------------------
	columns ex
------------------------------
*/
.colsJqifadewarning .colsJqi{ background-color: #b0be96; }
.colsJqifade{
	position: absolute;
	background-color: #ffffff;
}
div.colsJqi{
    position: absolute;
	background-color: #d0dEb6;
	padding: 10px; 
	width: 400px;
	text-align: left;
}
div.colsJqi .colsJqiclose{
    float: right;
    margin: -35px -10px 0 0;
    cursor: pointer;
    color: #bbbbbb;
}
div.colsJqi .colsJqicontainer{
	background-color: #e0eEc6;
	padding: 5px; 
	color: #ffffff;
	font-weight: bold;
	height: 160px;
}
div.colsJqi .colsJqimessage{
	background-color: #c0cEa6;
	padding: 10px;
	width: 280px;
	height: 140px;
	float: left;
}
div.colsJqi .jqibuttons{
	text-align: center;
	padding: 5px 0 0 0;
}
div.colsJqi button{
	background: url(../images/button_bg.jpg) top left repeat-x #ffffff;
	border: solid #777777 1px;
	font-size: 12px;
	padding: 3px 10px 3px 10px;
	margin: 5px 5px 5px 10px;
	width: 75px;
}
div.colsJqi button:hover{
	border: solid #aaaaaa 1px;
}

/*
------------------------------
	brown theme
------------------------------
*/
.brownJqiwarning .brownJqi{ background-color: #cccccc; }
.brownJqifade{
	position: absolute;
	background-color: #ffffff;
}
div.brownJqi{
	position: absolute;
	background-color: transparent;
	padding: 10px;
	width: 300px;
	text-align: left;
}
div.brownJqi .brownJqiclose{
    float: right;
    margin: -20px 0 0 0;
    cursor: pointer;
    color: #777777;
    font-size: 11px;
}
div.brownJqi .brownJqicontainer{
	position: relative;
	background-color: transparent;
	border: solid 1px #5F5D5A;
	color: #ffffff;
	font-weight: bold;
}
div.brownJqi .brownJqimessage{
	position: relative;
	background-color: #F7F6F2;
	border-top: solid 1px #C6B8AE;
	border-bottom: solid 1px #C6B8AE;
}
div.brownJqi .brownJqimessage h3{
	background: url(../images/brown_theme_gradient.jpg) top left repeat-x #ffffff;
	margin: 0;
	padding: 7px 0 7px 15px;
	color: #4D4A47;
}
div.brownJqi .brownJqimessage p{
	padding: 10px;
	color: #777777;
}
div.brownJqi .brownJqimessage img.helpImg{
	position: absolute;
	bottom: -25px;
	left: 10px;
}
div.brownJqi .brownJqibuttons{
	text-align: right;
}
div.brownJqi button{
	background: url(../images/brown_theme_gradient.jpg) top left repeat-x #ffffff;
	border: solid #777777 1px;
	font-size: 12px;
	padding: 3px 10px 3px 10px;
	margin: 5px 5px 5px 10px;
}
div.brownJqi button:hover{
	border: solid #aaaaaa 1px;
}

/*
*------------------------
*   clean blue ex
*------------------------
*/
.cleanbluewarning .cleanblue{ background-color: #acb4c4; }`
.cleanbluefade{ position: absolute; background-color: #aaaaaa; }
div.cleanblue{ font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; position: absolute; background-color: #ffffff; width: 300px; font-size: 11px; text-align: left; border: solid 1px #213e80; }
div.cleanblue .cleanbluecontainer{ background-color: #ffffff; border-top: solid 14px #213e80; padding: 5px; font-weight: bold; }
div.cleanblue .cleanblueclose{ float: right; width: 18px; cursor: default; margin: -19px -12px 0 0; color: #ffffff; font-weight: bold; }
div.cleanblue .cleanbluemessage{ padding: 10px; line-height: 20px; font-size: 11px; color: #333333; }
div.cleanblue .cleanbluebuttons{ text-align: right; padding: 5px 0 5px 0; border: solid 1px #eeeeee; background-color: #f4f4f4; }
div.cleanblue button{ padding: 3px 10px; margin: 0 10px; background-color: #314e90; border: solid 1px #f4f4f4; color: #ffffff; font-weight: bold; font-size: 12px; }
div.cleanblue button:hover{ border: solid 1px #d4d4d4; }

/*
*------------------------
*   Ext Blue Ex
*------------------------
*/
.extbluewarning .extblue{ border:1px red solid; }
.extbluefade{ position: absolute; background-color: #ffffff; }
div.extblue{ border:1px #6289B6 solid; position: absolute; background-color: #CAD8EA; padding: 0; width: 300px; text-align: left; }
div.extblue .extblueclose{ background-color: #CAD8EA; margin:2px -2px 0 0; cursor: pointer; color: red; text-align: right; }
div.extblue .extbluecontainer{ background-color: #CAD8EA; padding: 0 5px 5px 5px; color: #000000; font:normal 11px Verdana; }
div.extblue .extbluemessage{ background-color: #CAD8EA; padding: 0; margin:0 15px 15px 15px; }
div.extblue .extbluebuttons{ text-align: center; padding: 0px 0 0 0; }
div.extblue button{ padding: 1px 4px; margin: 0 10px; background-color:#cccccc; font-weight:normal; font-family:Verdana; font-size:10px; }

/*
*------------------------
*   smooth Ex
*------------------------
*/
.jqismoothfade{ position: absolute; background-color: #333333; }
div.jqismooth{ width: 350px; font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; position: absolute; background-color: #ffffff; font-size: 11px; text-align: left; border: solid 3px #e2e8e6; -moz-border-radius: 10px; -webkit-border-radius: 10px; padding: 7px; }
div.jqismooth .jqismoothcontainer{ font-weight: bold; }
div.jqismooth .jqismoothclose{ position: absolute; top: 0; right: 0; width: 18px; cursor: default; text-align: center; padding: 2px 0 4px 0; color: #727876; font-weight: bold; background-color: #e2e8e6; -moz-border-radius-bottomLeft: 5px; -webkit-border-bottom-left-radius: 5px; border-left: solid 1px #e2e8e6; border-bottom: solid 1px #e2e8e6;  }
div.jqismooth .jqismoothmessage{ padding: 10px; line-height: 20px; color: #444444; }
div.jqismooth .jqismoothbuttons{ text-align: right; padding: 5px 0 5px 0; border: solid 1px #e2e8e6; background-color: #f2f8f6; }
div.jqismooth button{ padding: 3px 10px; margin: 0 10px; background-color: #2F6073; border: solid 1px #f4f4f4; color: #ffffff; font-weight: bold; font-size: 12px; }
div.jqismooth button:hover{ background-color: #728A8C; }
div.jqismooth button.jqismoothdefaultbutton{ background-color: #BF5E26; }
.jqismoothwarning .jqismooth .jqismoothbuttons{ background-color: #BF5E26; }


</style>


<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery-impromptu.4.0.min.js"></script>
<script type="text/javascript" src="jquery.corner.js"></script>
<script type="text/javascript" src="common.js"></script>

<script type="text/javascript">
 function popup()
 {
 var tourSubmitFunc = function(e,v,m,f){
			if(v === -1){
				$.prompt.prevState();
				return false;
			}
			else if(v === 1){
				$.prompt.nextState();
				return false;
			}
 },
tourStates = [
	
	{
		html: 'Events happening today',
		buttons: { Next: 1 },
		focus: 1,
		position: { container: '#today', x: 20, y: 40, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
	{
		html: 'Events happening tomorrow',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#tomorrow', x: 20, y: 40, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},

	{
		html: 'Events in the coming week',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#later', x: 13, y: 40, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
	{
		html: 'Events after one week',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#other_events', x: 20, y: 40, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
		{
		html: 'You can create an Event',
		buttons: { Done: 2 },
		focus: 1,
		position: { container: '#create_event', x: 10, y: 40, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	}
		

];
$.prompt(tourStates, { opacity: 0.3 });
    }

</script>
<style type="text/css">
#helpbox{
position:fixed;
right:0;
width:130px;
height:60px;
opacity:0.8;
filter:alpha(opacity=80);
background:#000;
font-size:16px;
font-family: 'Century Gothic', sans-serif;
color:#f0f0f0;
padding:5px;
padding-left:15px;
}
.hbutton{
	font-family: 'Century Gothic', sans-serif;
	background:#ffffff;
	border: 1px solid #dadada;
	outline:none;
	font-size:11px;
}
</style>
<? //if($logid==$user){ ?>
<div id="helpbox" onclick="popup()">
Start Tutorial<br/>
<div style="height:5px"></div>
<input name="submit" value="Yes" class="hbutton"  onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'" type="submit">
</div>
<? //} ?>


<div id="event_contentbox">
<div id="cblog_wrap">
<div class="pblog_pm">
EVENTS
<div style="float:right; padding-right:43px;" id="create_event">
<a href="create_event.php" ><input  type="submit" name="submit" value="Create Event" class="ccbutton" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/></a>
</div>
</div>


<div class="pblog_pm" id="today">			<!--////////// Events happening today - begin ////////////-->
TODAY

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
					<!-- ///////// Today's Event Details with Attendance ////////// -->

<div class="aclass">            	
					<!-- ///////// Today's Event Description ////////////////////// -->
<div class="aclass_descr">		
<a href="event_template_in.php?id=<? echo $rows1['eventid'];?>"><span class="ctitle"><? echo $rows1['Event_Name']; ?></span></a>
<div class="space8"></div>
<? echo $rows1['venue']; ?><br/>
<? echo date("d-M-Y",$event); ?>, <? echo date("h:i A",strtotime($rows1['timeofevent'])); ?><br/>
</div>				
					<!-- //////// Today's Event Description Ends Here //////////////-->
	
					<!-- ///////// Today's Attendance Begins here ///////////////// -->
<div class="w_rightsub">		
<? 
			$sql6="SELECT * FROM events_invitees WHERE userid=".$user." AND eventid=".$rows1['eventid'];
			$result6=mysql_query($sql6);
			$rows6=mysql_fetch_array($result6);
			//echo $rows6['status'];
			if ($rows6['status']=="1") {
?>
			

ATTENDING<img src="img/w_tick.png" style="padding-left:3px" width="11" height="8"/><br/>
<a href="event_attendance.php?status=2&set=1&id=<? echo $rows1['eventid'];?>">MAYBE</a><br/>
<a href="event_attendance.php?status=0&set=1&id=<? echo $rows1['eventid'];?>">NOT ATTENDING</a>


<? }
			else if ($rows6['status']=="0") {
?>

<a href="event_attendance.php?status=1&set=1&id=<? echo $rows1['eventid'];?>">ATTENDING</a><br/>
<a href="event_attendance.php?status=2&set=1&id=<? echo $rows1['eventid'];?>">MAYBE</a><br/>
NOT ATTENDING<img src="img/w_tick.png" style="padding-left:3px" width="11" height="8"/>


<? }
			else if ($rows6['status']=="2") {
?>

<a href="event_attendance.php?status=1&set=1&id=<? echo $rows1['eventid'];?>">ATTENDING</a><br/>
MAYBE<img src="img/w_tick.png" style="padding-left:3px" width="11" height="8"/><br/>
<a href="event_attendance.php?status=0&set=1&id=<? echo $rows1['eventid'];?>">NOT ATTENDING</a>

<? }
			else {
?>

<a href="event_attendance.php?status=1&set=0&id=<? echo $rows1['eventid'];?>">ATTENDING</a><br/>
<a href="event_attendance.php?status=2&set=0&id=<? echo $rows1['eventid'];?>">MAYBE</a><br/>
<a href="event_attendance.php?status=0&set=0&id=<? echo $rows1['eventid'];?>">NOT ATTENDING</a>

<? } ?>		
			
</div>          			<!-- /////////// Today's Attendance  Ends Here /////////////--> 
<div class="clear"></div>
</div>					<!-- /////////// Today's Event description with Attendance Ends Here //////////-->
<?
 	}	 	
}
?>
</div>

					<!--////////// Events happening tomorrow - begin ////////////-->
<div class="pblog_pm" id="tomorrow">
TOMMOROW
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
					<!-- /////////// Tomorrow's Event Details with Attendance ////////// -->
<div class="aclass">
					<!-- /////////// Tomorrow's Event Description ////////////////////// -->
<div class="aclass_descr">
<a href="event_template_in.php?id=<? echo $rows2['eventid'];?>"><span class="ctitle"><? echo $rows2['Event_Name']; ?></span></a>
<div class="space8"></div>
<? echo $rows2['venue']; ?><br/>
<? echo date("d-M-Y",$event); ?>, <? echo date("h:i A",strtotime($rows2['timeofevent'])); ?><br/>
</div>
					<!-- ////////// Tomorrow's Event Description Ends Here //////////////-->
	
					<!-- ////////// Tomorrow's Attendance Begins here ///////////////// -->

<div class="w_rightsub">
<? 
			$sql4="SELECT * FROM events_invitees WHERE userid=".$user." AND eventid=".$rows2['eventid'];
			$result4=mysql_query($sql4);
			$rows4=mysql_fetch_array($result4);
			//echo $rows4['status'];
			if ($rows4['status']=="1") {
?>
ATTENDING<img src="img/w_tick.png" style="padding-left:3px" width="11" height="8"/><br/>
<a href="event_attendance.php?status=2&set=1&id=<? echo $rows2['eventid'];?>">MAYBE</a><br/>
<a href="event_attendance.php?status=0&set=1&id=<? echo $rows2['eventid'];?>">NOT ATTENDING</a>
<? }
			else if ($rows4['status']=="0") {
?>
<a href="event_attendance.php?status=1&set=1&id=<? echo $rows2['eventid'];?>">ATTENDING</a><br/>
<a href="event_attendance.php?status=2&set=1&id=<? echo $rows2['eventid'];?>">MAYBE</a><br/>
NOT ATTENDING<img src="img/w_tick.png" style="padding-left:3px" width="11" height="8"/>

<? }
			else if ($rows4['status']=="2") { 
?>
<a href="event_attendance.php?status=1&set=1&id=<? echo $rows2['eventid'];?>">ATTENDING</a><br/>
MAYBE<img src="img/w_tick.png" style="padding-left:3px" width="11" height="8"/><br/>
<a href="event_attendance.php?status=0&set=1&id=<? echo $rows2['eventid'];?>">NOT ATTENDING</a>

<? }
			else {
?>	
<a href="event_attendance.php?status=1&set=0&id=<? echo $rows2['eventid'];?>">ATTENDING</a><br/>
<a href="event_attendance.php?status=2&set=0&id=<? echo $rows2['eventid'];?>">MAYBE</a><br/>
<a href="event_attendance.php?status=0&set=0&id=<? echo $rows2['eventid'];?>">NOT ATTENDING</a>

<? } ?>	
				<!-- /////////// Tomorrow's Attendance  Ends Here /////////////--> 
</div>
<div class="clear"></div>
</div>
				<!-- /////////// Tomorrow's Event description with Attendance Ends Here //////////-->
<?
			 	}
			 	
			 }
?>
</div>
				<!-- ////////// Events happening later this week - begin ////////////-->
<div class="pblog_pm" id="later">
LATER THIS WEEK
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
				<!-- /////////// Later This Week's Event Details with Attendance ////////// -->
<div class="aclass">
				<!-- /////////// Later This Week's Event Description ////////////////////// -->
<div class="aclass_descr">
<a href="event_template_in.php?id=<? echo $rows3['eventid'];?>"><span class="ctitle"><? echo $rows3['Event_Name']; ?></span></a>
<div class="space8"></div>
<? echo $rows3['venue']; ?><br/>
<? echo date("d-M-Y",$event); ?>, <? echo date("h:i A",strtotime($rows3['timeofevent'])); ?><br/>
</div>
				<!-- ////////// Later This Week's Event Description Ends Here //////////////-->
				
				<!-- ////////// Later This week's Attendance Begins here ///////////////// -->
<div class="w_rightsub">
<? 
			$sql5="SELECT * FROM events_invitees WHERE userid=".$user." AND eventid=".$rows3['eventid'];
			$result5=mysql_query($sql5);
			$rows5=mysql_fetch_array($result5);
			//echo $rows5['status'];
			if ($rows5['status']=="1") {
?>
ATTENDING<img src="img/w_tick.png" style="padding-left:3px" width="11" height="8"/><br/>
<a href="event_attendance.php?status=2&set=1&id=<? echo $rows3['eventid'];?>">MAYBE</a><br/>
<a href="event_attendance.php?status=0&set=1&id=<? echo $rows3['eventid'];?>">NOT ATTENDING</a>
<? }
			else if ($rows5['status']=="0") {
?>
<a href="event_attendance.php?status=1&set=1&id=<? echo $rows3['eventid'];?>">ATTENDING</a><br/>
<a href="event_attendance.php?status=2&set=1&id=<? echo $rows3['eventid'];?>">MAYBE</a><br/>
NOT ATTENDING<img src="img/w_tick.png" style="padding-left:3px" width="11" height="8"/>

<? }
			else if ($rows5['status']=="2") {
?>
<a href="event_attendance.php?status=1&set=1&id=<? echo $rows3['eventid'];?>">ATTENDING</a><br/>
MAYBE<img src="img/w_tick.png" style="padding-left:3px" width="11" height="8"/><br/>
<a href="event_attendance.php?status=0&set=1&id=<? echo $rows3['eventid'];?>">NOT ATTENDING</a>

<? }
			else {
?>	
<a href="event_attendance.php?status=1&set=0&id=<? echo $rows3['eventid'];?>">ATTENDING</a><br/>
<a href="event_attendance.php?status=2&set=0&id=<? echo $rows3['eventid'];?>">MAYBE</a><br/>
<a href="event_attendance.php?status=0&set=0&id=<? echo $rows3['eventid'];?>">NOT ATTENDING</a>

<? } ?>	
</div>
				<!-- /////////// Later This Week's Attendance  Ends Here /////////////-->
<div class="clear"></div>
</div>
				<!-- /////////// Later This Week's Event description with Attendance Ends Here //////////-->
<?
			 }
			 	
		}
?>
</div>
				<!-- ////////// Other Events happening - begin ////////////-->
<div class="pblog_pm" id="other_events">
OTHER EVENTS
<?
			$sql3="SELECT * FROM eventsinterface ORDER BY dateofevent";
			$result3=mysql_query($sql3);
			
			while($rows3=mysql_fetch_array($result3))
			{
				$events_date=$rows3['dateofevent'];
				$event=strtotime($events_date);
				if($event>$later_this_week)
				{
?>
				<!-- /////////// Other Event Details with Attendance ////////// -->
<div class="aclass">
				<!-- /////////// Other Event Description ////////////////////// -->
<div class="aclass_descr">
<a href="event_template_in.php?id=<? echo $rows3['eventid'];?>"><span class="ctitle"><? echo $rows3['Event_Name']; ?></span></a>
<div class="space8"></div>
<? echo $rows3['venue']; ?><br/>
<? echo date("d-M-Y",$event); ?>, <? echo date("h:i A",strtotime($rows3['timeofevent'])); ?><br/>
</div>
				<!-- ////////// Other Event Description Ends Here //////////////-->
				
				<!-- ////////// Other Attendance Begins here ///////////////// -->
<div class="w_rightsub">
<? 
			$sql5="SELECT * FROM events_invitees WHERE userid=".$user." AND eventid=".$rows3['eventid'];
			$result5=mysql_query($sql5);
			$rows5=mysql_fetch_array($result5);
			//echo $rows5['status'];
			if ($rows5['status']=="1") {
?>
ATTENDING<img src="img/w_tick.png" style="padding-left:3px" width="11" height="8"/><br/>
<a href="event_attendance.php?status=2&set=1&id=<? echo $rows3['eventid'];?>">MAYBE</a><br/>
<a href="event_attendance.php?status=0&set=1&id=<? echo $rows3['eventid'];?>">NOT ATTENDING</a>
<? }
			else if ($rows5['status']=="0") {
?>
<a href="event_attendance.php?status=1&set=1&id=<? echo $rows3['eventid'];?>">ATTENDING</a><br/>
<a href="event_attendance.php?status=2&set=1&id=<? echo $rows3['eventid'];?>">MAYBE</a><br/>
NOT ATTENDING<img src="img/w_tick.png" style="padding-left:3px" width="11" height="8"/>

<? }
			else if ($rows5['status']=="2") {
?>
<a href="event_attendance.php?status=1&set=1&id=<? echo $rows3['eventid'];?>">ATTENDING</a><br/>
MAYBE<img src="img/w_tick.png" style="padding-left:3px" width="11" height="8"/><br/>
<a href="event_attendance.php?status=0&set=1&id=<? echo $rows3['eventid'];?>">NOT ATTENDING</a>

<? }
			else {
?>	
<a href="event_attendance.php?status=1&set=0&id=<? echo $rows3['eventid'];?>">ATTENDING</a><br/>
<a href="event_attendance.php?status=2&set=0&id=<? echo $rows3['eventid'];?>">MAYBE</a><br/>
<a href="event_attendance.php?status=0&set=0&id=<? echo $rows3['eventid'];?>">NOT ATTENDING</a>

<? } ?>	
</div>
				<!-- /////////// Other Event Attendance  Ends Here /////////////-->
<div class="clear"></div>
</div>
				<!-- /////////// Other Event description with Attendance Ends Here //////////-->
<?
			 }
			 	
		}
?>
</div>

</div>
</div>

<?php

include('html_bottom.php');

?>