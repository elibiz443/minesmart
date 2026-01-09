<?php
  // Set ROOT_URL based on environment
  if ($_SERVER['SERVER_NAME'] == 'localhost') {
    define('ROOT_URL', 'http://localhost/minesmart');

    // Local DB credentials
    $host = 'localhost';
    $dbname = 'minesmart_db';
    $username = 'root';
    $password = '';

    // Define ROOT_PATH for local
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/minesmart');
  } else {
    define('ROOT_URL', 'https://');

    // Production DB credentials
    $host = 'localhost';
    $dbname = '';
    $username = '';
    $password = '';

    // Define ROOT_PATH for production using __DIR__
    define('ROOT_PATH', dirname(__FILE__));
  }

  try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    die("Could not connect to the database $dbname: " . $e->getMessage());
  }
?>