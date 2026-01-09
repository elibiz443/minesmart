<?php
  require __DIR__ . '/../../../config.php';
  session_start();

  if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: " . ROOT_URL . "/auth/login");
    exit;
  }

  $currentUser = $_SESSION['user'];

  if (!empty($_POST['selected_ids']) && is_array($_POST['selected_ids'])) {
    $placeholders = implode(',', array_fill(0, count($_POST['selected_ids']), '?'));
    $stmt = $pdo->prepare("DELETE FROM alerts WHERE id IN ($placeholders) AND user_id = ?");
    $params = array_merge($_POST['selected_ids'], [$currentUser['id']]);
    $stmt->execute($params);

    $_SESSION['message'] = ['type' => 'success', 'text' => 'Selected alerts deleted successfully.'];
  } else {
    $_SESSION['message'] = ['type' => 'error', 'text' => 'No alerts selected.'];
  }

  header("Location: " . ROOT_URL . "/alerts");
exit;
