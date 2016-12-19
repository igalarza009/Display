<?php
	session_start();
	if (!isset($_SESSION['username'])){
		header("location:Login.php");
	}
	if ($_SESSION['admin'] =='SI'){
		header("location:LayoutAdmin.php");
	}
	
	$link = mysqli_connect("localhost", "root", "", "display");
	//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
		
	$idAl = $_SESSION['idAlbum'];
	$us = $_SESSION['username'];
	$idImagen = $_REQUEST['idIm'];
	$nuevaEt = $_REQUEST['etiquetaIm'];
	
	$sql="UPDATE imagen SET Etiqueta = '$nuevaEt' WHERE idImagen = '$idImagen'";
	if (!mysqli_query($link ,$sql)){
		die('Error: ' . mysqli_error($link));
	}
	
	echo "<script type='text/javascript'>
					alert('Cambios guardados correctamente'); 
					</script>";
	header("location:EditarAlbumUser.php?idAlbum=$idAl");
?>