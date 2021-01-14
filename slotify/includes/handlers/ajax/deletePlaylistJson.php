<?php 

	include('../../config/config.php');

	if (isset($_POST['playlistId'])) {
		
		$playlistId=$_POST['playlistId'];

	    $playlistQuery=mysqli_query($con,"DELETE FROM playlists WHERE id='$playlistId'");
		$songsQuery=mysqli_query($con,"DELETE FROM playlist_songs WHERE playlistId='$playlistId'");

		echo "Playlist deleted successfuly!";


	}
	else{

		echo "playlistId not passed into file!";
	}




 ?>