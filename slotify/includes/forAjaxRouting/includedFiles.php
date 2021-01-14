<?php 

		if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			// CALL FROM AJAX

			// configuração da base de dados e sessão
			include("includes/config/config.php");
			include("includes/classes/User.php");
			include("includes/classes/Genre.php");
			include("includes/classes/Artist.php");
			include("includes/classes/Album.php");
			include("includes/classes/Song.php");
			include("includes/classes/Playlist.php");


			if(isset($_GET['userLoggedIn'])){
				$userLoggedIn=new User($con,$_GET['userLoggedIn']);
			}
			else{
				echo "username was not passed into page. Check the openPage JS function!";
				return;
			}
		}
		else{
			// CALL FROM HTTP URL

			include("includes/site-structure/header.php");
			include("includes/site-structure/footer.php");

			$url=$_SERVER['REQUEST_URI'];
			echo "<script>openPage('$url')</script>";

			exit();
		}
		 ?>
