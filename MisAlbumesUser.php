<?php
	session_start();
	if (!isset($_SESSION['username'])){
		header("location:Login.php");
	}
	if ($_SESSION['admin'] =='SI'){
		header("location:GestionAlbumesAdmin.php");
	}
?>
<html>
<head>
    <meta charset="utf-8">
	<title>Irania</title>
    <link rel='stylesheet' type='text/css' href='estilo.css' />
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" charset="UTF-8"></script>

    <script type="text/javascript">
	    $(document).ready(function() {
	    	$('#cancel_add_album').hide();
	    	$('#add_album').click(function(){
	    		$("#aÃ±adirAlbum").load("FormularioNuevoAlbum.html");
	    		$('#add_album').hide();
	    		$('#cancel_add_album').show();
	    	});
	    	$('#cancel_add_album').click(function(){
	    		$("#aÃ±adirAlbum").html("");
	    		$('#add_album').show();
	    		$('#cancel_add_album').hide();

	    	});
	    });
		
    </script>
</head>
<body class="fondo">
 	<ul>
  		<li class=logo><img src="display.png"/></li>
  		<li><a href="LayoutUser.php">Inicio</a></li>
  		<li><a href="MisAlbumesUser.php" class="active">Mis Álbumes</a></li>
		<li><a href="MisAlbumesCompartidos.php">Álbumes Compartidos Conmigo</a></li>
  		<li class="right"><a href="Logout.php">Cerrar sesión (<?php echo $_SESSION['username']; ?>)</a></li>
	</ul>

<div style="padding:70px;margin-top:30px;height: 700px">

	<div id="aÃ±adirAlbum"> </div>

	<div class="center">
		<button id="add_album">+ AÑADIR ALBUM</button> 
		<button id="cancel_add_album">CANCELAR NUEVO ÁLBUM</button>
	<br/>
	</div>
	
	<div id="misAlbumes">

	<?php
		$link = mysqli_connect("localhost", "root", "", "display");
		// $link = mysqli_connect("mysql.hostinger.es", "u531741362_admin", "iratiania", "u531741362_dp");
			
		$us = $_SESSION['username'];
			
		$misAlbumes = mysqli_query($link, "select * from album where Username = '$us'" );
		
		while ($row = mysqli_fetch_array($misAlbumes)) {
			$nombre = $row['Nombre'];
			$id = $row['IdAlbum'];

			//Si existe el Ã¡lbum fÃ­sicamente
			if (file_exists("albums/" . $us. "/" . $nombre)){
				$imagenes = mysqli_query($link, "select * from imagen where IdAlbum='$id'" );
				$row2 =  mysqli_fetch_array( $imagenes );
				$imagen = $row2['Path'];
				
				//Si existe la imagen fÃ­sicamente
				if (file_exists($imagen)){
					echo '<div class=albumUser>';
					echo '<div class="album">';
					echo '<a href="EditarAlbumUser.php?idAlbum=' . $id. '">';
					echo '<img src="'. htmlspecialchars($imagen) .'" alt="album ' .$nombre. '" width="300" height="200" border="0"/>';
					echo '</a>';
					echo '<div class="desc">' .$nombre.'</div>' ;
					echo '</div>';
					echo '<div class="delete"><a class="alb" href="BorrarAlbum.php?idAlbum=' . $id. '" style = "button"> <img src="bin2.png" width="20" height="20"/> ELIMINAR</a></div>';
					echo '</div>';
				}
			}
		}

	?>
	</div>
</div>

</body>
</html>

<?php

	if(isset($_POST['albumName'])){

		//FALTAN COMPROBACIONES LADO SERVIDOR

		$link = mysqli_connect("localhost", "root", "", "display");
		// $link = mysqli_connect("mysql.hostinger.es", "u531741362_admin", "iratiania", "u531741362_dp");
		
		// Creamos las carpetas necesarias para el Ã¡lbum
		$user_dir = "albums/" . $_SESSION['username'];
		$album_name = $_REQUEST['albumName'];
		$target_dir = $user_dir . "/". $album_name;
		$album_desc = $_REQUEST['albumDesc'];

		if (!file_exists($user_dir)) {
	   		mkdir($user_dir, 0777, true);
		}

		if (!file_exists($target_dir)) {
	   		mkdir($target_dir, 0777, true);
		}

		// Insertamos Ã¡lbum en la BD
		if ($_POST['visibility']=="Privada")
			$pub = "NO";
		else
			$pub = "SI";

		$sql="INSERT INTO album(Username, Nombre, Descripcion, Publico) VALUES ('$_SESSION[username]', '$album_name', '$album_desc', '$pub')";
		if (!mysqli_query($link ,$sql)){
			die('Error: ' . mysqli_error($link));
		}
		
		// Cogemos el Id del Ãlbum reciÃ©n creado
		$Album = mysqli_query($link, "select * from album where username = '$_SESSION[username]' and nombre = '$album_name'" );
		$row = mysqli_fetch_array( $Album );
		$idAl = $row['IdAlbum'];

		// Por cada imagen enviada
		for ($i = 0; $i < count($_FILES['image']['name']); $i++) {

			$ext = explode('.', basename($_FILES['image']['name'][$i]));  
			$file_extension = end($ext); 
			$target_file = $target_dir . "/" . uniqid() . "." . $file_extension; 

			$nombreIm = $_FILES['image']['name'][$i];

			// Guardamos fÃ­sicamente la imagen en el path indicado
			if (move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_file)){

				// Insertamos la imagen en la BD			
				$tag = $_POST['tag'][$i];
				$sql="INSERT INTO imagen(Username, IdAlbum, NombreAlbum, Path, Etiqueta, NombreImagen) VALUES ('$_SESSION[username]', '$idAl', '$album_name', '$target_file', '$tag', '$nombreIm')";
				if (!mysqli_query($link ,$sql)){
						die('Error: ' . mysqli_error($link));
				}
			}
			else {
				echo "<script type='text/javascript'>
					alert('Ha ocurrido un error'); 
					</script>";
					die();
			}
		}

		//Nunca llega a salir
		echo "<script type='text/javascript'>
			alert('Ãlbum creado correctamente'); 
			window.location.assign(MisAlbumesUser.php);
			</script>";
		header("location:MisAlbumesUser.php");
	}

?>