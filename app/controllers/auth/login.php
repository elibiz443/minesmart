<?php
  session_start();
  require __DIR__ . '/../../../config.php';

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password and start session if valid
    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['logged_in'] = true;
      // Store the entire user record in the session
      $_SESSION['user'] = $user;

      // Set the welcome message
      $_SESSION['message'] = ['type' => 'success', 'text' => "Welcome back, " . htmlspecialchars($user['full_name']) . "!"];

      // Determine the redirect URL
      $redirectUrl = ROOT_URL . "/dashboard"; // Default redirect

      // Check if an initial URL was stored before redirection to login
      if (isset($_SESSION['redirect_after_login'])) {
      $initialLink = $_SESSION['redirect_after_login'];

      // Check if the initial link contains "/machines/"
      if (strpos($initialLink, '/machines/') !== false) {
       // The link is for a specific machine, so redirect there
       $redirectUrl = $initialLink;
      }
      // Clear the stored redirect URL to prevent re-using it
      unset($_SESSION['redirect_after_login']);
      }

      header("Location: " . $redirectUrl);
      exit;
    } else {
      $_SESSION['message'] = ['type' => 'error', 'text' => 'Invalid username or password.'];
      header("Location: " . ROOT_URL . "/auth/login");
      exit;
    }
  }
?>
