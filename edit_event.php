<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: dashboard.php');
    exit;
}

include 'db.php';

if (!isset($_GET['id'])) {
    header('Location: admin.php');
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    $sql = "UPDATE events SET title = :title, description = :description, date = :date WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['title' => $title, 'description' => $description, 'date' => $date, 'id' => $id]);

    header('Location: admin.php');
    exit;
} else {
    $sql = "SELECT * FROM events WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $event = $stmt->fetch();

    if (!$event) {
        header('Location: admin.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Edit Event - MTC IIT</title>
</head>
<body>
    <h2>Edit Event</h2>
    <form method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($event['description']); ?></textarea>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($event['date']); ?>" required>
        <button type="submit">Update Event</button>
    </form>
</body>
</html>
