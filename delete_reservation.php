<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

include 'db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare('DELETE FROM reservations WHERE id = ?');
$stmt->execute([$id]);

header('Location: manage_reservations.php');
exit();
?>
