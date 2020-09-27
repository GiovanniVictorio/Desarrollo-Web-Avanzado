<?php 

$mysqli = new mysqli("localhost", "root", "", "usuarios_examen");

 
if ($mysqli->connect_errno) {
    printf("Falló la conexión: %s\n", $mysqli->connect_error);
    exit();
}else{
	
	$consulta = "SELECT * FROM usuario";
	$ejecutarConsulta = mysqli_query($mysqli, $consulta);
	$verFilas = mysqli_num_rows($ejecutarConsulta);
	$fila = mysqli_fetch_array($ejecutarConsulta);

	if ( !$ejecutarConsulta ){
		echo 1;
	} else if ( $verFilas < 1 ){
		echo "<tr><td>Sin registros</td></tr>";
	} else {
		for ( $i = 0; $i <= $fila; $i++ ){
			echo '
				<tr>
					<td>'.$fila[1].'</td>
					<td>'.$fila[2].'</td>
					<td>'.$fila[3].'</td>
				</tr>
			';
			$fila = mysqli_fetch_array($ejecutarConsulta);
		}
	}
}

$mysqli->close();

?>