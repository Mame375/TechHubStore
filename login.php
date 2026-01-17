<?php
include 'header.php';
require 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_email = trim($_POST['username']); // allowing both
    $password = $_POST['password'];

    if (empty($username_email) || empty($password)) {
        $error = "Please enter username/email and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username_email, $username_email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: Index.php");
            exit;
        } else {
            $error = "Invalid credentials.";
        }
    }
}
?>

<section class="auth-section">
    <div class="auth-container">
        <h2 class="section-title">Welcome Back</h2>
        <?php if ($error): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="login.php" method="post" class="contact-form">
            <div class="form-group">
                <input type="text" name="username" required>
                <label>Username or Email</label>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
                <label>Password</label>
                <i class="fas fa-eye password-toggle-icon"></i>
            </div>
            <button type="submit" class="cta-button">Login</button>
        </form>
        <p style="margin-top: 20px; text-align: center;">New here?&nbsp;&nbsp;<a href="register.php"
                style="color: var(--accent-color);">Create an account</a>.</p>
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
</style>

<?php include 'footer.php'; ?>