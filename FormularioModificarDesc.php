<div class="container-nuevo-album">

<form id='nuevoAlbum' action="EditarAlbumUser.php" method="post">

	<div class="header"> <h3> MODIFICAR DESCRIPCIÓN  <h3> </div>

	<div class="sep"> </div>

	<div class="inputs">
			
	Cambiar descripción: 

	<?php 
			$link = mysqli_connect("localhost", "root", "", "display");
			//$link = mysqli_connect("mysql.hostinger.es", "u531741362_root", "iratiania", "u531741362_quiz"); No esta cambiado!
				
			$id = $_REQUEST['idAlbum'];
			
			$result = mysqli_query($link, "select * from album where IdAlbum = '$id'" );
				
			while ($row = mysqli_fetch_array($result)) {
				$desc = $row['Descripcion'];
				echo '<input type="text" name="albumDesc" id="album_Desc" value="' . $desc.'"/>';
			}
		?><br/>

	<input type="submit" value="MODIFICAR" name="submit" id="submit" class="upload"/>
	</div>

</form>

</div>