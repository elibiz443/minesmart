<?php
  session_start();
  require __DIR__ . '/../../../config.php';

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST['full_name'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? 'guest';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $status = $_POST['status'] ?? 'pending';

    $errors = [];

    if (empty($fullName)) $errors[] = 'Full Name is required.';
    if (empty($username)) $errors[] = 'Username is required.';
    if (empty($email)) $errors[] = 'Email is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format.';
    if (empty($password)) $errors[] = 'Password is required.';
    if ($password !== $confirm_password) $errors[] = 'Passwords do not match.';

    try {
      $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
      $stmt->execute([':username' => $username]);
      if ($stmt->fetchColumn()) $errors[] = 'Username is already taken.';

      $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
      $stmt->execute([':email' => $email]);
      if ($stmt->fetchColumn()) $errors[] = 'Email is already taken.';
    } catch (PDOException $e) {
      $_SESSION['message'] = ['type' => 'error', 'text' => "Uniqueness check failed: " . $e->getMessage()];
      header("Location: " . ROOT_URL . "/auth/register");
      exit;
    }

    if (!empty($errors)) {
      $_SESSION['message'] = ['type' => 'error', 'text' => implode(' ', $errors)];
      header("Location: " . ROOT_URL . "/auth/register");
      exit;
    }

    try {
      $hashed_password = password_hash($password, PASSWORD_BCRYPT);

      $query = "INSERT INTO users (full_name, username, role, status, email, password)
                VALUES (:full_name, :username, :role, :status, :email, :password)";
      
      $stmt = $pdo->prepare($query);
      $stmt->execute([
        ':full_name' => $fullName,
        ':username'  => $username,
        ':role'      => $role,
        ':status'    => $status,
        ':email'     => $email,
        ':password'  => $hashed_password,
      ]);

      $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
      $stmt->execute([':email' => $email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = $user;
        $_SESSION['message'] = ['type' => 'success', 'text' => "Welcome, " . htmlspecialchars($user['full_name']) . "!"];
        header("Location: " . ROOT_URL . "/dashboard");
        exit;
      } else {
        throw new Exception("User retrieval failed.");
      }
    } catch (Exception $e) {
      $_SESSION['message'] = ['type' => 'error', 'text' => "Registration error: " . $e->getMessage()];
      header("Location: " . ROOT_URL . "/auth/register");
      exit;
    }
  }
?>