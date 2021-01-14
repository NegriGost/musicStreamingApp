<?php 

	include("../../config/config.php");
	
	if(!isset($_POST['userLoggedIn'])){

		echo "Failed, the username was not provided!";

		exit();
	}

	$userLoggedIn=$_POST['userLoggedIn'];

	if(isset($_POST['email']) && $_POST['email']==""){

		echo "Error, you must provide your email!";

		exit();
	}

	$email=$_POST['email'];

	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

		echo "The email provided is not valid!";

		exit();
	}


$userQuery=mysqli_query($con,"SELECT email FROM users WHERE email='$email' AND username='$userLoggedIn'");

	if(mysqli_num_rows($userQuery) > 0){
		echo "Nothing to update!";
		return;
	}

	$result=mysqli_query($con,"UPDATE users SET email='$email' WHERE username='$userLoggedIn'");

	if($result){
		echo "Email updated successfuly!";
	}else{
		echo "Something went wrong updating user email [check your update query]";
	}

 ?>