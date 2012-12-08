<?php
  // include("dbconnect.php");
   $db_selected = new mysqli('localhost','connect1','om2407ntu','connect1_main');
	
	if(!$db_selected) {
	
		echo 'Could not connect to the database.';
	} else {
	
		if(isset($_POST['queryString'])) {
			$queryString = $db_selected->real_escape_string($_POST['queryString']);
			
			if(strlen($queryString) >0) {

				$query = $db_selected->query("SELECT classname FROM class_information WHERE classname LIKE '$queryString%' LIMIT 10");
				if($query) {
				echo '<ul>';
					while ($result = $query ->fetch_object()) {
	         			echo '<li onClick="fill(\''.addslashes($result->classname).'\');">'.$result->classname.'</li>';
	         		}
				echo '</ul>';
					
				} else {
					echo 'OOPS we had a problem :(';
				}
			} else {
				// do nothing
			}
		} else {
			echo 'There should be no direct access to this script!';
		}
	}
?>