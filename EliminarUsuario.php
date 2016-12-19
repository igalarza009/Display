
<?php
	session_start();
	if (!isset($_SESSION['username'])){
		header("location:Login.php");
	}
	if ($_SESSION['admin'] =='NO'){
		header("location:LayoutUser.php");
	}
	
	$link = mysqli_connect("localhost", "root", "", "display");
	//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
	
	$us = $_REQUEST['username'];
	
	$user = "DELETE FROM Usuario WHERE Username = '$us'";
	if (!mysqli_query($link ,$user)){
		die('Error: ' . mysqli_error($link));
	}
	
	$album = "DELETE FROM Album WHERE Username = '$us'";
	if (!mysqli_query($link ,$album)){
		die('Error: ' . mysqli_error($link));
	}
	
	$images = "DELETE FROM Imagen WHERE Username = '$us'";
	if (!mysqli_query($link ,$images)){
		die('Error: ' . mysqli_error($link));
	}
	
	header("location:usuariosAdmin.php");
?>