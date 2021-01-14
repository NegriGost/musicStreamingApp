<?php 
	
	class Song{

		private $con;
		private $id;
		private $song;
		private $title;
		private $artistId;
		private $albumId;
		private $genreId;
		private $duration;
		private $path;


		public function __construct($con,$id){
			
			$this->con=$con;
			$this->id=$id;

			$query=mysqli_query($this->con,"SELECT * FROM  songs WHERE id='$id'");

			$this->song=mysqli_fetch_array($query);

			$this->title=$this->song['title'];
			$this->artistId=$this->song['artist'];
			$this->albumId=$this->song['album'];
			$this->genreId=$this->song['genre'];
			$this->duration=$this->song['duration'];
			$this->path=$this->song['path'];
		}

		public function getId(){
			return $this->id;
		}

		public function getTitle(){
			return $this->title;
		}
		public function getArtist(){
			return new Artist($this->con,$this->artistId);
		}
		public function getAlbum(){
			return new Album($this->con,$this->albumId);
		}
		public function getGenre(){
			return new Genre($this->con,$this->genreId);
		}
		public function getDuration(){
			return $this->duration;
		}
		public function getPath(){
			return $this->path;
		}
		public function getSong(){
			return $this->song;
		}

	}


 ?>