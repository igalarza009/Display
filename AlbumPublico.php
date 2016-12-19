<?php
	session_start();
			
	if (isset($_SESSION['username']) && ($_SESSION['admin'] =='SI')){
		header("location:GestionAlbumesAdmin.php");
	}
	
	$link = mysqli_connect("localhost", "root", "", "display");
	//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
	
	$id = $_REQUEST['idAlbum'];
	$result = mysqli_query($link, "select * from album where idAlbum = '$id'" );
		
	while ($row = $result->fetch_assoc()) {
		$_SESSION['nombreAlbum'] = $row['Nombre'];
		$_SESSION['albumDescr'] = $row['Descripcion'];
		$publico = $row['Publico'];
		
		if ((!isset($_SESSION['username'])) && ($publico == "NO")){
			header("location:Login.php");
		}
	}

?>
<html>
<head>
    <meta charset="utf-8">
	<title>Irania</title>
    <link rel='stylesheet' type='text/css' href='estilo.css' />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" charset="UTF-8"></script>
	<script type="text/javascript">
		 $(document).ready(function() {
			$("#ImPeques img").click(function() {
				var image = $(this).attr('src');
				window.open(image, '_blank');
			});
		});
	</script>
</head>
<body class="fondo">
 	<ul>
		<li class=logo><img src="display.png"/></li>
		<?php
			if(!isset($_SESSION['username'])){ //Es un usuario anónimo
				echo '<li><a href="Layout.php">Inicio</a></li> 
						<li class="right"><a href="Registro.php">Registrarse</a></li>
						<li class="right"><a href="Login.php">Login</a></li>';
			}
			else{ //El usuario ha iniciado sesión
				echo '<li><a href="LayoutUser.php">Inicio</a></li>
						<li><a href="MisAlbumesUser.php">Mis Álbumes</a></li>
						<li><a href="MisAlbumesCompartidos.php">Álbumes Compartidos Conmigo</a></li>
						<li class="right"><a href="MiCuenta.php">AVATAR</a></li>'; 
			}
		?>
	</ul>

<div style="padding:20px;margin-top:30px;height:700px">

	<?php
		$nombre = $_SESSION['nombreAlbum'];
		$desc = $_SESSION['albumDescr'];
		echo "<div class='titulo'> <h1>".$nombre."</h1></div>";
		echo "<div class='descAlbum'><h4> Descripción del ábum: </h4><p>".$desc."</p></div>";

		$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
			
		$id = $_REQUEST['idAlbum'];
		$misFotos = mysqli_query($link, "select * from imagen where idAlbum = '$id'" );
			
		 echo '<h4> Imágenes del álbum: </h4>';
		 echo '<div class=galeria>';
		 echo '<div id=ImPeques>';

		while ($row = mysqli_fetch_array( $misFotos )) {
			$imagen = $row['Path'];
			$nombreIm = $row['NombreImagen'];
			$idImagen = $row['IdImagen'];
			$etiquetas = $row['Etiqueta'];

			//Comprobamos que existe la imagen físicamente
			if (file_exists($imagen)){

				echo '<div class="imagen">';
				echo '<img src="'. htmlspecialchars($imagen).'" alt="'.$nombreIm.'" width="100" height="77" />';
				echo '<div class="nomImagen"> <p>'.$nombreIm.' </p></div>';
				echo '</div>';
			}
		}
		echo '</div></div>';

	?>

</div>
</body>
</html>
