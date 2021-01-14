<?php 

	$randomPlaylistQuery=mysqli_query($con,"SELECT * FROM songs ORDER BY RAND() LIMIT 10");

	$randomPlaylist=array();

	while ($song=mysqli_fetch_array($randomPlaylistQuery)) {

		array_push($randomPlaylist,$song['id']);

	}


	$jsonRandomPlaylist=json_encode($randomPlaylist);

 ?>


<script type="text/javascript">

	$(document).ready(function(){
		// playlist coming from php
		var newPlaylist=<?php echo($jsonRandomPlaylist); ?>;

		audioTag=new Audio();

		setMusic(newPlaylist[0],newPlaylist,false);

		// colocando o volume no maximo, logo que a musica inicia
		updateVolumeProgressBar(audioTag.audio);

		//retira o comportamento normal ao fazer eventos no bowser
		
		

			$('#nowPlayingBarContainer').mousedown(function(){
				event.preventDefault();
			});

			$('#nowPlayingBarContainer').mousemove(function(){
				event.preventDefault();
			});

			// $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove",function(event){
			// 	event.preventDefault();
			// });

			// $('#nowPlayingBarContainer').touchstart(function(){
			// 	event.preventDefault();
			// });

			// $('#nowPlayingBarContainer').touchmove(function(){
			// 	event.preventDefault();
			// });

		// drag progressbar
		$('.playbackBar .progressBar').mousedown(function(){
			mouseDown=true;
		});

		$('.playbackBar .progressBar').mousemove(function(event){
			if(mouseDown){
				// set time o song depending of the position of the mouse
				timeFromOffset(event,this);
			}
		});

		$('.playbackBar .progressBar').mouseup(function(event){
			timeFromOffset(event,this);
		});


		// drag volumebar
		$('.volumeBar .progressBar').mousedown(function(){
			mouseDown=true;

		});

		$('.volumeBar .progressBar').mousemove(function(event){
			if(mouseDown){
				// set time o song depending of the position of the mouse
				setVolume(event,this);
			}
		});

		$('.volumeBar .progressBar').mouseup(function(event){
			   setVolume(event,this);
		}); 

		$(document).mouseup(function(){mouseDown=false})


	});

	//funcção que aumenta o volume

	function setVolume(mouse, progressBar){
		var percentage=mouse.offsetX / $(progressBar).width();
		if(percentage>=0 && percentage<=1){
			audioTag.audio.volume=percentage;
		}		
			
	}
	// função que move a barra de progresso
	function timeFromOffset(mouse, progressBar){
		var percentage=mouse.offsetX / $(progressBar).width() * 100;
		var seconds= audioTag.audio.duration * (percentage/100);
		audioTag.setTime(seconds);
	}

	//setar a proxima musica
	function nextSong(){

		if(repeat==true){
			audioTag.setTime(0);
			playSong();
			return;
		}

		if(currentIndex == currentPlaylist.length - 1){
			currentIndex=0;
		}
		else{
			currentIndex++;
		}

		var soundToPlay=shuffle? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];

		setMusic(soundToPlay,currentPlaylist,true);
	} 

	function shuffleSong(){
		shuffle= !shuffle;

		var imageName= shuffle ? "shuffle-active.png":"shuffle.png";

		if(shuffle){
			shuffleArray(shufflePlaylist);
			currentIndex=shufflePlaylist.indexOf(audioTag.currentlyPlayingSong.id);

		}else{
			currentIndex=currentPlaylist.indexOf(audioTag.currentlyPlayingSong.id);
		}

		$(".controlButton.shuffle img").attr("src","assets/images/icons/"+imageName);
	}

	function shuffleArray(songs){

		var j,x,i;

		for (i = songs.length - 1; i ; i--) {
			j=Math.floor(Math.random() *i);
			x=songs[i-1];
			songs[i-1]=songs[j];
			songs[j]=x;
		}
	}

	function muteSong(){
		audioTag.audio.muted= !audioTag.audio.muted;
		var imageName= audioTag.audio.muted ?"volume-mute.png":"volume.png";

		$(".controlButton.volume img").attr("src","assets/images/icons/"+imageName);
	}

	function previousSong(){
		if(audioTag.audio.currentTime>=5 || currentIndex==0){
			audioTag.setTime(0);
		}
		else{
			currentIndex--;
			setMusic(currentPlaylist[currentIndex],currentPlaylist,true);
		}
	}

	function repeatSong(){
		repeat= !repeat;
		var imageName=repeat?"repeat-active.png":"repeat.png";

		$(".controlButton.repeat img").attr("src","assets/images/icons/"+imageName);
	}
	//função para sectar a nova musica 
	function setMusic(musicId,newPlaylist,isPlaying){

			if(newPlaylist!=currentPlaylist){

				currentPlaylist=newPlaylist;
				shufflePlaylist=currentPlaylist.slice();
				shuffleArray(shufflePlaylist);
			}

			if(shuffle){
				currentIndex=shufflePlaylist.indexOf(musicId);
			}
			else{
				currentIndex=newPlaylist.indexOf(musicId);
			}
			
			pauseSong();

		// obtendo as musicas via ajax
		$.post("includes/handlers/ajax/getSongJson.php",{songId:musicId},function(data){



			var sound=JSON.parse(data);

			$(".trackName span").text(sound.title);
			$(".trackName span").attr("style","cursor:pointer");


				// obtendo o artista da musica
				$.post("includes/handlers/ajax/getArtistJson.php",{artistId:sound.artist},function(data){

					var artist=JSON.parse(data);

					$(".artistName span").text(artist.name);

					$(".artistName span").attr("style","cursor:pointer");

					$(".artistName span").attr("onClick","openPage('artist.php?id="+artist.id+"')");

				});


				// obtendo o album da musica
				$.post("includes/handlers/ajax/getAlbumJson.php",{albumId:sound.album},function(data){

					var album=JSON.parse(data);

					$(".albumLink img").attr("style","cursor:pointer");

					$(".albumLink img").attr("src",album.artworkPath);

					$(".albumLink img").attr("onClick","openPage('album.php?id="+album.id+"')");

					$(".trackName span").attr("onClick","openPage('album.php?id="+album.id+"')");

				});


			audioTag.setTrack(sound);

			playSong();
		});


		if(isPlaying){
			playSong();
		}
	}

	function playSong(){

		// actualizando o numero de plays de uma musica
		if(audioTag.audio.currentTime==0){

			$.post("includes/handlers/ajax/updatePlaysJson.php",{songId:audioTag.currentlyPlayingSong.id});

		}

		$('.controlButton.play').hide();
		$('.controlButton.pause').show();

		audioTag.play();
		
	}

	function pauseSong(){
		audioTag.pause();
		$('.controlButton.pause').hide();
		$('.controlButton.play').show();
	}

</script>

<div id="nowPlayingBarContainer">

		<div id="nowPlayingBar">
			
			<div id="nowPlayingLeft">
				<div class="content">
					<span class="albumLink">
						<img role="link" tabindex="0" class="albumArtWork" src="" alt="artworkPath">
					</span>

					<div class="trackInfo">
						<span class="trackName">
							<span role="link" tabindex="0"></span>
						</span>
						<span class="artistName">
							<span role="link" tabindex="0">Rodrigues Mafumo</span>
						</span>
					</div>
				</div>
			</div>


			<div id="nowPlayingCenter">
 
				 <div class="content playerControls">
				 	
				 	<div class="buttons">

				 		<button onclick="shuffleSong()" class="controlButton shuffle" title="shuffle button">
				 			<img src="assets/images/icons/shuffle.png" alt="shuffle">
				 		</button>

						<button onclick="previousSong()" class="controlButton previous" title="previous button">
							<img src="assets/images/icons/previous.png" alt="previous">
						</button>

						<button onclick="playSong()" class="controlButton play" title="play button">
							<img src="assets/images/icons/play.png" alt="play">
						</button>

						<button onclick="pauseSong()" class="controlButton pause" title="pause button" style="display: none">
							<img src="assets/images/icons/pause.png" alt="pause">
						</button>

						<button onclick="nextSong()" class="controlButton next" title="next button">
							<img src="assets/images/icons/next.png" alt="next">
						</button>

						

						<button class="controlButton repeat" title="repeat button" onclick="repeatSong()">
							<img src="assets/images/icons/repeat.png" alt="repeat">
						</button>
<!-- 

						<button class="controlButton shuffle" title="shuffle button">
							<img src="assets/images/icons/shuffle.png" alt="shuffle">
						</button> -->

				 	</div>


				 	<div class="playbackBar">
				 		<span class="progressTime current">0:00</span>
				 			<div class="progressBar">
				 				<div class="progressBarBg">
				 					<div class="progress"></div>
				 				</div>
				 			</div>
				 		<span class="progressTime remaining">0:00</span>
				 	</div>

				 </div>

			</div>


			<div id="nowPlayingRight">

				<div class="volumeBar">
					
					<button onclick="muteSong()" class="controlButton volume" title="volume button">
						<img src="assets/images/icons/volume.png" alt="volume">
						<!-- <img src="assets/images/icons/volume-mute.png" alt="volume"> -->
					</button>

					<div class="progressBar">
		 				<div class="progressBarBg">
		 					<div class="progress"></div>
		 				</div>
		 			</div>

				</div>
			</div>

		</div>


	</div>