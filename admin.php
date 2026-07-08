<?php
include 'auth.php';
requireLogin();

$message = '';
$dataFile = 'data.json';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $csrf_token = $_POST['csrf_token'] ?? '';

    if (!verifyCsrfToken($csrf_token)) {
        $message = "<p class='error'>Invalid CSRF token.</p>";
    } else {
        if (isset($_POST['json_data'])) {
            $newData = json_decode($_POST['json_data'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                if (file_put_contents($dataFile, json_encode($newData, JSON_PRETTY_PRINT))) {
                    $message = "<p class='success'>Data successfully updated!</p>";
                } else {
                    $message = "<p class='error'>Error writing to file.</p>";
                }
            } else {
                $message = "<p class='error'>Invalid JSON format provided!</p>";
            }
        }
    }
}

$currentData = file_get_contents($dataFile);

include 'header.php';
?>

<div style="max-width: 800px; margin: 20px auto;">
    <h2 style="margin-top:0;">Admin Portal</h2>
    <p>Edit the JSON data below to update the portal links. Ensure the JSON remains valid.</p>

    <?php echo $message; ?>

    <form method="POST" action="admin.php" style="max-width: 100%;">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(getCsrfToken()); ?>">
        <label for="json_data">Portal Data (JSON format):</label>
        <textarea id="json_data" name="json_data" rows="20" style="font-family: monospace;"><?php echo htmlspecialchars($currentData); ?></textarea>

        <button type="submit">Save Changes</button>
    </form>
</div>

<?php include 'footer.php'; ?>
