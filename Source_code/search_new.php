<?php
$auth=1;
include('includes.php');
include('html_top.php');

?>
<style type="text/css">
.option{
	margin-right: 10px;
}
.suggestionsBox {
	position: absolute;
top: 132px

	margin: 26px 0px 0px 0px;
	width: 200px;
padding: 0px;
background-color: #C8C8D0;
border-top: #C8C8D0;
color: #000;
font-size: small;
}
.suggestionList {
	margin: 0px;
	padding: 0px;
}
.suggestionList ul li {
	list-style:none;
	margin: 0px;
	padding: 6px;
	border-bottom:1px dotted #666;
	cursor: pointer;
}
.suggestionList ul li:hover {
	background-color: #FC3;
	color:#000;
}
ul {
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#FFF;
	padding:0;
	margin:0;
}

.load{
background-image:url(loader.gif);
background-position:right;
background-repeat:no-repeat;
}
#main_peers{
	padding-top:10px;
	width:645px;
}

#friend_left{

	float: left;
	width:90px;
	position: relative;
	z-index: 99;	
}
#friend_right{
	float: right;
	width:500px;
	position: relative;
	padding-top:2px;
	z-index: 99;
}
h5{
	margin: 0;
	font-family:Cambria,'Palatino Linotype','Book Antiqua','URW Palladio L',serif;
	font-size:18px;
	color:#6D929B;
}
.friend_holder{
	width: 120px;
	height:160px;
	border: 1px solid #ccc;
	float:left;
	margin-right: 10px;
	margin-bottom: 10px;
	line-height: 15px;
	text-align: center;
}
#friend_holder{
	overflow:auto;
}
#friends_holder{
	margin-top:30px;
}
#friends_left{
	float: left;
	width:90px;
	position: relative;
	z-index: 99;	
}
#friends_right{
	float: right;
	width:500px;
	position: relative;
	padding-top:2px;
	z-index: 99;
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
background:#fcfbfb;
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
.opDiv{
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
	width:540px;
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
margin-left:5px
}
.w_listr{
float:left;
font-size:15px;
padding-top:4px;
margin-left:12px;
padding-left:12px;
border-left:1px dashed #dadada;
width:110px;
}

.w_boxes{
float:left;
margin-left:25px;
}
.w_boxes2{
float:left;
margin-left:8px;
}
.winput{
	border: 1px solid #dadada;
	padding: 2px;
	margin-top:5px;
	width: 185px;
}
.sarea{
border: 1px solid #dadada;
	padding: 2px;
	width: 185px;
resize: none;
height:51px;
margin-top:13px;
}

.psep{
border:0;
border-bottom: 1px dashed #dadada;	
margin-top:5px;
margin-bottom:5px;
}

.wselect{
font-family: 'Century Gothic', sans-serif;
padding-left:3px;
width:61px;
}
.wselect2{
font-family: 'Century Gothic', sans-serif;
padding-left:3px;
width:190px;
}
.winputfile{
	position: relative;
	text-align: right;
	-moz-opacity:0 ;
	filter:alpha(opacity: 0);
	opacity: 0;
	z-index: 2;
}
.winputfilefake{
	border: 1px solid #dadada;
	padding: 2px;
	margin-top:5px;
	width: 185px;
	position: absolute;
	top: 0px;
	left: 0px;
	z-index: 1;
}
.fileinputs {
	position: relative;
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
		html: 'Having Trouble in a course? Do a general tag search to find out the expert.',
		buttons: { Next: 1 },
		focus: 1,
		position: { container: '#addTag', x: -52, y: 40, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
	{
		html: 'Choose a location and filter your search',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#addTag', x: -240, y: 70, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},

	{
		html: 'Choose a university and filter your search',
		buttons: { Prev: -1, Next: 1 },
		focus: 1,
		position: { container: '#addTag', x: -240, y: 110, width: 150, arrow: 'tl' },
		submit: tourSubmitFunc
	},
	{
		html: 'Expert in your University or locality to help you out',
		buttons: { Done: 2 },
		focus: 1,
		position: { container: '#experts', x: 60, y: 50, width: 150, arrow: 'tl' },
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
<?  //if($logid==$user){ ?>
<div id="helpbox" onclick="popup()">
Start Tutorial<br/>
<div style="height:5px"></div>
<input name="submit" value="Yes" class="hbutton"  onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'" type="submit">
</div>
<? //} ?>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript">//For Suggestive
function suggest(inputString){
        if(inputString.length == 0) {
            $('#suggestions').fadeOut();
        } else {
        $('#ntag').addClass('load');
            $.post("suggesttags.php", {queryString: ""+inputString+""}, function(data){
                if(data.length >0) {
                    $('#suggestions').fadeIn();
                    $('#suggestionsList').html(data);
                    $('#ntag').removeClass('load');
                }
            });
        }
    }
 
    function fill(thisValue) {
        $('#ntag').val(thisValue);
        setTimeout("$('#suggestions').fadeOut();", 600);
    }
 $(document).ready(function() {
    
$("div1").click(function () {
      $(this).hide("slide", { direction: "down" }, 1000);
});

  });
function disp(id)//Removes a tag
{ document.getElementById("Tag"+id).style.display="none";
  document.getElementById("cross"+id).style.display="none";
  document.getElementById("divt"+id).style.display="none";
}
function addTag()//Add a new tag
{if(document.getElementById("ntag").value==""||document.getElementById("ntag").value==" ")
return;

document.getElementById("count").value=(parseInt(document.getElementById("count").value)+1)+"";
//A new div is added with the tag
 document.getElementById("div1").innerHTML="<div class=\"aclass\" id='divt"+document.getElementById("count").value+"'><img src=\"img/blog_cross.png\" id='cross"+document.getElementById("count").value+"' onClick=\"disp('"+document.getElementById("count").value+"')\" ><input class='tags' onClick='disp(this.id)' name='tag"+document.getElementById("count").value+"' type='text' disabled id='Tag"+document.getElementById("count").value+"' size='"+((document.getElementById("ntag").value.length)-20)+"' value='"+document.getElementById("ntag").value+"'/></div>"+document.getElementById("div1").innerHTML;
 //The input box is cleared
 document.getElementById("ntag").value="";
}
//Display the found experts using jquery
function searchexpert()
{var n=parseInt(document.getElementById("count").value);
 var i;
 var s=document.getElementById('ntag').value;
 //Retrieve the tags
 for(i=1;i<=n;i++)
 {var id="Tag"+i;
  var t=document.getElementById(id);
  if(t.style.display!="none")
   {if(s!="")
     s+=",";
	s+=t.value;
   }
 }
 if(s=="")
 {alert("Atleast one tag needed");//ensure that there is atleast one tag
  return;
 }
 var univ,loca;
 if(document.getElementById("3").checked)//obtain university
   univ=document.getElementById("uni").value;
  else
   univ="";
  if(document.getElementById("2").checked)//obtain location
   {if(document.getElementById("2").checked)
     loca=document.getElementById("childdrop4f7c901da89bb").value;
	else
	 loca=document.getElementById("parentdrop1").value;
   }
  else
   loca="";
   //use jquery to run 'experts.php' and display the experts
 $.post('experts.php',{tags:s,loc:loca,uni:univ},function(output){ $('#friends_right').html(output).show();  } );
}
</script>
<script src="expertCountry.js">
//this script creates a list of cities for each country
</script>
<div class="pblog_pm" >
<p>Advanced Search</p>
<hr class="psep" />
<div class="space8"></div>
<br /><table>
<tr>
<!-- The Tags to be Added -->
<td>
Tag Search
<div class="opDiv" id='div1' ><input onkeyup="suggest(this.value);" id="ntag" name="newTag" type="text" maxlength="20" size="10" class="winput" style="margin-top:5px" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"/><div id="suggestions" class="suggestionsBox" style="display: none;">
 <img style="position: relative; top: -12px; left: 30px;" src="arrow.png" alt="upArrow" />
<div id="suggestionsList" class="suggestionList"></div>
</div><input id="addTag" type="button" value="Add Tag" onClick="addTag();" class="ccbutton"  onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'" /><input id="count" type="hidden" value="0" /></div>
</td>
</tr>
<tr><td><div style="height:12px;"></div></td></tr>
<tr>
<td>
<!-- The Location from which the experts must be -->
<input class="option" id="2" name="Location search" type="checkbox" value="2" />Location search
<div class="opDiv" id='div2' style="display:none;" >
<div style="margin-left:10px;"><input class="option" id="citych" name="city" type="checkbox" value="21" /> Search City</div>
<div style="height:12px;"></div><div id="city" align="center">Country: <select name='parentdrop1' id='parentdrop1' onchange='loadchild4f7c901da89bb(this)' style="margin-left:2px;margin-right:2px;font-weight: Lighter; font-family: Times New Roman; background-color: #FFFFFF; color: #000000; font-size: 12px; width: 120px; "><option value=''>-Select-</option><option value='Afghanistan'>Afghanistan</option><option value='Albania'>Albania</option><option value='Algeria'>Algeria</option><option value='American Samoa'>American Samoa</option><option value='Andorra'>Andorra</option><option value='Angola'>Angola</option><option value='Anguilla'>Anguilla</option><option value='Antarctica'>Antarctica</option><option value='Antigua and Barbuda'>Antigua and Barbuda</option><option value='Argentina'>Argentina</option><option value='Armenia'>Armenia</option><option value='Aruba'>Aruba</option><option value='Australia'>Australia</option><option value='Austria'>Austria</option><option value='Azerbaijan'>Azerbaijan</option><option value='Bahamas'>Bahamas</option><option value='Bahrain'>Bahrain</option><option value='Bangladesh'>Bangladesh</option><option value='Barbados'>Barbados</option><option value='Belarus'>Belarus</option><option value='Belgium'>Belgium</option><option value='Belize'>Belize</option><option value='Benin'>Benin</option><option value='Bermuda'>Bermuda</option><option value='Bhutan'>Bhutan</option><option value='Bolivia'>Bolivia</option><option value='Bosnia and Herzegovina'>Bosnia and Herzegovina</option><option value='Botswana'>Botswana</option><option value='Bouvet Island'>Bouvet Island</option><option value='Brazil'>Brazil</option><option value='British Indian Ocean Territory'>British Indian Ocean Territory</option><option value='Brunei'>Brunei</option><option value='Bulgaria'>Bulgaria</option><option value='Burkina Faso'>Burkina Faso</option><option value='Burundi'>Burundi</option><option value='Cambodia'>Cambodia</option><option value='Cameroon'>Cameroon</option><option value='Canada'>Canada</option><option value='Cape Verde'>Cape Verde</option><option value='Cayman Islands'>Cayman Islands</option><option value='Central African Republic'>Central African Republic</option><option value='Chad'>Chad</option><option value='Chile'>Chile</option><option value='China'>China</option><option value='Christmas Island'>Christmas Island</option><option value='Cocos (Keeling) Islands'>Cocos (Keeling) Islands</option><option value='Colombia'>Colombia</option><option value='Comoros'>Comoros</option><option value='Congo'>Congo</option><option value='Congo (DRC)'>Congo (DRC)</option><option value='Cook Islands'>Cook Islands</option><option value='Costa Rica'>Costa Rica</option><option value='Cote d Ivoire'>Cote d Ivoire</option><option value='Croatia'>Croatia</option><option value='Cuba'>Cuba</option><option value='Cyprus'>Cyprus</option><option value='Czech Republic'>Czech Republic</option><option value='Denmark'>Denmark</option><option value='Djibouti'>Djibouti</option><option value='Dominica'>Dominica</option><option value='Dominican Republic'>Dominican Republic</option><option value='Ecuador'>Ecuador</option><option value='Egypt'>Egypt</option><option value='El Salvador'>El Salvador</option><option value='Equatorial Guinea'>Equatorial Guinea</option><option value='Eritrea'>Eritrea</option><option value='Estonia'>Estonia</option><option value='Ethiopia'>Ethiopia</option><option value='Falkland Islands (Islas Malvinas)'>Falkland Islands (Islas Malvinas)</option><option value='Faroe Islands'>Faroe Islands</option><option value='Fiji'>Fiji</option><option value='Finland'>Finland</option><option value='France'>France</option><option value='French Guiana'>French Guiana</option><option value='French Polynesia'>French Polynesia</option><option value='French Southern and Antarctic Lands'>French Southern and Antarctic Lands</option><option value='Gabon'>Gabon</option><option value='Gambia'>Gambia</option><option value='Georgia'>Georgia</option><option value='Germany'>Germany</option><option value='Ghana'>Ghana</option><option value='Gibraltar'>Gibraltar</option><option value='Greece'>Greece</option><option value='Greenland'>Greenland</option><option value='Grenada'>Grenada</option><option value='Guadeloupe'>Guadeloupe</option><option value='Guam'>Guam</option><option value='Guatemala'>Guatemala</option><option value='Guernsey'>Guernsey</option><option value='Guinea'>Guinea</option><option value='Guinea-Bissau'>Guinea-Bissau</option><option value='Guyana'>Guyana</option><option value='Haiti'>Haiti</option><option value='Heard Island and McDonald Islands'>Heard Island and McDonald Islands</option><option value='Honduras'>Honduras</option><option value='Hong Kong SAR'>Hong Kong SAR</option><option value='Hungary'>Hungary</option><option value='Iceland'>Iceland</option><option value='India'>India</option><option value='Indonesia'>Indonesia</option><option value='Iran'>Iran</option><option value='Iraq'>Iraq</option><option value='Ireland'>Ireland</option><option value='Isle of Man'>Isle of Man</option><option value='Israel'>Israel</option><option value='Italy'>Italy</option><option value='Jamaica'>Jamaica</option><option value='Japan'>Japan</option><option value='Jersey'>Jersey</option><option value='Jordan'>Jordan</option><option value='Kazakhstan'>Kazakhstan</option><option value='Kenya'>Kenya</option><option value='Kiribati'>Kiribati</option><option value='Kuwait'>Kuwait</option><option value='Kyrgyzstan'>Kyrgyzstan</option><option value='Laos'>Laos</option><option value='Latvia'>Latvia</option><option value='Lebanon'>Lebanon</option><option value='Lesotho'>Lesotho</option><option value='Liberia'>Liberia</option><option value='Libya'>Libya</option><option value='Liechtenstein'>Liechtenstein</option><option value='Lithuania'>Lithuania</option><option value='Luxembourg'>Luxembourg</option><option value='Macao SAR'>Macao SAR</option><option value='Macedonia,Former Yugoslav Republic of'>Macedonia,Former Yugoslav Republic of</option><option value='Madagascar'>Madagascar</option><option value='Malawi'>Malawi</option><option value='Malaysia'>Malaysia</option><option value='Maldives'>Maldives</option><option value='Mali'>Mali</option><option value='Malta'>Malta</option><option value='Marshall Islands'>Marshall Islands</option><option value='Martinique'>Martinique</option><option value='Mauritania'>Mauritania</option><option value='Mauritius'>Mauritius</option><option value='Mayotte'>Mayotte</option><option value='Mexico'>Mexico</option><option value='Micronesia'>Micronesia</option><option value='Moldova'>Moldova</option><option value='Monaco'>Monaco</option><option value='Mongolia'>Mongolia</option><option value='Montenegro'>Montenegro</option><option value='Montserrat'>Montserrat</option><option value='Morocco'>Morocco</option><option value='Mozambique'>Mozambique</option><option value='Myanmar'>Myanmar</option><option value='Namibia'>Namibia</option><option value='Nauru'>Nauru</option><option value='Nepal'>Nepal</option><option value='Netherlands'>Netherlands</option><option value='Netherlands Antilles'>Netherlands Antilles</option><option value='New Caledonia'>New Caledonia</option><option value='New Zealand'>New Zealand</option><option value='Nicaragua'>Nicaragua</option><option value='Niger'>Niger</option><option value='Nigeria'>Nigeria</option><option value='Niue'>Niue</option><option value='Norfolk Island'>Norfolk Island</option><option value='North Korea'>North Korea</option><option value='Northern Mariana Islands'>Northern Mariana Islands</option><option value='Norway'>Norway</option><option value='Oman'>Oman</option><option value='Pakistan'>Pakistan</option><option value='Palau'>Palau</option><option value='Palestinian Authority'>Palestinian Authority</option><option value='Panama'>Panama</option><option value='Papua New Guinea'>Papua New Guinea</option><option value='Paraguay'>Paraguay</option><option value='Peru'>Peru</option><option value='Philippines'>Philippines</option><option value='Pitcairn Islands'>Pitcairn Islands</option><option value='Poland'>Poland</option><option value='Portugal'>Portugal</option><option value='Puerto Rico'>Puerto Rico</option><option value='Qatar'>Qatar</option><option value='Reunion'>Reunion</option><option value='Romania'>Romania</option><option value='Russia'>Russia</option><option value='Rwanda'>Rwanda</option><option value='Saint Helena'>Saint Helena</option><option value='Saint Kitts and Nevis'>Saint Kitts and Nevis</option><option value='Saint Lucia'>Saint Lucia</option><option value='Saint Pierre and Miquelon'>Saint Pierre and Miquelon</option><option value='Saint Vincent and the Grenadines'>Saint Vincent and the Grenadines</option><option value='Samoa'>Samoa</option><option value='San Marino'>San Marino</option><option value='São Tomé and Príncipe'>São Tomé and Príncipe</option><option value='Saudi Arabia'>Saudi Arabia</option><option value='Senegal'>Senegal</option><option value='Serbia'>Serbia</option><option value='Seychelles'>Seychelles</option><option value='Sierra Leone'>Sierra Leone</option><option value='Singapore'>Singapore</option><option value='Slovakia'>Slovakia</option><option value='Slovenia'>Slovenia</option><option value='Solomon Islands'>Solomon Islands</option><option value='Somalia'>Somalia</option><option value='South Africa'>South Africa</option><option value='South Georgia and the South Sandwich Islands'>South Georgia and the South Sandwich Islands</option><option value='South Korea'>South Korea</option><option value='Spain'>Spain</option><option value='Sri Lanka'>Sri Lanka</option><option value='Sudan'>Sudan</option><option value='Suriname'>Suriname</option><option value='Svalbard and jan Mayen'>Svalbard and jan Mayen</option><option value='Swaziland'>Swaziland</option><option value='Sweden'>Sweden</option><option value='Switzerland'>Switzerland</option><option value='Syria'>Syria</option><option value='Taiwan'>Taiwan</option><option value='Tajikistan'>Tajikistan</option><option value='Tanzania'>Tanzania</option><option value='Thailand'>Thailand</option><option value='Timor-Leste (East Timor)'>Timor-Leste (East Timor)</option><option value='Togo'>Togo</option><option value='Tokelau'>Tokelau</option><option value='Tonga'>Tonga</option><option value='Trinidad and Tobago'>Trinidad and Tobago</option><option value='Tunisia'>Tunisia</option><option value='Turkey'>Turkey</option><option value='Turkmenistan'>Turkmenistan</option><option value='Turks and Caicos Islands'>Turks and Caicos Islands</option><option value='Tuvalu'>Tuvalu</option><option value='Uganda'>Uganda</option><option value='Ukraine'>Ukraine</option><option value='United Arab Emirates'>United Arab Emirates</option><option value='United Kingdom'>United Kingdom</option><option value='United States'>United States</option><option value='United States Minor Outlying Islands'>United States Minor Outlying Islands</option><option value='Uruguay'>Uruguay</option><option value='Uzbekistan'>Uzbekistan</option><option value='Vanuatu'>Vanuatu</option><option value='Vatican City'>Vatican City</option><option value='Venezuela'>Venezuela</option><option value='Vietnam'>Vietnam</option><option value='Virgin Islands,British'>Virgin Islands,British</option><option value='Virgin Islands,U.S.'>Virgin Islands,U.S.</option><option value='Wallis and Futuna'>Wallis and Futuna</option><option value='Western Sahara'>Western Sahara</option><option value='Yemen'>Yemen</option><option value='Zambia'>Zambia</option><option value='Zimbabwe'>Zimbabwe</option></select><div style="height:12px;"></div><div id="div21" style="display:none">City: <select name='childdrop4f7c901da89bb' id='childdrop4f7c901da89bb' style="margin-left:2px;margin-right:2px;font-weight: Lighter; font-family: Times New Roman; background-color: #FFFFFF; color: #000000; font-size: 12px; width: 120px;"></select></div>

</div>

</div></td>
</tr>
<tr><td><div style="height:12px;"></div></td></tr>
<tr>
<td>
<!-- The University from which the experts must be -->
<input class="option" id="3" name="Tag search" type="checkbox" value="3" />University search
<div class="opDiv" id='div3' style="display:none"><div id='suggest'><table><tr><td>University:</td>
 
      <td><input id='uni'class="winput" style="margin-top:5px" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'" type='text' name='uni' value=''/>
</td></tr></table>
</div></div></td>
</tr>
<tr><td><div style="height:12px;"></div></td></tr>
</table>
<!-- Using Jquery to diplay in put options only when asked for -->
<script>
$(".option").click(function() {
  $("#div"+this.value).toggle("fold");
});
</script>
<script>
$(".city").click(function() {
  $("#country").toggle("fold");
  $("#city").toggle("fold");
});
</script>

<input name="search" type="button" value="Search" onclick="searchexpert();" class="ccbutton"  onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'"/>
</div>
<div class="pblog_pm">
<p id="experts">Experts</p>
<hr class="psep" />
<div class="space8"></div>
<div>
<div id="friends_right">
Start A New Search
</div>
</div>
</div>
</div>
<?php
include('html_bottom.php');
?>