<?php 
	
	class Playlist{

		private $con;
		private $id;
		private $name;
		private $owner;

		public function __construct($con,$id){
			
			$this->con=$con;
			$this->id=$id;

			$query=mysqli_query($this->con,"SELECT * FROM  playlists WHERE id='$this->id'");
			$playlist=mysqli_fetch_array($query);

			$this->name=$playlist['name'];
			$this->id=$playlist['id'];
			$this->owner=$playlist['owner'];
		}

		public function getId(){
			return $this->id;
		}

		public function getName(){
			return $this->name;
		}

		public function getOwner(){
			return new User($this->con,$this->owner);
		}

		public function getNumberOfSongs(){
			$query=mysqli_query($this->con,"SELECT songId FROM playlist_songs WHERE playlistId='$this->id'");
			$numberOfRows=mysqli_num_rows($query);
			return $numberOfRows;
		}

		public function getSongs(){
			$songs=array();

			$query=mysqli_query($this->con,"SELECT songId FROM playlist_songs WHERE playlistId='$this->id' ORDER BY playlistOrder DESC");


		    while ($songRow=mysqli_fetch_array($query)) {
		    	array_push($songs,new Song($this->con,$songRow['songId']));
		    }

		    return $songs;
		}

		public function getSongsIds(){
			$songIds=array();

			$query=mysqli_query($this->con,"SELECT songId FROM playlist_songs WHERE playlistId='$this->id' ORDER BY playlistOrder DESC");


		    while ($songRow=mysqli_fetch_array($query)) {
		    	array_push($songIds,$songRow['songId']);
		    }

		    return $songIds;
		}

		public static function getPlaylistDropdown($con,$userLoggedIn){
			$dropdown="
				<select class='item playlist'>
					<option value=''>Add to playlist</option>";

			$query=mysqli_query($con,"SELECT id,name FROM playlists WHERE owner='$userLoggedIn'");

			while ($playlistRow=mysqli_fetch_array($query)) {
				
				$id=$playlistRow['id'];
				$name=$playlistRow['name'];

		    	$dropdown= $dropdown. "<option value='$id'>$name</option>";
		    }

			return $dropdown."</select>";
		}

	}


 ?>