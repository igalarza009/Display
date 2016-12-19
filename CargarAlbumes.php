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
		
	$us = $_SESSION['username'];
		
	$misAlbumes = mysqli_query($link, "select * from album where Username = '$us'" );
	
	while ($row = mysqli_fetch_array( $misAlbumes )) {
		$nombre = $row['Nombre'];
		$id = $row['IdAlbum'];
		$imagenes = mysqli_query($link, "select * from imagen where Username = '$us' and NombreAlbum = '$nombre'" );
		$row2 =  mysqli_fetch_array( $imagenes );
		$imagen = $row2['Path'];
			
		echo '<p>';
		echo '<br> <br> <a href="album.php?nombreAlbum=' . $nombre. '">' . $nombre . '</a>';
		echo '<br><a href="album.php?nombreAlbum=' . $nombre. '"><img src=" '. htmlspecialchars($imagen) .' " alt="image" width="2000" height="2000"/></a>';
		echo '<br> <br> <a href="borrarAlbum.php?idAlbum=' . $id. '" style = "button">BORRAR ALBUM</a>';
		echo '</p>';
	}

?>