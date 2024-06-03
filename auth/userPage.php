<?php
session_start();
include("../functions/returnToHome.php");
$username = $_GET['username'];
try {
  include("../includes/db.inc.php");
  include("../functions/displayDate.php");
  include("../functions/getLikesCount.php");

  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
  $stmt->bindParam(":username", $_GET['username']);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    $select_posts = $pdo->prepare("SELECT 
            posts.title, 
            posts.content,
            posts.id, 
            posts.image,
            posts.created_at, 
            users.username, 
            users.profile_image, 
            users.user_title 
            FROM posts 
            INNER JOIN users ON posts.user_id = users.id 
            WHERE posts.user_id = :id");
    $select_posts->bindParam(':id', $user['id'], PDO::PARAM_INT);
    $select_posts->execute();

    $posts = $select_posts->fetchAll(PDO::FETCH_ASSOC);
  }
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="../images/logo.svg" type="image/x-icon">
  <link rel="stylesheet" href="../style.css">
  <title><?php echo $username . " • Profile"; ?></title>
</head>

<body class="min-h-screen w-full bg-[#0e1217f2]">
  <?php include("../components/header.php") ?>

  <div class="pt-10 w-full max-w-[1100px] max-xl:px-14 max-lg:px-6 max-md:px-5 mx-auto">
    <div class="flex flex-col gap-6">
      <div class="flex flex-col gap-5 w-full">
        <h1 class="text-[30px] text-white font-medium">User Information</h1>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 grid-rows-[auto] w-full">
          <div class="p-4 rounded-md shadow-lg bg-[#2a3136] flex flex-col gap-4 items-center justify-center">
            <h4 class="text-[#8a8d93da] text-xl font-medium text-center">Username</h4>
            <h3 class="text-xl font-medium text-center text-white"><?php echo ucwords($user['username']) ?></h3>
          </div>
          <div class="p-4 rounded-md shadow-lg bg-[#2a3136] flex flex-col gap-4 items-center justify-center">
            <h4 class="text-[#8a8d93da] text-xl font-medium text-center">User Title</h4>
            <h3 class="text-xl font-medium text-center text-white"><?php echo ucwords($user['user_title']) ?></h3>
          </div>
          <div class="p-4 rounded-md shadow-lg bg-[#2a3136] flex flex-col gap-4 items-center justify-center">
            <h4 class="text-[#8a8d93da] text-xl font-medium text-center">Profile Image</h4>
            <div class="flex items-center justify-center w-[60px] h-[60px]">
              <img class="w-full h-full object-cover rounded-md" src=<?php echo "../uploads/profiles/" . $user['profile_image'];  ?> />
            </div>
          </div>
        </div>
      </div>
      <div class="bg-[#24272f] shadow-lg p-5 rounded-md flex flex-col gap-5">
        <h1 class="text-[30px] text-white font-medium">User Posts</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 grid-rows-[auto]">
          <?php
          if ($posts) {
            foreach ($posts as $post) {
              $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE user_id = :user_id AND post_id = :post_id");
              $stmt->bindParam(":user_id", $_GET['username']);
              $stmt->bindParam(":post_id", $post['id']);
              $stmt->execute();
              $isLiked = $stmt->fetchColumn() > 0;
              echo '
              <div class="min-h-[300px] group justify-between flex py-5 flex-col gap-5 cursor-pointer border-[0.5px] bg-[#21242b] transition-all duration-300 hover:border-[#cacbceda] border-[#8a8d93da] rounded-2xl post-field">
                <a href=../posts_operations/blog.php?post_id=' . $post['id'] . ' class="flex flex-col gap-5">
                  <div class="px-4 flex flex-col gap-1">
                    <h4 class="text-white font-medium text-[20px]">' . $post['title'] . '</h4>
                    <p class="text-[#a8b3cfda] text-[14px]">' . displayDate(explode(" ", $post['created_at'])[0]) . '</p>
                  </div>
                </a>
                <div class="px-3">
                  <div class="px-3">
                  <a href=../posts_operations/blog.php?post_id=' . $post['id'] . ' class="flex h-[170px] w-full items-center justify-center overflow-hidden rounded-xl">
                    <img class="group-hover:scale-105 transition-all duration-300 object-cover h-full w-full rouned-xl" src="../uploads/posts/' . $post['image'] . '" />
                  </a>
                </div>
                </div>
              </div>
      ';
            }
          } else {
            echo '
          <div class=""></div>
          <h1 class="text-white font-medium text-xl text-center">No Posts Yet</h1>
          <div class=""></div>    
          ';
          }
          ?>
        </div>
      </div>
    </div>
  </div>

</body>

</html>