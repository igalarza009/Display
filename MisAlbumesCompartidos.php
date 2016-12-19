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
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" charset="UTF-8"></script>
	<script type="text/javascript">
		$(document).ready(function() {
	    	$('#cancel_add_album').hide();
	    	$('#add_album').click(function(){
	    		$("#añadirAlbum").load("FormularioNuevoAlbum.html");
	    		$('#add_album').hide();
	    		$('#cancel_add_album').show();
	    	});
	    	$('#cancel_add_album').click(function(){
	    		$("#añadirAlbum").html("");
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
  		<li><a href="MisAlbumesUser.php">Mis Álbumes</a></li>
		<li><a href="MisAlbumesCompartidos.php" class="active">Álbumes Compartidos Conmigo</a></li>
  		<li class="right"><a href="MiCuenta.php">AVATAR</a></li>
	</ul>

<div style="padding:20px;margin-top:30px;height: 700px">

	<div id="misAlbumes">

	<?php
		$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
			
		$us = $_SESSION['username'];
			
		$misAlbumesComp = mysqli_query($link, "select * from albumComp where Username = '$us'" );
		
		while ($row = mysqli_fetch_array($misAlbumesComp)) {
			$nombre = $row['Username'];
			$id = $row['IdAlbum'];

			//Si existe el álbum físicamente
			// if (file_exists("albums/" . $us. "/" . $nombreAlbum)){
				$imagenes = mysqli_query($link, "select * from imagen where IdAlbum='$id'" );
				$row2 =  mysqli_fetch_array( $imagenes );
				$imagen = $row2['Path'];
				$nombreAlbum = $row2['NombreAlbum'];
				
				//Si existe la imagen físicamente
				if (file_exists($imagen)){
					echo '<div class=albumUser>';
					echo '<div class="album">';
					echo '<a href="AlbumCompartido.php?idAlbum=' . $id. '"></a>';
					echo '<a href="AlbumCompartido.php?idAlbum=' . $id. '"><img src="'. htmlspecialchars($imagen) .'" alt="album ' .$nombreAlbum. '" width="300" height="200" border="0"/>';
					echo '</a>';
					echo '<div class="desc">' .$nombreAlbum.'</div>' ;
					echo '</div>';
					echo '</div>';
				}
			// }
		}

	?>
	</div>

</div>
</body>
</html>
