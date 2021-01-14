<?php 
	
	class Artist{

		private $con;
		private $id;
		private $name;

		public function __construct($con,$id){

			$this->con=$con;
			$this->id=$id;

			$query=mysqli_query($this->con,"SELECT * FROM  artists WHERE id='$this->id'");
			$artist=mysqli_fetch_array($query);

			$this->name=$artist['name'];
		}

		public function getId(){
			return $this->id;
		}

		public function getName(){
			return $this->name;
		}

		public function getSongs(){
			$songs=array();

			$query=mysqli_query($this->con,"SELECT * FROM songs WHERE artist='$this->id' ORDER BY plays ASC");

		    while ($songRow=mysqli_fetch_array($query)) {
		    	array_push($songs,new Song($this->con,$songRow['id']));
		    }

		    return $songs;
		}

		public function getSongsIds(){
			$songIds=array();

			$query=mysqli_query($this->con,"SELECT id FROM songs WHERE artist='$this->id' ORDER BY plays ASC");


		    while ($songRow=mysqli_fetch_array($query)) {
		    	array_push($songIds,$songRow['id']);
		    }

		    return $songIds;
		}




	}


 ?>