<?php require __DIR__ . '/../../helpers/connector.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MineSmart - Login Page</title>

  <!-- CSS -->
  <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

  <!-- FAV and Icons -->
  <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100 max-w-full overflow-x-hidden">
  <div class="relative w-full h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('<?php echo ROOT_URL; ?>/assets/images/login.webp');">

    <?php require __DIR__ . '/../includes/message2.php'; ?>

    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative w-96 p-8 rounded-lg shadow-lg glass-bg-color2 mx-4">
      <h2 class="text-3xl font-semibold text-white text-center mb-6">Sign In</h2>
      <form action="<?php echo ROOT_URL; ?>/app/controllers/auth/login.php" method="POST" autocomplete="off">
        <div class="mb-4">
          <label class="block text-white mb-1">Username</label>
          <input type="text" name="username" autofocus="autofocus" class="w-full px-3 py-2 bg-transparent border-b border-white text-white focus:outline-none focus:border-yellow-600" placeholder="johndoe123" autocomplete="new-username" required>
        </div>
        <div class="mb-6 relative">
          <label class="block text-white mb-1">Password</label>
          <input type="password" name="password" id="password" class="w-full px-3 py-2 bg-transparent border-b border-white text-white focus:outline-none focus:border-yellow-600 pr-10" placeholder="********" autocomplete="new-password" required>
          <button type="button" id="togglePassword" class="absolute right-2 top-9 text-white cursor-pointer text-2xl">
            👁️
          </button>
        </div>
        <button type="submit" class="w-full cursor-pointer bg-yellow-600 text-white py-3 rounded-md hover:bg-yellow-800">
          Sign In
        </button>
      </form>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
        <p class="text-white md:pl-4">
          <a href="<?php echo ROOT_URL; ?>" class="text-yellow-400 hover:text-yellow-600 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" width="16" height="16" fill="currentColor" class="mr-1">
              <path d="M9.4 278.6c-12.5-12.5-12.5-32.8 0-45.3l128-128c9.2-9.2 22.9-11.9 34.9-6.9s19.8 16.6 19.8 29.6l0 256c0 12.9-7.8 24.6-19.8 29.6s-25.7 2.2-34.9-6.9l-128-128z"/>
            </svg>
            Home
          </a>
        </p>
        <p class="text-white md:text-end md:pr-4">
          New here? 
          <a href="<?php echo ROOT_URL; ?>/auth/register" class="text-yellow-400 hover:text-yellow-600 underline">
            Sign Up
          </a>
        </p>
      </div>
    </div>
  </div>

  <script src="<?= ROOT_URL; ?>/assets/js/view-password.js"></script>
  <script src="<?= ROOT_URL; ?>/assets/js/message-modal.js"></script>
</body>
</html>
