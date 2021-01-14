<?php 
	
	class User{

		private $con;
		private $id;
		private $username;
		private $firstName;
		private $lastName;
		private $email;

		public function __construct($con,$username){
			
			$this->con=$con;
			$this->username=$username;

			$query=mysqli_query($this->con,"SELECT * FROM  users WHERE username='$this->username'");
			$user=mysqli_fetch_array($query);

			$this->username=$user['username'];
			$this->id=$user['id'];
			$this->email=$user['email'];
			$this->firstName=$user['firstName'];
			$this->lastName=$user['lastName'];
		}

		public function getId(){
			return $this->id;
		}

		public function getUsername(){
			return $this->username;
		}

		public function getFirstname(){
			return $this->firstName;
		}

		public function getLastname(){
			return $this->lastName;
		}

		public function getFullName(){
			return $this->getFirstname().' '.$this->getLastname();
		}

		public function getEmail(){
			return $this->email;
		}


		public function getPlaylists(){

			$playlists=array();

			$query=mysqli_query($this->con,"SELECT * FROM playlists WHERE owner='$this->username'");


		    while ($userRow=mysqli_fetch_array($query)) {
		    	array_push($playlists,new Playlist($this->con,$userRow['id']));
		    }

		    return $playlists;

		}

	}


 ?>