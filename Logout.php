<?php
	session_start();
	unset($_SESSION['username']);
	unset($_SESSION['idAlbum']);
	session_destroy();
	header("location:Layout.php");	
?>