<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $user_name = htmlspecialchars($_POST['username']);
  $pwd = htmlspecialchars($_POST['password']);
  $not_found = false;
  $incorrect = false;

  if (!empty($user_name) && !empty($pwd)) {
    try {
      include("../includes/db.inc.php");
      $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
      $stmt->bindParam(':username', $user_name);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        if (password_verify($pwd, $user['password'])) {
          $_SESSION['username'] = $user_name;
          $_SESSION['image_profile'] = $user['profile_image'];
          $_SESSION['user_id'] = $user['id'];
          header('Location:../index.php');
          exit;
        } else {
          $incorrect = true;
        }
      } else {
        $not_found = true;
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
  <title>Login</title>
</head>

<body class="min-h-screen w-full bg-[#0e1217f2]">
  <?php include("../components/header.php") ?>
  <main style="height: calc(100vh - 75px);" class="flex items-center justify-center flex-col gap-6">
    <h1 class="text-[30px] text-white">Login</h1>
    <form class="flex flex-col gap-5 w-[90%] sm:w-[550px] bg-[#24272f] p-5 rounded-lg" method="post">
      <div class="flex flex-col gap-2 relative">
        <label for="username" class="text-white">Username</label>
        <small class="absolute top-[7px] font-medium right-0 text-red-500 text-[15px]">
          <?php
          if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (empty($user_name)) {
              echo "Cannot be empty";
            } else if ($not_found) {
              echo "User Not Found";
            }
          }
          ?>
        </small>
        <input class="py-[10px] px-4 outline-none rounded-md" type="text" name="username" id="username" placeholder="adam04">
      </div>
      <div class="flex flex-col gap-2 relative">
        <label for="username" class="text-white">Password</label>
        <small class="absolute top-[7px] font-medium right-0 text-red-500 text-[15px]">
          <?php
          if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (empty($pwd)) {
              echo "Cannot be empty";
            } else if ($incorrect) {
              echo "Incorrect password";
            }
          }
          ?>
        </small>
        <input class="py-[10px] px-4 outline-none rounded-md" type="password" name="password" id="password" placeholder="⁕⁕⁕⁕⁕⁕⁕⁕">
      </div>
      <button class="bg-[#0e1217f2] transition-colors duration-300 hover:bg-[#0e1217b5] text-white text-[17px] rounded-md py-3 mx-auto w-fit px-6" type="submit">Login</button>
    </form>
  </main>
</body>

</html>