<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';
$role = $_SESSION['role'];

$sql = "SELECT * FROM events";
$stmt = $pdo->query($sql);
$events = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Dashboard - MTC IIT</title>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="images/logo.png" alt="MTC IIT Logo" class="logo">
        </div>
        <h1 class="header-title">Dashboard</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if ($role == 'admin'): ?>
                    <li><a href="admin.php" class="admin-button">Admin Dashboard</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <section class="dashboard">
        <h2>Upcoming Events</h2>
        <ul>
            <?php foreach ($events as $event): ?>
                <li class="event">
                    <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                    <p><?php echo htmlspecialchars($event['description']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</body>
</html>
