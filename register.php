<?php
require_once 'config/database.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: admin-dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $full_name = trim($_POST['full_name']);

    if (!empty($username) && !empty($password) && !empty($full_name)) {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, password, full_name, user_type) VALUES (?, ?, ?, 'admin')");
        
        if ($stmt->execute([$username, $hashed_password, $full_name])) {
            header("Location: admin-login.php?registered=1");
            exit;
        } else {
            $error = "Username already exists.";
        }

    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <a href="index.php" class="back-link">← Back to Events</a>

    <div class="login-card">
        <h2>Register Admin Account</h2>

        <?php if($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" class="login-form">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
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