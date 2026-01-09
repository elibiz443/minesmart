<?php require __DIR__ . '/../../helpers/connector.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <title>MineSmart - Signup Page</title>

  <!-- CSS -->
  <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

  <!-- FAV and Icons -->
  <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
</head>
<body class="bg-gray-100 max-w-full overflow-x-hidden flex items-center justify-center min-h-screen">
  <?php require __DIR__ . '/../includes/message2.php'; ?>

  <div class="md:flex w-full md:h-screen bg-white shadow-lg overflow-hidden">
    <div class="w-full md:w-1/2 relative flex flex-col items-center justify-center p-8 bg-cover bg-center" 
      style="background-image: url('<?php echo ROOT_URL; ?>/assets/images/register.webp');">
      <div class="absolute inset-0 bg-black/40"></div>

      <div class="glass-bg-color2 py-8 px-10 rounded-lg text-center">
        <img src="<?php echo ROOT_URL; ?>/assets/images/logo.webp" class="w-14 lg:w-20 h-auto mx-auto" alt="Logo">
        <h2 class="text-xl lg:text-3xl font-bold text-white relative z-10 mt-2">Create An Account</h2>
      </div>

      <a href="<?php echo ROOT_URL; ?>" class="glass-bg-color2 absolute bottom-8 left-8 px-6 py-2 text-white rounded-md z-10 border-2 border-transparent hover:border-2 hover:border-white">
        Home
      </a>
      <p class="hidden md:block absolute bottom-[5.5rem] right-8 text-white text-sm z-10">Already registered?</p><br><br>
      <a href="<?php echo ROOT_URL; ?>/auth/login" class="glass-bg-color2 absolute bottom-8 right-8 px-6 py-2 text-white rounded-md z-10 border-2 border-transparent hover:border-2 hover:border-white">
        Sign In
      </a>
    </div>

    <!-- Signup Form -->
    <div class="w-full md:w-1/2 p-12 flex flex-col justify-center relative text-[0.9rem]">
      <form method="POST" action="<?php echo ROOT_URL; ?>/app/controllers/auth/registrations.php" autocomplete="off">
        <input type="hidden" name="status" value="pending">
        <input type="hidden" name="role" value="admin">

        <div class="mb-4">
          <label class="block text-gray-600 mb-1">Full Name</label>
          <input type="text" name="full_name" autocomplete="off" class="w-full px-3 py-2 border-b border-gray-400 focus:outline-none focus:border-yellow-600" placeholder="John Doe" required>
        </div>
        <div class="mb-4 md:flex md:gap-4">
          <div class="w-full md:w-1/2 mb-4 md:mb-0">
            <label class="block text-gray-600 mb-1">Username</label>
            <input type="text" name="username" autocomplete="off" class="w-full px-3 py-2 border-b border-gray-400 focus:outline-none focus:border-yellow-600" placeholder="johndoe123" required>
          </div>
          <div class="w-full md:w-1/2">
            <label class="block text-gray-600 mb-1">Email</label>
            <input type="email" name="email" autocomplete="off" class="w-full px-3 py-2 border-b border-gray-400 focus:outline-none focus:border-yellow-600" placeholder="doe@example.com" required>
          </div>
        </div>
        <div class="mb-4">
          <label class="block text-gray-600 mb-1">Password</label>
          <input type="password" name="password" autocomplete="new-password" class="w-full px-3 py-2 border-b border-gray-400 focus:outline-none focus:border-yellow-600" placeholder="********" required>
        </div>
        <div class="mb-6">
          <label class="block text-gray-600 mb-1">Confirm Password</label>
          <input type="password" name="confirm_password" autocomplete="new-password" class="w-full px-3 py-2 border-b border-gray-400 focus:outline-none focus:border-yellow-600" placeholder="********" required>
        </div>
        <button type="submit" class="cursor-pointer w-full bg-yellow-600 text-white py-3 rounded-md hover:bg-yellow-800">
          Submit
        </button>
      </form>
    </div>
  </div>
</body>
</html>
