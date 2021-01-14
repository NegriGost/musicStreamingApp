<?php 

	include('../../config/config.php');

	if (isset($_POST['songId']) && isset($_POST['playlistId'])) {
		
		$songId=$_POST['songId'];
		$playlistId=$_POST['playlistId'];

		$query=mysqli_query($con,"SELECT name FROM playlists WHERE id='$playlistId'");
		$playlist=mysqli_fetch_array($query);

		$query=mysqli_query($con,"SELECT MAX(playlistOrder)+1 as playlistOrder FROM playlist_songs WHERE playlistId='$playlistId'");

		$playlistOrganize=mysqli_fetch_array($query);

		$order=$playlistOrganize['playlistOrder'];

		$queryPSE=mysqli_query($con,"SELECT songId,playlistId FROM playlist_songs WHERE playlistId='$playlistId' AND songId=$songId");
		$playlistSongExist=mysqli_fetch_array($queryPSE);

		// if($playlistSongExist){
		// 	echo "<script>alert('is not true');</script>";
		// }

		if($playlistSongExist){
					echo "that song exists in that playlist.";
		}
		else{
			

				$result=mysqli_query($con,"INSERT INTO playlist_songs VALUES('','$songId','$playlistId','$order')");

				if($result){
					
					echo "Song added successfuly to \"".$playlist['name']."\" Playlist!";
				}
				else{
			
					echo "Something went wrong inserting playlist_songs, check your query again";
				}
		}

		

		


	}
	else{

		echo "playlistId or songId not passed into file!";
	}




 ?>