<?php 
	// incluindo um ficheiro externo, em outro ficheiro

	// configuração da base de dados e sessão
	include("includes/config/config.php");

	// classes
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	//podes acessar a variavel $account em register handler e login-handler
	// a variável $con vem de config
	$account=new Account($con);

	// handlers 
	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	// php scripts
	include("includes/php-scripts/scripts.php");

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Slotify!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">

	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
	<script src="assets/js/jquery-1.5.2.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>

<?php 

// escolhendo qual formulario deverá ser exibido quando o botão login ou registar for clicado
if(isset($_POST['loginButton'])){

	echo "
	<script>
		$(document).ready(function(){

			$('#loginForm').show();
			$('#registerForm').hide();

		});
	</script>";
}

else{

		echo "
	<script>
		$(document).ready(function(){

			$('#loginForm').hide();
			$('#registerForm').show();

		});
	</script>";
}

?>

 
<div id="background">
	
	<div id="login-container">
		
		<div id="formContainer">
	
			<form id="loginForm" action="register.php" method="POST">
			
				<h2>Login to your account</h2>

				<div class="form-control">
					<?php echo $account->getError(Constants::$loginFailed); ?>
					<label for="iptUsername">Username</label>
					<input type="text" name="iptUsername" id="iptUsername" placeholder="e.g. Roger94" value="<?php getInputValue('iptUsername'); ?>" required>
				</div>

				<div class="form-control">
					<label for="iptPassword">Password</label>
					<input type="password" name="iptPassword" id="iptPassword" placeholder="your password." required>
				</div>

				<button type="submit" name="loginButton">LOG IN</button>

				<div class="hasAccountText">
					<span id="hideLogin">Don't have account yet? sign up here.</span>
				</div>

			</form>

			<form id="registerForm" action="register.php" method="POST">
			
				<h2>Create your free account</h2>

				<div class="form-control">
					<?php echo $account->getError(Constants::$usernameCharacters); ?>
					<?php echo $account->getError(Constants::$usernameExist); ?>
					<label for="iptUsername">Username</label>
					<input type="text" name="iptUsername" id="iptUsername" value="<?php getInputValue('iptUsername'); ?>" placeholder="e.g. Roger94" required>
				</div>

				<div class="form-control">
					<?php echo $account->getError(Constants::$firstNameCharacters); ?>
					<label for="iptFirstname">First name</label>
					<input type="text" name="iptFirstname" id="iptFirstname" value="<?php getInputValue('iptFirstname'); ?>" placeholder="e.g. Rodrigues" required>
				</div>


				<div class="form-control">
					<?php echo $account->getError(Constants::$lastNameCharacters); ?>
					<label for="iptLastname">Last name</label>
					<input type="text" name="iptLastname" id="iptLastname" value="<?php getInputValue('iptLastname'); ?>" placeholder="e.g. Mafumo" required>
				</div>


				<div class="form-control">
					<?php echo $account->getError(Constants::$emailsDoNoMatch); ?>
					<?php echo $account->getError(Constants::$emailInvalid); ?>
					<?php echo $account->getError(Constants::$emailExist); ?>
					<label for="iptEmail">Email</label>
					<input type="text" name="iptEmail" id="iptEmail" value="<?php getInputValue('iptEmail'); ?>" placeholder="e.g. mafumorodrigues@gmail.com" required>
				</div>

				<div class="form-control">
					<label for="iptConfirmEmail">Confirm email</label>
					<input type="text" name="iptConfirmEmail" id="iptConfirmEmail" value="<?php getInputValue('iptConfirmEmail'); ?>" placeholder="e.g. mafumorodrigues@gmail.com" required>
				</div>

				<div class="form-control">
					<?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
					<?php echo $account->getError(Constants::$passwordsCharacters); ?>
					<label for="iptPassword">Password</label>
					<input type="password" name="iptPassword" id="iptPassword" value="<?php getInputValue('iptPassword'); ?>" placeholder="your password." required>
				</div>

				<div class="form-control">
					<label for="iptConfirmPassword">Confirm password</label>
					<input type="password" name="iptConfirmPassword" id="iptConfirmPassword" value="<?php getInputValue('iptConfirmPassword'); ?>" placeholder="your password." required>
				</div>

				<button type="submit" id="button" name="signUpButton">SIGN UP</button>

				<div class="hasAccountText">
					<span id="hideRegister">Already have an account? log in here.</span>
				</div>

			</form>

		</div>

		<div id="loginText">
			<h1>Get great music, right now</h1>
			<h2>Listen to load of song for free</h2>

			<ul>
			    <li>Discover music you'll fall in love with</li>
			    <li>Create your own playlists</li>
			    <li>Follow artists to keep up to date</li>
			</ul>
		</div>	

	</div>

</div>


</body>
</html>