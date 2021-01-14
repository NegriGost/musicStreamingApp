
<?php include("includes/forAjaxRouting/includedFiles.php"); ?>

<?php 

	if (isset($_GET['term'])) {
		$term=urldecode($_GET['term']);
		$term=str_replace("?", "", $term);

	}
	else{
		$term="";
	}

 ?>

 <div class="searchContainer">

 	<h4>Search for an song, artist, album or playlist</h4>
 	<input type="text"  class="searchInput" name="searchInput" value="<?php echo $term; ?>" placeholder="Start typing..." onfocus="this.value = this.value">

 </div>

 <script>

	$(".searchInput").focus();
 	
 	$(function(){ 

 		$(".searchInput").keyup(function(){
 			clearTimeout(timer);

 			timer=setTimeout(function(){
 				var searchValue=$(".searchInput").val();
 				openPage('search.php?term='+searchValue);
 			},2000);

 		});
 	});


 </script>

<?php 
	
	// prevenindo que a página faça load; 
	if ($term=="") return;

?>

<div class="trackListContainer borderBottom">
	<h2>Songs</h2>
	<ul class="trackList">

	    <?php 

  			$index=1;

	    	$query=mysqli_query($con,"SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");

	    	if(mysqli_num_rows($query)==0){
	    		echo "<span class='noResults'>No songs found matching ". '\''.$term.'\'' ."</span>";
	    	}

	    	$songsIdArray=array();

	    	while($row=mysqli_fetch_array($query)){

				if($index > 5) break;

	    		array_push($songsIdArray, $row['id']);


	    		$searchSong=new Song($con,$row['id']);

		    	echo "

		    		<li class='tracklistRow'>

		    			<div class='trackCount'>

		    				<img class='play' src='assets/images/icons/play-white.png' alt='play button' onclick='setMusic(\"".$searchSong->getId()."\",tempPlaylist,true)'>
		    				<span class='trackNumber'>".$index."</span>

		    			</div>

		    			<div class='trackInfo'>

		    				<span class='trackName'>".$searchSong->getTitle()."</span>
		    				<span class='artistName'>".$searchSong->getArtist()->getName()."</span>

		    			</div>

		    			<div class='trackOptions'>
		    				<input type='hidden' class='songId' value='".$searchSong->getId()."'>
		    				<img onclick='showDropdownMenu(this)' class='optionsButton' src='assets/images/icons/more.png' alt='more button'>
		    			</div>


		    			<div class='trackDuraction'>
		    				<span class='duraction'>".$searchSong->getDuration()."</span>
		    			</div>

		    		</li>


		    	";

				$index++;
		    }

	    ?>




	</ul>


</div>

<div class="artistsContainer borderBottom">
	<h2>artists</h2>

	<?php 
			$query=mysqli_query($con,"SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");

	    	if(mysqli_num_rows($query)==0){
	    		echo "<span class='noResults'>No artists found matching ". '\''.$term.'\'' ."</span>";
	    	}


			while($row=mysqli_fetch_array($query)){
				$artist=new Artist($con,$row['id']);

				echo "

					<div class='searchResultRow'>
							<div class='artistName'>
								<span role='link' tabindex='0' onclick='openPage(\"artist.php?id=".$artist->getId()."\")'  style='cursor:pointer'>".$artist->getName()."</span>
							</div>
					</div>
				";
			}


	 ?>
</div>

 	<div class="gridViewContainer borderBottom">
 			<h2>albums</h2>
 		<?php 
 		
 			$query=mysqli_query($con,"SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10"); 


	    	if(mysqli_num_rows($query)==0){
	    		echo "<span class='noResults'>No albums found matching ". '\''.$term.'\'' ."</span>";
	    	}

 			while ($row=mysqli_fetch_array($query)) {

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
<br><br><br><br><br><br><br>