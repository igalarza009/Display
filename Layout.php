<html>
<head>
    <meta charset="utf-8">
	<title>Irania</title>
    <link rel='stylesheet' type='text/css' href='estilo.css' />
</head>
<body class="fondo">
 	<ul>
  		<li class=logo><img src="display.png"/></li>
  		<li><a href="Layout.php" class="active">Inicio</a></li>
  		<li class="right"><a href="Registro.php">Registrarse</a></li>
 	 	<li class="right"><a href="Login.php">Login</a></li>
	</ul>

	<div style="padding:20px;margin-top:70px;height:1500px;">

	<?php
		$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
		
		$albumes = mysqli_query($link, "select * from album where Publico = 'SI'" );
	
		while ($row = mysqli_fetch_array( $albumes )) {
			$IdAlbum = $row['IdAlbum'];
			$nombre = $row['Nombre'];
			$user = $row['Username'];

			//Si existe el álbum fisicamente
			if (file_exists("albums/" . $user. "/" . $nombre)){
				$imagenes = mysqli_query($link, "select * from imagen where IdAlbum = '$IdAlbum'" );
				$row2 =  mysqli_fetch_array( $imagenes );
				$imagen = $row2['Path'];
			
				//Si existe la imagen físicamente
				if (file_exists($imagen)){
					echo '<div class="album">';
					echo '<a href="AlbumPublico.php?idAlbum=' . $IdAlbum. '">';
					echo '<img src="'. htmlspecialchars($imagen) .'" alt="album ' .$nombre. '" width="300" height="200" border="0"/>';
					echo '</a>';
					echo '<div class="desc"> '.$nombre.' <div class="autor">  By: '.$user.' </div> </div>' ;
					echo '</div>';
				}
			}
		}

	?>

	</div>

</body>
</html>