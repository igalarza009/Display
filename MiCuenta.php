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
</head>
<body>
 	<ul>
  		<li class="logo"><img src="display.png"/></li>
  		<li><a href="LayoutUser.php">Inicio</a></li>
  		<li><a href="MisAlbumesUser.php">Mis Álbumes</a></li>
  		<li class="right"><a href="MiCuenta.php" class="active">AVATAR</a></li>
	</ul>

	<div style="padding:20px;margin-top:30px;">

	<br><br>

	<a href="Logout.php"> LOGOUT </a>

	</div>


</body>
</html>