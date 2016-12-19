<?php
	session_start();
	if (!isset($_SESSION['username'])){
		header("location:Login.php");
	}
	
	$link = mysqli_connect("localhost", "root", "", "display");
	//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!

	$idAlbum = $_REQUEST['idAlbum'];
	
	$album = mysqli_query($link, "select * from album where idAlbum = '$idAlbum'" );
	$row =  mysqli_fetch_array($album);
	$usuario = $row['Username'];
	
	if ($_SESSION['username'] != $usuario){
		header("location:LayoutUser.php");
	}		
	
	// Eliminamos las imágenes del álbum
	$deleteImages = "DELETE FROM Imagen WHERE IdAlbum = '$idAlbum'";
	if (!mysqli_query($link ,$deleteImages)){
		die('Error: ' . mysqli_error($link));
	}
	
	//Eliminamos el álbum
	$deleteAlbum = "DELETE FROM Album WHERE IdAlbum = '$idAlbum'";
	if (!mysqli_query($link ,$deleteAlbum)){
		die('Error: ' . mysqli_error($link));
	}
	
	if ($_SESSION['admin'] =='SI'){
		unset($_SESSION['IdAlbum']);
		header("location:GestionAlbumesAdmin.php");
	}
	else {
		unset($_SESSION['IdAlbum']);
		header("location:MisAlbumesUser.php");
	}
?>
