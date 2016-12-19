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
  		<li class="logo"><img src="display.png"/></li>
  		<li><a href="GestionAlbumesAdmin.php" class="active">Todos los albumes</a></li>	
		<li><a href="GestionUsersAdmin.php">Todos los usuarios</a></li>	
		<li><a href="AltaUsersAdmin.php">Dar de alta</a></li>
  		<li class="right"><a href="logout.php">CERRAR SESION</a></li>
	</ul>

	<div style="padding:70px;margin-top:30px;height: 700px">

	<?php
		$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
			
		$albumes = mysqli_query($link, "select * from album" );
		
		while ($row = mysqli_fetch_array( $albumes )) {
			$id = $row['IdAlbum'];
			$nombre = $row['Nombre'];
			$us = $row['Username'];
			//Si existe el álbum físicamente
			if (file_exists("albums/" . $us. "/" . $nombre)){
				$imagenes = mysqli_query($link, "select * from imagen where idAlbum = '$id'" );
				$row2 =  mysqli_fetch_array( $imagenes );
				$imagen = $row2['Path'];
				
				//Si existe la imagen físicamente
				if (file_exists($imagen)){
					echo '<div class=albumUser>';
					echo '<div class="album">';
					echo '<a href="EditarAlbumAdmin.php?idAlbum=' . $id. '">';
					echo '<img src="'. htmlspecialchars($imagen) .'" alt="album ' .$nombre. '" width="300" height="200" border="0"/>';
					echo '</a>';
					echo '<div class="desc">' .$nombre.'</div>' ;
					echo '</div>';
					echo '<div class="delete"><a href="BorrarAlbum.php?idAlbum=' . $id. '" style = "button"> <img src="bin2.png" width="20" height="20"/> ELIMINAR</a></div>';
					echo '</div>';
				}
			}
		}
	?>

	</div>

</body>
</html>

