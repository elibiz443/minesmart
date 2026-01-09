<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  session_start();

  require __DIR__ . '/../../../config.php';

  if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: " . ROOT_URL . "/app/views/auth/login.php");
    exit;
  }

  $currentUser = isset($_SESSION['user']) ? $_SESSION['user'] : [];

  if (!isset($currentUser['role']) || $currentUser['role'] !== 'global_admin') {
    $_SESSION['message'] = ['type' => 'error', 'text' => 'Access denied. Only Global Admins can delete sites.'];
    header("Location: " . ROOT_URL . "/app/views/sites/index.php");
    exit;
  }

  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $selectedSiteId = $_GET['id'];

    $fetchSiteQuery = "SELECT name FROM sites WHERE id = :id";
    $fetchStmt = $pdo->prepare($fetchSiteQuery);
    $fetchStmt->execute([':id' => $selectedSiteId]);
    $siteToDelete = $fetchStmt->fetch(PDO::FETCH_ASSOC);

    if ($siteToDelete) {
      try {
        $pdo->beginTransaction();

        $query = "DELETE FROM sites WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $deleted = $stmt->execute([':id' => $selectedSiteId]);

        if ($deleted) {
          $activityQuery = "INSERT INTO activity_logs (user_id, activity, detail) VALUES (:user_id, :activity, :detail)";
          $activityStmt = $pdo->prepare($activityQuery);
          $activityStmt->execute([
            ':user_id' => $currentUser['id'],
            ':activity' => 'Deleted Site',
            ':detail' => "Deleted site: {$siteToDelete['name']}",
          ]);

          $pdo->commit();
          $_SESSION['message'] = ['type' => 'success', 'text' => 'Site deleted successfully.'];
        } else {
          $pdo->rollBack();
          $_SESSION['message'] = ['type' => 'error', 'text' => 'Failed to delete site. Please try again.'];
        }
      } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Error deleting site: " . $e->getMessage());
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Error deleting site. Please try again. If the problem persists, contact support.'];
      }
    } else {
      $_SESSION['message'] = ['type' => 'error', 'text' => 'Site not found.'];
    }
  } else {
    $_SESSION['message'] = ['type' => 'error', 'text' => 'Invalid site ID.'];
  }

  header("Location: " . ROOT_URL . "/app/views/sites/index.php");
  exit;
?>
