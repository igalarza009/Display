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
	
	$user = "UPDATE Usuario SET Aceptado = 'SI' WHERE Username = '$us'";
	if (!mysqli_query($link ,$user)){
		die('Error: ' . mysqli_error($link));
	}
	
	header("location:AltaUsersAdmin.php");
?>