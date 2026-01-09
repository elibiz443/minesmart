<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'site_form') {
    if (!isset($currentUser) || !isset($currentUser['role']) || $currentUser['role'] !== 'global_admin') {
      $_SESSION['message'] = ['type' => 'error', 'text' => 'Access denied. Only Global Admins can create new sites.'];
      header("Location: " . ROOT_URL . "/app/views/sites");
      exit;
    }

    $name = $_POST['name'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    $coords = $_POST['coords'] ?? null;
    $admin_id = $_POST['admin_id'] ?? null;

    $image_link = null;
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

      $query = "INSERT INTO sites (name, coords, image_link, admin_id, user_id)
                VALUES (:name, :coords, :image_link, :admin_id, :user_id)";
      $stmt = $pdo->prepare($query);
      $stmt->execute([
        ':name' => $name,
        ':coords' => $coords,
        ':image_link' => $image_link,
        ':admin_id' => $admin_id,
        ':user_id' => $user_id,
      ]);

      $siteId = $pdo->lastInsertId();

      $activityQuery = "INSERT INTO activity_logs (user_id, activity, detail) VALUES (:user_id, :activity, :detail)";
      $activityStmt = $pdo->prepare($activityQuery);
      $activityStmt->execute([
        ':user_id' => $currentUser['id'],
        ':activity' => 'Created Site',
        ':detail' => "Created site '$name' and assigned admin ID $admin_id.",
      ]);

      $pdo->commit();

      $_SESSION['message'] = ['type' => 'success', 'text' => "Site '$name' added successfully."];
      header("Location: " . ROOT_URL . "/app/views/sites/view.php?id=$siteId");
      exit;
    } catch (PDOException $e) {
      $pdo->rollBack();
      error_log("Error adding site: " . $e->getMessage());
      $_SESSION['message'] = ['type' => 'error', 'text' => "Error adding site. Please try again. If the problem persists, contact support."];
      header("Location: " . ROOT_URL . "/app/views/sites");
      exit;
    }
  }
?>
