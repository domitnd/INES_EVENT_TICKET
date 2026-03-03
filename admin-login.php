<?php 
require_once 'config/database.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: ' . ($_SESSION['admin_type'] == 'admin' ? 'admin-dashboard.php' : 'organizer-dashboard.php'));
    exit;
}

$error = '';
$selected_role = $_GET['role'] ?? 'admin'; // Default to admin
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - INES Event Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-link">← Back to Events</a>
        
        <div class="login-card">
            <h2>Staff Login</h2>
            
            <!-- Role Selection Tabs -->
            <div class="role-tabs">
                <a href="?role=admin" class="role-tab <?php echo $selected_role == 'admin' ? 'active' : ''; ?>">
                    <span class="role-icon">👑</span>
                    <span>Admin</span>
                </a>
                <a href="?role=organizer" class="role-tab <?php echo $selected_role == 'organizer' ? 'active' : ''; ?>">
                    <span class="role-icon">🎪</span>
                    <span>Organizer</span>
                </a>
            </div>
            
            <?php if($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="login-process.php" class="login-form">
                <input type="hidden" name="role" value="<?php echo $selected_role; ?>">
                
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter your username" required>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" class="btn-large">
                    Login as <?php echo ucfirst($selected_role); ?>
                </button>
            </form>
            <div class="register-link">
    <p>Don't have an account?</p>
    <a href="register.php" class="btn-secondary">Register Here</a>
</div>
           
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>