<?php
	session_start();
?>
<html>
	<head>
		<title> Login </title>
		<link rel='stylesheet' type='text/css' href='estilo.css' />
		<meta charset="utf-8">
	</head>
	<body class="fondo">
		<ul>
			<li class="logo"><img src="display.png"/></li>
			<li><a href="Layout.php">Inicio</a></li>
			<li class="right"><a href="Registro.php">Registrarse</a></li>
			<li class="right"><a href="Login.php" class="active">Login</a></li>
		</ul>

	<div style="padding:20px;margin-top:70px;height: 700px">

		<div class="container">

		<form id="login" method="post">

		<div class="header">
			<h3> LOGIN </h3>
		</div>

		<div class="sep"> </div>

		<div class="inputs">
			<p> Username: <input type="text" required name="username" size="21" value="" autofocus=""/> </p>
			<p> Password: <input type="password" required name="pass" size="21" value="" /> </p>
			<p> <input id="submit" value="ENTRAR" type="submit" /> </p>
		</div>
		</form>
		</div>

<?php
	if (isset($_POST['username'])){
		
		$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_admin", "iratiania", "u531741362_dp");
	
		$name=$_POST['username']; 
		$pass=$_POST['pass'];
		
		$nameAdmin = "Vadillo";

		$passEnc = sha1($pass);
		
		$usuarios = mysqli_query($link,"select * from usuario where username='$name' and password='$passEnc' and aceptado='SI'");
		
		$cont = mysqli_num_rows($usuarios); 
			
		if($cont==1){

			$_SESSION['username'] = $name;

			// $horaConex = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
			// $sql="INSERT INTO conexiones(Correo, Hora) VALUES ('$email', '$horaConex' )";
			// if (!mysqli_query($link ,$sql)){
			// 	die('Error: ' . mysqli_error($link));
			// }
				
			if ($name == $nameAdmin){
				$_SESSION['admin'] = "SI";
				header("location:GestionAlbumesAdmin.php");
			}
			else{
				$_SESSION['admin'] = "NO";
				header("location:LayoutUser.php");
			}	
		}
		else {
			echo "<p> <FONT COLOR=RED>Datos incorrectos !!</FONT> </p>";
		}
	
		mysqli_close($link);
	}
?>

		</div>
		
	</body>
</html>