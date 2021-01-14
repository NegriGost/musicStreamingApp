<?php 
	
	class Album{

		private $con;
		private $id;
		private $title;
		private $artworkPath;
		private $artist;
		private $genre;

		public function __construct($con,$id){
			
			$this->con=$con;
			$this->id=$id;

			$query=mysqli_query($this->con,"SELECT * FROM albums WHERE id='$this->id'");
			$album=mysqli_fetch_array($query);

			$this->title=$album['title'];
			$this->artist=$album['artist'];
			$this->artworkPath=$album['artworkPath'];
			$this->genre=$album['genre'];
		}

		public function getId(){
			return $this->id;
		}

		public function getTitle(){
			return $this->title;
		}

		public function getArtist(){
			return new Artist($this->con,$this->artist);
		}

		public function getGenre(){
			return new Genre($this->con,$this->genre);
		}

		public function getArtistId(){
			return $this->artist;
		}

		public function getGenreId(){
			return $this->genre;
		}

		public function getAlbumArtworkPath(){
			return $this->artworkPath;
		}

		public function getNumberOfSongs(){
			$query=mysqli_query($this->con,"SELECT id FROM songs WHERE album='$this->id'");
			$numberOfRows=mysqli_num_rows($query);
			return $numberOfRows;
		}

		public function getSongs(){
			$songs=array();

			$query=mysqli_query($this->con,"SELECT * FROM songs WHERE album='$this->id' ORDER BY albumOrder ASC");


		    while ($songRow=mysqli_fetch_array($query)) {
		    	array_push($songs,new Song($this->con,$songRow['id']));
		    }

		    return $songs;
		}

		public function getSongsIds(){
			$songIds=array();

			$query=mysqli_query($this->con,"SELECT id FROM songs WHERE album='$this->id' ORDER BY albumOrder ASC");


		    while ($songRow=mysqli_fetch_array($query)) {
		    	array_push($songIds,$songRow['id']);
		    }

		    return $songIds;
		}



	}


 ?>