<?php
	session_start();
	if (!isset($_SESSION['username'])){
		header("location:Login.php");
	}
	if ($_SESSION['admin'] =='SI'){
		header("location:GestionAlbumesAdmin.php");
	}
	
	$link = mysqli_connect("localhost", "root", "", "display");
	//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
	
	$us = $_REQUEST['username'];
	$idAlbum = $_SESSION['idAlbum'];
	
	$compartir = "INSERT INTO albumcomp VALUES ('$idAlbum', '$us')";
	if (!mysqli_query($link ,$compartir)){
		die('Error: ' . mysqli_error($link));
	}
	
	header("location:EditarAlbumUser.php?idAlbum=$idAlbum");
?>