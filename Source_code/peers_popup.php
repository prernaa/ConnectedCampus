<?php
$auth=1;
include('includes.php');


?>
<html>
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript">
	/* Calls when the page button is clicked, used to link user to next page */
    function pageTurn(peerName,peerUni,peerLoc,peerField,control) {
		window.open("peers_popup.php?peerName="+peerName+"&peerUni="+peerUni+"&peerLoc="+peerLoc+"&peerField="+peerField+"&submit=Search&page="+control, "_self")
    }
	/* calls when user intends to request to be a peer, sends data to fsql.php to update the database */
	function addPeer(id, btnid){
		if(btnid.value!="Request Sent"){
		$.post('includes/fsql.php', { postID: 'reqPeer' , userid: <?php echo getID($_SESSION['email']); ?> , peerid:id});
		btnid.value="Request Sent";
		}
	}
	/* calls when user intends to accept a peer request, sends data to fsql.php to update the database */
	function accPeer(id, btnid){
		if(btnid.value!="Peer Added"){
		$.post('includes/fsql.php', { postID: 'accPeer' , userid: <?php echo getID($_SESSION['email']); ?> , peerid:id});
		btnid.value="Peer Added";
		}
	}
</script>
<style type="text/css">
body {
font-family:Cambria,'Palatino Linotype','Book Antiqua','URW Palladio L',serif;
background-color:#dadada;
}	
#top {
background-color:#fafafa;
position: absolute;
top:30;
left:30;
right:38;
padding:10px;

font-size:18px;
color:#5c818a;

}
#main{
padding:10px;
padding-top:15px;	
position: absolute;
background-color:#fafafa;
top:86;
left:30;
bottom: 30;
width: 200px;
color:#6D929B;
font-size:18px;

}
.input {
    border: 1px solid #2F4F4F;
	width: 195px;
	color:#FF3100 ;
}
.input-mini {
    border: 1px solid #2F4F4F;
	width: 185px;
	color:#FF5100 ;
}
.button {
background:#ffffff;
border: 1px solid #000000;
outline:none;
}
#spacer{
height:5px;
}
#spacer2{
height:15px;
}
#tabber{
padding-left:10px;
padding-top:10px;
}
#button{
padding-left:124px;
}
#show{
position:absolute;
left:280px;
top:86px;
right:0px;
bottom:30px;
}
.box{
background-color:#fafafa;
width:300px;
height:115px;
float:left;
margin: 0 20px 20px 0;
padding: 10px;
font-size:14px;
}
.boxleft{
float:left;	
}
.boxright{
float:left;	
padding-left:10px;
}
#buttonfooter{
position:absolute;
bottom:0px;
right:30px;

}
.buttonNum{
background:#ffffff;
float:right;
padding:5px;
margin:5px;
}
  </style>
</head>
<body>
<div id="top">

FIND PEERS
</div>
<div id="main">
<form action="peers_popup.php" method="get">
CRITERIA<br>
<div id="spacer"></div>
<input type="text" name="peerName" class="input" />
<div id="spacer2"></div>
FILTER BY<br>
<div id="tabber">
University<br>
<input type="text" name="peerUni" class="input-mini" />
<div id="spacer2"></div>
Location<br>
<input type="text" name="peerLoc" class="input-mini" />
<div id="spacer2"></div>

Field of study<br>
<input type="text" name="peerField" class="input-mini" />
<div id="spacer2"></div>
<div id="spacer"></div>
<div id="button">
<input type="submit" name="submit" value="Search" class="button" />
</form>
</div>
</div>
</div>
<div id="show">
<?php
// Checks if submit button is pressed
if(isset($_GET['submit'])){

// Gets page number
if(!isset($_GET['page'])){
$page = 1;
} else {
$page = $_GET['page'];
}
// iterate through database

$sql = mysql_query("SELECT * FROM user_information");

$data = array();

while($peer = mysql_fetch_array($sql)){
// Friend check

// Checks if there is any name matches
$boolName = inText(getNamewID($peer['userid']), $_GET['peerName']);
if($boolName != -1 || $_GET['peerName'] == ''){
$boolName = True;
} else {
$boolName = False;
}

// Checks if there is any university matches
$boolUni = inText(fetchData("user_information", "university", "userid", $peer['userid']), $_GET['peerUni']);
if($boolUni != -1 || $_GET['peerUni'] == ''){
$boolUni = True;
} else {
$boolUni = False;
}

// Checks if there is any location matches
$boolLoc = inText(fetchData("user_information", "country", "userid", $peer['userid']), $_GET['peerLoc']);
if($boolLoc != -1 || $_GET['peerLoc'] == ''){
$boolLoc = True;
} else {
$boolLoc = False;
}

// Checks if there is any field of study matches
$boolField = inText(fetchData("user_information", "fieldofstudy", "userid", $peer['userid']), $_GET['peerField']);
if($boolField != -1 || $_GET['peerField'] == ''){
$boolField = True;
} else {
$boolField = False;
}


// Insert ids into array
if($boolName && $boolUni && $boolLoc && $boolField && getNum2("friends", "userid", getID($_SESSION['email']), "friendid",  $peer['userid'])==0 && $peer['userid']!=getID($_SESSION['email'])) {
$data[] = $peer;
}
}

// limit result variable
$lb=(($page-1)*10);
$hb=$page*10-1;

// Iterates through newly constructed array
for($i=$lb;$i<$hb;$i++){
if($data[$i]!=NULL){
?>
<div class="box">
<div class="boxleft"><a target="parentWindow" href="profile_main.php?userid=<?php echo $data[$i]['userid']; ?>">
<img src="<?php 
if(getPic($data[$i]['userid'])!=''){
echo getPic($data[$i]['userid']);
} else {
echo "img/defpic.png";
} ?>" width=120px height=100px></img></a>
</div>
<div class="boxright">
<span style="font-size:17px; color:#5c818a">
<?php 
$name = getNamewID($data[$i]['userid']); 
if(strlen($name)<20){
echo $name;
} else {
echo substr($name, 0,20);
echo"...";
}
?>
</span><br>
<div id="spacer"></div>
<div id="spacer"></div>	
<?php 
// get school
$school = fetchData('user_information', 'university', 'userid', $data[$i]['userid']);
if($school !=''){
if(strlen($school)<17){
echo $school;
} else {
echo substr($school, 0,17);
echo"...";
}
} else {

echo 'school not specified';
}
?><br>
<?php 
// get country
$country = fetchData('user_information', 'country', 'userid', $data[$i]['userid']);
if($country !=''){
if(strlen($country)<17){
echo $country;
} else {
echo substr($country, 0, 17);
echo"...";
}
} else {
echo 'country not specified';
}
?><br>
<?php 
// get field of study
$field = fetchData('user_information', 'fieldofstudy', 'userid', $data[$i]['userid']);
if($field !=''){
if(strlen($field)<17){
echo $field;
} else {
echo substr($field,0,17);
echo"...";
}
} else {
echo 'field not specified';
}
$frs = "SELECT * FROM friends_request WHERE userid='".$data[$i]['userid']."' AND friendid='".getID($_SESSION['email'])."' AND status='0'";// Request Sent
$frs = mysql_query($frs);
$frp = "SELECT * FROM friends_request WHERE userid='".getID($_SESSION['email'])."' AND friendid='".$data[$i]['userid']."' AND status='0'"; // Request Pending
$frp = mysql_query($frp);
if(	mysql_num_rows($frs)==1){
?><br>

<div id="spacer2"></div>
<input type="submit" value="Request Sent"  class="button" />	
</div>
</div>
<?php
} elseif(mysql_num_rows($frp)==1){
?><br>

<div id="spacer2"></div>
<input type="submit" value="Accept Request" onclick="accPeer(<?php echo $data[$i]['userid'];	 ?>, this)" class="button" />	
</div>
</div>
<?php
} else {
?><br>

<div id="spacer2"></div>
<input type="submit" value="Add Peer" onclick="addPeer(<?php echo $data[$i]['userid'];	 ?>, this)" class="button" />	
</div>
</div>
<?php
}

}
}
}


?>
<div id="buttonfooter">
<?php $size = ceil(sizeof($data)/9);

// Prints page turn buttons
for($i=$size;$i>=1;$i--){
?>
<div style="cursor: pointer;" onclick="pageTurn('<?php echo $_GET[peerName]; ?>','<?php echo $_GET[peerUni]; ?>','<?php echo $_GET[peerLoc]; ?>','<?php echo $_GET[peerField]; ?>',<?php echo $i; ?>)" class="buttonNum">
<?php echo $i; ?>
</div>
<?php
}
?>
</div>
</div>
</body>
</html>