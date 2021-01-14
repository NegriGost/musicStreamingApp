<?php 

	include('../../config/config.php');

	if (isset($_POST['playlistId']) && isset($_POST['songId'])) {
		
		$playlistId=$_POST['playlistId'];
		$songId=$_POST['songId']; 

		$result=mysqli_query($con,"DELETE FROM playlist_songs WHERE playlistId='$playlistId' AND songId='$songId'");

		if($result){
			echo "Song removed from playlist successfuly!";
		}
		else{
			echo "something went wrong deleting a song from playlist_songs [Check th query]";
		}


	}
	else{

		echo "playlistId or songId not passed into file!";
	}




 ?>