<? include "dbconnect.php"; //Connect to the database
$GrpID=$_POST['GrpID']; //id of the whiteboard group
$sql="SELECT * FROM collwb_event WHERE GroupID=".$GrpID." AND Activewb=1"; //Fetches information of active whiteboard
$wbinfo=mysql_fetch_array(mysql_query($sql));
//TIMER CODE
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
$result=calcTime($wbinfo['lastmu']);
// this page is called after 30 sec, so checking for a 30sec inactivity period would mean that if the user writing on the whiteboard has been inactive for a minute, we change him from write to view mode to give the other users a chance to write
if($result["D"]>0 || $result["H"]>0 || $result["M"]>0 || $result["S"]>30){
			//echo "YES";
			switchtoview($GrpID);
		}
function switchtoview($grp) {
	$sql="UPDATE collwb_groupmembers SET Mode=0 WHERE GroupID=".$grp;
	mysql_query($sql);
}
?>