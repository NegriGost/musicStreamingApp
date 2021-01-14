<?php include("includes/forAjaxRouting/includedFiles.php"); ?>

<?php 

		if(isset($_GET['id'])){
			$artistId=$_GET['id'];
		}
		else{
			header("Location:index.php");
		}

		$artist=new Artist($con,$artistId);
		$songIds=json_encode($artist->getSongsIds());
?>

<script>

	var tempSongsIds='<?php echo($songIds); ?>';//USAR PLICAS SEMPRE NÃO ASPAS
	tempPlaylist=JSON.parse(tempSongsIds);

	
</script>

<div class="entityInfo borderBottom">

	<div class="centerSection">
		
		<div class="artistInfo">
			<h1 class="artistName"><?php echo $artist->getName(); ?></h1>

			<div class="headerButtons">
				<button class="button button-green" onclick="playArtistFirstSong()">PLAY</button>
			</div>	
		</div>
	</div>
	
</div>

<div class="trackListContainer borderBottom">
	<h2>Songs</h2>
	<ul class="trackList">

	    <?php 

	    	$index=1;

		    foreach ($artist->getSongs() as $artistSong) {

		    	if($index > 5) break;

		    	echo "

		    		<li class='tracklistRow'>

		    			<div class='trackCount'>

		    				<img class='play' src='assets/images/icons/play-white.png' alt='play button' onclick='setMusic(\"".$artistSong->getId()."\",tempPlaylist,true)'>
		    				<span class='trackNumber'>".$index."</span>

		    			</div>

		    			<div class='trackInfo'>

		    				<span class='trackName'>".$artistSong->getTitle()."</span>
		    				<span class='artistName'>".$artistSong->getArtist()->getName()."</span>

		    			</div>

		    			<div class='trackOptions'>
		    				<input type='hidden' class='songId' value='".$artistSong->getId()."'>
		    				<img onclick='showDropdownMenu(this)' class='optionsButton' src='assets/images/icons/more.png' alt='more button'>
		    			</div>

		    			<div class='trackDuraction'>
		    				<span class='duraction'>".$artistSong->getDuration()."</span>
		    			</div>


		    		</li>


		    	";

				$index++;
		    }

	    ?>




	</ul>


</div>

<div class="gridViewContainer">
	<h2>Albums</h2>

	<?php 
	
		$albumQuery=mysqli_query($con,"SELECT * FROM albums WHERE artist='$artistId'"); 

		while ($row=mysqli_fetch_array($albumQuery)) {
			// echo $row['title'] ."<br/>";

			echo "

 					<div class='gridViewItem'>

 						<a role='link' tabindex='0' href='javascript:void(0)' onclick='openPage(\"album.php?id=".$row['id']." \")'>
	 						<img src='".$row['artworkPath']."' alt='artworkPath'/>

	 						<div class='gridViewInfo'>
	 
	 							".$row['title']."

	 						</div>
						</a>
 					</div>

			";
		}
	?>
</div>

<nav class="optionsMenu">

	<input type="hidden" class="songId">

	<?php 
		echo Playlist::getPlaylistDropdown($con,$userLoggedIn->getUsername());
	 ?>

</nav>
<br/><br/><br/><br/><br/>