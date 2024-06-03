<!-- <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Daily Blog</title>
</head>

<body>
  <header class="bg-[#24272f] py-5 h-[80px] shadow-md">
    <div class="flex items-center justify-between w-full max-w-[1150px] max-xl:px-14 max-lg:px-6 max-md:px-5 mx-auto">
      <a href="../../php_project/" class="flex items-center">
        <img class="w-[35px]" src="../../php_project/images/logo.svg">
        <p class="flex items-center justify-center text-[25px] text-white">DailyBlogs</p>
      </a>
      <div class="flex items-center gap-5">
        <a href="../../php_project/posts_operations/blogs.php" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[17px]">Blogs</a>
        <?php if (!isset($_SESSION['username'])) : ?>
          <a href="../../php_project/auth/login.php" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[17px]">Login</a>
          <a href="../../php_project/auth/singup.php" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[17px]">Singup</a>
        <?php endif ?>
        <?php if (isset($_SESSION['username'])) : ?>
          <a href="../../php_project/dashboard/" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[17px]">Dashboard</a>
          <a href="../../php_project/posts_operations/create.php" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[17px]">Creat Post</a>
          <a href="../../php_project/auth/logout.php" class="bg-white hover:bg-slate-100 transition-all duration-300 text-slate-950 font-medium py-[8px] px-[13px] rounded-md text-[17px] flex items-center gap-3">
            Logout
          </a>
          <?php
          if (isset($_SESSION["username"])) {
            if ($_SESSION["image_profile"] !== "./user.svg") {
              echo '<img class="w-[42px] h-[42px] object-cover rounded-lg" src="../../php_project/uploads/profiles/' . $_SESSION['image_profile'] . '" />';
            } else {
              echo '
                <div class="w-[43px] h-[43px] flex items-center justify-center bg-[#a6b0cc] rounded-full">
                  <img class="w-[39px] h-[39px] object-cover rounded-lg" src="../../php_project/uploads/profiles/' . $_SESSION['image_profile'] . '" />
                </div>
              ';
            }
          }
          ?>
        <?php endif ?>
      </div>
    </div>
  </header>
</body>

</html> -->


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Daily Blog</title>
</head>

<body>
  <header class="bg-[#24272f] py-4 shadow-md">
    <div class="flex items-center justify-between w-full max-w-[1150px] px-4 mx-auto">
      <a href="../../php_project/" class="flex items-center">
        <img class="w-[35px]" src="../../php_project/images/logo.svg">
        <p class="flex items-center justify-center text-[25px] text-white">DailyBlogs</p>
      </a>
      <div class="md:hidden flex items-center gap-4">
        <button id="menu-button" class="text-white focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
          </svg>
        </button>
        <?php if ($_SESSION["image_profile"] !== "./user.svg") : ?>
          <img class="w-[42px] h-[42px] object-cover rounded-lg" src="../../php_project/uploads/profiles/<?php echo $_SESSION['image_profile']; ?>" />
        <?php else : ?>
          <div class="w-[43px] h-[43px] flex items-center justify-center bg-[#a6b0cc] rounded-full">
            <img class="w-[39px] h-[39px] object-cover rounded-lg" src="../../php_project/uploads/profiles/<?php echo $_SESSION['image_profile']; ?>" />
          </div>
        <?php endif; ?>
      </div>
      <div id="menu" class="hidden md:flex md:items-center gap-5">
        <a href="../../php_project/posts_operations/blogs.php" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[17px]">Blogs</a>
        <?php if (!isset($_SESSION['username'])) : ?>
          <a href="../../php_project/auth/login.php" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[17px]">Login</a>
          <a href="../../php_project/auth/singup.php" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[17px]">Signup</a>
        <?php endif ?>
        <?php if (isset($_SESSION['username'])) : ?>
          <a href="../../php_project/dashboard/" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[17px]">Dashboard</a>
          <a href="../../php_project/posts_operations/create.php" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[17px]">Create Post</a>
          <a href="../../php_project/auth/logout.php" class="bg-white hover:bg-slate-100 transition-all duration-300 text-slate-950 font-medium py-[8px] px-[13px] rounded-md text-[17px] flex items-center gap-3">
            Logout
          </a>
          <?php if (isset($_SESSION["username"])) : ?>
            <?php if ($_SESSION["image_profile"] !== "./user.svg") : ?>
              <a href="../../php_project/auth/userPage.php?username=<?php echo $_SESSION['username'] ?>">
                <img class="w-[42px] h-[42px] object-cover rounded-lg" src="../../php_project/uploads/profiles/<?php echo $_SESSION['image_profile']; ?>" />
              </a>
            <?php else : ?>
              <a href="../../php_project/auth/userPage.php?username=<?php echo $_SESSION['username'] ?>" class="w-[43px] h-[43px] flex items-center justify-center bg-[#a6b0cc] rounded-full">
                <img class="w-[39px] h-[39px] object-cover rounded-lg" src="../../php_project/uploads/profiles/<?php echo $_SESSION['image_profile']; ?>" />
              </a>
            <?php endif; ?>
          <?php endif; ?>
        <?php endif ?>
      </div>
    </div>
    <div id="mobile-menu" class="md:hidden flex flex-col items-center justify-center gap-6 p-4 pt-6 bg-[#24272f]">
      <a href="../../php_project/posts_operations/blogs.php" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[19px]">Blogs</a>
      <?php if (!isset($_SESSION['username'])) : ?>
        <a href="../../php_project/auth/login.php" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[19px]">Login</a>
        <a href="../../php_project/auth/singup.php" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[19px]">Signup</a>
      <?php endif ?>
      <?php if (isset($_SESSION['username'])) : ?>
        <a href="../../php_project/dashboard/" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[19px]">Dashboard</a>
        <a href="../../php_project/posts_operations/create.php" class="text-[#a8b3cfda] transition-colors duration-300 hover:text-white text-[19px]">Create Post</a>
        <a href="../../php_project/auth/logout.php" class="bg-white hover:bg-slate-100 transition-all duration-300 text-slate-950 font-medium py-[8px] px-[13px] rounded-md text-[17px] flex items-center gap-3">
          Logout
        </a>
      <?php endif ?>
    </div>
  </header>

  <script>
    document.getElementById('menu-button').addEventListener('click', function() {
      var mobileMenu = document.getElementById('mobile-menu');
      if (mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.remove('hidden');
      } else {
        mobileMenu.classList.add('hidden');
      }
    });
  </script>
</body>

</html>