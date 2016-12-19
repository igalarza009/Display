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
	$id = $_SESSION['idAlbum'];
	
	$misFotos = mysqli_query($link, "select * from imagen where idAlbum = '$id'" );
		
	while ($row = mysqli_fetch_array( $misFotos )) {
		$imagen = $row['Path'];
		$nombreIm = $row['NombreImagen'];
		$idImagen = $row['IdImagen'];
		
		echo '<p>';
		echo '<form id="guardarEtiquetas" action="guardarEtiquetas.php" method="post" enctype="multipart/form-data">';
		echo '<br><br>' . $nombreIm;
		echo '<br><img src=" '. htmlspecialchars($imagen) .' " alt="image" width="2000" height="2000"/>';
		echo '<br> Añadir etiquetas:';
		echo '<br><input type="text" name="etiqueta" id="etiqueta"/>';
		echo '<br><input type="button" value="Save changes" name="submit" id="upload" class="upload" onClick="guardarEtiquetas('.$nombreIm.', )"/>';
		echo '<br><a href="borrarImagen.php?idIm=' . $idImagen. '" style = "button">BORRAR IMAGEN</a>';
		echo '</p>';
	}

	while($filas = $misFotos->fetch_array(MYSQLI_ASSOC)) {
        // Se comprueba que existan las imagenes
        if (file_exists("imagenes/".$filas["directorio"]."/".$filas["archivo"])){
            echo'<a href="imagenes/'.$filas['directorio'].'/'.$filas['archivo'].'" rel="lightbox[galeria]" title="'.$filas['archivo'].'"><img src="imagenes/'.$filas['directorio'].'/'.$filas['archivo'].'"/></a>';
        }                    
    }
?>