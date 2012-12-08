<script src="http://code.jquery.com/jquery-latest.js"></script>
<?php
//Start Session and connect to Database
session_start();
include("dbconnect.php");
//Display form for image upload
echo "<center><form action='picupdate.php' method='post' enctype='multipart/form-data' name='image_upload_form' id='image_upload_form' style='margin-bottom:0px;'>
<label>Maximum: 4Mb | Only JPEG:</label><br><br />
          <input name='image_upload_box' type='file' id='image_upload_box' size='40' class='myButton'/>
          <input type='submit' name='submit' value='Upload image' class='myButton' /><input name='submitted_form' type='hidden' id='submitted_form' value='image_upload_form' />
          </form></center>";

//Check if form already submitted
if ((isset($_POST["submitted_form"])) && ($_POST["submitted_form"] == "image_upload_form")) {
	
	// file needs to be jpg,gif,bmp,x-png and 4 MB max
	if (($_FILES["image_upload_box"]["type"] == "image/jpeg" || $_FILES["image_upload_box"]["type"] == "image/pjpeg" || $_FILES["image_upload_box"]["type"] == "image/gif" || $_FILES["image_upload_box"]["type"] == "image/x-png") && ($_FILES["image_upload_box"]["size"] < 4000000))
	{
		
  
		// some settings
		$max_upload_width = 150;
		$max_upload_height = 200;
		  
		// if user chosed properly then scale down the image according to user preferances
		if(isset($_REQUEST['max_width_box']) and $_REQUEST['max_width_box']!='' and $_REQUEST['max_width_box']<=$max_upload_width){
			$max_upload_width = $_REQUEST['max_width_box'];
		}    
		if(isset($_REQUEST['max_height_box']) and $_REQUEST['max_height_box']!='' and $_REQUEST['max_height_box']<=$max_upload_height){
			$max_upload_height = $_REQUEST['max_height_box'];
		}	

		
		// if uploaded image was JPG/JPEG
		if($_FILES["image_upload_box"]["type"] == "image/jpeg" || $_FILES["image_upload_box"]["type"] == "image/pjpeg"){	
			$image_source = imagecreatefromjpeg($_FILES["image_upload_box"]["tmp_name"]);
		}		
		// if uploaded image was GIF
		if($_FILES["image_upload_box"]["type"] == "image/gif"){	
			$image_source = imagecreatefromgif($_FILES["image_upload_box"]["tmp_name"]);
		}	
		// BMP doesn't seem to be supported so remove it form above image type test (reject bmps)	
		// if uploaded image was BMP
		if($_FILES["image_upload_box"]["type"] == "image/bmp"){	
			$image_source = imagecreatefromwbmp($_FILES["image_upload_box"]["tmp_name"]);
		}			
		// if uploaded image was PNG
		if($_FILES["image_upload_box"]["type"] == "image/x-png"){
			$image_source = imagecreatefrompng($_FILES["image_upload_box"]["tmp_name"]);
		}
		//Append name with time, to give unique name to each file
		$name=time().$_FILES["image_upload_box"]["name"];
		//Address for image upload
		$remote_file = "image_files/".$name;
		imagejpeg($image_source,$remote_file,100);
		chmod($remote_file,0644);
	
	

		// get width and height of original image
		list($image_width, $image_height) = getimagesize($remote_file);
	
		if($image_width>$max_upload_width || $image_height >$max_upload_height){
			$proportions = $image_width/$image_height;
			
			if($image_width>$image_height){
				$new_width = $max_upload_width;
				$new_height = round($max_upload_width/$proportions);
			}		
			else{
				$new_height = $max_upload_height;
				$new_width = round($max_upload_height*$proportions);
			}		
			
			
			$new_image = imagecreatetruecolor($new_width , $new_height);
			$image_source = imagecreatefromjpeg($remote_file);
			
			imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
			imagejpeg($new_image,$remote_file,100);
			
			imagedestroy($new_image);
		}
		
		imagedestroy($image_source);
		//If succesful, display message and update database
		
		echo "<center><font color='green'>Upload successful</font></center>";
		echo "<script type='text/javascript'>
    self.parent.location.href='profile_main.php';
</script>";
		$pic=$name;
                $pic="http://connectedcampus.org/image_files/".$pic; 
                $email=$user_data['email'];
		$q=mysql_query("UPDATE user_information SET photo='$pic' WHERE email='$email'");
		
		exit;
	}
	else{
		echo "<center><font color='red'>Upload error</font></center>";
		exit;
	}
	}
?>