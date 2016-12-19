<?php
	session_start();
	
	if (!isset($_SESSION['username'])){
		header("location:Login.php");
	}
	if ($_SESSION['admin'] =='SI'){
		header("location:GestionAlbumesAdmin.php");
	}

	// if (isset($_SESSION['IdAlbum'])){
	// 	unset($_SESSION['IdAlbum']);
	// }
	
	$link = mysqli_connect("localhost", "root", "", "display");
	//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
			
	if (isset($_REQUEST['idAlbum']))
		$_SESSION['idAlbum'] = $_REQUEST['idAlbum'];

	$id = $_SESSION['idAlbum'];
	
	$result = mysqli_query($link, "select * from album where IdAlbum = '$id'" );
		
	while ($row = mysqli_fetch_array($result)) {
		$user = $row['Username'];
		if ($user != $_SESSION['username']) 
			header("location:LayoutUser.php");
		$_SESSION['nombreAlbum'] = $row['Nombre'];
		$_SESSION['albumDescr'] = $row['Descripcion'];
	}
	
?>
<html>
<head>
    <meta charset="utf-8">
	<title>Irania</title>
    <link rel='stylesheet' type='text/css' href='estilo.css' />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" charset="UTF-8"></script>

    <script type="text/javascript">

    	 $(document).ready(function() {
	    	$('#cancel_modify_visib').hide();
	    	$('#cancel_modify_desc').hide();
	    	$('#cancel_add_imag').hide();
	    	$('#cancel_modify_comp').hide();

	    	$('#modify_visib').click(function(){
	    		$("#modificarVisib").load("FormularioModificarVisib.php?idAlbum=<?php echo $_SESSION['idAlbum']?>");
	    		$('#modify_visib').hide();
	    		$('#cancel_modify_visib').show();
	    	});
	    	$('#modify_desc').click(function(){
	    		$("#modificarDesc").load("FormularioModificarDesc.php?idAlbum=<?php echo $_SESSION['idAlbum']?>");
	    		$('#modify_desc').hide();
	    		$('#cancel_modify_desc').show();
	    	});
	    	$('#add_imag').click(function(){
	    		$("#addImagenes").load("FormularioAddImagenes.html");
	    		$('#add_imag').hide();
	    		$('#cancel_add_imag').show();
	    	});
	    	$('#modify_comp').click(function(){
	    		$("#modificarComp").load("FormularioAddComp.php");
	    		$('#modify_comp').hide();
	    		$('#cancel_modify_comp').show();
	    	});


	    	$('#cancel_modify_visib').click(function(){
	    		$("#modificarVisib").html("");
	    		$('#modify_visib').show();
	    		$('#cancel_modify_visib').hide();
	    	});
	    	$('#cancel_modify_desc').click(function(){
	    		$("#modificarDesc").html("");
	    		$('#modify_desc').show();
	    		$('#cancel_modify_desc').hide();
	    	});
	    	$('#cancel_add_imag').click(function(){
	    		$("#addImagenes").html("");
	    		$('#add_imag').show();
	    		$('#cancel_add_imag').hide();
	    	});
	    	$('#cancel_modify_comp').click(function(){
	    		$("#modificarComp").html("");
	    		$('#modify_comp').show();
	    		$('#cancel_modify_comp').hide();
	    	});
	    });
	    	
		//No funciona: expected expression, got ')' CREO QUE YA ESTÁ CORREGIDO
		function guardarEtiquetas(idIm){
			// var idIm = nomIm;
			var etiq = document.getElementById("etiqueta").value;
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
					document.getElementById("etiquetaGuardada") = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET","guardarEtiqueta.php?idIm="+idIm+"&etiquetaIm"+etiq, true);
			xmlhttp.send();
		}
    </script>
</head>
<body class="fondo">
 	<ul>
  		<li class=logo><img src="display.png"/></li>
  		<li><a href="LayoutUser.php">Inicio</a></li>
  		<li><a href="MisAlbumesUser.php">Mis Álbumes</a></li>
		<li><a href="MisAlbumesCompartidos.php">Álbumes Compartidos Conmigo</a></li>
  		<li class="right"><a href="MiCuenta.php">AVATAR</a></li>
	</ul>

<div style="padding:20px;margin-top:30px;height: 700px">

	<?php	
		$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!

		$nombre = $_SESSION['nombreAlbum'];
		$desc = $_SESSION['albumDescr'];
		$pub = mysqli_query($link, "select * from album where IdAlbum='$_SESSION[idAlbum]'");
		$row = mysqli_fetch_array($pub);
		$publico = $row['Publico'];

		echo "<div class='titulo'> <h1>".$nombre;
		if ($publico=='NO'){
			echo " (Privado) </h1> </div>";
		}
		if ($publico=='SI'){
			echo " (Publico) </h1> </div>";
		}
		if ($publico=='CP'){
			echo " (Compartido) </h1> </div>";
		}

			echo '<div class="right"> <div class="delete"> <a href="BorrarAlbum.php?idIm=' . $_SESSION['idAlbum']. '"> <img src="bin2.png" width="20" height="20"/>ELIMINAR ALBUM</a> </div></div> <br/>';

		echo '<div id="modificarVisib"></div>
			<div class="center">
				<button id="modify_visib">MODIFICAR VISIBILIDAD</button> 
				<button id="cancel_modify_visib">CANCELAR MODIFICAR VISIBILIDAD</button>
			</div>';

		$result = mysqli_query($link, "select * from album where IdAlbum = '$id'" );
		while ($row = mysqli_fetch_array($result)) {
			$pub = $row['Publico'];
			if ($pub != "SI"){
				echo '<div id="modificarComp"></div>
				<div class="center">
				<button id="modify_comp">MODIFICAR COMP</button> 
				<button id="cancel_modify_comp">CANCELAR MODIFICAR COMP</button>
				</div>';
			}
		}

		echo "<div class='descAlbum'><h4> Descripción del ábum: </h4><p>".$desc."</p></div>";	
		echo '
			<div id="modificarDesc"></div>

			<div id="modificarAlbum"></div>

			<div class="center">
				<button id="modify_desc">MODIFICAR DESCRIPCIÓN</button> 
				<button id="cancel_modify_desc">CANCELAR MODIFICAR DESCRIPCIÓN</button>
			<br/>
			</div>';
	
	// <!-- <div id="etiquetaGuardada"></div> -->
			
		$us = $_SESSION['username'];
		$id = $_SESSION['idAlbum'];
		
		$misFotos = mysqli_query($link, "select * from imagen where idAlbum = '$id'" );

		echo '<h4> Imágenes del álbum: </h4>';
		echo '<div id="addImagenes"></div>';
		echo '<div class="center">
				<button id="add_imag">AÑADIR IMÁGENES</button> 
				<button id="cancel_add_imag">CANCELAR AÑADIR IMÁGENES</button>
			<br/></div>';
		echo '<div class=galeria>';
		echo '<div id=ImPeques>';
			
		while ($row = mysqli_fetch_array( $misFotos )) {
			$imagen = $row['Path'];
			$nombreIm = $row['NombreImagen'];
			$idImagen = $row['IdImagen'];
			$etiqueta = $row['Etiqueta'];
			
			//Comprobamos que existe la imagen físicamente
			if (file_exists($imagen)){
				echo '<div class=albumUser>';
				echo '<div class="imagen">';
				echo '<img src="'. htmlspecialchars($imagen).'" alt="'.$nombreIm.'" width="100" height="77" />';
				echo '<div class="nomImagen"> <p>'.$nombreIm.' </p></div>';
				echo '</div>';
				echo '<div class="delete"><a href="BorrarImagen.php?idAlbum=' . $idImagen. '" style = "button"> <img src="bin2.png" width="20" height="20"/> BORRAR IMAGEN</a></div>';
				echo '</div>';
				echo '</div>';
			}

			// echo '<div class=albumUser>';
			// 		echo '<div class="album">';
			// 		echo '<a href="EditarAlbumUser.php?idAlbum=' . $id. '">';
			// 		echo '<img src="'. htmlspecialchars($imagen) .'" alt="album ' .$nombre. '" width="300" height="200" border="0"/>';
			// 		echo '</a>';
			// 		echo '<div class="desc">' .$nombre.'</div>' ;
			// 		echo '</div>';
			// 		echo '<div class="delete"><a href="BorrarAlbum.php?idAlbum=' . $id. '" style = "button"> <img src="bin2.png" width="20" height="20"/> ELIMINAR</a></div>';
			// 		echo '</div>';
		}

		echo '</div>';
		// echo'</div>';

	?>
	<!-- <div id=ImGrande>
		<div class=imagen>
			<img src="" alt="Imagen grande" width="450" height="400" id="grande"/>
		</div>
		<div class="datos">
			<p> </p>
			<div class=center> </div>
		</div>
	</div> -->

</div>
</div>

<?php

	if(isset($_POST['albumDesc'])){
		$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
		
		$album_desc = $_POST['albumDesc'];
		
		$sql="update album set Descripcion='$album_desc' where IdAlbum='$_SESSION[idAlbum]'";
		if (!mysqli_query($link ,$sql)){
			die('Error: ' . mysqli_error($link));
		}

		//Nunca llega a ejecutarse
		// echo "<script type='text/javascript'>
		// 			alert('Cambios guardados correctamente');
		// 			window.location.assign(EditarAlbumUser.php?idAlbum=" . $_SESSION['idAlbum']. "); 
		// 			</script>";
		$idAlb = $_SESSION['idAlbum'];
		header("location:EditarAlbumUser.php?idAlbum=$idAlb");
	}

	 if(isset($_POST['visibility'])){

		$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
		
		$vis = $_POST['visibility'];

		if($vis=='Publica'){
			$pub = 'SI';
		}
		else
			$pub = 'NO';

		$sql="UPDATE album SET Publico = '$pub' where IdAlbum='$_SESSION[idAlbum]'";
		if (!mysqli_query($link ,$sql)){
			die('Error: ' . mysqli_error($link));
		}

		//Nunca llega a ejecutarse
		// echo "<script type='text/javascript'>
		// 			alert('Cambios guardados correctamente'); 
		// 			</script>";
		$idAlb = $_SESSION['idAlbum'];
		header("location:EditarAlbumUser.php?idAlbum=$idAlb");

	 }
	
	 if(isset($_FILES['image']['name'][0])){
	 	$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
		
		$user_dir = "albums/" . $_SESSION['username'];
		$album_name = $_SESSION['nombreAlbum'];
		$target_dir = $user_dir . "/". $album_name;
		
		$idAl = $_SESSION['idAlbum']; 
		
		for ($i = 0; $i < count($_FILES['image']['name']); $i++) {

			$ext = explode('.', basename($_FILES['image']['name'][$i]));  
			$file_extension = end($ext); 
			$target_file = $target_dir . "/" . uniqid() . "." . $file_extension;

			$nombreIm = $_FILES['image']['name'][$i];
			if (move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_file)){
				//GUARDAR LA IMAGEN EN LA BD
				$tag = $_POST['tag'][$i];				
				$sql="INSERT INTO imagen(Username, IdAlbum, NombreAlbum, Path, Etiqueta, NombreImagen) VALUES ('$_SESSION[username]', '$idAl', '$album_name', '$target_file', '$tag', '$nombreIm')";
				if (!mysqli_query($link ,$sql)){
						die('Error: ' . mysqli_error($link));
				}
			}
			else {
				echo "<script type='text/javascript'>
					alert('Ha ocurrido un error'); 
					</script>";
					die();
			}
		}

		//Nunca llega a ejecutarse
		// echo "<script type='text/javascript'>
		// 			alert('Cambios guardados correctamente'); 
		// 			</script>";
		// header("location:EditarAlbumUser.php?idAlbum=$idAl");
		header("location:EditarAlbumUser.php?idAlbum=$idAl");
		
	 }

	 if(isset($_POST['usComp'])){
		if($_POST['usComp'] != ""){
			$link = mysqli_connect("localhost", "root", "", "display");
			//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
			
			$us = $_POST['usComp'];
			$idAl = $_SESSION['idAlbum'];
			
			$sql="UPDATE album SET Publico = 'CM' WHERE IdAlbum = '$idAl'";
			if (!mysqli_query($link ,$sql)){
				die('Error: ' . mysqli_error($link));
			}
		
			$sql="INSERT INTO albumcomp(IdAlbum, Username) VALUES ('$idAl', '$us')";
			if (!mysqli_query($link ,$sql)){
				die('Error: ' . mysqli_error($link));
			}
			
			header("location:EditarAlbumUser.php?idAlbum=$idAl");
		}
	}


?>
<br/><br/><br/>

</body>
</html>