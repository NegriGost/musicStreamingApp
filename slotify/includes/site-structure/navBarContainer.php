<div id="navBarContainer">
	<nav class="navBar">

		<a  href="javascript:void(0)" onclick="openPage('index.php')" class="logo" role="link" tabindex="0">
			<img src="assets/images/icons/logo.png" alt="logo">
		</a>

		<div class="group">
			<div class="navItem">
				<a onclick="openPage('search.php')" role="link" tabindex="0" href="javascript:void(0)" class="navItemLink">
					<span>Search</span>
					<span><img src="assets/images/icons/search.png" class="icon" alt="search"></span>
				</a>
			</div>
		</div>

		<div class="group">
			<div class="navItem">
				<a onclick="openPage('browse.php')" role="link" tabindex="0" href="javascript:void(0)" class="navItemLink">Browse</a>
			</div>

			<div class="navItem">
				<a onclick="openPage('yourMusic.php')" role="link" tabindex="0" href="javascript:void(0)" class="navItemLink">Your Music</a>
			</div>

			<div class="navItem">
				<a  onclick="openPage('settings.php')" role="link" tabindex="0" href="javascript:void(0)" class="navItemLink"><?php echo $userLoggedIn->getFullName(); ?></a>
			</div>
		</div>

	</nav>
</div>
