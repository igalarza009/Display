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
					
	$id = $_SESSION['idAlbum'];
	$yaComp = "NO";
				
	$result = mysqli_query($link, "select * from album where IdAlbum = '$id'" );			
	$row = mysqli_fetch_array($result);
	$user = $row['Username'];
	if($_SESSION['username']!=$user){
		header("location:LayoutUser.php");
	}

?>

<div class="container-nuevo-album">

<form id='modificarAlbum' action="EditarAlbumUser.php" method="post" enctype="multipart/form-data">

	<div class="header"> <h3> COMPARTIR ALBUM <h3> </div>

	<div class="sep"> </div>

	<div class="inputs">

	Usuarios con los que ya esta compartido:
	<?php 
		$link = mysqli_connect("localhost", "root", "", "display");
		//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
					
		$id = $_SESSION['idAlbum'];
		$yaComp = "NO";
				
		$result = mysqli_query($link, "select * from albumcomp where IdAlbum = '$id'" );			
		while ($row = mysqli_fetch_array($result)) {
			$yaComp = "SI";
			$user = $row['Username'];
			echo $user;
			echo '<br>';
		}	

		if ($yaComp == "NO"){
			echo "Este album todavía no ha sido compartido con nadie";
			echo '<br>';
		}
	?>
	<br/>
	<br/>
	Añadir usuarios con los que compartir el álbum: 
	<select name="usComp" id="usComp" class="peque">
		<option selected value=""> Seleccione un usuario </option> 
		<?php 
			$link = mysqli_connect("localhost", "root", "", "display");
			//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
				
			$id = $_SESSION['idAlbum'];
			$admin = "Vadillo";
			$autor = $_SESSION['username'];
					
			$usuario = mysqli_query($link, "select * from usuario" );
			while ($row = mysqli_fetch_array( $usuario )){
				$us = $row['Username'];

				if (($us!=$autor) && ($us!=$admin)){

					$usYaComp = false;

					$usuarios = mysqli_query($link, "select * from albumcomp where IdAlbum = '$id'" );
					while (($row2 = mysqli_fetch_array($usuarios)) && !$usYaComp) {
						if ($us == $row2['Username'])
							$usYaComp = true;
					}
					
					if (!$usYaComp){
						echo '<option value = '.$us .'>' . $us . '</option>';
					}
				}
			}
		?>
	</select>
	<br/><br/>
	
	<div id = "compartirCon"> </div>
	<br/><br/>

	<input type="submit" value="MODIFICAR" name="submit" id="submit" class="upload"/>
	</div>

</form>

</div>