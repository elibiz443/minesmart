<?php
  session_start();
  require __DIR__ . '/../../../config.php';

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect form data
    $fullName = $_POST['full_name'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? 'operator';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $status = $_POST['status'] ?? 'pending';

    // Initialize errors array
    $errors = [];

    // Validation
    if (empty($fullName)) $errors[] = 'Full Name is required.';
    if (empty($username)) $errors[] = 'Username is required.';
    if (empty($email)) $errors[] = 'Email is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format.';
    if (empty($password)) $errors[] = 'Password is required.';
    if ($password !== $confirm_password) $errors[] = 'Passwords do not match.';

    // Check for uniqueness of username & email
    try {
      $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
      $stmt->execute([':username' => $username]);
      if ($stmt->fetchColumn()) $errors[] = 'Username is already taken.';

      $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
      $stmt->execute([':email' => $email]);
      if ($stmt->fetchColumn()) $errors[] = 'Email is already taken.';
    } catch (PDOException $e) {
      $_SESSION['message'] = ['type' => 'error', 'text' => "Error checking uniqueness: " . $e->getMessage()];
      header("Location: " . ROOT_URL . "/auth/register");
      exit;
    }

    // If there are validation errors, store them in session and redirect
    if (!empty($errors)) {
      $_SESSION['message'] = ['type' => 'error', 'text' => implode(' ', $errors)];
      header("Location: " . ROOT_URL . "/auth/register");
      exit;
    }

    try {
      // Hash the password
      $hashed_password = password_hash($password, PASSWORD_BCRYPT);

      // Insert the user into the database
      $query = "INSERT INTO users (full_name, username, email, product_key, role, company_id, grant_access_to_creator, password, creator_id, status, plan)
                VALUES (:full_name, :username, :email, :product_key, :role, :company_id, :grant_access_to_creator, :password, :creator_id, :status, :plan)";
      $stmt = $pdo->prepare($query);
      $stmt->execute([
        ':full_name' => $fullName,
        ':username' => $username,
        ':email' => $email,
        ':role' => $role,
        ':password' => $hashed_password,
        ':creator_id' => $creator_id,
        ':status' => $status,
      ]);

      // Retrieve the newly registered user
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
        throw new Exception("Failed to retrieve user after registration.");
      }
    } catch (Exception $e) {
      $_SESSION['message'] = ['type' => 'error', 'text' => "Registration error: " . $e->getMessage()];
      header("Location: " . ROOT_URL . "/auth/register");
      exit;
    }
  }
?>
