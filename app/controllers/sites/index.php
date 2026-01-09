<?php
$sitesPerPage = 20;

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$offset = ($current_page - 1) * $sitesPerPage;

try {
  $userCompanyId = $currentUser['company_id'] ?? null;

  if ($userCompanyId === null) {
    die('Error: User company ID not found.');
  }

  $totalSitesQuery = "
    SELECT COUNT(*)
    FROM sites s
    JOIN users u ON s.user_id = u.id
    WHERE u.company_id = :company_id";
  $totalSitesStmt = $pdo->prepare($totalSitesQuery);
  $totalSitesStmt->bindValue(':company_id', $userCompanyId, PDO::PARAM_INT);
  $totalSitesStmt->execute();
  $totalSites = $totalSitesStmt->fetchColumn();
  $totalPages = ceil($totalSites / $sitesPerPage);

  $sitesQuery = "
    SELECT s.*
    FROM sites s
    JOIN users u ON s.user_id = u.id
    WHERE u.company_id = :company_id
    ORDER BY s.id DESC
    LIMIT :limit OFFSET :offset";
  $sitesStmt = $pdo->prepare($sitesQuery);
  $sitesStmt->bindValue(':company_id', $userCompanyId, PDO::PARAM_INT);
  $sitesStmt->bindValue(':limit', $sitesPerPage, PDO::PARAM_INT);
  $sitesStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
  $sitesStmt->execute();
  $sites = $sitesStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die('Database error: ' . $e->getMessage());
}

if (isset($_POST['form_type'])) {
  if ($_POST['form_type'] === 'site_form') {
    require __DIR__ . '/create.php';
  }
}
