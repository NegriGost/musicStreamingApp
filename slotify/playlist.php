
<?php include("includes/forAjaxRouting/includedFiles.php"); ?>

<!-- obtendo o parametro da url -->
<?php 

	if(isset($_GET['id'])){
	    $playlistId = $_GET['id'];
	}else{
		header("Location: index.php");
	}


	// obtendo o album da base de dados
	$playlist=new Playlist($con,$playlistId);

	$owner=$playlist->getOwner();

	$songs=$playlist->getSongs();

	$songIds=json_encode($playlist->getSongsIds());

?>

<script>

	var tempSongsIds='<?php echo($songIds); ?>';//USAR PLICAS SEMPRE NÃO ASPAS
	tempPlaylist=JSON.parse(tempSongsIds);

	
</script>

<div class="entityInfo">
	<div class="leftSection playlistImage">
		<img src="assets/images/icons/playlist.png" alt="artworkPath">
	</div>

	<div class="rightSection">
		<h2><?php echo $playlist->getName(); ?></h2>
		<p>By <?php echo $owner->getUsername(); ?></p>
		<p><?php echo $playlist->getNumberOfSongs(); ?> Songs</p>
		<button class="button" onclick="deletePlaylist(<?php echo $playlist->getId(); ?>)">DELETE PLAYLIST</button>
	</div>
</div>


<div class="trackListContainer">

	<ul class="trackList">

	    <?php 

	    	$index=1;

		    foreach ($playlist->getSongs() as $playlistSong) {

		    	echo "

		    		<li class='tracklistRow'>

		    			<div class='trackCount'>

		    				<img class='play' src='assets/images/icons/play-white.png' alt='play button' onclick='setMusic(\"".$playlistSong->getId()."\",tempPlaylist,true)'>
		    				<span class='trackNumber'>".$index."</span>

		    			</div>

		    			<div class='trackInfo'>

		    				<span class='trackName'>".$playlistSong->getTitle()."</span>
		    				<span class='artistName'>".$playlistSong->getArtist()->getName()."</span>

		    			</div>


		    			<div class='trackOptions'>
		    				<input type='hidden' class='songId' value='".$playlistSong->getId()."'>
		    				<img onclick='showDropdownMenu(this)' class='optionsButton' src='assets/images/icons/more.png' alt='more button'>
		    			</div>


		    			<div class='trackDuraction'>
		    				<span class='duraction'>".$playlistSong->getDuration()."</span>
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
	<div class="item" onclick="removeFromPlaylist(this,'<?php echo $playlistId; ?>')"> 
		Remove from playlist
	</div>

</nav>

<br/><br/><br/><br/><br/>