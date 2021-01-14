<?php 

	include("../../config/config.php");
	

	if($_POST['userLoggedIn']==""){

		echo "Failed, the username was not provided!";

		exit();
	}

	$userLoggedIn=$_POST['userLoggedIn'];

	if($_POST['oldPassword']=="" || $_POST['newPassword']==""){

		echo "Not all password fields have been set! please fill all fields";
	
		exit();
	}


	
	$newPassword=$_POST['newPassword'];

	if(strlen($newPassword) < 5 || strlen($newPassword) > 30){
		echo "The password must be between 5 and 30";

		exit();
	}

	$newPassword=md5($newPassword);
	$oldPassword=md5($_POST['oldPassword']);

	$userQuery=mysqli_query($con,"SELECT * FROM users WHERE password='$oldPassword'AND username='$userLoggedIn'");

	if(mysqli_num_rows($userQuery) != 1){
		echo "Your current password provided is invalid! try again";
	}else{
		$query=mysqli_query($con,"UPDATE users SET password='$newPassword' WHERE username='$userLoggedIn'");

		if($query){
			echo "User password updated successfuly!";
		}else{
			echo "something went wrong updating user password [check your update query]";
		}
	}

 ?>