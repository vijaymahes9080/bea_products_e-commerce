<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to sign-in if not authenticated
    header("Location: signin.php");
    exit();
}

include 'config.php';

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Makeup Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?></h2>
        <p>Explore the latest makeup products for all your beauty needs.</p>
        <a href="products.html">view product</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
