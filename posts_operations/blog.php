<?php
session_start();

$post_id = $_GET['post_id'];

try {
  include("../includes/db.inc.php");
  include("../functions/addEllipsis.php");
  include("../functions/displayDate.php");
  $stmt = $pdo->prepare("SELECT 
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
WHERE posts.id = :id");
  $stmt->bindParam(':id', $post_id);
  $stmt->execute();
  $post = $stmt->fetch();
} catch (PDOException $e) {
  $e->getMessage();
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
  <link rel="shortcut icon" href="../images/logo.svg" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../style.css">
  <title><?php echo addEllipsis($post['title']); ?></title>
</head>

<body class="min-h-screen w-full bg-[#0e1217f2]">
  <?php include("../components/header.php") ?>
  <div class="pt-16">
    <div class="w-full max-w-[1110px] max-xl:px-14 max-lg:px-6 max-md:px-5 mx-auto flex flex-col gap-10">
      <div class="flex flex-col gap-5 max-w-[900px] mx-auto items-center justify-center">
        <h1 class="text-white font-medium mx-auto text-[35px] md:text-[50px] text-center"><?php echo $post['title']; ?></h1>
      </div>
      <div class="flex flex-col gap-7 items-center justify-center w-full">
        <div class="flex w-full flex-col gap-8 justify-center">
          <img class=" w-full max-w-[950px] mx-auto rounded-lg object-cover" src=<?php echo "../uploads/posts/" . $post['image']; ?> />
        </div>
        <div class="flex items-center md:gap-16 w-full md:w-1/2 justify-between">
          <div class="px-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-[45px] md:w-[50px] h-[45px] md:h-[50px] bg-[#a6b0cc] rounded-full overflow-hidden flex items-center justify-center">
                <img class="w-full h-full object-cover rounded-full" src=<?php echo "../uploads/profiles/" . $post['profile_image']; ?> />
              </div>
              <div class="flex flex-col">
                <p class="text-[#a8b3cfda] font-medium text-[15px]"><?php echo ucwords($post['username']); ?></p>
                <p class="text-[#a8b3cfda] font-medium text-[15px]"><?php echo ucwords($post['user_title']); ?></p>
              </div>
            </div>
          </div>
          <p class="text-[#a8b3cfda] text-[16px]"><?php echo "Created • " . displayDate(explode(" ", $post['created_at'])[0])  ?></p>
        </div>
      </div>
      <div class="bg-[#24272f] w-full rounded-lg py-5 px-5 md:py-10 mb-10 h-fit">
        <div class="flex items-center gap-10 relative max-w-[900px] w-full mx-auto">
          <div style="height: calc(100% + 15px);" class="w-[3px] max-md:hidden -left-8 rounded-sm absolute bg-[#7c4dff]"></div>
          <p class="text-[#cfd6e6]"><?php echo $post['content']; ?></p>
        </div>
      </div>

    </div>
  </div>
</body>

</html>