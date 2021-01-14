<?php include("includes/forAjaxRouting/includedFiles.php"); ?>

<div class="entityInfo">
	<div class="centerSection">
		<div class="userInfo">
			<h1><?php echo $userLoggedIn->getFullName(); ?></h1>
		</div>	

		<div class="buttonItems">
			<button class="button mb" onclick="openPage('profile.php')">USER DETAILS</button>
			<button class="button" onclick="logout()">LOGOUT</button>
		</div>	
	</div>
</div>