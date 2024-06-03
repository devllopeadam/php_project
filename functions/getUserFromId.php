<?php

function getUserFromId($user_id)
{
  include("../includes/db.inc.php");
  $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
  $stmt->bindParam(":user_id", $user_id);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}
