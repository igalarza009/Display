<div class="container-nuevo-album">

<form id='nuevoAlbum' action="EditarAlbumUser.php" method="post">

	<div class="header"> <h3> MODIFICAR VISIBILIDAD  <h3> </div>

	<div class="sep"> </div>

	<div class="inputs">

	Cambiar visbilidad del álbum: 
	<select name="visibility" id="album_visibility" class="peque">
		<?php 
			$link = mysqli_connect("localhost", "root", "", "display");
			//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
				
			$id = $_REQUEST['idAlbum'];
			
			$result = mysqli_query($link, "select * from album where IdAlbum = '$id'" );
				
			while ($row = mysqli_fetch_array($result)) {
				$publico = $row['Publico'];
				if ($publico == 'SI'){
					echo '<option value="Privada"> Privada </option>
							<option selected value="Publica"> Publica </option>';
				}
				else{
					echo '<option selected value="Privada"> Privada </option>
					<option value="Publica"> Publica </option>';
				}
			}
		?>
	</select>
	<br/><br/>

	<input type="submit" value="MODIFICAR" name="submit" id="submit" class="upload"/>
	</div>

</form>

</div>