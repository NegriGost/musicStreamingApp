<?php include("includes/forAjaxRouting/includedFiles.php"); ?>

 <div class="playlistsContainer">
 	<div class="gridViewContainer">
 		<h2>PLAYLISTS</h2>

 		<div class="buttonItems">
 			<button class="button button-green" onclick="createPlaylist()">NEW PLAYLIST</button>
 		</div>
 	</div>
 </div>


<div class="gridViewContainer borderBottom">
	<!-- <h2>albums</h2> -->
	<?php 

		if(count($userLoggedIn->getPlaylists())==0){
    		echo "<span class='noResults'>No playlists found yet!</span>";
    		return;
    	}
		foreach ($userLoggedIn->getPlaylists() as $playlist) {

			echo "
 					<div class='gridViewItem'>

 						<a role='link' tabindex='0' href='javascript:void(0)' onclick='openPage(\"playlist.php?id=".$playlist->getId()." \")'>
	 						<img src='assets/images/icons/playlist.png' alt='artworkPath'/>

	 						<div class='gridViewInfo'>
	 
	 							".$playlist->getName()."

	 						</div>
						</a>
 					</div>

			";
		}
	?>
</div>
<br><br><br><br><br><br>
