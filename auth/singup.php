<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $tempname = htmlspecialchars($_FILES['image']['tmp_name']);
  $file_name = htmlspecialchars($_FILES['image']['name']);
  $user_name = htmlspecialchars($_POST['username']);
  $email = htmlspecialchars($_POST['email']);
  $pwd = htmlspecialchars($_POST['password']);
  $title = htmlspecialchars($_POST['title']);
  $profile_image = './user.svg';
  $folder = '../uploads/profiles/' . $file_name;
  $already_exists = false;

  if (
    !empty($user_name) && !empty($pwd) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($title)
  ) {
    try {
      include("../includes/db.inc.php");
      if ($file_name === "") {
        $file_name = $profile_image;
      }
      $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
      $stmt->bindParam(':username', $user_name);
      $stmt->bindParam(':email', $email);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        $already_exists = true;
      } else {
        // Insert user data into the database
        $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, profile_image, user_title) VALUES (:username, :email, :password, :profile_image, :user_title);");
        $stmt->bindParam(':username', $user_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_pwd);
        $stmt->bindParam(':profile_image', $file_name);
        $stmt->bindParam(':user_title', $title);
        $stmt->execute();
        move_uploaded_file($tempname, $folder);
        header("Location: ./login.php");
        exit();
      }
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
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="../images/logo.svg" type="image/x-icon">
  <link rel="stylesheet" href="../style.css">
  <title>Singup</title>
</head>

<body class="min-h-screen w-full bg-[#0e1217f2]">
  <?php include("../components/header.php") ?>
  <main class="singup !max-md:min-h-screen flex items-center max-md:pb-10 max-md:pt-20 justify-center flex-col gap-8">
    <form enctype="multipart/form-data" class="flex flex-col gap-5 w-[90%] sm:w-[550px] bg-[#24272f] p-5 rounded-lg py-10 relative" method="post">
      <div class="flex items-center justify-center w-full">`
        <label for="dropzone-file" class="cursor-pointer w-[110px] h-[110px] absolute -top-[50px]">
          <input id="dropzone-file" name="image" type="file" class="hidden" accept="image/*" />
          <div class="w-[110px] rounded-full bg-[#a6b0cc] h-[110px] flex items-center justify-center post-field">
            <img id="imagePreview" class="profile-image w-[110px] h-[110px] rounded-full object-cover select-none" src="../uploads/profiles/user.svg" />
          </div>
        </label>
      </div>
      <div class="flex flex-col gap-2 relative">
        <label for="username" class="text-white">Username</label>
        <small class="absolute top-[7px] font-medium right-0 text-red-500 text-[15px]">
          <?php
          if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (empty($user_name)) {
              echo "Cannot be empty";
            } else if ($already_exists) {
              echo "Username or email already exists";
            }
          }
          ?>
        </small>
        <input class="py-[10px] px-4 outline-none rounded-md" type="text" name="username" id="username" placeholder="adam04">
      </div>

      <div class="flex flex-col gap-2 relative">
        <label for="title" class="text-white">Title</label>
        <small class="absolute top-[7px] font-medium right-0 text-red-500 text-[15px]">
          <?php
          if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (empty($title)) {
              echo "Cannot be empty";
            }
          }
          ?>
        </small>
        <input class="py-[10px] px-4 outline-none rounded-md" type="text" name="title" id="title" placeholder="Software Developer">
      </div>

      <div class="flex flex-col gap-2 relative">
        <label for="email" class="text-white">Email</label>
        <small class="absolute top-[7px] font-medium right-0 text-red-500 text-[15px]">
          <?php
          if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (empty($email)) {
              echo "Cannot be empty";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              echo "Invalid email address";
            }
          }
          ?>
        </small>
        <input class="py-[10px] px-4 outline-none rounded-md" type="text" name="email" id="email" placeholder="adam04@gmail.com">
      </div>
      <div class="flex flex-col gap-2 relative">
        <label for="password" class="text-white">Password</label>
        <small class="absolute top-[7px] font-medium right-0 text-red-500 text-[15px]">
          <?php
          if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (empty($pwd)) {
              echo "Cannot be empty";
            }
          }
          ?>
        </small>
        <input class="py-[10px] px-4 outline-none rounded-md" type="password" name="password" id="password" placeholder="⁕⁕⁕⁕⁕⁕⁕⁕">
      </div>
      <button class="bg-[#0e1217f2] transition-colors duration-300 hover:bg-[#0e1217b5] text-white text-[17px] rounded-md py-3 mx-auto w-fit px-6" type="submit">Singup</button>
    </form>
  </main>
  <script src="../js/main.js"></script>
</body>

</html>