<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LTSG Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1><a href="index.php" style="color: white; text-decoration: none;">LTSG</a></h1>
        </div>
        <nav>
            <ul>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Storage Tools <span class="caret">▼</span></a>
                    <div class="dropdown-content">
                        <a href="#">Tool 1</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Service Now <span class="caret">▼</span></a>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Sharepoint Links <span class="caret">▼</span></a>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Disaster Recovery <span class="caret">▼</span></a>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Storage Discovery <span class="caret">▼</span></a>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Inventory <span class="caret">▼</span></a>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Firmware Version <span class="caret">▼</span></a>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                    </div>
                </li>
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <li class="dropdown">
                        <a href="#" class="dropbtn">Admin <span class="caret">▼</span></a>
                        <div class="dropdown-content">
                            <a href="admin.php">Admin Portal</a>
                            <a href="login.php?action=logout">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
