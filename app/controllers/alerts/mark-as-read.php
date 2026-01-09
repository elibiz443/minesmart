<?php
  require __DIR__ . '/../../helpers/online_connector.php';

  header('Content-Type: application/json');

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $notification_id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $user_id = $currentUser['id'] ?? null;

    if (!$user_id) {
      echo json_encode(['success' => false]);
      exit;
    }

    $stmt = $pdo->prepare("UPDATE alerts SET is_read = 1 WHERE id = :id AND user_id = :user_id AND is_read = 0");
    $stmt->execute([':id' => $notification_id, ':user_id' => $user_id]);

    if ($stmt->rowCount() > 0) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false]);
    }
  } else {
    echo json_encode(['success' => false]);
  }
?>
