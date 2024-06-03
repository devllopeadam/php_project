<?php
session_start();
include("../functions/returnToHome.php");

try {
  include("../includes/db.inc.php");
  include("../functions/displayDate.php");
  include("../functions/getLikesCount.php");
  $stmt = $pdo->prepare("SELECT posts.title, posts.id, posts.image, posts.created_at, users.username, users.profile_image, users.user_title, users.id as user_id FROM posts 
                        INNER JOIN users
                        ON posts.user_id = users.id");
  $stmt->execute();
  $posts = $stmt->fetchAll();
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="shortcut icon" href="../images/logo.svg" type="image/x-icon">
  <link rel="stylesheet" href="../style.css">
  <title>Blogs</title>
</head>

<body class="min-h-screen w-full bg-[#0e1217]">
  <?php include("../components/header.php") ?>
  <main class="py-16">
    <div class="w-full max-w-[1300px] max-xl:px-14 max-lg:px-6 max-md:px-5 mx-auto grid grid-rows-[auto] sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php
      foreach ($posts as $post) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE user_id = :user_id AND post_id = :post_id");
        $stmt->bindParam(":user_id", $_SESSION['user_id']);
        $stmt->bindParam(":post_id", $post['id']);
        $stmt->execute();
        $isLiked = $stmt->fetchColumn() > 0;

        echo '
              <div class="min-h-[384px] group justify-between flex py-5 flex-col gap-5 cursor-pointe border-[0.5px] bg-[#21242b] transition-all duration-300 hover:border-[#cacbceda] border-[#8a8d93da] rounded-2xl post-field">
                <div class="flex flex-col gap-5">
                  <div class="px-4 flex items-center justify-between">
                    <a href=../auth/userPage.php?username=' . $post['username'] . ' class="flex items-center gap-3">
                    <div class="w-[39px] h-[39px] bg-[#a6b0cc] rounded-full overflow-hidden flex items-center justify-center">
                      <img class="w-full h-full object-cover rounded-full" src="../uploads/profiles/' . $post['profile_image'] . '" />
                    </div>
                    <div class="flex flex-col">
                      <p class="text-[#8a8d93da] text-[13px]">' . ucwords($post['username']) . '</p>
                      <p class="text-[#8a8d93da] text-[13px]">' . ucwords($post['user_title']) . '</p>
                    </div>
                    </a>
                  </div>
                  <a href=./blog.php?post_id=' . $post['id'] . ' class="px-4 flex flex-col gap-1">
                    <h4 class="text-white font-medium text-[20px]">' . $post['title'] . '</h4>
                    <p class="text-[#a8b3cfda] text-[14px]">' . displayDate(explode(" ", $post['created_at'])[0]) . '</p>
                  </a>
                </div>
                <div class="px-3">
                  <a href=./blog.php?post_id=' . $post['id'] . ' class="flex h-[170px] w-full items-center justify-center overflow-hidden rounded-xl">
                    <img class="group-hover:scale-105 transition-all duration-300 object-cover h-full w-full rouned-xl" src="../uploads/posts/' . $post['image'] . '" />
                  </a>
                  <a href="./like.php?post_id=' . $post['id'] . '&user_id=' . $_SESSION['user_id'] . '" class="px-3 mt-5 flex items-center justify-center gap-2 bg-[#35393d] w-fit py-2 mx-auto rounded-md">
                    <p class="' . ($isLiked ? 'text-[#ce3df3]' : 'text-[#fc538d]') . '">' . ($isLiked ? 'Dislike' : 'Like') . '</p>
                    <p id="like" class="' . ($isLiked ? 'text-[#ce3df3]' : 'text-[#fc538d]') . ' cursor-pointer select-none">' . getLikesCount($pdo, $post['id']) . '</p>
                  </a>
                </div>
              </div>
      ';
      }
      ?>
    </div>
  </main>
  <script src="../js/like.js"></script>
</body>

</html>