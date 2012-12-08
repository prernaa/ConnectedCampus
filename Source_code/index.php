<?php
session_start();
$auth=2;
include("dbconnect.php");
include("includes.php");


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="ui-mobile ui-mobile-rendering"><head profile="http://gmpg.org/xfn/11">
<link href="CSS/style1.css" rel="stylesheet" type="text/css" />
<link id="style-css" href="CSS/diapo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/PageLoad.js"></script> <!-- Slider Scripts-->
<script type="text/javascript" src="js/jquery.min.js"></script> <!--[if !IE]><!-->
<script type="text/javascript" src="js/jquery.mobile-1.0rc2.customized.min.js"></script> <!--<![endif]-->
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.hoverIntent.minified.js"></script>
<script type="text/javascript" src="js/diapo.js"></script>
<script>
$(function(){
	$('.pix_diapo').diapo();
});
</script>
	<title>ConnectedCampus| Networking & Nourishing Minds</title>


		<meta name="robots" content="noindex,nofollow">
		<script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<link rel="stylesheet" href="/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://wp-themes.com/wp/xmlrpc.php?rsd">
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://wp-themes.com/wp/wp-includes/wlwmanifest.xml"> 
<meta name="generator" content="WordPress 3.3.1">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>

<script type="text/javascript" src="js/PageLoad.js"></script> <!-- Slider Scripts-->
<script type="text/javascript" src="js/jquery.min.js"></script> <!--[if !IE]><!-->
<script type="text/javascript" src="js/jquery.mobile-1.0rc2.customized.min.js"></script> <!--<![endif]-->
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.hoverIntent.minified.js"></script>
<script type="text/javascript" src="js/diapo.js"></script>
<script>
$(function(){
	$('.pix_diapo').diapo();
});
</script>
<!-- Javascript for Validation -->
<script type="text/javascript">


function validateForm()
{
var x=document.forms["myForm"]["name"].value;
var y=document.forms["myForm"]["email"].value;
var z=document.forms["myForm"]["newemail"].value;
var u=document.forms["myForm"]["password"].value;
if (x==null || x=="")
  {
  alert("Name must be filled out");
  return false;
  }
if (y==null || y=="")
  {
  alert("Email must be filled out");
  return false;
  }  
if (u==null || u=="")
  {
  alert("Password must be filled out");
  return false;
  }
if (y!=z)
  {
  alert("Email Addresses dont match!");
  return false;
  }  
 return true;
}
</script>
<!--Fade out for error boxes -->
<script type="text/javascript">
$(document).ready(function() {

setTimeout(function(){

  $('#error').fadeOut('slow', function() {
    // Animation complete.
 
});
}, 2000);

});
function validateLoginForm()
{
var y=document.forms["myLogin"]["email"].value;
var u=document.forms["myLogin"]["password"].value;

if (y==null || y=="")
  {
  alert("Email must be filled out");
  return false;
  }  
if (u==null || u=="")
  {
  alert("Password must be filled out");
  return false;
  }

 return true;
}
</script>
<!-- Facebook/Google Login box -->
<script type="text/javascript">
(function() {
    if (typeof window.janrain !== 'object') window.janrain = {};
    window.janrain.settings = {};
    
    janrain.settings.tokenUrl = 'http://connectedcampus.org/success.php';

    function isReady() { janrain.ready = true; };
    if (document.addEventListener) {
      document.addEventListener("DOMContentLoaded", isReady, false);
    } else {
      window.attachEvent('onload', isReady);
    }

    var e = document.createElement('script');
    e.type = 'text/javascript';
    e.id = 'janrainAuthWidget';

    if (document.location.protocol === 'https:') {
      e.src = 'https://rpxnow.com/js/lib/ccampus/engage.js';
    } else {
      e.src = 'http://widget-cdn.rpxnow.com/js/lib/ccampus/engage.js';
    }

    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(e, s);
})();
</script>
</head>
<?php
//Start Session, check if logged in
session_start();

if(isset($_SESSION['email']))
{
header("location:profile_main.php");
}
?>
<style type="text/css">
body{
	margin:0;
	padding:0;
	background:#f7f7f7;
}
#iheader{
	min-height:27px;
	border-bottom:1px solid #B7B7B7;
	background:#F7F7F7;
}	
</style>
<body>
	<!-- header START -->
	
	<!-- header END -->
<style type="text/css">
#index_container{
	background:#f7f7f7;
	padding: 1px 0px 1px 0px;
	min-height:610px;

}

#i_container{
	max-width:1012px;
	margin:0 auto;
	margin-top:10px;
	min-height:590px;
}

.head{
font-family: 'Century Gothic', serif;
	color:#aaaaaa;
	font-size:20px;
}
.descr{
	font-family: 'Century Gothic', serif;
	font-size:14px;
	color:#dadada;
}
.ibox{
	padding: 10px;
	background:#ffffff;
	width:977px;
	height:180px;
	margin-bottom:20px;
}
.ibox_descr{
	font-family: 'Century Gothic', serif;
	width:535px;
	padding-left:5px;
	color:#a0a0a0;
	float:left;
	padding-right:20px;
	border-right: 1px dashed #dadada;
}
.ibox_login{
	padding-left:12px;
	float:left;
	font-family: 'Century Gothic', serif;
	color:#a0a0a0;
	margin-bottom: 15px;
}
.ccbutton{
	font-family: 'Century Gothic', sans-serif;
	background:#ffffff;
	border: 1px solid #dadada;
	outline:none;
}
.ibox2{
	padding: 10px;
	background:#f7f7f7;
	margin-top:-10px;
	margin-bottom:20px;
	width:977px;
	font-family: 'Century Gothic', serif;
	color:#a0a0a0;
}
.iencr{
padding-left:12px;
	float:left;
	width:430px;
}

#error{

position:fixed;
width:400px;
height:200px;
z-index:10000;
background:#000;
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;
opacity:0.6;
filter:alpha(opacity=60); /* For IE8 and earlier */
margin-left:20%;
font-size: 18px;
font-family: 'Century Gothic', sans-serif;
color: #F0F0F0;
text-align:center;

}

</style>

<div id="index_container">
<div id="i_container">
<img src="LogoPicNew.png"/>
<div style="height:10px"></div>
<!--<div class="ibox">-->

<div class="pix_diapo">
<!-- Image 1 -->

<div> 
	<img alt="hello" src="SliderImages/pic1.jpg" width="975px" height="176px" /><!-- Caption for Image 1-->
</div>

<!-- Image 2 -->

<div> 
	<img alt="" src="SliderImages/pic2.jpg" width="975px" height="176px" /><!-- Caption 1 for Image 2 -->
</div>

<!-- Image 3 -->

<div> 
	<img alt="" src="SliderImages/pic3.jpg" width="975px" height="176px" /><!-- Caption for Image 3 -->
</div>

<!-- Image 4 -->

<div> 
	<img alt="" src="SliderImages/pic4.jpg" width="975px" height="176px" /> <!-- Caption for Image 4 -->
</div>

</div>

<!--<img src="img/banner.png" />


</div>-->
<div class="ibox2">
Login with a demo account:&nbsp;{testuser1,testuser2,testuser3}@connectedcampus.org &nbsp;&nbsp; Password: krishna
</div>
<?
//If there is error, show error box
if(isset($_SESSION['error']))
{
echo "<div id='error'><h3>";
if($_SESSION['error']==1)
{
echo "Wrong username/password";
session_destroy();

}
if($_SESSION['error']==2)
{
echo "Email Registered already</h3>";
session_destroy();
}
echo "</div>";
}
?>
<div class="ibox_descr">
<iframe src="http://player.vimeo.com/video/40824291?title=0&amp;byline=0&amp;portrait=0" width="555" height="344" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe><p><a target="_blank" href="http://vimeo.com/prernac/ccscreencast">View Screen Cast</a>.</p>
</div>
<style type="text/css">
.lbin{
	font-size:12px;
	width: 90px;
	float:left;
	padding-top:8px;
	
}
.icnt{
	float:left;
}
.iinput{
	font-size:12px;
	font-family: 'Century Gothic', serif;
	color: #a0a0a0;
	border: 1px solid #dadada;
	padding: 2px;
	margin-top:5px;
	width: 295px;
}
</style>
<div class="iencr">
<div class="ibox_login">
<form name="myForm" action="register.php" onsubmit="return validateForm()" method="post" autocomplete="on" >
Register<br/>
<div class="lbin">full name</div>
<div class="icnt">
<input name='name' class="iinput" style="" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></input><br/>
</div><br/>
<div style="height:3px"></div>
<div class="lbin">email</div>
<div class="icnt">
<input name='email' class="iinput" style="" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></input><br/>
</div><br/>
<div class="lbin">retype email</div>
<div class="icnt">
<input name='newemail' class="iinput" style="" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></input><br/>
</div><br/>
<div class="lbin">password</div>
<div class="icnt">
<input type='password' name='password' class="iinput" style="" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></input><br/>
</div><br/>
<div style="padding-top:30px; padding-left: 322px;">
<input name="submit" value="Register" class="ccbutton"  onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'" type="submit"></form>
</div>
</div>
<div class="ibox_login">
<form name="myLogin" action="logincheck.php" onsubmit="return validateLoginForm()" method="post" autocomplete="on">
Login<br/>
<span class="lbin">login</span>
<input name='email' class="iinput" style="" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></input><br/>
<span class="lbin">password</span>
<input type='password' name='password' class="iinput" style="" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></input><br/>
<div style="padding-top:10px; padding-left: 246px;">
<input name="submit" value="Login" class="ccbutton"  onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'" type="submit">
| <a href="forgotpwd.php" class="iframe" style="font-size:10px;">Forgot Password</a><br/></form>
</div>

</div>
<div class="ibox_login">
<div style="height:5px"></div>
<div align="center" id="janrainEngageEmbed" style="padding-top:5px"></div>
</div>

</div>
</div>
</div>




</body></html>