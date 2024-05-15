<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: dashboard.php');
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $created_by = $_SESSION['user_id'];

    $sql = "INSERT INTO events (title, description, date, created_by) VALUES (:title, :description, :date, :created_by)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['title' => $title, 'description' => $description, 'date' => $date, 'created_by' => $created_by]);

    header('Location: admin.php');
}

$sql = "SELECT * FROM events";
$stmt = $pdo->query($sql);
$events = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Admin Panel - MTC IIT</title>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="images/logo.png" alt="MTC IIT Logo" class="logo">
        </div>
        <h1 class="header-title">Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </nav>
    </header>    <section class="admin-panel">
        <h2>Add Event</h2>
        <form method="POST" class="admin-form">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            <button type="submit">Add Event</button>
        </form>
        <h2>Manage Events</h2>
        <ul>
            <?php foreach ($events as $event): ?>
                <li class="event">
                    <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                    <p><?php echo htmlspecialchars($event['description']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
                    <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="edit-button">Edit</a>
                    <a href="delete_event.php?id=<?php echo $event['id']; ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</body>
</html>
