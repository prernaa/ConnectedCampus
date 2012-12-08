<?php
//Start Session and connect to DB


ob_start();
include("dbconnect.php");
session_start();


/*
 Below is a very simple and verbose PHP 5 script that implements the Engage token URL processing and some popular Pro/Enterprise examples.
 The code below assumes you have the CURL HTTP fetching library with SSL.  
*/

//For a production script it would be better to include the apiKey in from a file outside the web root to enhance security.
$rpx_api_key = '94ce31f4e04542b5d512b6075a584c013a8b61ab';


/*
 Set this to true if your application is Pro or Enterprise.
 Set this to false if your application is Basic or Plus.
*/
$engage_pro = false;

/* STEP 1: Extract token POST parameter */
$token = $_POST['token'];



  /* STEP 2: Use the token to make the auth_info API call */
  $post_data = array('token'  => $token,
                     'apiKey' => $rpx_api_key,
                     'format' => 'json',
                     'extended' => 'true'); //Extended is not available to Basic.

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, 'https://rpxnow.com/api/v2/auth_info');
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_FAILONERROR, true);
  $result = curl_exec($curl);
  if ($result == false){
    echo "\n".'Curl error: ' . curl_error($curl);
    echo "\n".'HTTP code: ' . curl_errno($curl);
    echo "\n"; var_dump($post_data);
  }
  curl_close($curl);


  /* STEP 3: Parse the JSON auth_info response */
  $auth_info = json_decode($result, true);

 
    echo "Info Recieved:<br>";
//   echo "\n"; var_dump($auth_info);

      /* Extract the needed variables from the response */
      $profile = $auth_info['profile'];
      $identifier = $profile['identifier'];
      $provider = $profile['providerName'];


//echo "Username: ".$profile["displayName"]."<br>";
$name= $profile["name"]["formatted"];
$email=$profile["email"];
$photo=$profile["photo"];
$_SESSION['email']=$email;
//Check if email already present
$q=mysql_query("SELECT * FROM user_information WHERE email='$email'");
//Make database entry, start session and send to profile_main
if(mysql_num_rows($q)==0)
{
$q=mysql_query("INSERT INTO user_information VALUES(null,'$password','$email','$name','','','','$photo','','1','','','','','','')");
header("location:profile_main.php");
}
else
{
if(isset($_SESSION['url']))
{
header("location:".$_SESSION['url']."");

}
else
{
header("location:profile_main.php");
}
}

?>