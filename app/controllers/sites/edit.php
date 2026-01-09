<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    if (!isset($currentUser) || !isset($currentUser['role']) || $currentUser['role'] !== 'global_admin') {
      $_SESSION['message'] = ['type' => 'error', 'text' => 'Access denied. Only Global Admins can edit sites.'];
      header("Location: " . ROOT_URL . "/app/views/sites");
      exit;
    }

    $siteId = $_POST['site_id'] ?? null;
    $name = $_POST['name'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    $coords = $_POST['coords'] ?? null;
    $admin_id = $_POST['admin_id'] ?? null;

    if (!$siteId) {
      $_SESSION['message'] = ['type' => 'error', 'text' => 'Missing Site ID.'];
      header("Location: " . ROOT_URL . "/app/views/sites");
      exit;
    }

    $stmt = $pdo->prepare("SELECT image_link FROM sites WHERE id = :id");
    $stmt->execute([':id' => $siteId]);
    $site = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$site) {
      $_SESSION['message'] = ['type' => 'error', 'text' => 'Site not found.'];
      header("Location: " . ROOT_URL . "/app/views/sites");
      exit;
    }

    $image_link = $site['image_link'];
    if (isset($_FILES['image_link']) && $_FILES['image_link']['error'] === UPLOAD_ERR_OK) {
      $image = $_FILES['image_link'];

      $uploadsDir = __DIR__ . '/../../../uploads/';
      if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
      }

      $fileName = uniqid() . '.webp';
      $image_link = '/uploads/' . $fileName;
      if (!move_uploaded_file($image['tmp_name'], $uploadsDir . $fileName)) {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Error: Failed to upload image.'];
        header("Location: " . ROOT_URL . "/app/views/sites");
        exit;
      }
    }

    $errors = [];

    if (empty($admin_id)) {
      $errors[] = "Site Admin must be selected.";
    }

    if (!empty($errors)) {
      $_SESSION['message'] = ['type' => 'error', 'text' => implode(' ', $errors)];
      header("Location: " . ROOT_URL . "/app/views/sites");
      exit;
    }

    try {
      $pdo->beginTransaction();

      $updateQuery = "UPDATE sites SET name = :name, coords = :coords, image_link = :image_link, admin_id = :admin_id, user_id = :user_id WHERE id = :id";
      $stmt = $pdo->prepare($updateQuery);
      $stmt->execute([
        ':name' => $name,
        ':coords' => $coords,
        ':image_link' => $image_link,
        ':admin_id' => $admin_id,
        ':user_id' => $user_id,
        ':id' => $siteId,
      ]);

      $activityQuery = "INSERT INTO activity_logs (user_id, activity, detail) VALUES (:user_id, :activity, :detail)";
      $activityStmt = $pdo->prepare($activityQuery);
      $activityStmt->execute([
        ':user_id' => $currentUser['id'],
        ':activity' => 'Edited Site',
        ':detail' => "Edited site '$name' and assigned admin ID $admin_id.",
      ]);

      $pdo->commit();

      $_SESSION['message'] = ['type' => 'success', 'text' => "Site '$name' updated successfully."];
      header("Location: " . ROOT_URL . "/app/views/sites/view.php?id=$siteId");
      exit;
    } catch (PDOException $e) {
      $pdo->rollBack();
      error_log("Error updating site: " . $e->getMessage());
      $_SESSION['message'] = ['type' => 'error', 'text' => "Error updating site. Please try again. If the problem persists, contact support."];
      header("Location: " . ROOT_URL . "/app/views/sites");
      exit;
    }
  }
?>
