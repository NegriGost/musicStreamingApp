<?php 


	// remeber inputs values
	function getInputValue($name){

		if(isset($_POST[$name])){

			echo $_POST[$name];

		}

	}

 ?>