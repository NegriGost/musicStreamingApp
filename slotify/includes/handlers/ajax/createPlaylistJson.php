<?php 

	include('../../config/config.php');

	if (isset($_POST['name']) && isset($_POST['owner'])) {
		
		$name=$_POST['name'];
		$owner=$_POST['owner'];
		$date=date("Y-m-d H:m:s");

		$query=mysqli_query($con,"INSERT INTO playlists VALUES('','$name','$owner','$date')");

		echo "Playlist created successfuly!";


	}
	else{

		echo "playlist name or owner not passed into file!";
	}




 ?>