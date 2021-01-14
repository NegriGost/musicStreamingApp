<?php include("includes/forAjaxRouting/includedFiles.php"); ?>

<div class="userDetails">

	<div class="container borderBottom">
		<h2>EMAIL</h2>
		<input type="text" name="email" class="email" placeholder="your email address..." value="<?php echo $userLoggedIn->getEmail(); ?>">
		<!-- <span class="message">message success</span> -->
		<button class="button" onclick="updateEmail('email')">SAVE</button>
	</div>

	<div class="container">
		<h2>PASSWORD</h2>
		<input type="password" name="oldPassword" class="oldPassword" placeholder="your current password">
		<input type="password" name="newPassword1" class="newPassword1" placeholder="your new password">

		<input type="password" name="newPassword2" class="newPassword2" placeholder="repeat your new password">
		<!-- <span class="message">message success</span> -->
		<button class="button" onclick="updateUserPassword('oldPassword','newPassword1','newPassword2')">
			SAVE
		</button>
	</div>
</div>
<br><br><br><br>