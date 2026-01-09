<?php
  $stmt = $pdo->prepare("SELECT * FROM alerts WHERE user_id = :user_id ORDER BY created_at DESC");
  $stmt->execute([':user_id' => $currentUser['id']]);
  $alerts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
