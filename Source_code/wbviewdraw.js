// JavaScript Document
var eventdata=document.getElementById("eventout").value; // gets the array of coordinates to be drawn
var eventarray=eventdata.split("/"); //splits the eventdata from DB into an array
canvasdisp=document.getElementById('WBview'); //fetches the canvas
contextdisp=canvasdisp.getContext('2d'); //fetches the context of the canvas

var i=0;
while (i< eventarray.length)
//reading the already existing array of coordinates correctly & changing colors of the pen or switching to eraser wherever indicated in the array
{	if(eventarray[i]=="blackpen"){
		contextdisp.lineWidth = 1;
		contextdisp.strokeStyle = "#000000";
		i++;
	}
	else if(eventarray[i]=="redpen"){
		contextdisp.lineWidth = 1;
		contextdisp.strokeStyle = "#ff0000";
		i++;
	}
	else if(eventarray[i]=="bluepen"){
		contextdisp.lineWidth = 1;
		contextdisp.strokeStyle = "#005aff";
		i++;
	}
	else if(eventarray[i]=="greenpen"){
		contextdisp.lineWidth = 1;
		contextdisp.strokeStyle = "#038518";
		i++;
	}
	else if(eventarray[i]=="eraser"){
		contextdisp.lineWidth = 5;
		contextdisp.strokeStyle = "#ffffff";
		i++;
	}
	else if (eventarray[i]=="md")
	//Simulates the mousedown event
		{
			i++;
			coord=eventarray[i].split(",");
			contextdisp.beginPath();//if path hasn't started
      		contextdisp.moveTo(coord[0], coord[1]);//we take ink to starting point
			i++;
		}
	else if (eventarray[i]=="mu")
	//simulates mouseup event
		{
			i++;
		}
	else
	//Simulates mousemove event
		{
			coord=eventarray[i].split(",");
			contextdisp.lineTo(coord[0], coord[1]);//line is drawn from one coord to another
      		contextdisp.stroke();//renders the drawing on canvas
			i++;
		}
}
