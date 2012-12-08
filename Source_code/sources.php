<?php

$auth=1; //user must be logged in to view this page 

include('includes.php');

include('html_top.php');

?>

<style type="text/css">
#class_contentbox{
}
#cblog_wrap{
width:450px;
float:left;
}
.fblog_p{
width:700px;
background:#ffffff;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:15px;
float:left;

}
.fblog_r{
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
.fblog_p2{
width:700px;
background:#fafafa;
margin-bottom:10px;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:20px;
float:left;

}
.fblog_pm{
width:700px;
background:#ffffff;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:10px;
float:left;
font-size:14px;
font-family: 'Century Gothic', sans-serif;
min-height:250px;
margin-top:10px;
}
.fblog_title{
width:700px;
background:#ffffff;
padding-left:10px;
padding-top:10px;
padding-right:10px;
padding-bottom:10px;
margin-top:10px;
float:left;
font-size:16px;
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
.fcomment{
	border: 1px solid #dadada;
	padding: 2px;
	width: 610px;
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
td {
	padding:10px;
	text-align:center;
	width:200px;
}
th{
	padding:10px;
	border-bottom:2px #333 solid;
}
A:link {text-decoration: none; color:#3b5998;}
A:visited {text-decoration: none; color:#3b5998;}
A:active {text-decoration: none; color:#3b5998;}
A:hover {text-decoration: underline; color:#3b5998;}
</style>
<div id="class_contentbox">
<div id="cblog_wrap">

<div class="fblog_title">
External Sources Used
</div>
<div class="fblog_pm">
<table border="0" style="margin-left:auto; margin-right:auto;">
   <tr>
    <th>Resource</th>
    <th>License/Terms</th>
  </tr>
  <tr>
  <tr>
    <td><a target="_blank" href="http://code.jquery.com/jquery-1.7.2.min.js">jQuery from Google/ jquery.org</a></td>
    <td><a target="_blank" href="http://jquery.org/license">MIT &amp; GPL License</a></td>
  </tr>
  <tr>
    <td><a target="_blank" href="http://fancybox.net/">Fancybox</a></td>
    <td><a target="_blank" href="http://jquery.org/license">MIT &amp; GPL License</a></td>
  </tr>
  <tr>
    <td><a target="_blank" href="http://trentrichardson.com/Impromptu/">jQuery Impromptu</a></td>
    <td><a target="_blank" href="http://trentrichardson.com/Impromptu/MIT-LICENSE.txt">MIT</a> &amp; <a href="http://trentrichardson.com/Impromptu/GPL-LICENSE.txt">GPL</a> License</a></td>
  </tr>
  <tr>
    <td><a target="_blank" href="http://cdn.mathjax.org/mathjax/latest/MathJax.js">Mathjax</a></td>
    <td><a target="_blank" href="http://www.apache.org/licenses/LICENSE-2.0">Apache License, Version 2.0</a></td>
  </tr>
  <tr>
    <td><a target="_blank" href="https://github.com/gedex/World-University-Names-Database">Universities list</a></td>
    <td><a target="_blank" href="https://github.com/gedex/World-University-Names-Database/blob/master/README">Open Source on GitHub</a></td>
  </tr>
  <tr>
    <td><a target="_blank" href="http://toolsjar.com/">Country/Region list</a></td>
    <td>Free Developer's Tool</td>
  </tr>
  <tr>
    <td><a target="_blank" href="http://janrain.com/products/engage/social-login/">Janrain Engage Social Login Plugin</a></td>
    <td>Free Developer's Tool</td>
  </tr>
  <tr>
    <td><a target="_blank" href="http://www.fyneworks.com/jquery/multiple-file-upload/#tab-Overview">jQuery Multiple File upload</a></td>
    <td><a target="_blank" href="http://www.fyneworks.com/jquery/multiple-file-upload/#tab-License">MIT &amp; GPL license</a></td>
  </tr>
  <tr>
    <td><a target="_blank" href="http://ckeditor.com/">CKEditor</a></td>
    <td><a target="_blank" href="http://ckeditor.com/license">GPL, LGPL, and MPL Licenses</a></td>
  </tr>
</table>


</div>

<br/>

<div class="fblog_title">
Screen Cast
</div>
<div class="fblog_pm">
<iframe src="http://player.vimeo.com/video/40824291?title=0&amp;byline=0&amp;portrait=0" width="700" height="344" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe><p><a target="_blank" href="http://vimeo.com/prernac/ccscreencast">View Screen Cast</a>.</p>
</div>



</div>
</div>
<?php

include('html_bottom.php');

?>
