<?php
  // Enable error reporting for debugging
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  header('Content-Type: application/json');
  session_start();

  require __DIR__ . '/../../../config.php';

  if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
  }

  $currentUser = $_SESSION['user'] ?? [];

  if (!isset($currentUser['id'], $currentUser['company_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'User or company not found in session']);
    exit;
  }

  try {
    // Step 1: Fetch all user IDs in the same company
    $userQuery = "SELECT id FROM users WHERE company_id = :company_id";
    $userStmt = $pdo->prepare($userQuery);
    $userStmt->bindValue(':company_id', $currentUser['company_id'], PDO::PARAM_INT);
    $userStmt->execute();
    $userIds = $userStmt->fetchAll(PDO::FETCH_COLUMN);

    if (!$userIds) {
      echo json_encode([]);
      exit;
    }

    // Step 2: Fetch all sites belonging to users in this company
    $inUserIds = implode(',', array_fill(0, count($userIds), '?'));
    $sitesQuery = "SELECT s.id, s.name, s.coords, s.image_link, s.user_id AS creator_id
                   FROM sites s
                   WHERE s.user_id IN ($inUserIds)";
    $sitesStmt = $pdo->prepare($sitesQuery);
    $sitesStmt->execute($userIds);
    $sites = $sitesStmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$sites) {
      echo json_encode([]);
      exit;
    }

    $siteIds = array_column($sites, 'id');
    $creatorIds = array_column($sites, 'creator_id');

    // Step 3: Fetch all machines for these sites
    $inSiteIds = implode(',', array_fill(0, count($siteIds), '?'));
    $machinesQuery = "SELECT site_id, name, model FROM machines WHERE site_id IN ($inSiteIds)";
    $machinesStmt = $pdo->prepare($machinesQuery);
    $machinesStmt->execute($siteIds);
    $allMachines = $machinesStmt->fetchAll(PDO::FETCH_ASSOC);

    $machinesGrouped = [];
    foreach ($allMachines as $machine) {
      $machinesGrouped[$machine['site_id']][] = [
        'name' => $machine['name'],
        'model' => $machine['model']
      ];
    }

    // Step 4: Fetch creator names
    $inCreatorIds = implode(',', array_fill(0, count($creatorIds), '?'));
    $creatorsQuery = "SELECT id, full_name AS name FROM users WHERE id IN ($inCreatorIds)";
    $creatorsStmt = $pdo->prepare($creatorsQuery);
    $creatorsStmt->execute($creatorIds);
    $creators = $creatorsStmt->fetchAll(PDO::FETCH_KEY_PAIR); // id => name

    // Step 5: Construct response
    $response = [];
    foreach ($sites as $site) {
      $response[] = [
        'id' => $site['id'],
        'name' => $site['name'],
        'coords' => $site['coords'],
        'image_link' => $site['image_link'],
        'machines' => $machinesGrouped[$site['id']] ?? [],
        'creator' => ['name' => $creators[$site['creator_id']] ?? null]
      ];
    }

    echo json_encode($response);

  } catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
  }
?>
