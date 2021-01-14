<?php 

	class Account{

		private $errors;
		private $con;

		public function __construct($con){
			$this->errors=array();
			$this->con=$con;
		}

		public function register($un,$fn,$ln,$em,$emC,$pass,$passC){

			$this->validateUsername($un);
			$this->validateFirstname($fn);
			$this->validateLastname($ln);
			$this->validateEmails($em,$emC);
			$this->validatePasswords($pass,$passC);	

			if (empty($this->errors)) {
				# insert to db

				return $this->insertUserDB($un,$fn,$ln,$em,$pass);

			}
			else {

				return false;

			}

		}

		public function login($username,$password){

			$pwd=md5($password);

			$query=mysqli_query($this->con,"SELECT username,password FROM users WHERE username='$username' && password='$pwd'");

			if(mysqli_num_rows($query)==1){

				return true;

			}
			else{

				array_push($this->errors, Constants::$loginFailed);
				return false;

			}

		}

		private function insertUserDB($un,$fn,$ln,$em,$pass){
			$encriptedPw=md5($pass);
			$profilePic="assets/images/profile-pics/avatar.php";
			$date=date("Y-m-d");

			$result=mysqli_query($this->con,"INSERT INTO users VALUES ('','$un','$fn','$ln','$em','$encriptedPw','$date','$profilePic')");

			return $result;
		}

		public function getError($error){

			$isInArray=in_array($error, $this->errors);

			if(!$isInArray){
				$error="";
			}

			return "<span class='errorMessage'>".$error."</span>";
		}

		private function validateUsername($username){

			$usernameLength=strlen($username);

			if($usernameLength > 25 || $usernameLength < 5){
				array_push($this->errors, Constants::$usernameCharacters);
				return;
			}

			// validar se o nome de utilizador já existe na base de dados ou não;
			$checkUsernameQuery=mysqli_query($this->con,"SELECT username FROM users WHERE username='$username'");

			if(mysqli_num_rows($checkUsernameQuery) != 0){
				array_push($this->errors, Constants::$usernameExist);
				return;
			}
		}

		private function validateFirstname($firstname){
			$firstnameLength=strlen($firstname);

			if($firstnameLength > 25 || $firstnameLength < 2){
				array_push($this->errors, Constants::$firstNameCharacters);
				return;
			}

		}

		private function validateLastname($lastname){
			$lastLength=strlen($lastname);

			if($lastLength > 25 || $lastLength < 2){
				array_push($this->errors, Constants::$lastNameCharacters);
				return;
			}

		}

		private function validateEmails($email,$emailConfirmation){

			// validar se os emails são compatíveis 
			if($email != $emailConfirmation){
				array_push($this->errors, Constants::$emailsDoNoMatch);
				return;
			}

			// ver se o email está no formato correcto
			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				array_push($this->errors, Constants::$emailInvalid);
				return;
			}

			// verificar se o email esta sendo utilizado ou não.
			$checkEmailQuery=mysqli_query($this->con,"SELECT email FROM users WHERE email='$email'");

			if(mysqli_num_rows($checkEmailQuery) != 0){
				array_push($this->errors, Constants::$emailExist);
				return;
			}


		}

		private function validatePasswords($password,$passwordCofirmation){

			// validar se oas passwords são compatíveis 
			if($password != $passwordCofirmation){
				array_push($this->errors, Constants::$passwordsDoNoMatch);
				return;
			}

			$passwordLength=strlen($password);

			if($passwordLength > 30 || $passwordLength < 5){
				array_push($this->errors, Constants::$passwordsCharacters);
				return;
			}
		}

	}

 ?>