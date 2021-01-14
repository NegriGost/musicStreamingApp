<?php 
	
	class Genre{

		private $con;
		private $id;
		private $name;

		public function __construct($con,$id){
			
			$this->con=$con;
			$this->id=$id;

			$query=mysqli_query($this->con,"SELECT * FROM  genres WHERE id='$this->id'");
			$genre=mysqli_fetch_array($query);

			$this->name=$genre['name'];
		}

		public function getId(){
			return $this->id;
		}

		public function getName(){
			return $this->name;
		}

		public function getSongs(){
			$songs=array();

			$query=mysqli_query($this->con,"SELECT * FROM songs WHERE genre='$this->id' ORDER BY albumOrder ASC");


		    while ($songRow=mysqli_fetch_array($query)) {
		    	array_push($songs,new Song($this->con,$songRow['id']));
		    }

		    return $songs;
		}

	}


 ?>