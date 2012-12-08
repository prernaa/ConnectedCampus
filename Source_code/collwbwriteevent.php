<style type="text/css">
.ccbutton3{
	font-family: 'Century Gothic', sans-serif;
	background:#ffffff;
	border: 1px solid #dadada;
	outline:none;
	cursor:pointer;
	font-size:12px;
	font-weight:bold;
	padding-left:3px;
	padding-right:3px;
}
.colortip { position:relative; z-index:24; }

.colortip span { display:none;}

.colortip:hover {z-index:25;}

.colortip:hover span {
	display:block;
	position:absolute;
	width:120px;
	top:25px;
	left:20px;
	background-color:#ffffff;
	border:1px solid #3b5998;
	padding:5px;
	font-size:9px;
	color:#3b5998;
	text-decoration:none;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
#WB{
	position: relative;
}
</style>
<?
include "dbconnect.php"; //Connect to the database
$groupid=$_GET['GrpID']; //id of the whiteboard group
$login=$_GET['LogID']; //userid of the logged in user or user who is saving the whiteboard
$sql="SELECT eventarray FROM collwb_event WHERE GroupID=$groupid AND Activewb=1"; //the existing array of coordinates to be written onto the whiteboard
$eventgetold=mysql_fetch_array(mysql_query($sql));
?>
	<canvas id="WB" height="250" width="600"><!--Displays canvas for the write mode. the user writes on this canvas-->
    Sorry, your browser does not support the whiteboard. You must download the latest version.
    <a href="http://download.cnet.com/Google-Chrome/3000-2356_4-10881381.html" target="_blank">Click to Download Google Chrome </a>
    </canvas>
<form action="" name="DBwrite">
	<input id="eventin" type="hidden" name="eventin" size="115" value="<? echo $eventgetold[0]; ?>">
    <input id="grpid" type="hidden" name="grpid" value="<? echo $groupid; ?>" />
    <input id="logid" type="hidden" name="logid" value="<? echo $login; ?>" />
</form>


<table>
  <tr>
  <td>Tools:&nbsp;</td>
  <!-- Displaying whiteboard tools-->
    <td style="height:35px; vertical-align:bottom;">
    <a style="text-decoration:none;" href="#" class="colortip"><span>Black</span>
    <img id="pentool" class="wbtool" src="wbtools-pen.png" width="24" height="24" alt="Black Pen" onclick="blackpenclick()"/>
    </a>
    <a style="text-decoration:none;" href="#" class="colortip"><span>Red</span>
    <img id="redpentool" class="wbtool" src="wbtools-redpen.png" width="24" height="24" alt="Red Pen" onclick="redpenclick()"/>
    </a>
    <a style="text-decoration:none;" href="#" class="colortip"><span>Blue</span>
    <img id="bluepentool" class="wbtool" src="wbtools-bluepen.png" width="24" height="24" alt="Blue Pen" onclick="bluepenclick()"/>
    </a>
    <a style="text-decoration:none;" href="#" class="colortip"><span>Green</span>
    <img id="greenpenrtool" class="wbtool" src="wbtools-greenpen.png" width="24" height="24" alt="Green Pen" onclick="greenpenclick()"/>
    </a>
    <a style="text-decoration:none;" href="#" class="colortip"><span>Eraser</span>
    <img id="erasertool" class="wbtool" src="wbtools-eraser.png" width="24" height="24" alt="Eraser" onclick="eraserclick()"/>
    </a>
    </td>
    <!--Displaying an option which allows the canvas to be converted to an image-->
    <td style="padding-left:20px; padding-top:3px;"><input id="imgconvert" type="button" value="Convert to img" class="ccbutton3" onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/></td>
  </tr>
</table>

<script type="text/javascript">

// JavaScript Document

var eventdata2=document.getElementById("eventin").value; //fetching already existing coordinates
var eventarray2=eventdata2.split("/"); //splits the eventdata from DB into an array
canvas=document.getElementById('WB'); //fetching the canvas
context=canvas.getContext('2d'); //fetching the context of the canvas
context.fillStyle="#ffffff";
context.fillRect(0,0,600,250);
var i=0;
while (i< eventarray2.length)
//reading the already existing array of coordinates correctly & changing colors of the pen or switching to eraser wherever indicated in the array
{
	if(eventarray2[i]=="blackpen"){
		context.lineWidth = 1;
		context.strokeStyle = "#000000";
		i++;
	}
	else if(eventarray2[i]=="redpen"){
		context.lineWidth = 1;
		context.strokeStyle = "#ff0000";
		i++;
	}
	else if(eventarray2[i]=="bluepen"){
		context.lineWidth = 1;
		context.strokeStyle = "#005aff";
		i++;
	}
	else if(eventarray2[i]=="greenpen"){
		context.lineWidth = 1;
		context.strokeStyle = "#038518";
		i++;
	}
	else if(eventarray2[i]=="eraser"){
		context.lineWidth = 5;
		context.strokeStyle = "#ffffff";
		i++;
	}
	else if (eventarray2[i]=="md")
	//Simulates the mousedown event
		{
			i++;
			coord=eventarray2[i].split(",");
			context.beginPath();//if path hasn't started
      		context.moveTo(coord[0], coord[1]);//we take ink to starting point
			i++;
		}
	else if (eventarray2[i]=="mu")
	//simulates mouseup event
		{
			i++;
		}
	else
		{
			//Simulates mousemove event
			coord=eventarray2[i].split(",");
			context.lineTo(coord[0], coord[1]);//line is drawn from one coord to another
      		context.stroke();//renders the drawing on canvas
			i++;
		}
}
//adding event listeners to the canvas
canvas.addEventListener('mousedown', mousedownevent, false); //mousedown event
canvas.addEventListener('mousemove', mousemovedevent, false); //mousemove event
canvas.addEventListener('mouseup', mouseupevent, false); //mouseup event
var browserName=navigator.appName; 
var pathbegun=false; //we initialise it as this since the path has not begun
function mousedownevent(e) {
	document.getElementById("eventin").value+="md/"; //md-->mousedown 
	var x, y;
	//we store coordinates relative to the canvas. Our code should cover most major browsers.

	if (e.layerX || e.layerX == 0) { 
     	x = e.layerX;
      	y = e.layerY;
	//layerX & layerY works on all browsers except Opera
    } else if (e.offsetX || e.offsetX == 0) {
      	x = e.offsetX;
      	y = e.offsetY;
	//offsetX & offsetY works on all browsers except Firefox
    }
    context.beginPath();//if path hasn't started
    context.moveTo(x, y);//we take ink to starting point
	document.getElementById("eventin").value+=x+","+y+"/"; 
    pathbegun = true;//and begin the path
}
function mousemovedevent(e) {
	//we initialise it as this since the path has not begun
	var x, y;
	//we store coordinates relative to the canvas. Our code should cover most major browsers.
	if (e.layerX || e.layerX == 0) { 
     	x = e.layerX;
      	y = e.layerY;
	//layerX & layerY works on all browsers except Opera
    } else if (e.offsetX || e.offsetX == 0) {
      	x = e.offsetX;
      	y = e.offsetY;
	//offsetX & offsetY works on all browsers except Firefox
    }
	if (pathbegun) {
		document.getElementById("eventin").value+=x+","+y+"/";
      	context.lineTo(x, y);//line is drawn from one coord to another
      	context.stroke();//renders the drawing on canvas
    }
}
	
function mouseupevent(e) {
	//we initialise it as this since the path has not begun
	var x, y;
	//we store coordinates relative to the canvas. Our code should cover most major browsers.
	
	if (e.layerX || e.layerX == 0) { 
     	x = e.layerX;
      	y = e.layerY;
	//layerX & layerY works on all browsers except Opera
    } else if (e.offsetX || e.offsetX == 0) {
      	x = e.offsetX;
      	y = e.offsetY;
	//offsetX & offsetY works on all browsers except Firefox
    }
    if (pathbegun) {
		document.getElementById("eventin").value+=x+","+y+"/";
		document.getElementById("eventin").value+="mu/";
      	context.lineTo(x, y);//line is drawn from one coord to another
      	context.stroke();//renders the drawing on canvas
    	pathbegun=false;
    }
}
function blackpenclick() {
	//Selects the black pen by changing color to black
	context.lineWidth = 1;
	context.strokeStyle = "#000000";
	document.getElementById("eventin").value+="blackpen/";
}
function redpenclick() {
	//Selects the red pen by changing color to red
	context.lineWidth = 1;
	context.strokeStyle = "#ff0000";
	document.getElementById("eventin").value+="redpen/";
}
function bluepenclick() {
	//Selects the blue pen by changing color to blue
	context.lineWidth = 1;
	context.strokeStyle = "#005aff";
	document.getElementById("eventin").value+="bluepen/";
}
function greenpenclick() {
	//Selects the green pen by changing color to green
	context.lineWidth = 1;
	context.strokeStyle = "#038518";
	document.getElementById("eventin").value+="greenpen/";
}

function eraserclick() {
	//Selects the eraser by changing color to white
	context.lineWidth = 5;
	context.strokeStyle = "#ffffff";
	document.getElementById("eventin").value+="eraser/";
}
$('#WB').mouseup(function() {
	//posts the array of coordinates to the database on mouse up
	var logsend=$("#logid").val();
	var grp=$("#grpid").val();
	var eventarray=$("#eventin").val();
	$.post("collwbpost.php", {eventstore: eventarray, GrpID:grp });
	$.post("collwb_mutime.php", {GrpID:grp }); 
	$.post("collwb_useractivity.php", {GrpID:grp, LogID:logsend });
	return false;
});
$('#WB').mousedown(function() {
	//records the mouse down event in the database
	var grp=$("#grpid").val();
	$.post("collwb_md.php", {GrpID:grp });
	return false;
});
$('#imgconvert').click(function() {
	//on clicking button to convert canvas to image it opens another window which contains the image
	var oCanvas = document.getElementById("WB");  
    window.open(oCanvas.toDataURL("image/png"));
});

</script>

