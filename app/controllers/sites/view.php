<?php
  $selected_site = null;

  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $selectedSiteId = $_GET['id'];

    $query = "SELECT * FROM sites WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $selectedSiteId]);
    $selected_site = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$selected_site) {
      $_SESSION['message'] = ['type' => 'error', 'text' => 'Site not found.'];
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
?>