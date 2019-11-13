<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<link rel="stylesheet" href="estilo.css">
<link href="https://fonts.googleapis.com/css?family=McLaren&display=swap" rel="stylesheet"> 
<body>
<div class="divlogin">
	<h1>Introduce el nombre de la tienda</h1>
	<form action="inventario.php" method="post">
		<input style="width: 100%" type="text" name="nombreinventario"><br><br>
		<button type="submit" name="submitlogin" class="boton_personalizado">Enviar</button>
	</form>
</div>
</body>
</html>