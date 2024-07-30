<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];
    $event_type = $_POST['event_type'];
    $special_request = isset($_POST['special_request']) ? $_POST['special_request'] : '';

    // Préparer la requête pour insérer la réservation d'événement dans la base de données
    $stmt = $pdo->prepare('INSERT INTO event_reservations (user_id, date, time, guests, event_type, special_request) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$user_id, $date, $time, $guests, $event_type, $special_request]);

    // Rediriger vers une page de confirmation ou une autre page pertinente
    header('Location: event_confirmation.php');
    exit();
} else {
    // Rediriger vers le formulaire de réservation d'événement si la méthode de requête n'est pas POST
    header('Location: reserve_event.php');
    exit();
}
?>
