<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  session_start();

  require __DIR__ . '/../../config.php';

  // Check if the user is logged in
  if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: " . ROOT_URL . "/auth/login");
    exit;
  }

  $currentUser = isset($_SESSION['user']) ? $_SESSION['user'] : [];

  // Retrieve the flash message from the session if it exists
  $message = null;
  if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
  }
?>