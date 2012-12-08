<?
//This file is responsible for making users active & inactive 
include "dbconnect.php"; //connects to the DB
$GrpID=$_POST['GrpID']; //The groupid of the whiteboard group is sent via GET variable
//CODE FOR COMPARE TIME
$query=mysql_query("SELECT userid FROM collwb_groupmembers WHERE GroupID=$GrpID AND Activity=1");
while($record=mysql_fetch_array($query)) {	
	if((checkmodeactivity($GrpID, $record['userid'])==0) && (checklastactivity($GrpID, $record['userid'])==0)) { 
		mysql_query("UPDATE collwb_groupmembers SET Activity=0 WHERE GroupID=".$GrpID." AND userid=".$record['userid']);
	}
	echo"<br/>";
}

function calcTime($datein){
       $tempsplit=explode(" ",$datein);
       $tempdate=explode("-",$tempsplit[0]);
	   $temptime=explode(":", $tempsplit[1]);
       $year = $tempdate[0];
       $month= $tempdate[1];
       $day = $tempdate[2];
       $hour = $temptime[0];
       $minute = $temptime[1];
       $second = $temptime[2];
       list($d,$h,$m,$s) = comparecurrent($year, $month, $day, $hour,$minute, $second);
       return array("D"=>$d, "H"=>$h, "M"=>$m, "S"=>$s);
}

 function comparecurrent($year, $month, $day, $hour, $minute, $second)
               {
                 global $return;
                 global $user_stamp;
                 $user_stamp = mktime($hour, $minute, $second, $month, $day, $year); 
                 $today = time();
                 $diff = $today-$user_stamp;
                 if ($diff < 0)$diff = 0;
                 $d = floor($diff/60/60/24);
                 $h = floor(($diff - $d*60*60*24)/60/60);
                 $m = floor(($diff - $d*60*60*24 - $h*60*60)/60);
                 $s = floor(($diff - $d*60*60*24 - $h*60*60 - $m*60));
               // OUTPUT
               $return = array($d, $h, $m, $s);
               return $return;
               }
			   
function checkmodeactivity($grp, $usrid) { //returns 0 if view OR 1 if write
	$sql="SELECT * FROM collwb_groupmembers WHERE GroupID=".$grp." AND userid=".$usrid." AND Mode=1"; //checks if user is on write mode
	if(!mysql_num_rows(mysql_query($sql))) {//if user is not on write mode. He is on view mode. so returns 0
		return 0; 
	}
	else {
		return 1;//user is on write mode-->NOT INACTIVE
	}
}

function checklastactivity($grp, $usrid){ //checks if 5min have passed since the user's last activity
	$sql="SELECT * FROM collwb_groupmembers WHERE GroupID=".$grp." AND userid=".$usrid;
	$datanew=mysql_fetch_array(mysql_query($sql));
	$result=calcTime($datanew['LastUserActivity']);
	if($result["D"]>0 || $result["H"]>0 || $result["M"]>4){
			echo date("Y-m-d G:i:s", time())."<br>";
			echo $result['D']." ".$result['H']." ".$result['M']." ".$result['S']."<br>";
			return 0; //5min have passed--> INACTIVE
		}
	else {
		return 1;
	}
}
?>