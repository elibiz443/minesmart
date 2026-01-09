<?php
  require __DIR__ . '/../config.php';

  try {
    // Step 1: Drop the existing database
    $pdo->exec("DROP DATABASE IF EXISTS $dbname");

    // Step 2: Recreate the database
    $pdo->exec("CREATE DATABASE $dbname");

    // Step 3: Reconnect to the newly created database
    $pdo->exec("USE $dbname");

    // Step 4: Import SQL files with enhanced error handling
    function importSQLFile($pdo, $filePath) {
      $sql = file_get_contents($filePath);
      if ($sql === false) {
        die("Error reading file: $filePath");
      }

      try {
        $pdo->exec($sql);
      } catch (PDOException $e) {
        die("Error in file: $filePath\nSQLSTATE: " . $e->getCode() . "\nMessage: " . $e->getMessage());
      }
    }

    // Paths to your .sql files
    $sqlFiles = [
      'users.sql', 'sites.sql', 'alerts.sql'
    ];

    foreach ($sqlFiles as $file) {
      importSQLFile($pdo, __DIR__ . "/../db/$file");
    }

    echo "Database reset and seeded successfully.";

  } catch (PDOException $e) {
    die("Database operation failed: " . $e->getMessage());
  }
?>
