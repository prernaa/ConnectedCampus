<?
$usermail=$userinfo['email']; //email address of user whose profile is being viewed

//Below, $privacybday, $privacypic, $privacypeers, $privacyabt contain privacy settings of the user for birthday, profile pic, peers, about, etc
//0 means global, 1 means peer & 2 means only the user himself & no one else
$qp1=mysql_query("SELECT * FROM privacy_user WHERE email='".$usermail."' AND property='bday'");
if(mysql_num_rows($qp1)==0){
	$privacybday=0;
}
else{
	$prbday=mysql_fetch_array($qp1);
	$privacybday=$prbday['setting'];
}
$qp2=mysql_query("SELECT * FROM privacy_user WHERE email='".$usermail."' AND property='pic'");
if(mysql_num_rows($qp2)==0){
	$privacypic=0;
}
else{
	$prbpic=mysql_fetch_array($qp2);
	$privacypic=$prbpic['setting'];
}
$qp3=mysql_query("SELECT * FROM privacy_user WHERE email='".$usermail."' AND property='peers'");
if(mysql_num_rows($qp3)==0){
	$privacypeers=0;
}
else{
	$prpeers=mysql_fetch_array($qp3);
	$privacypeers=$prpeers['setting'];
}
$qp4=mysql_query("SELECT * FROM privacy_user WHERE email='".$usermail."' AND property='abtme'");
if(mysql_num_rows($qp4)==0){
	$privacyabt=0;
}
else{
	$prabt=mysql_fetch_array($qp4);
	$privacyabt=$prabt['setting'];
}

function checkpeer($l, $u){ //checks if two userids passed as parameters are peers of each other
	$query=mysql_query("SELECT * FROM friends WHERE userid=".$u." AND friendid=".$l);
	if(mysql_num_rows($query)==1){
		return 1;
	}
	else{
		return 0;
	}
}


?>

<!--<button onclick="popup()">Click</button>-->

<div id="pbox">
<div id="pbox_img_hold">
<!--displays picture of the user whose profile is being viewed along with his other details considering his privacy settings-->
<img src="<? if($userinfo['photo']==""){echo "img/defpic.png";}else{if($privacypic==0||($privacypic==1 && checkpeer($logid, $user)==1)|| ($privacypic==2 && $logid==$user)) {echo $userinfo['photo'];}else echo "img/defpic.png"; } ?>" height="100" width="100"></div>
<div id="pdes_hold">
<h5><? echo $userinfo['name']; ?>
<a style="text-decoration:none;" class='iframe' tabindex='1' href='newmessage.php?touser=<? echo $userinfo['userid']; ?>'> <img src='img/add_message.png'></a> 

<? $query2=mysql_query("SELECT * FROM friends WHERE userid=".$user." AND friendid=".$logid);
$query3=mysql_query("SELECT * FROM friends_request WHERE userid=".$user." AND friendid=".$logid);
if($user!=$logid){
	//If the logged in user is viewing another users profile, he will see appropriate options like 'remove peer', 'add peer' 'accept request', 'peer request sent'
	//The code for these options is in profile_options.php
if(mysql_num_rows($query2)!=0){ //i.e. confirmed friend ?>
<a href="profile_options.php?<? echo "userid=".$user."&action=3"; ?>"><img src="img/p_del2.png" width="18" height="18"/></a>
<? } //ending if
else if(mysql_num_rows($query3)==0){ ?>
<a href="profile_options.php?<? echo "userid=".$user."&action=1"; ?>"><img src="img/p_add2.png" width="18" height="18"/></a>
<? } else{ 
$statuspeer=mysql_fetch_array($query3);
if($statuspeer['status']==1){?>
<a href="profile_options.php?<? echo "userid=".$user."&action=2"; ?>"><img src="img/p_acpt2.png" width="18" height="18"/></a>
<? } 
elseif($statuspeer['status']==0){?>
<img src="img/p_sent2.png" width="18" height="18"/>
<? }
} 
}?>
</h5><br/>


<div id="pdescription">
<? if($userinfo['university']!=""){echo $userinfo['university'];} ?><br/>
<? if($userinfo['occupation']!="") {echo $userinfo['occupation']." in ";} ?><? if($userinfo['fieldofstudy']!="") {echo $userinfo['fieldofstudy'].", ";} ?>
<? if(($userinfo['graduationyr']!="") && ($userinfo['graduationyr']!=0)) {echo "Class of ".$userinfo['graduationyr'];} ?><br/>
<? if($userinfo['city']!="") {echo $userinfo['city'].", ";} if($userinfo['country']!="") {echo $userinfo['country'];} ?><br />
<? $birthday=$userinfo['bday']; $birthmonth=$userinfo['bmonth']; $birthyear=$userinfo['byear']; 
  if($birthday[1]=="1") {$bdaysup="st";} 
  else if($birthday[1]=="2") {$bdaysup="nd";}
  else if($birthday[1]=="3") {$bdaysup="rd";}
  else $bdaysup="th";?>
<? if(($birthday!="") && ($birthmonth!="")) {echo "B'day: ".$birthday."<sup>".$bdaysup."</sup>"." ".$birthmonth." ".$birthyear;} ?><br/>
</div>
<div id="pnav_bar">
<? if($user==$logid){?>
<div class = "class_nav_btn">
<a href='picupdate.php' class='iframe'>Edit avatar</a>
</div>
<div class = "class_nav_btn">
<a href='profile.php?action=edit&tab=personal'>Settings</a>
</div>
<? }//ending if ?>
<div class = "class_nav_btn">
<a href="peers_main.php?userid=<?php echo $user;?>">Peers</a>
</div>
<div class = "class_nav_btn">
<a href="profile_main.php?userid=<?php echo $user;?>">Main</a>
</div>
</div>
</div>

</div>