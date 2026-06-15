<?php
$host = 'mysql';
$user = trim(file_get_contents('/run/secrets/user'));
$pass = trim(file_get_contents('/run/secrets/userpass'));
$db = trim(file_get_contents('/run/secrets/db'));

echo "<p>101587</p>";

try{
  $mysqli = new mysqli($host,$user,$pass,$db);
  echo $mysqli->server_info . "\nNazwa bazy: " . $db
  $mysqli->close();
}catch(Exception $e){
  echo $e->getMessage();
}
