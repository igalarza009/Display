<html>
<head>
	<meta charset="utf-8">
	<title>Irania</title>
	<link rel='stylesheet' type='text/css' href='estilo.css' />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" charset="UTF-8"></script>

	<script type="text/javascript">

		 $(document).ready(function() {
	   		$('#username').change(function(){
	    		var username = $("#username").val();
	    		$("#comprobarUsername").load("ComprobarUsername.php?username=" + username);
	    	});
	    	$('#correo').change(function(){
	    		var email = $("#correo").val();
	    		$("#comprobarEmail").load("ComprobarEmail.php?email=" + email);
	    	});
	    });

		function comprobarPasswords(){
			var pass1 = document.getElementById("password").value;
			var pass2 = document.getElementById("password2").value;
			if(pass1!=pass2){
				document.getElementById("compPasswords").innerHtml = "Las contraseñas no coinciden. Vuelva a intentaro por favor.";
			}
			else{
				document.getElementById("compPasswords").innerHtml = "<br/>";
			}
		}

	</script>
</head>
<body class="fondo">
	<ul>
		<li class="logo"><img src="display.png"/></li>
		<li><a href="Layout.php">Inicio</a></li>
		<li class="right"><a href="Registro.php" class="active">Registrarse</a></li>
		<li class="right"><a href="Login.php">Login</a></li>
	</ul>

	<div style="padding:20px;margin-top:70px;">

		<div class="container">

			<form id='registro' name='registro' action='Registro.php' method="post" enctype="multipart/form-data">

				<div class="header">
					<h3> REGISTRO </h3>
				</div>

				<div class="sep"></div>

				<div class="inputs">

					Nombre(*): <input type="text" id="nombre" name="Nombre" required autofocus=""><br>

					Apellidos(*): <input type="text" id="apellidos" name="Apellidos" required pattern="[a-zA-Z]+(\s)+[a-zA-Z]+"><br>

					Username(*): <input type="text" id="username" name="Username" required><br> 
					<div id="comprobarUsername"> <br> </div><br/>

					Direccion de correo(*): <input type="text" id="correo" name="Correo" required placeholder="you@youremail.com" pattern="[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})"> <br>
					<div id="comprobarEmail"> <br/> </div><br/>

					Contraseña(*): <input type="password" id="password" name="Password" required placeholder="Mínimo 6 caracteres" pattern=".{6,}"> <br>

					Repita la contraseña(*): <input type="password" id="password2" name="Password2" required pattern=".{6,}" onchange="comprobarPasswords()"> <br>
					<div id="compPasswords"> <br/> </div><br/>

					<p align="center">
						<input type="submit" id="submit" value="REGISTRARSE" name="submit"> 
					</p>
				</div>
			</form>
		</div>

	</div>
</body>
</html>

<?php

	if(isset($_POST['Nombre'])){

		$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_admin", "iratiania", "u531741362_dp");

		function validarExpresion($variable, $expresion){
			$validar = array(
					 "options" => array("regexp"=>$expresion)
				);
			if(!filter_var($variable, FILTER_VALIDATE_REGEXP, $validar)){
				return false;
			}
			else{
				return true;
			}
		}
		
		function validaRequerido($valor){
			if(trim($valor) == ''){
				return false;
			}
			else{
				return true;
			}
		}
		
		if (!validaRequerido($_POST['Nombre'])) {
			echo "<script type='text/javascript'>
			alert('Es obligatorio introducir el nombre'); 
			</script>";
			die();
		}
		if(!validaRequerido($_POST['Apellidos'])){
			echo "<script type='text/javascript'>
			alert('Es obligatorio introducir los apellidos'); 
			</script>";
			die();
		}
		if(!validarExpresion($_POST['Apellidos'], '/^[a-zA-Z]+(\s)+[a-zA-Z]+$/')){
			echo "<script type='text/javascript'>
			alert('Debes introducir dos apellidos'); 
			</script>";
			die();
		}
		if(!validaRequerido($_POST['Username'])){
			echo "<script type='text/javascript'>
			alert('Es obligatorio introducir un username'); 
			</script>";
			die();
		}

		if(!validaRequerido($_POST['Correo'])){
			echo "<script type='text/javascript'>
			alert('Es obligatorio introducir un email'); 
			</script>";
			die();
		}
		if(!validarExpresion($_POST['Correo'], '/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/')){
			echo "<script type='text/javascript'>
			alert('El email no es válido.'); 
			</script>";
			die();
		}
		
		if(!validaRequerido($_POST['Password'])){
			echo "<script type='text/javascript'>
			alert('Es obligatorio introducir una contraseña'); 
			</script>";
			die();
		}

		if(!validaRequerido($_POST['Password2'])){
			echo "<script type='text/javascript'>
			alert('Es obligatorio repetir la contraseña'); 
			</script>";
			die();
		}

		if(!validarExpresion($_POST['Password'], '/^.{6,}$/')){
			echo "<script type='text/javascript'>
			alert('La contraseña debe tener al menos 6 caracteres'); 
			</script>";
			die();
		}

		$pass = $_POST['Password'];
		$pass2 = $_POST['Password2'];

		if($pass!=$pass2){
			echo "<script type='text/javascript'>
			alert('Las contraseñas no coinciden. Vuelva a intentarlo por favor.'); 
			</script>";
			die();
		}

		$username = $_POST['Username'];

		$file = "avatar.jpg";

		$passEnc = sha1($_POST['Password']);

		$sql="INSERT INTO usuario VALUES ('$username', '$_POST[Nombre]', '$_POST[Apellidos]', '$_POST[Correo]','$passEnc', '$file', 'NO')";

		if (!mysqli_query($link ,$sql)){
			die('Error: ' . mysqli_error($link));
		}
		echo "<script type='text/javascript'>
			alert('Estamos procesando su petición, pronto podrá acceder a Display'); 
			</script>";

		mysqli_close($link);

		header("location:Layout.php");

	}

?>