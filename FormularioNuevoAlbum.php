<?php
	session_start();
	if (!isset($_SESSION['username'])){
		header("location:Login.php");
	}
	if ($_SESSION['admin'] =='SI'){
		header("location:GestionAlbumesAdmin.php");
	}

?>

<script type="text/javascript">

    $('#add_more').click(function() {
	    	$(this).before($("<div/>", {
	    		id: 'filediv'
	    		}).fadeIn('slow').append($("<img/>", {
		    			src: 'no_image.png',
		    			id: 'imagenSelec',
		    			height: '150',
		    			width: '210'
	    			}),
	    			$("<br/>"),
	    			$("<input/>", {
		    			name: 'image[]',
		    			type: 'file',
		    			id: 'image',
		    			accept: 'image/*'
	    			}), 
	    			$("<br/>"),
	    			"Etiquetar imagen:",
	    			$("<input/>", {
	    				name: 'tag[]',
		   				type: 'text',
		   				id: 'text'
	    			}),$("<br/>"), $("<br/>")));
    	});

    $(document).on("change",'#image',function(){
		var img = $(this).prev().prev();
		fotoDinamica(this,img);
	});

	function fotoDinamica(im,output){
		if (im.files && im.files[0]){
			var reader = new FileReader();
			reader.onload = function(){
				// var output = document.getElementById('idImg');
				output.attr("src", reader.result);
				// output.src = reader.result;
			};
			reader.readAsDataURL(im.files[0]);
		}
	}

</script>

<div class="container-nuevo-album">

<form id='nuevoAlbum' action="MisAlbumesUser.php" method="post" enctype="multipart/form-data">

	<div class="header"> <h3> NUEVO ÁLBUM  <h3> </div>

	<div class="sep"> </div>

	<div class="inputs">
			
	Nombre del álbum: <input type="text" class="peque" name="albumName" id="album_Name"  required /><br/>

	Descripción: <input type="text" name="albumDesc" id="album_Desc"/><br/>

	Visbilidad del álbum: 
	<select name="visibility" id="album_visibility" class="peque">
		<option selected value="Privada"> Privada </option>
		<option value="Publica"> Publica </option>
	</select>
	<br/><br/>
			
	<div class="bold"> Elegir imágenes:<br/><br/> </div>

	<div id="filediv">
		<img src="no_image.png" id="imagenSelec" width="210" height="150">
		<br/>
		<input name="image[]" type="file" id="image" accept="image/*" ><br/>
		<!-- <label for="imagen">Examinar...</label> <br/> -->
		Etiquetar imagen: <input name="tag[]" type="text" id="tag"/><br/>
		<br/>
	</div>
			
	<input type="button" id="add_more" value="+ Añadir Otra Imagen"/>
	<input type="submit" value="CREAR ÁLBUM" name="submit" id="submit" class="upload"/>
	</div>

</form>

</div>
