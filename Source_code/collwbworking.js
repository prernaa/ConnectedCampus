// JavaScript Document

$(window).bind('beforeunload', function(){
	//To confirm before the user exits the whiteboard
  return 'Unsaved whiteaboards may be deleted/overwritten...';
});

$(document).ready(function(){
$('#writemode').hide(); //initially, the write mode is hidden
$('#viewmode').show(); //and view mode is visible
fetch(); //fetch the view canvas with drawing on it as well as the active users display
fetch2(); //fetch the view tools i.e. "write now" button OR "so & so is writing now..."
userpass(); //fetch active users with option to pass the pen to them
refreshloadlist(); //to refresh the saved whiteboard list
var countswitch=0;
switchmode(); //to switch from view-->write & write-->view
function fetch()
{//fetch the view canvas with drawing
	var grp=$("#grpid").val();
	var _url='collwbviewget.php?GrpID='+grp;
    $.ajax({  
        url:_url,
        cache: false,  
        success: function(html){  
            $("#viewcanvas").html(html);      
            }
	});
//fetch the active users display
	var _url='collwbviewusers.php?GrpID='+grp;
    $.ajax({  
        url:_url,
        cache: false,  
        success: function(html){  
            $("#viewright").html(html);      
            }
	});

}
setInterval(fetch,5000); //refreshes viewcanvas and viewright every 5 sec
function fetch2()
{//fetch the view tools i.e. "write now" button OR "so & so is writing now..."
	var grp=$("#grpid").val();
	var login=$("#loginid").val();
	var _url='collwbviewtools.php?GrpID='+grp+'&LogID='+login;
    $.ajax({  
        url:_url,
        cache: false,  
        success: function(html){  
            $("#viewtools").html(html);      
            }
	});

}
setInterval(fetch2,2500); //refreshes viewtools (write now) button for 1st time write every 2 sec
function userpass()
{//fetch active users with option to pass the pen to them
	var grp=$("#grpid").val();
	var login=$("#loginid").val();
	var _url='collwbwriteusers.php?GrpID='+grp+'&LogID='+login;
    $.ajax({  
        url:_url,
        cache: false,  
        success: function(html){  
            $("#writeright").html(html);      
            }
	});

}
setInterval(userpass,2500);

//Code to switch between view and write mode
function switchmode()
//to switch from view-->write & write-->view
{	var grp=$("#grpid").val();
	var login=$("#loginid").val();
	$.ajax({
		type: 'POST',
		url:'collwb_switchmode.php',
		data: { GrpID:grp, LogID:login },
		cache:false,
		success: function(html){
			$("#switchdiv").html(html);
		}
	});
	if(($("#currentmode").val()==1) && $("#writemode").is(':hidden')) { //1->write so hide view
	//if the user is on write mode according to the data in the DB, hide the view mode to activate write mode
		//switch from view-->write
		countswitch++;
		getwriteevent();
		refreshloadlist();
		$('#viewmode').hide();
		$('#writemode').show();
	}
	else if(($("#currentmode").val()==0) && $("#viewmode").is(':hidden')){ //0->view so hide write
	//if the user is on view mode according to the data in the DB, hide the write mode to activate view mode
		//switch from write-->view
		countswitch++;
		refreshloadlist();
		$('#writemode').hide();
		$('#viewmode').show(); 
	}

}
if(countswitch==0){
	setInterval(switchmode,500);
}
else {
	setInterval(switchmode,1500);
}

function getwriteevent() //to get initial eventin on switching from view-->write 
{
	var login=$("#loginid").val();
	var grp=$("#grpid").val();
	var _url='collwbwriteevent.php?GrpID='+grp+'&LogID='+login;
    $.ajax({  
        url:_url,
        cache: false,  
        success: function(html){  
            $("#writecanvas").html(html);      
            }
	});

}
$("#savebutton").click(function() {  
//If the save button is pressed to post the whiteboard info to the collwb_save.php page which inserts that data into the database
	var grp=$("#grpid").val();
	var login=$("#loginid").val();
    var savename = $("#newwbname").val();
	$("#newwbname").val('');
	var eventarray=$("#eventin").val();
	
	if(!savename) {
		alert("You did not specify a name for the whiteboard!");
	}
	else {
		$.ajax({
			type: 'POST',
			url:'collwb_save.php',
			data: { GrpID:grp, LogID:login, WBname:savename, SaveArray: eventarray },
			cache:false,
			success: function(html){
				$("#msgtousr").html(html);
				refreshloadlist();
			}
		});
	}
});  

function refreshloadlist() {
	//Refreshes the list of saved whiteboards for that group
	var grp=$("#grpid").val();
	var login=$("#loginid").val();
	$.ajax({
			type: 'POST',
			url:'collwb_loadlist.php',
			data: { GrpID:grp, LogID:login },
			cache:false,
			success: function(html){
				$("#loaddiv").html(html);
			}
		});
}
$("#loadbutton").click(function() { 
//Loads a whiteboard which the user selects from the list of saved whiteboards
	var loadwb=$("#wbselect").val();
	var grp=$("#grpid").val();

	if(!loadwb) {alert("Please choose whiteboard to load!"); }
	else { 
		var r=confirm("Are you sure you want to load this whiteboard? The current whiteboard will be erased...");
		if(r=true) {
			$.ajax({
				type: 'POST',
				url:'collwb_activeload.php',
				data: { GrpID:grp, archid:loadwb/*, LogID:login */},
				cache:false,
				success: function(html){
					$("#tempdiv").html(html);
					getwriteevent();
				}
			});
			
		}
	}
});  
$("#deletebutton").click(function() {
//Deleted a whiteboard selected by the user from the list of saved whiteboards
	var deletewb=$("#wbselect").val();
	var grp=$("#grpid").val();
	var login=$("#loginid").val();
	if(!deletewb) {alert("Please choose whiteboard to delete!"); }
	else { 
		$.ajax({
				type: 'POST',
				url:'collwb_delete.php',
				data: { GrpID:grp, archid:deletewb, LogID:login },
				cache:false,
				success: function(html){
					$("#msgondel").html(html);
					refreshloadlist();
				}
				
			});
	}
});
$("#createnewbutton").click(function() { 
//Create a new whiteboard & discards the active whiteboard
	var grp=$("#grpid").val();
	var r=confirm("Are you sure you want to create a new whiteboard? The current whiteboard will be erased...");
	if(r=true) {
		$.ajax({
			type: 'POST',
			url:'collwb_createnew.php',
			data: { GrpID:grp},
			cache:false,
			success: function(html){
				getwriteevent();
			}
			});
			
	}
}); 
function timerswitch() { //Timer responsible for switching a user on write mode back to view mode if they have been inactive for some time 
	var grp=$("#grpid").val();
	$.ajax({
			type: 'POST',
			url:'collwb_timer.php',
			data: { GrpID:grp},
			cache:false,
			success: function(html){
				$("#timetemp").html(html);
			}
			});
}
setInterval(timerswitch,30000);
function activeget() {
	//Makes the user inactive if he has not participated in writing on the whiteboard or chatting for some time. The user must be involved in activities to stay active
	var grp=$("#grpid").val();//Store grp id from hidden input
	$.post("makeinactive.php", {GrpID:grp}); //send a post request to 'post.php' & 'usertext' is posted as 'text' & 'proj' is posted as 'projid'
	return false;
}
setInterval(activeget,30000);



});//end of $(document).ready()
