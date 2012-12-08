<?php
// Start session
session_start();

// Connect to database
$con = mysql_connect("localhost","connect1","om2407ntu");

// Check if connection is successful
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

// Select database  
$db_selected = mysql_select_db('connect1_main', $con);

// Set variable placeholders
$email=$_SESSION['email'];
$user_data=mysql_query("SELECT * FROM user_information WHERE email='".$email."'");
$user_data=mysql_fetch_array($user_data);
  
  
?>