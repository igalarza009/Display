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
		
		$usuarios = mysqli_query($link,"select * from usuario where username='$name' and password='$passEnc'");
		
		$cont = mysqli_num_rows($usuarios); 
			
		if($cont==1){

            $usuarioAc = mysqli_query($link,"select * from usuario where username='$name' and password='$passEnc' and Aceptado='SI'");
            $aceptado = mysqli_num_rows($usuarioAc);
			
            if($aceptado ==1){
            	$_SESSION['username'] = $name;
                $aceptado = $row['Aceptado'];
				
			    if ($name == $nameAdmin){
					$_SESSION['admin'] = "SI";
					header("location:GestionAlbumesAdmin.php");
			    }
			    else{
				   	$_SESSION['admin'] = "NO";
				   	header("location:LayoutUser.php");
			    }
            }
            else echo "<script type='text/javascript'>
		 			alert('Su solicitud de acceso se esta procesando, aun no está dado de alta.'); 
		 			</script>";	
		}
		else {
			echo "<script type='text/javascript'>
		 			alert('Datos incorrectos'); 
		 			</script>";
		}
	
		mysqli_close($link);
	}
?>

		</div>
		
	</body>
</html>