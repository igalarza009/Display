<?php
	session_start();
	if (!isset($_SESSION['username'])){
		header("location:Login.php");
	}
	
	$link = mysqli_connect("localhost", "root", "", "display");
	//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
	
	$idIm = $_REQUEST['idIm'];
	$id = $_SESSION['idAlbum'];
	
	$imagen = mysqli_query($link, "select * from imagen where IdImagen = '$idIm'" );
	$row =  mysqli_fetch_array($imagen);
	$usuario = $row['Username'];
	$album = $row['IdAlbum'];
	
	//Si el álbum no pertenece al usuario en cuestión
	if ($_SESSION['username'] != $usuario){
		header("location:LayoutUser.php");
	}

	//Si la imagen a borrar no está dentro del álbum escogido
	if ($album != $id){
		if ($_SESSION['admin'] =='SI'){
			echo "<script type='text/javascript'>
				alert('La imagen a eliminar no corresponde con el álbum seleccionado.'); 
				window.location.assign(MisAlbumesUser.php);
				script>";
		}
		else
			echo "<script type='text/javascript'>
				alert('La imagen a eliminar no corresponde con el álbum seleccionado.'); 
				window.location.assign(GestionAlbumesAdmin.php);
				script>";
	}
	else {
	
		//Eliminamos la imagen
		$deleteImage = "DELETE FROM Imagen WHERE IdImagen = '$idIm'";
		if (!mysqli_query($link ,$deleteImage)){
			die('Error: ' . mysqli_error($link));
		}
		
		if ($_SESSION['admin'] =='SI'){
			unset($_SESSION['IdAlbum']);
			header("location:EditarAlbumAdmin.php?idAlbum=$id");
		}
		else {
			unset($_SESSION['IdAlbum']);
			header("location:EditarAlbumUser.php?idAlbum=$id");
		}
	}
	
	
?>