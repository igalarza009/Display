<?php
	session_start();
	if (!isset($_SESSION['username'])){
		header("location:Login.php");
	}
	if ($_SESSION['admin'] =='NO'){
		header("location:LayoutUser.php");
	}
?>
<html>
<head>
    <meta charset="utf-8">
	<title>Irania</title>
    <link rel='stylesheet' type='text/css' href='estilo.css' />
</head>
<body class="fondo">
 	<ul>
  		<li class=logo><img src="display.png"/></li>
  		<li><a href="GestionAlbumesAdmin.php">Todos los albumes</a></li>	
		<li><a href="GestionUsersAdmin.php" class="active">Todos los usuarios</a></li>	
		<li><a href="AltaUsersAdmin.php">Dar de alta</a></li>
  		<li class="right"><a href="logout.php">CERRAR SESION</a></li>
	</ul>
	
	<div style="padding:70px;margin-top:30px;height: 700px">
	
	<table id="table"><tr><th>Username</th><th>Email</th><th>Eliminar</th></tr>
		
	<?php
		$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
			
		$admin = "Vadillo";
		$usuarios = mysqli_query($link, "select * from usuario where Aceptado = 'SI' " );
			
		while ($row = mysqli_fetch_array( $usuarios )) {
			$username = $row['Username'];
			$email = $row['Email'];
			
			if ($username != $admin){
				echo '<tr><td>' . $username . '</td>';
				echo '<td>' . $email . '</td>';
				echo '<td><div class="delete"><a href="eliminarUsuario.php?username=' . $username. '" style = "button"><img src="bin2.png" width="20" height="20"/> ELIMINAR</a></div></td></tr>';	
			}
		}
	?>
	</table>
	</div>
	
</body>
</html>