<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  session_start();
  require __DIR__ . '/../../../config.php';

  // Set a session message before destroying the session
  $_SESSION['message'] = ['type' => 'success', 'text' => 'You have been successfully logged out.'];

  // Unset all session variables
  session_unset();

  // Destroy the session
  session_destroy();

  // Redirect to the login page
  header("Location: " . ROOT_URL . "/auth/login");
  exit;
?>
