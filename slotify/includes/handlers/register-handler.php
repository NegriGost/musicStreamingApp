<?php 


// =====================funcões para o tratamento dos campos==========================
	function sanitizePasswordInput($iptText){

		// remover todos elementos hrml do campo
		$inputText=strip_tags($iptText);

		return $inputText;
	}

	function sanitizeAllInputsToString($iptText){

		// remover todos elementos hrml do campo
		$inputText=strip_tags($iptText);

		// remover todos espaços em branco no campo inputText
		$inputText=str_replace(" ", "", $inputText);

		return $inputText;
	}


	function sanitizeFirstnameAndLastname($iptName){

		$name=sanitizeAllInputsToString($iptName);
		// colocar a primeira letra do nome em maúscula
		$name=ucfirst(strtolower($name));

		return $name;
	}

// =========================funções para a validação dos dados===================







	// ===========================action for signing up======================


	if(isset($_POST['signUpButton'])){
		// login button was pressed!

		// obtendo o valor da variavel iptUsername
		$username=sanitizeAllInputsToString($_POST['iptUsername']);

		// obtendo o valor da variavel iptFirstname
		$firstname=sanitizeFirstnameAndLastname($_POST['iptFirstname']);

		// obtendo o valor da variavel iptLastname
		$lastname=sanitizeFirstnameAndLastname($_POST['iptLastname']);

		// obtendo o valor da variavel iptEmail
		$email=sanitizeAllInputsToString($_POST['iptEmail']);

				// obtendo o valor da variavel iptConfirmEmail
		$emailConfirmation=sanitizeAllInputsToString($_POST['iptConfirmEmail']);

						// obtendo o valor da variavel iptPassword
		$password=sanitizePasswordInput($_POST['iptPassword']);

						// obtendo o valor da variavel iptConfirmPasswordC
		$passwordConfirmation=sanitizePasswordInput($_POST['iptConfirmPassword']);

		

		$success=$account->register($username,$firstname,$lastname,$email,$emailConfirmation,$password,$passwordConfirmation);

		if ($success) {
			 
			$_SESSION['user']=$username;
			header('Location: index.php');
		}

	}

 ?>