<?php
$auth=1;
include('includes.php'); //including "includes" file which connects to the database.
include('html_top.php'); //including the top header & left bar
//This page is displayed whenever the user tries to go to a page he doesn't have access to.
//IF THE USER FOLLOWS THE LINKS AND USES THE APP APPROPRIATELY, HE WILL NEVER LAND ON THIS PAGE
?>
<br/>
Denied Access! You are either not authorized to view this page or this page does not exist!
</br>

<?php
include('html_bottom.php'); //including bottom footer
?>