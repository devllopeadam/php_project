<?php
session_start();
include("../functions/returnToHome.php");

$id = $_GET['idpost'];

try {
  include("../includes/db.inc.php");
  include("../functions/displayDate.php");
  $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
  $stmt->bindParam(":id", $id);
  if ($stmt->execute()) {
    header("Location: ../dashboard/");
  }
} catch (PDOException $e) {
  echo $e->getMessage();
}
