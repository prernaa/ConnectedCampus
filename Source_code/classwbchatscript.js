// JavaScript Document
var delaytime=500;
var userdelaytime=500;
var counter=1;
//var count=1;
$(document).ready(function(){
	$("#submitmsg").click(function(){   //posts to the chat message to the table in the database
		var usertext=$("#usermsg").val(); //Stores user input in a variable called 'usertext'
		var grp=$("#grpid").val();//Store grp id from hidden input
		$.post("classwbchatpost.php", {text: usertext , grpid:grp}); //send a post request to 'classwbchatpost.php' & 'usertext' is posted as 'text' & 'grp' is posted as 'grpid'
		$("#usermsg").attr("value", ""); //empties the textarea where user writes his message
		return false;
	});
	function loadLog(){ //loads the chat log of the whiteboard group. This function is called every few seconds to refresh the chat log every time
		if(counter>1)
			delaytime=2500;
		counter++;
    	var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request  
		var grp=$("#grpid").val();//Store ProjID from hidden input
		var _url='classwbchatdisp.php?GrpID='+grp;
    	$.ajax({  
        	url:_url,
        	cache: false,  
        	success: function(html){  
            	$("#chatbox").html(html); //Insert chat from DB into the #chatbox div     
  
            	//Auto-scroll  
            	var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request  
            	if(newscrollHeight > oldscrollHeight){  
                	$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div  
            	}  
        	},  
    	});  
	}
	setInterval (loadLog, delaytime); //loadLog Function is called at this interval
  
});

   


