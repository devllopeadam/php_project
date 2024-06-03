<?php

function getLikesCount($pdo, $postId)
{
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE post_id = :post_id");
  $stmt->bindParam(":post_id", $postId);
  $stmt->execute();
  return $stmt->fetchColumn();
}
