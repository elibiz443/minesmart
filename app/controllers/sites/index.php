<?php
  $sitesPerPage = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $sitesPerPage;

  try {
    $totalSitesQuery = "SELECT COUNT(*) FROM sites";
    $totalSitesStmt = $pdo->prepare($totalSitesQuery);
    $totalSitesStmt->execute();
    $totalSites = $totalSitesStmt->fetchColumn();
    $totalPages = ceil($totalSites / $sitesPerPage);

    $sitesQuery = "
      SELECT id, name, coords 
      FROM sites 
      ORDER BY id DESC 
      LIMIT :limit OFFSET :offset
    ";
    $sitesStmt = $pdo->prepare($sitesQuery);
    $sitesStmt->bindValue(':limit', $sitesPerPage, PDO::PARAM_INT);
    $sitesStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $sitesStmt->execute();
    $sites = $sitesStmt->fetchAll(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    die('Database error: ' . $e->getMessage());
  }

  if (isset($_POST['form_type']) && $_POST['form_type'] === 'site_form') {
    require __DIR__ . '/create.php';
  }
?>