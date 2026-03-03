<?php
require_once 'config/database.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: admin-dashboard.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if (!empty($full_name) && !empty($username) && !empty($password) && !empty($role)) {

        if ($role === 'admin') {
            $checkAdmin = $pdo->query("SELECT COUNT(*) FROM users WHERE user_type = 'admin'")->fetchColumn();
            if ($checkAdmin > 0) {
                $error = "An admin already exists. Only one admin allowed.";
            }
        }

        if (!$error) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, username, password, user_type) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$full_name, $username, $hashed_password, $role])) {
                $success = "Account created successfully! You can now login.";
            } else {
                $error = "Username already exists.";
            }
        }

    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - INES Event Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <!-- Back to events -->
    <a href="index.php" class="back-link">← Back to Events</a>

    <div class="login-card">
        <!-- Styled Heading -->
        <h2 class="card-heading">Create Account</h2>

        <!-- Error / Success -->
        <?php if($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if($success): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" class="login-form">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <!-- Role selection -->
            <div class="form-group">
                <label>Register As</label>
                <div class="role-buttons">
                    <input type="radio" name="role" value="admin" id="admin" required>
                    <label for="admin" class="role-btn admin-btn">👑 Admin</label>

                    <input type="radio" name="role" value="organizer" id="organizer">
                    <label for="organizer" class="role-btn organizer-btn">🎪 Organizer</label>
                </div>
            </div>

            <button type="submit" class="btn-large">Register</button>
        </form>

        <div class="register-link">
            <p>Already have an account?</p>
            <a href="admin-login.php" class="btn-secondary">Login Here</a>
        </div>

    </div>
</div>

</body>
</html>