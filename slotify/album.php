
<?php include("includes/forAjaxRouting/includedFiles.php"); ?>

<!-- obtendo o parametro da url -->
<?php 

	if(isset($_GET['id'])){
	    $albumId = $_GET['id'];
	}else{
		header("Location: index.php");
	}


	// obtendo o album da base de dados
	$album=new Album($con,$albumId);

	$genre=$album->getGenre();

	$artist=$album->getArtist();

	$songs=$album->getSongs();

	$songIds=json_encode($album->getSongsIds());

?>

<script>

	var tempSongsIds='<?php echo($songIds); ?>';//USAR PLICAS SEMPRE NÃO ASPAS
	tempPlaylist=JSON.parse(tempSongsIds);

	
</script>
<div class="entityInfo">
	<div class="leftSection">
		<img src="<?php echo $album->getAlbumArtworkPath(); ?>" alt="artworkPath">
	</div>

	<div class="rightSection">
		<h2><?php echo $album->getTitle(); ?></h2>
		<p><?php echo $genre->getName(); ?> Music</p>
		<p>By <?php echo $artist->getName(); ?></p>
		<p><?php echo $album->getNumberOfSongs(); ?> Songs</p>
	</div>
</div>


<div class="trackListContainer">

	<ul class="trackList">

	    <?php 

	    	$index=1;

		    foreach ($album->getSongs() as $albumSong) {

		    	echo "

		    		<li class='tracklistRow'>

		    			<div class='trackCount'>

		    				<img class='play' src='assets/images/icons/play-white.png' alt='play button' onclick='setMusic(\"".$albumSong->getId()."\",tempPlaylist,true)'>
		    				<span class='trackNumber'>".$index."</span>

		    			</div>

		    			<div class='trackInfo'>

		    				<span class='trackName'>".$albumSong->getTitle()."</span>
		    				<span class='artistName'>".$albumSong->getArtist()->getName()."</span>

		    			</div>

		    			<div class='trackOptions'>
		    				<input type='hidden' class='songId' value='".$albumSong->getId()."'>
		    				<img onclick='showDropdownMenu(this)' class='optionsButton' src='assets/images/icons/more.png' alt='more button'>
		    			</div>

		    			<div class='trackDuraction'>
		    				<span class='duraction'>".$albumSong->getDuration()."</span>
		    			</div>


		    		</li>


		    	";

				$index++;
		    }

	    ?>




	</ul>




</div>

<nav class="optionsMenu">

	<input type="hidden" class="songId">

	<?php 
		echo Playlist::getPlaylistDropdown($con,$userLoggedIn->getUsername());
	 ?>

</nav>
<br/><br/><br/><br/><br/>
