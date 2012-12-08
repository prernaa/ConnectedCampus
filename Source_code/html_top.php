<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
session_start();
include("dbconnect.php");
if($user_data['occupation']=="" || $user_data['university']=="" || $user_data['fieldofstudy']=="" || $user_data['graduationyr']=="")
{
$r=1;
}
else
{
$r=0;
}

?>

<head>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
/* refresh activity div per 2 seconds */
var int=self.setInterval("fetch()",2000);

/* fetches data from php file */
/* function to update div */
function fetch()
{
   $.post('includes/fsql.php', { postID: 'updateNotification' }, function(output){ $('#activities').html(output).show(); } );
}

/* function to unset an activity */
function CleanActivity(id)
{
   $.post('includes/fsql.php', { postID: 'unsetNotification', actID: id });
}
</script>

<script>

 $(document).ready(function() {
 	 $("#msgnew").load("msgupd.php");
   var refreshId = setInterval(function() {
      $("#msgnew").load('msgupd.php?randval='+ Math.random());
   }, 9000);
   $.ajaxSetup({ cache: false });
});
</script>
<script type="text/javascript"
  src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
   MathJax.Hub.Config({
     extensions: ["tex2jax.js","TeX/AMSmath.js","TeX/AMSsymbols.js"],
     jax: ["input/TeX","output/HTML-CSS"],
     tex2jax: {inlineMath: [["\\(","\\)"]],  processEscapes: true, ignoreClass: "tex2jax_ignore|ignore",  skipTags: ["script","noscript","style","textarea","code"] }
   });
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="/fancybox/jquery.easing-1.4.pack.js"></script>
<script type="text/javascript" src="/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<link rel="stylesheet" href="/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script type="text/javascript">
/*FancyBox Content*/
$(document).ready(function() {
	$.fancybox.init();
	$("a.iframe").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});
$("#msgnew").on("focusin", function(){

	$("a.iframe").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	
	
});
});
	
});

	
</script>
<?php //if($r)
	//{
	//echo "Your profile is incomplete, Click <a href='profile.php'>here</a> to go to the profile page";
	//}
	?>
	
<?php 
	// Activity checker
	if(isset($_POST['actUnset'])){
		//update database and unset notification
		updateDB("user_notifications", "Unread", '0', 'ID', $_POST['actID']);
	}
?>
<title>ConnectedCampus| Networking & Nourishing Minds</title>
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="stylesheet/default.css" type="text/css" media="screen" title="white">
<link rel="stylesheet" href="stylesheet/global.css" type="text/css" media="screen">
<link rel="stylesheet" href="kwicksnav/stylekwicks.css" type="text/css" media="screen">
<link rel="stylesheet" href="stylesheet/customstyle.css" type="text/css" media="screen">


</head>
<body>
	<!-- header START -->
	<div id="header">
		<div class="inner">
			<div class="content">
				<div class="caption">
					<h1 id="title"><a href="profile_main.php">
                    <img src="img/LogoPicNew.png" width="200" height="39">
                    </a></h1>
					<!--div id="tagline"> Networking And Nourishing Minds</div-->
				</div>

				<!-- navigation START -->
				<ul id="navigation">

					<li class="page_item page-item-2" id="im_profile"><a href="profile_main.php">Profile</a></li>
					<li class="page_item page-item-2" id="im_peers"><a href="peers_main.php">Peers</a></li>
					<li class="page_item page-item-2" id="im_forum"><a href="main_forum.php">Forum</a></li>
                    <li class="page_item page-item-2" id="im_wb"><a href="main_wb.php">Whiteboard</a></li>
					<li class="page_item page-item-2" id="im_event"><a href="event_template.php">Events</a></li>
                    <li class="page_item page-item-2" id="im_expert"><a href="search_new.php">Find An Expert</a></li>
                    <li class="page_item page-item-2" id="im_settings"><a href="settings_template.php">Settings</a>
                    <li class="page_item page-item-2"><a href="logout.php">Logout</a></li>
					
				</ul>
				<!-- navigation END -->

			</div>
		</div>
	</div>
	<!-- header END -->

<div id="container">
<div id="contcontainer">
<div id="elegantbg">
<div id="userpanel">
<div id="imghold">
<img src="<?php // get user photo
if($user_data['photo']==""){echo "img/defpic.png";}else{echo $user_data['photo'];} ?>" width="198" height="184"/>
</div>
<div id="acthold" class="hold">
<h1>ACTIVITIES</h1> <br />
<div id="spacer1"></div>
<div id = "activities">

</div>
</div>
<div id="spacer"></div>

<div id="msg" class="hold">
<h1>MESSAGES</h1><div id="msg_pic_hold">
<a class='iframe' tabindex='1' href='viewmessage.php?all=set'><img src='img/read_message.png'></a>
<a class='iframe' tabindex='1' href='newmessage.php'><img src='img/add_message.png'></a></div>
<div id="spacer1"></div>
<div id="msgnew">
</div>
</div> 


</div>
<div id="mainbox">