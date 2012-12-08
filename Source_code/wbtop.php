<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
session_start();
include("dbconnect.php"); //to connect to database
//THIS FILE JUST CONTAINS FANCYBOX AND SOME BASIC CSS
?>

<head>
<!--All fancybox jQuery files-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="/fancybox/jquery.easing-1.4.pack.js"></script>
<script type="text/javascript" src="/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<link rel="stylesheet" href="/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script type="text/javascript">
/*FancyBox Content*/
 $(document).ready(function() {
 	 $("#msgnew").load("msgupd.php");
   var refreshId = setInterval(function() {
      $("#msgnew").load('msgupd.php?randval='+ Math.random());
   }, 9000);
   $.ajaxSetup({ cache: false });
});
$(document).ready(function() {
	
	$("a.iframe").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});
	
});
	
</script>
<?php //if($r)
	//{
	//echo "Your profile is incomplete, Click <a href='profile.php'>here</a> to go to the profile page";
	//}
	?>
<title>ConnectedCampus| Networking & Nourishing Minds</title>
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="stylesheet/default.css" type="text/css" media="screen" title="white">
<link rel="stylesheet" href="stylesheet/global.css" type="text/css" media="screen">
<link rel="stylesheet" href="kwicksnav/stylekwicks.css" type="text/css" media="screen">
<link rel="stylesheet" href="stylesheet/customstyle.css" type="text/css" media="screen">
<style type="text/css">
#mainboxwb{
	width:800px;
	padding:10px;
}
#contcontainerwb{
	width:100%;
	height:100%;
	background:#F7F7F7;
}
#containerwb{
	width:100%;
	height:100%;
	background:#F7F7F7;
}
</style>

</head>
<body>
	

<div id="containerwb">
<div id="contcontainerwb">
<div id="elegantbgwb">
<div id="mainboxwb">