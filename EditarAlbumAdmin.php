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
  		<li><a href="GestionAlbumesAdmin.php">Todos los albumes</a></li>	
		<li><a href="GestionUsersAdmin.php">Todos los usuarios</a></li>	
		<li><a href="AltaUsersAdmin.php">Dar de alta</a></li>
  		<li class="right"><a href="logout.php">Cerrar sesión (Admin)</a></li>
	</ul>

	<div style="padding:70px;margin-top:30px;height: 700px">
		
	<?php
		$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!

		$pub = mysqli_query($link, "select * from album where IdAlbum='$_REQUEST[idAlbum]'");
		$row = mysqli_fetch_array($pub);
		// $publico = $row['Publico'];

		$nombre = $row['Nombre'];
		$desc = $row['Descripcion'];
		$id = $_REQUEST['idAlbum'];

		echo "<div class='titulo'> <h1>".$nombre."</h1> </div>";

			echo '<div class="right"> <div class="delete"> <a href="BorrarAlbum.php?idAlbum=' . $_REQUEST['idAlbum']. '"> <img src="bin2.png" width="20" height="20"/>ELIMINAR ALBUM</a> </div></div> <br/>';
		
		echo "<div class='descAlbum'><h4> Descripción del ábum: </h4><p>".$desc."</p></div>";	
		
		$misFotos = mysqli_query($link, "select * from imagen where idAlbum = '$id'" );

		echo '<h4> Imágenes del álbum: </h4>';
		echo '<div class=galeria>';
		echo '<div id=ImPeques>';
			
		while ($row = mysqli_fetch_array($misFotos)) {
			$idImagen = $row['IdImagen'];
			$imagen = $row['Path'];
			$nombreIm = $row['NombreImagen'];
			
			//Comprobamos que existe la imagen físicamente
			if (file_exists($imagen)){
				echo '<div class=albumUser>';
				echo '<div class="imagen">';
				echo '<img src="'. htmlspecialchars($imagen).'" alt="'.$nombreIm.'" width="100" height="77" />';
				echo '<div class="nomImagen"> <p>'.$nombreIm.' </p></div>';
				echo '</div>';
				echo '<div class="delete"><a href="BorrarImagen.php?idIm=' . $idImagen. '" style = "button"> <img src="bin2.png" width="20" height="20"/> BORRAR IMAGEN</a></div>';
				echo '</div>';
			}
		}

		echo '</div>';
		echo '</div>';
	?>

	</div>
	
</body>
</html>