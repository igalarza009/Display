<?php
	session_start();
	if (!isset($_SESSION['username'])){
		header("location:Login.php");
	}
	if ($_SESSION['admin'] =='NO'){
		header("location:LayoutUser.php");
	}
	if (isset($_SESSION['IdAlbum'])){
		unset($_SESSION['IdAlbum']);
	}
?>
<html>
<head>
    <meta charset="utf-8">
	<title>Irania</title>
    <link rel='stylesheet' type='text/css' href='estilo.css' />
	<!-- <script type="text/javascript">
		
		function getGET(){
			var loc = document.location.href;
			var getString = loc.split('?')[1];
			var GET = getString.split('&');
			var tmp = GET[0].split('=');
			var get = unescape(decodeURI(tmp[1]));
			return get;
		}
	</script> -->
</head>
<body class="fondo">
 	<ul>
  		<li class=logo><img src="display.png"/></li>
  		<li><a href="GestionAlbumesAdmin.php">Todos los albumes</a></li>	
		<li><a href="GestionUsersAdmin.php">Todos los usuarios</a></li>	
		<li><a href="AltaUsersAdmin.php">Dar de alta</a></li>
  		<li class="right"><a href="logout.php">CERRAR SESION</a></li>
	</ul>

	<div style="padding:70px;margin-top:30px;height: 700px">
		
	<?php
		$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
			
		$id = $_REQUEST['idAlbum'];
		$_SESSION['IdAlbum'] = $id;
		
		echo '<br> <br> <a href="BorrarAlbum.php?idAlbum=' . $id. '" style = "button">BORRAR ALBUM</a>';
		
		$misFotos = mysqli_query($link, "select * from imagen where idAlbum = '$id'" );
			
		while ($row = mysqli_fetch_array($misFotos)) {
			$idImagen = $row['IdImagen'];
			$imagen = $row['Path'];
			$nombreIm = $row['NombreImagen'];
			
			//Comprobamos que existe la imagen físicamente
			if (file_exists($imagen)){
				echo '<p>';
				echo '<br><br>' . $nombreIm;
				echo '<br><img src=" '. htmlspecialchars($imagen) .' " alt="image" width="200" height="200"/>';
				
				echo '<br><a href="BorrarImagen.php?idIm=' . $idImagen. '" style = "button">BORRAR IMAGEN</a>';
				echo '</p>';
			}
		}

		// while($filas = $misFotos->fetch_array(MYSQLI_ASSOC)) {
		// 	// Se comprueba que existan las imagenes
		// 	if (file_exists("imagenes/".$filas["directorio"]."/".$filas["archivo"])){
		// 		echo'<a href="imagenes/'.$filas['directorio'].'/'.$filas['archivo'].'" rel="lightbox[galeria]" title="'.$filas['archivo'].'"><img src="imagenes/'.$filas['directorio'].'/'.$filas['archivo'].'"/></a>';
		// 	}                    
		// }
	?>

	</div>
	
</body>
</html>