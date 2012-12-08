<?php
$auth=1;
?>

<script type="text/javascript">
				///////////////// Subcategory Options  ///////////////

var opt=[
["Language",
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
["Administration",
"Accountancy",
"Finance",
"Management",
"Advertising",
"Marketing",
"OTHER"
],
["Communications & Media",
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
["Dentistry",
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
["Architecture",
"Building",
"Industrial Design",
"Project & Facilities Mangement",
"Real Estate",
"OTHER"
],["Common Engineering",
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
],["Corporate Law",
"Criminal Law",
"International Law",
"Administrative Law",
"Property Law",
"OTHER",
],["Instruments",
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
],["Digital Animation",
"Digital Filmaking",
"Interactive Media",
"Photography & Digital Imaging",
"Product Design",
"Visual Communication",
"OTHER",
],["Arts (education)",
"Science (education)",
"Special Education",
"OTHER",
],["General Sport Science","OTHER"],["Engineering",
"Science",
"Arts, Humanities, Social Sciences",
"Arts, Design & Media",
"Business/ Finance/ Management",
"Medicine",
"Technology",
"Education",
"OTHER",
]];
				/////////////// Choosing Subcategory based on choice of Category /////////////
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

<script>
function fetch(output)
{
	$('#activities').html(output).show();
}
</script>
<script>
function closeIframe() {
  
   document.close();
}
</script>

<script type="text/javascript">
function createvalidate()
{
var x=document.forms["myform"]["classname"].value;

if (x==null || x=="")
  {
  alert("Class Name must be filled out");
  return false;
  }

 return true;
}
</script>


				<!--  //////////// Inputting Details  /////////  -->
<div class="gradient" id="profusername" align="center">
<span align="center" style="color:#333; font-size:24px; font-weight:bold;" >Create Class</span>
</div>
<table align="center" style="color:#333; font-size:16px; font-weight:bold;">


<form method="get" action="createclass.php" name="myform" onsubmit="return createvalidate()">
<tr>
<td>
Class Name:
</td>
<td>
<input type="text" name="classname" placeholder="Class Name" size="32px">
</td>
</tr>
<tr>
<td>
Category:
</td>
<td>
<select name="box1" onchange="Box2(this.selectedIndex)" style="width:230px">
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
    
</select>
</td>
</tr>
<tr>
<td>
Sub-Category:
</td>
<td>
<select name="box2" style="width:230px"></select>
 </td>
 </tr> 

<tr>
<td>
Privacy:
</td>
<td>  
<select name="privacy" placeholder="Privacy" style="width:230px">
	<option value="0"> Global </option>
	<option value="1"> Private </option>
</select>
</td>
</tr>
<?php 
	$rating=0;

?>
<input name="rating" type="hidden" value="<? echo $rating; ?>">
<br><br><br>
<tr>
<td>
<a href="javascript: window.parent.closeIframe()">
	<input type="submit" class="myButton" name="submit" value="Create Classroom" >
</a>
</td>
</tr>
</form>
</table>













