<?php
session_start();
include("../functions/returnToHome.php");


try {
  include("../includes/db.inc.php");
  $post_id = $_GET['post_id'];
  $user_id = $_GET['user_id'];

  $stmt = $pdo->prepare("SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id");
  $stmt->bindParam(":user_id", $user_id);
  $stmt->bindParam(":post_id", $post_id);
  $stmt->execute();
  $like = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($like) {
    $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id");
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":post_id", $post_id);
    $stmt->execute();
    header("Location: ./blogs.php");
  } else {
    $stmt = $pdo->prepare("INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)");
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":post_id", $post_id);
    $stmt->execute();
    header("Location: ./blogs.php");
  }
} catch (PDOException $e) {
  echo $e->getMessage();
}
