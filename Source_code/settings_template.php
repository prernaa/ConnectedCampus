<?php
//Start Session and connect to database
session_start();
$auth=1; //user must be logged in to view this page 

include('includes.php');
include('dbconnect.php');
include('html_top.php');
$email=$_SESSION['email'];
?>
<!-- Script for country city selection -->
<script src="country.js"></script>
<!-- Script for university suggestion -->
<script type='text/javascript'>

function suggest(inputString){
        if(inputString.length == 0) {
            $('#suggestions').fadeOut();
        } else {
        $('#uni').addClass('load');
            $.post("unisugg.php", {queryString: ""+inputString+""}, function(data){
                if(data.length >0) {
                    $('#suggestions').fadeIn();
                    $('#suggestionsList').html(data);
                    $('#uni').removeClass('load');
                }
            });
        }
    }
 
    function fill(thisValue) {
        $('#uni').val(thisValue);
        setTimeout("$('#suggestions').fadeOut();", 600);
    }
    
    function validate()
    {
    var x = document.form.name.value;
    if(x=="")
    {
    alert("Name cant be empty");
    return false;
    }
    return true;
    }
</script>

<style type="text/css">
.suggestionsBox {
	position: absolute;
left: 173px;
top: 115px;
margin: 166px 0px 0px 390px;
width: 190px;
padding: 0px;
background-color: #C8C8D0;
border-top: #C8C8D0;
color: black;
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

#pbox{
	width:720px;
	height:110px;
	background: #ffffff;
	border: 1px solid #fdfdfd;
	font-family: 'Century Gothic', sans-serif;
}
#pbox_img_hold{
	float:left;
	padding:5px;
}
#pdes_hold{
	float:left;
	padding:10px;
	width:450px;
}
#pdescription{

	font-size: 12px;

}
h5{
	font-family: 'Century Gothic', sans-serif;
    font-size: 25px;
	color: #1a1a1a;
	font-weight: normal;
	margin-top: -5px;
	margin-bottom: -10px;
}
#pnav_bar{
	float:right;
	padding-top:0px;
	margin-right:-130px;
}
.class_nav_btn{
	background:#f7f7f7;
	height:15px;
	padding:5px 20px 5px 20px;
	float:right;
	margin-left:10px;
	border: 1px solid #ffffff;
}
</style>

<style type="text/css">
#class_contentbox{
margin-top:20px;
}
#cblog_wrap{
width:450px;
float:left;
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
<div id="class_contentbox">
<div id="cblog_wrap">


<form name='form' method='post' action='updatepro.php'>
<div class="pblog_pm">
<p>PERSONAL SETTINGS</p>
<hr class="psep" />
<div class="space8"></div>
<div class="w_list">
NAME<br/>

<div style="height:12px;"></div>
BIRTHDAY
<div style="height:11px;"></div>
STUDY/WORK<br/>
<div style="height:11px;"></div>
UNIVERSITY<br/>
<div style="height:11px;"></div>
FIELD OF STUDY<br/>
</div>
<div class="w_boxes">
<input name="name" value="<? echo $user_data['name']; ?>" class="winput" style="margin-top:5px" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></input><br/>
<div class="space8"></div>
<div class="space8"></div>


<div style="margin-top:-8px; font-size:16px;">
<select name='bmonth' class="wselect" id='bmonth' onchange='loadchild4f5cbbed28c77(this)' selected="<? echo $user_data['bmonth']; ?>"><option value=''>-Select-</option><option value='January'>January</option><option value='February'>February</option><option value='March'>March</option><option value='April'>April</option><option value='May'>May</option><option value='June'>June</option><option value='July'>July</option><option value='August'>August</option><option value='September'>September</option><option value='October'>October</option><option value='November'>November</option><option value='December'>December</option></select>
<select class="wselect" name='childdrop4f5cbbed28c77' id='childdrop4f5cbbed28c77' ></select>
<select name='byear' class="wselect"><option value='2010
'>2010
</option><option value='2009
'>2009
</option><option value='2008
'>2008
</option><option value='2007
'>2007
</option><option value='2006
'>2006
</option><option value='2005
'>2005
</option><option value='2004
'>2004
</option><option value='2003
'>2003
</option><option value='2002
'>2002
</option><option value='2001
'>2001
</option><option value='2000
'>2000
</option><option value='1999
'>1999
</option><option value='1998
'>1998
</option><option value='1997
'>1997
</option><option value='1996
'>1996
</option><option value='1995
'>1995
</option><option value='1994
'>1994
</option><option value='1993
'>1993
</option><option value='1992
'>1992
</option><option value='1991
'>1991
</option><option value='1990
'>1990
</option><option value='1989
'>1989
</option><option value='1988
'>1988
</option><option value='1987
'>1987
</option><option value='1986
'>1986
</option><option value='1985
'>1985
</option><option value='1984
'>1984
</option><option value='1983
'>1983
</option><option value='1982
'>1982
</option><option value='1981
'>1981
</option><option value='1980
'>1980
</option><option value='1979
'>1979
</option><option value='1978
'>1978
</option><option value='1977
'>1977
</option><option value='1976
'>1976
</option><option value='1975
'>1975
</option><option value='1974
'>1974
</option><option value='1973
'>1973
</option><option value='1972
'>1972
</option><option value='1971
'>1971
</option><option value='1970
'>1970
</option><option value='1969
'>1969
</option><option value='1968
'>1968
</option><option value='1967
'>1967
</option><option value='1966
'>1966
</option><option value='1965
'>1965
</option><option value='1964
'>1964
</option><option value='1963
'>1963
</option><option value='1962
'>1962
</option><option value='1961
'>1961
</option><option value='1960
'>1960
</option><option value='1959
'>1959
</option><option value='1958
'>1958
</option><option value='1957
'>1957
</option><option value='1956
'>1956
</option><option value='1955
'>1955
</option><option value='1954
'>1954
</option><option value='1953
'>1953
</option><option value='1952
'>1952
</option><option value='1951
'>1951
</option><option value='1950
'>1950
</option><option value='1949
'>1949
</option><option value='1948
'>1948
</option><option value='1947
'>1947
</option><option value='1946
'>1946
</option><option value='1945
'>1945
</option><option value='1944
'>1944
</option><option value='1943
'>1943
</option><option value='1942
'>1942
</option><option value='1941
'>1941
</option><option value='1940
'>1940
</option><option value='1939
'>1939
</option><option value='1938
'>1938
</option><option value='1937
'>1937
</option><option value='1936
'>1936
</option><option value='1935
'>1935
</option><option value='1934
'>1934
</option><option value='1933
'>1933
</option><option value='1932
'>1932
</option><option value='1931
'>1931
</option><option value='1930
'>1930
</option><option value='1929
'>1929
</option><option value='1928
'>1928
</option><option value='1927
'>1927
</option><option value='1926
'>1926
</option><option value='1925
'>1925
</option><option value='1924
'>1924
</option><option value='1923
'>1923
</option><option value='1922
'>1922
</option><option value='1921
'>1921
</option><option value='1920
'>1920
</option><option value='1919
'>1919
</option><option value='1918
'>1918
</option><option value='1917
'>1917
</option><option value='1916
'>1916
</option><option value='1915
'>1915
</option><option value='1914
'>1914
</option><option value='1913
'>1913
</option><option value='1912
'>1912
</option><option value='1911
'>1911
</option><option value='1910
'>1910
</option><option value='1909
'>1909
</option><option value='1908
'>1908
</option><option value='1907
'>1907
</option><option value='1906
'>1906
</option><option value='1905
'>1905
</option><option value='1904
'>1904
</option><option value='1903
'>1903
</option><option value='1902
'>1902
</option><option value='1901
'>1901
</option><option value='1900'>1900</option></select><div class="space8"></div>
<!-- Show options for Occupation -->
<?php echo "<select class='wselect2' name='occupation' selected='".$user_data['occupation']."' >
<option value='Junior School' ";if($user_data['occupation']=='Junior School'){echo "selected";}echo ">Junior school</option>
<option value='High School' ";if($user_data['occupation']=='High School'){echo "selected";}echo ">High School</option>
<option value='Bachelors' ";if($user_data['occupation']=='Bachelors'){echo "selected";}echo ">Bachelors</option>
<option value='Masters' ";if($user_data['occupation']=='Masters'){echo "selected";}echo ">Masters</option>
<option value='PHD' ";if($user_data['occupation']=='PHD'){echo "selected";}echo ">PHD</option>
<option value='Professor' ";if($user_data['occupation']=='Professor'){echo "selected";}echo ">Prof</option>
<option value='Lecturer' ";if($user_data['occupation']=='Lecturer'){echo "selected";}echo ">Lecturer</option>
<option value='Other' ";if($user_data['occupation']=='Other'){echo "selected";}echo ">Other</option>
<option value=''";if($user_data['occupation']==""){echo "selected";}echo "> </option>
</select><br/>"; ?>


</div>

<div style="height:12px;"></div>
<!-- Show option for University with auto fill suggestions -->
<input id="uni" autocomplete="off" value="<?php echo $user_data['university']; ?>" onkeyup='suggest(this.value);' name='uni' class="winput" style="margin-top:5px" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"><div id='suggestions' class='suggestionsBox' style='display: none;'>
 <img style='position: relative; top: -12px; left: 30px;' src='arrow.png' alt='upArrow' />
<div id='suggestionsList' class='suggestionList'></div>
</div><br />
<input name='fieldofstudy' value='<? echo $user_data['fieldofstudy']; ?>' class="winput" style="margin-top:12px" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></input><br/>
<div style="height:5px;"></div>

</div>
<div class="w_listr">
<div style="margin-top:-9px;"></div>
GRADUATION YEAR<br/>
<div style="height:1px;"></div>
COUNTRY<br/>
<div style="height:9px;"></div>
CITY<br/>
<div style="height:11px;"></div>
ABOUT ME<br/>
<div style="height:38px;"></div>
</div>
<div class="w_boxes">
<input class="winput" name='graduationyr' value='<? if($user_data['graduationyr']==0){echo " ";}else{echo $user_data['graduationyr'];}?>' style="margin-top:5px" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></input><br/>
<div style="height:13px;"></div>
<select class="wselect2" name='parentdrop1' id='parentdrop1' onchange='loadchild4f5cb8a6e68e3(this)' style='margin-left:2px;margin-right:2px;font-weight: Lighter; font-family: Times New Roman; background-color: #FFFFFF; color: #000000; font-size: 12px; width: 120px; '><option value=''>-Select-</option><option value='Afghanistan'>Afghanistan</option><option value='Albania'>Albania</option><option value='Algeria'>Algeria</option><option value='American Samoa'>American Samoa</option><option value='Andorra'>Andorra</option><option value='Angola'>Angola</option><option value='Anguilla'>Anguilla</option><option value='Antarctica'>Antarctica</option><option value='Antigua and Barbuda'>Antigua and Barbuda</option><option value='Argentina'>Argentina</option><option value='Armenia'>Armenia</option><option value='Aruba'>Aruba</option><option value='Australia'>Australia</option><option value='Austria'>Austria</option><option value='Azerbaijan'>Azerbaijan</option><option value='Bahamas'>Bahamas</option><option value='Bahrain'>Bahrain</option><option value='Bangladesh'>Bangladesh</option><option value='Barbados'>Barbados</option><option value='Belarus'>Belarus</option><option value='Belgium'>Belgium</option><option value='Belize'>Belize</option><option value='Benin'>Benin</option><option value='Bermuda'>Bermuda</option><option value='Bhutan'>Bhutan</option><option value='Bolivia'>Bolivia</option><option value='Bosnia and Herzegovina'>Bosnia and Herzegovina</option><option value='Botswana'>Botswana</option><option value='Bouvet Island'>Bouvet Island</option><option value='Brazil'>Brazil</option><option value='British Indian Ocean Territory'>British Indian Ocean Territory</option><option value='Brunei'>Brunei</option><option value='Bulgaria'>Bulgaria</option><option value='Burkina Faso'>Burkina Faso</option><option value='Burundi'>Burundi</option><option value='Cambodia'>Cambodia</option><option value='Cameroon'>Cameroon</option><option value='Canada'>Canada</option><option value='Cape Verde'>Cape Verde</option><option value='Cayman Islands'>Cayman Islands</option><option value='Central African Republic'>Central African Republic</option><option value='Chad'>Chad</option><option value='Chile'>Chile</option><option value='China'>China</option><option value='Christmas Island'>Christmas Island</option><option value='Cocos (Keeling) Islands'>Cocos (Keeling) Islands</option><option value='Colombia'>Colombia</option><option value='Comoros'>Comoros</option><option value='Congo'>Congo</option><option value='Congo (DRC)'>Congo (DRC)</option><option value='Cook Islands'>Cook Islands</option><option value='Costa Rica'>Costa Rica</option><option value='Cote d Ivoire'>Cote d Ivoire</option><option value='Croatia'>Croatia</option><option value='Cuba'>Cuba</option><option value='Cyprus'>Cyprus</option><option value='Czech Republic'>Czech Republic</option><option value='Denmark'>Denmark</option><option value='Djibouti'>Djibouti</option><option value='Dominica'>Dominica</option><option value='Dominican Republic'>Dominican Republic</option><option value='Ecuador'>Ecuador</option><option value='Egypt'>Egypt</option><option value='El Salvador'>El Salvador</option><option value='Equatorial Guinea'>Equatorial Guinea</option><option value='Eritrea'>Eritrea</option><option value='Estonia'>Estonia</option><option value='Ethiopia'>Ethiopia</option><option value='Falkland Islands (Islas Malvinas)'>Falkland Islands (Islas Malvinas)</option><option value='Faroe Islands'>Faroe Islands</option><option value='Fiji'>Fiji</option><option value='Finland'>Finland</option><option value='France'>France</option><option value='French Guiana'>French Guiana</option><option value='French Polynesia'>French Polynesia</option><option value='French Southern and Antarctic Lands'>French Southern and Antarctic Lands</option><option value='Gabon'>Gabon</option><option value='Gambia'>Gambia</option><option value='Georgia'>Georgia</option><option value='Germany'>Germany</option><option value='Ghana'>Ghana</option><option value='Gibraltar'>Gibraltar</option><option value='Greece'>Greece</option><option value='Greenland'>Greenland</option><option value='Grenada'>Grenada</option><option value='Guadeloupe'>Guadeloupe</option><option value='Guam'>Guam</option><option value='Guatemala'>Guatemala</option><option value='Guernsey'>Guernsey</option><option value='Guinea'>Guinea</option><option value='Guinea-Bissau'>Guinea-Bissau</option><option value='Guyana'>Guyana</option><option value='Haiti'>Haiti</option><option value='Heard Island and McDonald Islands'>Heard Island and McDonald Islands</option><option value='Honduras'>Honduras</option><option value='Hong Kong SAR'>Hong Kong SAR</option><option value='Hungary'>Hungary</option><option value='Iceland'>Iceland</option><option value='India'>India</option><option value='Indonesia'>Indonesia</option><option value='Iran'>Iran</option><option value='Iraq'>Iraq</option><option value='Ireland'>Ireland</option><option value='Isle of Man'>Isle of Man</option><option value='Israel'>Israel</option><option value='Italy'>Italy</option><option value='Jamaica'>Jamaica</option><option value='Japan'>Japan</option><option value='Jersey'>Jersey</option><option value='Jordan'>Jordan</option><option value='Kazakhstan'>Kazakhstan</option><option value='Kenya'>Kenya</option><option value='Kiribati'>Kiribati</option><option value='Kuwait'>Kuwait</option><option value='Kyrgyzstan'>Kyrgyzstan</option><option value='Laos'>Laos</option><option value='Latvia'>Latvia</option><option value='Lebanon'>Lebanon</option><option value='Lesotho'>Lesotho</option><option value='Liberia'>Liberia</option><option value='Libya'>Libya</option><option value='Liechtenstein'>Liechtenstein</option><option value='Lithuania'>Lithuania</option><option value='Luxembourg'>Luxembourg</option><option value='Macao SAR'>Macao SAR</option><option value='Macedonia,Former Yugoslav Republic of'>Macedonia,Former Yugoslav Republic of</option><option value='Madagascar'>Madagascar</option><option value='Malawi'>Malawi</option><option value='Malaysia'>Malaysia</option><option value='Maldives'>Maldives</option><option value='Mali'>Mali</option><option value='Malta'>Malta</option><option value='Marshall Islands'>Marshall Islands</option><option value='Martinique'>Martinique</option><option value='Mauritania'>Mauritania</option><option value='Mauritius'>Mauritius</option><option value='Mayotte'>Mayotte</option><option value='Mexico'>Mexico</option><option value='Micronesia'>Micronesia</option><option value='Moldova'>Moldova</option><option value='Monaco'>Monaco</option><option value='Mongolia'>Mongolia</option><option value='Montenegro'>Montenegro</option><option value='Montserrat'>Montserrat</option><option value='Morocco'>Morocco</option><option value='Mozambique'>Mozambique</option><option value='Myanmar'>Myanmar</option><option value='Namibia'>Namibia</option><option value='Nauru'>Nauru</option><option value='Nepal'>Nepal</option><option value='Netherlands'>Netherlands</option><option value='Netherlands Antilles'>Netherlands Antilles</option><option value='New Caledonia'>New Caledonia</option><option value='New Zealand'>New Zealand</option><option value='Nicaragua'>Nicaragua</option><option value='Niger'>Niger</option><option value='Nigeria'>Nigeria</option><option value='Niue'>Niue</option><option value='Norfolk Island'>Norfolk Island</option><option value='North Korea'>North Korea</option><option value='Northern Mariana Islands'>Northern Mariana Islands</option><option value='Norway'>Norway</option><option value='Oman'>Oman</option><option value='Pakistan'>Pakistan</option><option value='Palau'>Palau</option><option value='Palestinian Authority'>Palestinian Authority</option><option value='Panama'>Panama</option><option value='Papua New Guinea'>Papua New Guinea</option><option value='Paraguay'>Paraguay</option><option value='Peru'>Peru</option><option value='Philippines'>Philippines</option><option value='Pitcairn Islands'>Pitcairn Islands</option><option value='Poland'>Poland</option><option value='Portugal'>Portugal</option><option value='Puerto Rico'>Puerto Rico</option><option value='Qatar'>Qatar</option><option value='Reunion'>Reunion</option><option value='Romania'>Romania</option><option value='Russia'>Russia</option><option value='Rwanda'>Rwanda</option><option value='Saint Helena'>Saint Helena</option><option value='Saint Kitts and Nevis'>Saint Kitts and Nevis</option><option value='Saint Lucia'>Saint Lucia</option><option value='Saint Pierre and Miquelon'>Saint Pierre and Miquelon</option><option value='Saint Vincent and the Grenadines'>Saint Vincent and the Grenadines</option><option value='Samoa'>Samoa</option><option value='San Marino'>San Marino</option><option value='São Tomé and Príncipe'>São Tomé and Príncipe</option><option value='Saudi Arabia'>Saudi Arabia</option><option value='Senegal'>Senegal</option><option value='Serbia'>Serbia</option><option value='Seychelles'>Seychelles</option><option value='Sierra Leone'>Sierra Leone</option><option value='Singapore'>Singapore</option><option value='Slovakia'>Slovakia</option><option value='Slovenia'>Slovenia</option><option value='Solomon Islands'>Solomon Islands</option><option value='Somalia'>Somalia</option><option value='South Africa'>South Africa</option><option value='South Georgia and the South Sandwich Islands'>South Georgia and the South Sandwich Islands</option><option value='South Korea'>South Korea</option><option value='Spain'>Spain</option><option value='Sri Lanka'>Sri Lanka</option><option value='Sudan'>Sudan</option><option value='Suriname'>Suriname</option><option value='Svalbard and jan Mayen'>Svalbard and jan Mayen</option><option value='Swaziland'>Swaziland</option><option value='Sweden'>Sweden</option><option value='Switzerland'>Switzerland</option><option value='Syria'>Syria</option><option value='Taiwan'>Taiwan</option><option value='Tajikistan'>Tajikistan</option><option value='Tanzania'>Tanzania</option><option value='Thailand'>Thailand</option><option value='Timor-Leste (East Timor)'>Timor-Leste (East Timor)</option><option value='Togo'>Togo</option><option value='Tokelau'>Tokelau</option><option value='Tonga'>Tonga</option><option value='Trinidad and Tobago'>Trinidad and Tobago</option><option value='Tunisia'>Tunisia</option><option value='Turkey'>Turkey</option><option value='Turkmenistan'>Turkmenistan</option><option value='Turks and Caicos Islands'>Turks and Caicos Islands</option><option value='Tuvalu'>Tuvalu</option><option value='Uganda'>Uganda</option><option value='Ukraine'>Ukraine</option><option value='United Arab Emirates'>United Arab Emirates</option><option value='United Kingdom'>United Kingdom</option><option value='United States'>United States</option><option value='United States Minor Outlying Islands'>United States Minor Outlying Islands</option><option value='Uruguay'>Uruguay</option><option value='Uzbekistan'>Uzbekistan</option><option value='Vanuatu'>Vanuatu</option><option value='Vatican City'>Vatican City</option><option value='Venezuela'>Venezuela</option><option value='Vietnam'>Vietnam</option><option value='Virgin Islands,British'>Virgin Islands,British</option><option value='Virgin Islands,U.S.'>Virgin Islands,U.S.</option><option value='Wallis and Futuna'>Wallis and Futuna</option><option value='Western Sahara'>Western Sahara</option><option value='Yemen'>Yemen</option><option value='Zambia'>Zambia</option><option value='Zimbabwe'>Zimbabwe</option></select><br /><div style="height:12px;"></div><select class="wselect2" name='childdrop4f5cb8a6e68e3' id='childdrop4f5cb8a6e68e3' style='margin-left:2px;margin-right:2px;font-weight: Lighter; font-family: Times New Roman; background-color: #FFFFFF; color: #000000; font-size: 12px; width: 120px; '></select><br />

<br />
<input class="winput" type='text' name='abtmebox' value='<? echo $user_data['abtme']; ?>' onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"><br/>
</div>
</div>
<?php
//If selected, change password
if(!$_GET['changepwd'])
{
//Disable change password for demo accounts
if(!($_SESSION['email']=="testuser1@connectedcampus.org" || $_SESSION['email']=="testuser1@connectedcampus.org" || $_SESSION['email']=="testuser1@connectedcampus.org"))
{

echo "Click <a href='settings_template.php?changepwd=yes'>here</a> to change password <br><br>";
}

}
//Show change password details
if(!($_SESSION['email']=="testuser1@connectedcampus.org" || $_SESSION['email']=="testuser1@connectedcampus.org" || $_SESSION['email']=="testuser1@connectedcampus.org"))
{
 if($_GET['changepwd'] && $flag !=1) { ?>
<div class="pblog_pm2">
<p>ACCOUNT SETTINGS</p>
<hr class="psep" />
<div class="space8"></div>
<div class="w_list">
EMAIL<br/>

<div style="height:5px; width:108px"></div>

</div>
<div class="w_boxes">
<input value="<? echo $user_data['email']; ?>" disabled="disabled" class="winput" style="margin-top:4px" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></input><br/>
<div class="space8"></div>
<div class="space8"></div>

</div>
<div class="w_listr">
<div style="margin-top:px;"></div>
PASSWORD
<div style="height:5px;"></div>
</div>
<div class="w_boxes">
<input class="winput" name="password" type="password" style="margin-top:4px" onMouseOver="this.style.border='1px solid #f4d040'" onMouseOut="this.style.border='1px solid #dadada'"></input><br/>
</div>
</div>
<? } }?>
<div class="pblog_pm">
<p>PRIVACY SETTINGS</p>
<hr class="psep" />
<div class="space8"></div>
<div class="w_list">
BIRTHDAY<br/>
<div style="height:11px;"></div>
ABOUT ME<br/>
<div style="height:11px;"></div>


<div style="height:5px; width:108px"></div>

</div>
<div class="w_boxes" style="font-size:13px;  max-width:194px;">
<div style="height:5px;"></div>	
<!-- Show privacy settings -->
    <select name="bday" class="wselect2">
  <option value='0' <? $p=mysql_query("SELECT * FROM privacy_user WHERE email='$email' AND property='bday'");$p=mysql_fetch_array($p);if($p['setting']==0){echo "selected";}?>>Global</option>
  
  <option value='1' <? $p=mysql_query("SELECT setting FROM privacy_user WHERE email='$email' AND property='bday'");$p=mysql_fetch_array($p);if($p['setting']==1){echo "selected";}?>>Peers</option>
  <option value='2' <? $p=mysql_query("SELECT setting FROM privacy_user WHERE email='$email' AND property='bday'");$p=mysql_fetch_array($p);if($p['setting']==2){echo "selected";}?>>Only Me</option>
  
</select><br />
<div style="height:14px;"></div>	
    <select name="abtme" class="wselect2">
  <option value='0' <? $p=mysql_query("SELECT * FROM privacy_user WHERE email='$email' AND property='abtme'");$p=mysql_fetch_array($p);if($p['setting']==0){echo "selected";}?>>Global</option>
  <option value='1' <? $p=mysql_query("SELECT * FROM privacy_user WHERE email='$email' AND property='abtme'");$p=mysql_fetch_array($p);if($p['setting']==1){echo "selected";}?>>Peers</option>
  <option value='2' <? $p=mysql_query("SELECT * FROM privacy_user WHERE email='$email' AND property='abtme'");$p=mysql_fetch_array($p);if($p['setting']==2){echo "selected";}?>>Only Me</option>
</select><br />
<div class="space8"></div>

</div>
<div class="w_listr">
<div style="margin-top:px;"></div>
PROFILE PIC<br/>
<div style="height:11px;"></div>
MY PEERS<br/>
<div style="height:5px;"></div>
</div>
<div class="w_boxes">
<div style="height:5px;"></div>	
    <select name="pic" class="wselect2">
  <option value='0' <? $p=mysql_query("SELECT * FROM privacy_user WHERE email='$email' AND property='pic'");$p=mysql_fetch_array($p);if($p['setting']==0){echo "selected";}?>>Global</option>
  <option value='1' <? $p=mysql_query("SELECT * FROM privacy_user WHERE email='$email' AND property='pic'");$p=mysql_fetch_array($p);if($p['setting']==1){echo "selected";}?>>Peers</option>
  <option value='2' <? $p=mysql_query("SELECT * FROM privacy_user WHERE email='$email' AND property='pic'");$p=mysql_fetch_array($p);if($p['setting']==2){echo "selected";}?>>Only Me</option>
</select><br />
<div style="height:13px;"></div>	
    <select name="peers" class="wselect2">
  <option value='0' <? $p=mysql_query("SELECT * FROM privacy_user WHERE email='$email' AND property='peers'");$p=mysql_fetch_array($p);if($p['setting']==0){echo "selected";}?>>Global</option>
  <option value='1' <? $p=mysql_query("SELECT * FROM privacy_user WHERE email='$email' AND property='peers'");$p=mysql_fetch_array($p);if($p['setting']==1){echo "selected";}?>>Peers</option>
  <option value='2' <? $p=mysql_query("SELECT * FROM privacy_user WHERE email='$email' AND property='peers'");$p=mysql_fetch_array($p);if($p['setting']==2){echo "selected";}?>>Only Me</option>
</select><br /><div class="space8"></div>
</div>
</div>


<div class="pblog_pm">
<div style="float:right">
<input name="submit" value="Submit" class="ccbutton"  onMouseDown="this.style.border='1px solid #f4d040'" onMouseUp="this.style.border='1px solid #dadada'" type="submit"></form>
</div>
</div>

</div>
</div>

<?php

include('html_bottom.php');

?>