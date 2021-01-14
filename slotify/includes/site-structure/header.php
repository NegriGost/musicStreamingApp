
<?php 

// configuração da base de dados e sessão
	include("includes/config/config.php");

	include("includes/classes/User.php");
	include("includes/classes/Playlist.php");
	include("includes/classes/Genre.php");
	include("includes/classes/Artist.php");
	include("includes/classes/Album.php");
	include("includes/classes/Song.php");


	if(isset($_SESSION['user'])){

		$userLoggedIn=new User($con,$_SESSION['user']);
		$username=$userLoggedIn->getUsername();
		echo "<script> userLoggedIn='$username'; </script>";

	}
	else{

		header("Location: register.php");

	}

	if (isset($_POST['logout'])) {
		// destruindo a sessão
		session_destroy();
		header("Location: register.php");
	}

 ?>

<!DOCTYPE html>
<html>

	<head>
		<title>Slotify!</title>
		<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
		<script src="assets/js/jquery-1.5.2.min.js"></script>
		<script src="assets/js/scripts.js"></script>
	</head>

<body>

	<script>
		var audioTag=new Audio();

		audioTag.setTrack("assets/music/bensound-acousticbreeze.mp3");

		// audioTag.play();
	</script>
 <div id="mainContainer">

 	<div id="topContainer">
 		
 		<?php include("includes/site-structure/navBarContainer.php"); ?>

 		<div id="mainViewContainer">
 			
 			<div id="mainContent">