<?php
include 'header.php';
require 'db.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);

        if ($stmt->rowCount() > 0) {
            $error = "Username or Email already exists.";
        } else {
            // Hash password and insert
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $password_hash])) {
                $success = "Registration successful! You can now <a href='login.php' style='color: var(--accent-color);'>Login</a>.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<section class="auth-section">
    <div class="auth-container">
        <h2 class="section-title">One of Us</h2>
        <?php if ($error): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="register.php" method="post" class="contact-form">
            <div class="form-group">
                <input type="text" name="username" required>
                <label>Username</label>
            </div>
            <div class="form-group">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>
            <div class="form-group">
                <input type="password" name="password" required>
                <label>Password</label>
                <i class="fas fa-eye password-toggle-icon"></i>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" required>
                <label>Confirm Password</label>
                <i class="fas fa-eye password-toggle-icon"></i>
            </div>
            <button type="submit" class="cta-button">Register</button>
        </form>
        <p style="margin-top: 20px; text-align: center;">Already have an account?&nbsp;&nbsp;<a href="login.php"
                style="color: var(--accent-color);">Login here</a>.</p>
    </div>
</section>

<style>
    .auth-section {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
    }

    .auth-container {
        width: 100%;
        max-width: 500px;
    }

    .alert {
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
        text-align: center;
    }

    .alert.error {
        background: #ff4d4d33;
        color: #ff4d4d;
        border: 1px solid #ff4d4d;
    }

    .alert.success {
        background: #4caf5033;
        color: #4caf50;
        border: 1px solid #4caf50;
    }
</style>

<?php include 'footer.php'; ?>