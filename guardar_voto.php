<?php
$dbHost = 'localhost';
$dbPort = '5432';
$dbUser = 'postgres';
$dbPass = 'admin';
$dbName = 'sistema_votacion';

$conn = pg_connect("host=$dbHost port=$dbPort dbname=$dbName user=$dbUser password=$dbPass");

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
// Otros campos del formulario

// Validar que los campos no estén vacíos
if (empty($nombre) || empty($rut) || empty($email)) {
  echo "Error: Todos los campos son obligatorios.";
  exit;
}

// Validar el formato del RUT
if (!validarRUT($rut)) {
  echo "Error: El RUT no tiene un formato válido.";
  exit;
}

// Validar el formato del correo electrónico
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "Error: El correo electrónico no tiene un formato válido.";
  exit;
}

// Validar la duplicación de votos por RUT
$query = "SELECT rut FROM votos WHERE rut = $1";
$result = pg_query_params($conn, $query, [$rut]);

if (pg_num_rows($result) > 0) {
  echo "Error: Ya se ha registrado un voto con este RUT.";
  exit;
}

// Insertar el voto en la base de datos
$query = "INSERT INTO votos (rut, nombre, candidato_id) VALUES ($1, $2, $3)";
$result = pg_query_params($conn, $query, [$rut, $nombre, $candidato]);

if ($result) {
  echo "Voto registrado correctamente.";
} else {
  echo "Error al registrar el voto.";
}

pg_close($conn);

// Función para validar el RUT (formato Chile)
function validarRUT($rut) {
  $rut = preg_replace('/[^k0-9]/i', '', $rut);
  $dv  = substr($rut, -1);
  $numero = substr($rut, 0, strlen($rut)-1);
  $i = 2;
  $suma = 0;
  foreach(array_reverse(str_split($numero)) as $v) {
    if($i==8) $i = 2;
    $suma += $v * $i;
    ++$i;
  }
  $dvr = 11 - ($suma % 11);
  if($dvr == 11) $dvr = 0;
  if($dvr == 10) $dvr = 'K';
  if($dvr == strtoupper($dv)) {
    return true;
  } else {
    return false;
  }
}
?>
