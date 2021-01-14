<?php 
 // ===================actions for login=======================================

	if(isset($_POST['loginButton'])){
		// login button was pressed!

		// obtendo o valor da variavel iptUsername
		// $username=sanitizeAllInputsToString($_POST['iptUsername']);
		$username=$_POST['iptUsername'];

		$password=$_POST['iptPassword'];


		$result=$account->login($username,$password);

		if($result){
			$_SESSION['user']=$username;
			
			header("Location: index.php");
		}
	}

?>