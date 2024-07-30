<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];

    // Insertion des données dans la table reservations
    $stmt = $pdo->prepare('INSERT INTO reservations (user_id, name, phone, email, date, time, guests) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$user_id, $name, $phone, $email, $date, $time, $guests]);

    // Redirection après la réservation
    header('Location: reservations_success.php');
    exit();
}
?>
