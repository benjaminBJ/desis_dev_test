<?php
$host = 'localhost';
$port = '5432';
$usuario = 'postgres';
$contrasena = 'admin';
$nombreBD = 'sistema_votacion';

// Conexión a la base de datos
$conex = pg_connect("host=$host port=$port dbname=$nombreBD user=$usuario password=$contrasena")
  or die('Error de conexión a la base de datos');

// Obtener las regiones desde la base de datos
function obtenerRegiones() {
  global $conex;
  $query = "SELECT nombre FROM regiones";
  $result = pg_query($conex, $query);

  $regiones = array();
  while ($row = pg_fetch_assoc($result)) {
    $regiones[] = $row['nombre'];
  }

  return $regiones;
}

// Obtener las comunas de una región desde la base de datos
function obtenerComunas($region) {
  global $conex;
  $query = "SELECT nombre FROM comunas WHERE region = '$region'";
  $result = pg_query($conex, $query);

  $comunas = array();
  while ($row = pg_fetch_assoc($result)) {
    $comunas[] = $row['nombre'];
  }

  return $comunas;
}

// Obtener los candidatos desde la base de datos
function obtenerCandidatos() {
  global $conex;
  $query = "SELECT nombre FROM candidatos";
  $result = pg_query($conex, $query);

  $candidatos = array();
  while ($row = pg_fetch_assoc($result)) {
    $candidatos[] = $row['nombre'];
  }

  return $candidatos;
}

// Obtener el RUT sin dígito verificador
function obtenerRutSinDV($rut) {
  return substr($rut, 0, -1);
}

// Validar RUT
function validarRut($rut) {
  $rut = strtoupper($rut);

  if (!preg_match('/^[0-9K]{1,9}-[0-9K]{1}$/', $rut)) {
    return false;
  }

  $rut = str_replace('-', '', $rut);
  $rutSinDV = obtenerRutSinDV($rut);
  $dv = substr($rut, -1);

  $s = 1;
  for ($m = 0, $i = strlen($rutSinDV) - 1; $i >= 0; $i--) {
    $s = ($s + $rutSinDV[$i] * $s) % 11;
  }

  $dvCalculado = ($s > 1) ? 11 - $s : 'K';

  return $dv == $dvCalculado;
}

// Procesar el voto
function procesarVoto() {
  global $conex;

  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $alias = $_POST['alias'];
  $rut = $_POST['rut'];
  $email = $_POST['email'];
  $region = $_POST['region'];
  $comuna = $_POST['comuna'];
  $candidato = $_POST['candidato'];
  $comoSeEntero = $_POST['comoSeEntero'];

  // Validar campos obligatorios
  if (empty($nombre) || empty($apellido) || empty($alias) || empty($rut) || empty($email) || empty($region) || empty($comuna) || empty($candidato) || empty($comoSeEntero)) {
    return 'Todos los campos son obligatorios';
  }

  // Validar alias
  if (strlen($alias) < 5 || !preg_match('/^[a-zA-Z0-9]+$/', $alias)) {
    return 'El alias debe tener al menos 5 caracteres y contener solo letras y números';
  }

  // Validar RUT
  if (!validarRut($rut)) {
    return 'El RUT ingresado no es válido';
  }

  // Validar correo electrónico
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return 'El correo electrónico ingresado no es válido';
  }

  // Realizar el insert en la base de datos
  $query = "INSERT INTO votantes (nombre, apellido, alias, rut, email, region, comuna, candidato, como_se_entero) VALUES ('$nombre', '$apellido', '$alias', '$rut', '$email', '$region', '$comuna', '$candidato', '$comoSeEntero')";
  $result = pg_query($conex, $query);

  if ($result) {
    return 'Voto registrado correctamente';
  } else {
    return 'Error al registrar el voto';
  }
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $mensaje = procesarVoto();
  echo $mensaje;
} else {
  echo 'No se recibieron datos del formulario';
}

// Cerrar la conexión a la base de datos
pg_close($conex);
?>
