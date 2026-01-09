<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  session_start();

  // Include the database configuration file
  require __DIR__ . '/../../config.php';

  // Display message if exists
  $message = null;
  if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
  }
?>