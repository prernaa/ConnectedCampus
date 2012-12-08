<?php
//Connect to Database and get tags
  // include("dbconnect.php");
   $db_selected = new mysqli('localhost','connect1','om2407ntu','connect1_main');
	
	if(!$db_selected) {
	
		echo 'Could not connect to the database.';
	} else {
	
		if(isset($_POST['queryString'])) {
			$queryString = $db_selected->real_escape_string($_POST['queryString']);
			//Get tags from database and fill textbox
			if(strlen($queryString) >0) {

				$query = $db_selected->query("SELECT DISTINCT tagname FROM forum_tags WHERE tagname LIKE '$queryString%' LIMIT 10");
				if($query) {
				echo '<ul>';
					while ($result = $query ->fetch_object()) {
	         			echo '<li onClick="fill(\''.addslashes($result->tagname).'\');">'.$result->tagname.'</li>';
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