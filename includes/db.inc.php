<?php
$host = "localhost";
$username = "root";
$password = "";
$db_name = "php_project";

$dsn = "mysql:host=$host;dbname=$db_name;";

try {
  $pdo = new PDO($dsn, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo $e->getMessage();
}
