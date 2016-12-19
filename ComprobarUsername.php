<?php

	$link = mysqli_connect("localhost", "root", "", "display");
	//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz");
	
	$username=$_REQUEST['username']; 
		
	$usuarios = mysqli_query($link,"select * from usuario where username='$username'");
		
	$cont = mysqli_num_rows($usuarios); 
			
	if($cont==1){
		echo "Dicho username ya existe. Por favor, seleccione uno distinto.<br/>";
	}
	else{
		echo "<br/>";
	}

	mysqli_close($link);

?>