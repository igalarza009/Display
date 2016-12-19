<?php

	$link = mysqli_connect("localhost", "root", "", "display");
	//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz");
	
	$email=$_REQUEST['email']; 
		
	$usuarios = mysqli_query($link,"select * from usuario where email='$email'");
		
	$cont = mysqli_num_rows($usuarios); 
			
	if($cont==1){
		echo "Ya se ha registrado un usuario con dicho email. Introduzca uno nuevo por favor.";
	}
	else{
		echo "<br/>";
	}

	mysqli_close($link);

?>