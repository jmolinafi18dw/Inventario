<?php
	session_start();
?>
<!doctype html>
<html>
	<head>
		<title>
			DWES03 - Inventario
		</title>
	</head>
	<link rel="stylesheet" href="estilo.css">
	<link href="https://fonts.googleapis.com/css?family=McLaren&display=swap" rel="stylesheet"> 
	<body>
		<?php
			//Funciones extra que he utilizado para gestionar del inventario

			function stringtoarray ($string_inventario,&$array_inventario) {
				//Convierte el inventario de datos (string) en un array asociativo
				$a=explode (";",$string_inventario);
				for($i=0; $i<count($a); $i++) {
					$array_inventario[$a[$i]]=$a[$i+1];
					$i++;
				}
				return true;
			}

			function arraytostring ($array_inventario) {
				//Convierte el array asociativo en una cadena de caracteres cada elemento separado por ;
				foreach($array_inventario as $key_codigo => $value)
				{
				  $string_inventario.=$key_codigo.";".$value.";";
				}
				//Quitamos el ultimo ';''
				$string_inventario=substr($string_inventario, 0, -1);
				return $string_inventario;
			}

			function add_dispositivo ($codigo,$descripcion,&$array_inventario) {
				//Añadir dispositivo al array con clave 'codigo' y valor 'descripcion'
				$array_inventario[$codigo]=$descripcion;
				return true;
			}

			function del_dispositivo ($codigo,&$array_inventario) {
				//Borrar el elemento cuya clave es 'codigo'
				unset($array_inventario[$codigo]);
				return true;
			}

			function change_dispositivo ($codigo,$descripcion,&$array_inventario) {
				//Modificar el dispositivo al array con clave 'codigo' con valor 'descripcion'
				$array_inventario[$codigo]=$descripcion;
				return true;
			}

			function is_dispositivo ($codigo,$array_inventario) {
				//Comprobar si 'codigo' existe en el array
				$array_claves=array_keys($array_inventario);
				$pos=array_search($codigo,$array_claves);
				return (in_array($codigo,$array_claves));
			}
		?>
		<?php
		if (isset($_POST['nombreinventario']))
			$_SESSION['nombreinventario'] = $_POST['nombreinventario'];

		//Creamos un array para almacenar los datos del inventario
		$array_inventario=array();
		$error="";
		$info="";

		if (!empty($_POST['inventario']))
			//Rellenamos el array con los datos recibidos en el campo oculto 'inventario' del formulario
			stringtoarray ($_POST['inventario'],$array_inventario);

		if (isset ($_POST['submit'])) {
			if(!empty($_POST['codigo'])) {
				$codigo=strtolower($_POST['codigo']);
				if(!empty($_POST['descripcion'])) {
					// añadir un nuevo dispositivo al inventario, si ya existe modificara la descripcion
					if (is_dispositivo($codigo,$array_inventario)) {
						add_dispositivo ($codigo,$_POST['descripcion'],$array_inventario);
						$info = "Modificado 'descripcion'.";
					}
					else {
						add_dispositivo ($codigo,$_POST['descripcion'],$array_inventario);
						$info = "Nuevo dispositivo.";
					}
				}
				else { // el campo descripcion está vacio
					if (is_dispositivo($codigo,$array_inventario)) {
						// el dispositivo ya existe en el inventario, hay que borrar el dispositivo
						del_dispositivo ($codigo,$array_inventario);
						$info = "Dispositivo eliminado.";
					}
					else
						$error="No ha introducido 'descripcion'.";
				}
			}
			else
				$error="No ha introducido 'codigo'.";
		}
		?>
		<header>
			<h1>Inventario de <?php echo $_SESSION['codigo']; ?></h1>
		</header>
		<div id="contenedor">
			<div id="divdatos"> <!--Panel izquierdo-->
				<h1> Datos del dispositivo</h2>
				<form action="" method="post">
					<!-- Campo oculto para ir almacenando los elementos del inventario-->
					<input name="inventario" type="hidden" value="<?php echo  arraytostring ($array_inventario) ?>"/><br>
					Codigo:<br>
					<input style="width: 100%" type="text" name="codigo" value="<?php echo empty($_POST['codigo'])?"":$_POST['codigo'];?>"><br><br>
					Descripcion:<br>
					<input style="width: 100%" type="text" name="descripcion" value="<?php echo empty($_POST['descripcion'])?"":$_POST['descripcion'];?>"><br><br>
					<button type="submit" name="submit" class="boton_personalizado">Añadir dispositivo</button>
				</form>
				<?php
				if ($error)
					echo "<p style=\"color:red;\">".$error."</p>";
				if ($info)
					echo "<p style=\"color:green;\">".$info."</p>";
				?>
			</div>

			<div id="divlista"> <!--Panel derecho-->
				<h2>Listado de dispositivos</h2>
				<table>
				  <tr>
				    <th>Codigo</th>
				    <th>Descripcion</th>
				  </tr>
				  	<?php
				  		// recorremos el array y mostramos los dispositivos
				  		foreach ($array_inventario as $codigo => $descripcion) {
				  			echo "<tr>";
				  			echo "<td>".ucwords($codigo," ")."</td>";
				  			echo "<td>$descripcion</td>";
				  			echo "</tr>";
				  		}
					?>
				</table>
			</div>
		</div>
	</body>
</html>
