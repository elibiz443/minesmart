<?php
  ini_set('display_errors', 0);
  ini_set('display_startup_errors', 0);
  error_reporting(E_ALL);

  header('Content-Type: application/json');
  session_start();

  require __DIR__ . '/../../../config.php';

  if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
  }

  try {
    $sitesQuery = "SELECT id, name, coords, image_link, user_id AS creator_id FROM sites";
    $sitesStmt = $pdo->prepare($sitesQuery);
    $sitesStmt->execute();
    $sites = $sitesStmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$sites) {
      echo json_encode([]);
      exit;
    }

    $creatorIds = array_unique(array_column($sites, 'creator_id'));
    $inCreatorIds = implode(',', array_fill(0, count($creatorIds), '?'));
    $creatorsQuery = "SELECT id, full_name AS name FROM users WHERE id IN ($inCreatorIds)";
    $creatorsStmt = $pdo->prepare($creatorsQuery);
    $creatorsStmt->execute($creatorIds);
    $creators = $creatorsStmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $response = [];
    foreach ($sites as $site) {
      $response[] = [
        'id' => $site['id'],
        'name' => $site['name'],
        'coords' => $site['coords'],
        'image_link' => $site['image_link'],
        'creator' => ['name' => $creators[$site['creator_id']] ?? 'Unknown']
      ];
    }

    echo json_encode($response);

  } catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
  }
?>