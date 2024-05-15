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

$sql = "DELETE FROM events WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);

header('Location: admin.php');
exit;
?>
