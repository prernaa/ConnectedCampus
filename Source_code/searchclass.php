<?php
$auth=1;
include "includes.php";
function getclassname($id) { //Returns classname whose classid is passed as parameter
	$sql="SELECT classname FROM class_information WHERE classid=".$id;
	$result=mysql_fetch_array(mysql_query($sql));
	return $result['classname'];
}
function getclassimg($id) { //Returns filename of class image whose classid is passed as parameter
	$sql="SELECT image FROM class_information WHERE classid=".$id;
	$result=mysql_fetch_array(mysql_query($sql));
	return $result['image'];
}
?>

<script type="text/javascript">
				////////////// Subcategory Browsing options /////////////////

var opt=[["------------------------------"],
["All",
"Language",
"Communication & New Media",
"Economics",
"English Language",
"English Literature",
"Geography",
"History",
"Philosophy",
"Political Science",
"Psychology",
"Social Work",
"Sociology",
"Theatre & Acting",
"Visual Arts",
"Performing Arts",
"OTHER"
],
["All",
"Administration",
"Accountancy",
"Finance",
"Management",
"Advertising",
"Marketing",
"OTHER"
],
["All",
"Communications & Media",
"Computational Biology",
"E-Commerce",
"Information Systems",
"Programming & Design",
"Circuit Design",
"Hardware",
"Networking",
"Artificial Intelligence",
"Neural Networks",
"Parallel & Distributed Computing",
"Software",
"Internet",
"Security",
"OTHER"
],
["All",
"Dentistry",
"Nursing",
"Public Health",
"Surgery",
"General",
"Paramedical",
"Neuro",
"Cardio",
"Orthopedic",
"OTHER"
],
["All",
"Architecture",
"Building",
"Industrial Design",
"Project & Facilities Mangement",
"Real Estate",
"OTHER"
],
["All",
"Common Engineering",
"Bioengineering",
"Chemical Engineering",
"Civil Engineering",
"Computer Engineering/Science",
"Electrical Engineering",
"Engineering & Technology Management",
"Engineering Science",
"Industrial & Systems Engineering",
"Material Science & Engineering",
"Mechanical Engineering",
"Aerospace Engineering",
"Maritime Studies",
"Environmental Engineering",
"OTHER",
],
["All",
"Corporate Law",
"Criminal Law",
"International Law",
"Administrative Law",
"Property Law",
"OTHER",
],
["All",
"Instruments",
"Vocal",
"Composition",
"OTHER",
],["Life Sciences",
"Mathematics",
"Pharmacy",
"Physics",
"Quantitive Finance",
"Statistics",
"Physics",
"Applied Physics",
"Biological Sciences",
"OTHER",
],
["All",
"Digital Animation",
"Digital Filmaking",
"Interactive Media",
"Photography & Digital Imaging",
"Product Design",
"Visual Communication",
"OTHER",
],
["All",
"Arts (education)",
"Science (education)",
"Special Education",
"OTHER",
],
["All",
"General Sport Science","OTHER"],["Engineering",
"Science",
"Arts, Humanities, Social Sciences",
"Arts, Design & Media",
"Business/ Finance/ Management",
"Medicine",
"Technology",
"Education",
"OTHER",
]];
				/////////////////// Subcategory Option Switching Based on Choice of Category ////////////////////
function Box2(idx) {
var f=document.myform;
f.box2.options.length=0;
for(i=0; i<opt[idx].length; i++) {
    f.box2.options[i]=new Option(opt[idx][i], opt[idx][i]); 
   // f.box2.options[i]= new Option(opt[idx][i], i).value;
    }    
}

onload=function() {Box2(0);};
</script>




<!DOCTYPE HTML>
<html>
<head>
<style type="text/css">
#searchdiv{
	width:500px;
	color:#333333;
}
#result{
	padding:10px;
	text-align:center;
}
.classbox_img_hold{
	float:left;
}
.classbox_des_hold{
	float:left;
	padding:10px;
	width:250px;
	background:#ffffff;
	height:60px;
	font-size:20px;
}
.nothing{
	width: 410px;
	height:60px;
	background:#ffffff;
	font-size:20px;
	float:left;
	padding:10px;
}
a:link {text-decoration: none; color:#3b5998;}
a:visited {text-decoration: none; color:#3b5998;}
a:active {text-decoration: none; color:#3b5998;}
a:hover {text-decoration: underline; color:#3b5998;}
</style>
</head>

<div id="searchdiv">
<!--Keyword Search Option Displayed-->
<form method="get" action="searchclass.php" name="myform">
<table>
<tr>
<td>
<input type="text" name="searchtext" id="searchtext" size="60" />
</td>
<td><input type="submit" value="search" name="searchgo"/>
</td>
</tr>
<tr>
<td>

<table>
<tr>
<td>
Category:
</td>
<td>
			<!-- //////////////Option to Browse classrooms according to category & sub-category displayed  ///////////////-->
			
<select name="box1" onchange="Box2(this.selectedIndex)">
			<!-- ///////////// Category Options to Browse ////////////////////// -->

<option>All</option>
  <option>Arts, Humanities, Social Sciences</option>
  <option>Business</option>
  <option>Computing</option>
  <option>Medical</option>
  <option>Design & Environmental</option>
  <option>Engineering</option>
  <option>Law</option>
  <option>Music</option>
  <option>Science</option>
  <option>Art, Design & Media</option>
  <option>Education</option>
  <option>Sports, Science & Management</option>
  <option>Research</option>
</select><br/>
</td>
<tr>
<td>
Sub-category:
</td>
<td>
<select name="box2"></select>
</td>
</tr>
</table>
</td>
<td>
<input type="submit" value="Browse" name="browse"/>
</td>
</tr>
</table>
</form>
</div>
<div style="clear:both;"></div>


<div id="result">


<? if(isset($_GET['searchgo'])){ 
$sql2="SELECT * FROM class_information WHERE classname LIKE '%".$_GET['searchtext']."%' AND privacy=0"; 
//fetches classroom information from table in DB according to the keyword entered by the user
$query2=mysql_query($sql2);
if(mysql_num_rows($query2)==0){ ?>

<div class="nothing">
No results
</div>
<div style="clear:both;"></div>

<? } else{ 
while($class=mysql_fetch_array($query2)){?>

<div class="classbox_img_hold">
<a href="main_class.php?classid=<? echo $class['classid']; ?>" target="_parent">

			<!-- ///////// The class image is displayed linked to the main page of that class ////////// -->
			
<img src="<? echo "classimages/".getclassimg($class['classid']); ?>" width="160" height="80" alt="<? echo getclassname($class['classid']); ?>" style="cursor:pointer;"/></a>
</div>
<div class="classbox_des_hold">
<a href="main_class.php?classid=<? echo $class['classid']; ?>" target="_parent"><? echo getclassname($class['classid']); ?></a>
</div>
<div style="clear:both;"></div>

<? } 
 }
} ?>
 
			<!-- /////////// Browsing option  //////////////// --> 
<? if(isset($_GET['browse'])){  

$cat=$_GET['box1'];
$subcat=$_GET['box2'];
if ($cat=="All")
{
	$sql_browse="SELECT * FROM class_information WHERE privacy=0";
}
else if ($subcat=="All")
{
	$sql_browse="SELECT * FROM class_information WHERE catid IN (SELECT catid FROM class_category WHERE catname='".$cat."') AND privacy=0";
}
else 
{
	$sql_browse="SELECT * FROM class_information WHERE catid IN (SELECT catid FROM class_category WHERE catname='".$cat."') AND subcatid IN (SELECT subcatid FROM class_subcat WHERE subcatname='".$subcat."') AND privacy=0";
} 
$query_browse=mysql_query($sql_browse);
if(mysql_num_rows($query_browse)==0){
?>
			<!-- //////////// In Case None of the Records Matched //////////////// -->
			
<div class="nothing">
No results
</div>
<div style="clear:both;"></div>

<? } else{ 
while($browse=mysql_fetch_array($query_browse)){
?>

<div class="classbox_img_hold">
<a href="main_class.php?classid=<? echo $browse['classid']; ?>" target="_parent">
<img src="<? echo "classimages/".getclassimg($browse['classid']); ?>" width="160" height="80" alt="<? echo getclassname($browse['classid']); ?>" style="cursor:pointer;"/></a>
</div>
<div class="classbox_des_hold">
<a href="main_class.php?classid=<? echo $browse['classid']; ?>" target="_parent"><? echo getclassname($browse['classid']); ?></a>
</div>
<div style="clear:both;"></div>



<!--IF NO RESULT THEN USE THE DIV BELOW
<div class="nothing">
No results
</div>
<div style="clear:both;"></div>-->

<? }}} ?>
</div>

</html>