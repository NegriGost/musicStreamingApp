<?php 

	// iniciar sessão na base de dados
	ob_start();

	// iniciar sessão no browser
	session_start();

	// configurando o fuso horário
	$timezone=date_default_timezone_set('Africa/Maputo');

	$con=mysqli_connect("localhost","root","","slotify");


	if(mysqli_connect_errno()){
		echo "Failed to connect: ".mysqli_connect_errno();
	}




 ?>