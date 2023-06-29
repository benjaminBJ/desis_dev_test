<?php
//conexion a la bd
if (isset($_POST['regionId'])) {
  $regionId = $_POST['regionId'];

  $dbHost = 'localhost';
  $dbPort = '5432';
  $dbUser = 'postgres';
  $dbPass = 'admin';
  $dbName = 'sistema_votacion';
  $conn = pg_connect("host=$dbHost port=$dbPort dbname=$dbName user=$dbUser password=$dbPass");
  //se genera la query y se consulta  
  $query = "SELECT * FROM comunas WHERE id_region = $regionId";
  $result = pg_query($conn, $query);
  // se genera el codigo para insertar en el html
  while ($row = pg_fetch_assoc($result)) {
    echo "<option value={$row['id_comuna']}>{$row['nombre']}</option>";
  }
}
?>
