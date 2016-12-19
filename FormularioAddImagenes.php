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

<form id='modificarAlbum' action="EditarAlbumUser.php" method="post" enctype="multipart/form-data">

	<div class="header"> <h3> AÑADIR IMÁGENES  <h3> </div>

	<div class="sep"> </div>

	<div class="inputs">
			
	<div class="bold"> Subir más imágenes:<br/><br/> </div>

	<div id="filediv">
	</div>
			
	<input type="button" id="add_more" value="+ Añadir Otra Imagen"/>
	<input type="submit" value="AÑADIR" name="submit" id="submit" class="upload"/>
	</div>

</form>

</div>