<?php
$selected_site = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $selectedSiteId = $_GET['id'];

  $userCompanyId = $currentUser['company_id'] ?? null;

  if ($userCompanyId === null) {
    $_SESSION['message'] = ['type' => 'error', 'text' => 'User company ID not found.'];
    header("Location: " . ROOT_URL . "/app/views/sites/index.php");
    exit;
  }

  $query = "
    SELECT s.*
    FROM sites s
    JOIN users u ON s.user_id = u.id
    WHERE s.id = :id AND u.company_id = :company_id";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'id' => $selectedSiteId,
    'company_id' => $userCompanyId
  ]);
  $selected_site = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$selected_site) {
    $_SESSION['message'] = ['type' => 'error', 'text' => 'Site not found or unauthorized access.'];
    header("Location: " . ROOT_URL . "/app/views/sites/index.php");
    exit;
  }
} else {
  $_SESSION['message'] = ['type' => 'error', 'text' => 'Invalid site ID.'];
  header("Location: " . ROOT_URL . "/app/views/sites/index.php");
  exit;
}

if (isset($_POST['form_type'])) {
  if ($_POST['form_type'] === 'site_form') {
    require __DIR__ . '/edit.php';
  }
}
