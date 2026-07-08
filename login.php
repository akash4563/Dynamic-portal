<?php
include 'auth.php';

$error = '';
$success = '';

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';

    if (!verifyCsrfToken($csrf_token)) {
        $error = "Invalid CSRF token.";
    } else {
        // Read credentials from environment variables or a configuration file.
        // For this task, we will simulate a more secure check.
        // In a real application, fetch from DB or environment.
        $stored_user = getenv('ADMIN_USERNAME') ?: 'admin';
        // A hashed password should be stored securely.
        $stored_hash = getenv('ADMIN_PASSWORD_HASH') ?: '$2y$10$HLclfGxQG6nbY1UnlcqVIuYU2uUHVYtZhzPOugymTQ3Cgr.rhxVba';

        if ($username === $stored_user && password_verify($password, $stored_hash)) {
            $_SESSION['logged_in'] = true;
            header("Location: admin.php");
            exit;
        } else {
            $error = "Invalid username or password!";
        }
    }
}

include 'header.php';
?>

<div style="max-width: 400px; margin: 50px auto;">
    <form method="POST" action="login.php">
        <h2 style="text-align:center; margin-top:0;">Admin Login</h2>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(getCsrfToken()); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

<?php include 'footer.php'; ?>
