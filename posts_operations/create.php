<?php
session_start();
include("../functions/returnToHome.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $post_title = htmlspecialchars($_POST['title']);
  $post_content = htmlspecialchars($_POST['content']);
  $post_image = htmlspecialchars($_FILES['image']['name']);
  $file_name = htmlspecialchars($_FILES['image']['name']);
  $post_image_temp = htmlspecialchars($_FILES['image']['tmp_name']);
  $folder = '../uploads/posts/' . $file_name;

  if (!empty($post_title) && !empty($post_content) && $file_name !== "") {
    try {
      include("../includes/db.inc.php");
      $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content, image) VALUES (:user_id, :title, :content, :image);");
      $stmt->bindParam(":user_id", $_SESSION['user_id']);
      $stmt->bindParam(":title", $post_title);
      $stmt->bindParam(":content", $post_content);
      $stmt->bindParam(":image", $file_name);
      $stmt->execute();
      move_uploaded_file($post_image_temp, $folder);
      header("Location: ./blogs.php");
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
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
  <title>Create Post</title>
</head>

<body class="min-h-screen w-full bg-[#0e1217f2]">
  <?php include("../components/header.php") ?>
  <main class="flex flex-col gap-10 pt-8 items-center w-full max-w-[1150px] max-xl:px-14 max-lg:px-6 max-md:px-5 mx-auto">
    <h1 class="text-[40px] text-white">Create a post</h1>
    <form enctype="multipart/form-data" class="gap-14 grid grid-cols-1 lg:grid-cols-[1.5fr_1fr] max-w-[1100px] mx-auto w-full" method="post">
      <div class="flex flex-col gap-8">
        <div class="flex flex-col gap-3 bg-[#24272f] p-5 rounded-xl shadow-lg relative">
          <small class="absolute top-5 font-medium right-5 text-red-500 text-[15px]">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              if (empty($post_title)) {
                echo "Cannot be empty";
              }
            }
            ?>
          </small>
          <label for="title" class="text-white">Enter the post title</label>
          <input class="py-[18px] post-field text-[17px] placeholder:text-[16px] max-h-[60px] px-4 outline-none rounded-md" type="text" name="title" id="title" placeholder="Best vscode extesions">
        </div>
        <div class="flex flex-col gap-3 bg-[#24272f] p-5 rounded-xl shadow-lg relative">
          <small class="absolute top-5 font-medium right-5 text-red-500 text-[15px]">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              if (empty($post_content)) {
                echo "Cannot be empty";
              }
            }
            ?>
          </small>
          <label for="content" class="text-white">Enter the post content</label>
          <textarea name="content" id="content" class="py-[18px] post-field text-[17px] max-h-[200px] placeholder:text-[16px] px-4 outline-none rounded-md" placeholder="one two three foor"></textarea>
        </div>
      </div>
      <div class="flex flex-col gap-8">
        <div class="max-lg:w-full lg:w-full pt-10 relative border-2 bg-[#24272f] border-gray-500 border-dashed rounded-lg p-6" id="dropzone">
          <small class="absolute top-[10px] font-medium left-1/2 -translate-x-1/2 text-red-500 text-[15px]">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              if ($file_name === "") {
                echo "Chose an image file";
              }
            }
            ?>
          </small>
          <!-- <form method="post" enctype="multipart/form-data"> -->
          <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 z-50 cursor-pointer" accept="image/*" />
          <div class="text-center">
            <img class="mx-auto h-12 w-12" src="../images/image-upload.svg">
            <h3 class="mt-3 text-sm font-medium text-gray-900">
              <label class="relative cursor-pointer">
                <span class="text-[#a8b3cfda]">Drag and drop</span>
                <span class="text-[#a8b3cfda]">or browse</span>
                <span class="text-[#a8b3cfda]">to upload</span>
                <span class="text-[#a8b3cfda]">your image post</span>
                <input type="file" class="sr-only" accept="image/*"> <!-- This input is now redundant -->
              </label>
            </h3>
            <p class="mt-3 text-xs text-gray-500">
              PNG, JPG, SVG, JPEG, GIF
            </p>
          </div>

          <img src="" class="mt-4 mx-auto max-h-40 hidden" id="preview">
          <!-- </form> -->
        </div>
        <button class="text-white text-[18px] rounded-md bg-[#7c4dff] hover:bg-[#7c4dffd7] hover:shadow-lg py-3 duration-300 transition-all" type="submit">Create Post</button>
      </div>
    </form>
  </main>
  <script src="../js/createPost.js"></script>
</body>

</html>