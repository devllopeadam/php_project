<?php
session_start();
include("../functions/returnToHome.php");

try {
  include("../includes/db.inc.php");
  include("../functions/displayDate.php");
  include("../functions/getLikesCount.php");
  include("../functions/getWhoLike.php");
  include("../functions/getUserFromId.php");
  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
  $stmt->bindParam(":username", $_SESSION["username"]);
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
  $stmt->execute();
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="../images/logo.svg" type="image/x-icon">
  <link rel="stylesheet" href="../style.css">
  <title>Dashboard</title>
</head>

<body class="min-h-screen w-full bg-[#1a1e22]">
  <?php include("../components/sideBar.php"); ?>
  <main class="p-5 sm:ml-64 flex flex-col gap-5">
    <div class="bg-[#24272f] shadow-lg p-5 rounded-md flex flex-col gap-5">
      <h1 class="text-[30px] text-white font-medium">User Information</h1>
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 grid-rows-[auto]">
        <div class="p-4 rounded-md shadow-lg bg-[#1a1e22] flex flex-col gap-4 items-center justify-center">
          <h4 class="text-[#8a8d93da] text-xl font-medium text-center">Username</h4>
          <h3 class="text-xl font-medium text-center text-white"><?php echo ucwords($user['username']) ?></h3>
        </div>
        <div class="p-4 rounded-md shadow-lg bg-[#1a1e22] flex flex-col gap-4 items-center justify-center">
          <h4 class="text-[#8a8d93da] text-xl font-medium text-center">User Title</h4>
          <h3 class="text-xl font-medium text-center text-white"><?php echo ucwords($user['user_title']) ?></h3>
        </div>
        <div class="p-4 rounded-md shadow-lg bg-[#1a1e22] flex flex-col gap-4 items-center justify-center">
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
            echo '
              <div class="min-h-[300px] group justify-between flex py-5 flex-col gap-5 cursor-pointer border-[0.5px] bg-[#21242b] transition-all duration-300 hover:border-[#cacbceda] border-[#8a8d93da] rounded-2xl post-field">
                <a href=../posts_operations/blog.php?post_id=' . $post['id'] . ' class="flex flex-col gap-5">
                  <div class="px-4 flex flex-col gap-1">
                    <h4 class="text-white font-medium text-[20px]">' . $post['title'] . '</h4>
                    <p class="text-[#a8b3cfda] text-[14px]">' . displayDate(explode(" ", $post['created_at'])[0]) . '</p>
                  </div>
                </a>
                <div class="px-3">
                  <div class="flex h-[170px] w-full items-center justify-center overflow-hidden rounded-xl">
                    <img class="group-hover:scale-105 transition-all duration-300 object-cover h-full w-full rouned-xl" src="../uploads/posts/' . $post['image'] . '" />
                  </div>
                </div>
                <div class="px-4 grid grid-cols-2 items-center gap-4">
                  <a href="../posts_operations/delete.php?idpost=' . $post['id'] . '" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:bg-gray-600 dark:hover:bg-gray-700 group1">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group1-hover:text-gray-900 dark:group1-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                      fill="currentColor"
                      viewBox="0 0 20 20">
                      <path
                      d="M6 2a1 1 0 0 0-1 1v1H2.5a.5.5 0 0 0 0 1H3v11a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V5h.5a.5.5 0 0 0 0-1H15V3a1 1 0 0 0-1-1H6ZM5 5h10v11a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5Zm3 3a.5.5 0 0 1 1 0v6a.5.5 0 0 1-1 0V8Zm4 0a.5.5 0 0 1 1 0v6a.5.5 0 0 1-1 0V8Z" />
                  </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Delete Post</span>
                  </a>
                  <a href="../posts_operations/update.php?idpost=' . $post['id'] . '" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:bg-gray-600 dark:hover:bg-gray-700 group1">
                    <svg
                      class="flex-shrink-0 w-5 h-5 text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                      aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg"
                      fill="currentColor"
                      viewBox="0 0 20 20">
                      <path
                      d="M17.414 2.586a2 2 0 0 1 0 2.828l-1.707 1.707-2.828-2.828 1.707-1.707a2 2 0 0 1 2.828 0ZM2 14.293l8.586-8.586 2.828 2.828-8.586 8.586H2v-2.828Zm9.414-6.172-1.414-1.414-7.707 7.707V17h2.828l7.707-7.707-1.414-1.414Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Update Post</span>
                  </a>
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
    <div class="bg-[#24272f] shadow-lg p-5 rounded-md flex flex-col gap-5">
      <h1 class="text-[30px] text-white font-medium">Posts Info</h1>
      <div class="">
        <?php
        if (!$posts) {
          echo '
        <h1 class="text-white font-medium text-xl text-center">No Posts Yet</h1>
        ';
        }
        ?>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded-lg overflow-hidden">
          <thead class="text-[14px] font-normal text-gray-700 uppercase bg-gray-500 dark:bg-[#30333b] dark:text-white">
            <tr>
              <th scope="col" class="px-6 py-4">
                Post Image
              </th>
              <th scope="col" class="px-6 py-4">
                Post Title
              </th>
              <th scope="col" class="px-6 py-4">
                Post Likes
              </th>
              <th scope="col" class="px-6 py-4">
                Who Likes the post
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($posts as $post) {
              echo "<tr class='bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600'>";
              echo '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white w-[200px]">
                      <img src="../uploads/posts/' . $post['image'] . '" alt="" class="w-[80px] h-[80px] object-cover rounded-lg">
                    </th>';
              echo '<td class="px-6 py-4 text-[16px] max-w-[200px]">
                        ' . $post['title'] . '
                    </td>';
              echo '<td class="px-6 py-4 text-[16px] w-[150px]">
                        ' . getLikesCount($pdo, $post['id']) . '
                    </td>';
              echo '<td class="px-6 py-4 text-[16px] grid grid-cols-2 gap-3 list-none h-full grid-rows-[auto]">';
              foreach (getWhoLike($pdo, $post['id']) as $user) {
                echo '
                      <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                          <div class="w-[35px] h-[35px] bg-[#a6b0cc] rounded-full overflow-hidden flex items-center justify-center">
                            <img class="w-full h-full object-cover rounded-full" src="../uploads/profiles/' . getUserFromId($user['user_id'])['profile_image'] . '"/>
                          </div>
                          <div class="flex flex-col">
                            <p class="text-[#8a8d93da] text-[13px]">' . getUserFromId($user['user_id'])['username'] . '</p>
                            <p class="text-[#8a8d93da] text-[13px]">' . getUserFromId($user['user_id'])['user_title'] . '</p>
                          </div>
                        </div>
                      </div>
                    ';
              }
              echo '</td>';
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</body>

</html>