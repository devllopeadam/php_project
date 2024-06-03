<?php
include("../includes/db.inc.php");
function getWhoLike($pdo, $post_id)
{
  $stmt = $pdo->prepare("SELECT user_id FROM likes WHERE post_id = :post_id");
  $stmt->bindParam(":post_id", $post_id);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
