<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];

    $stmt = $pdo->prepare('INSERT INTO reservations (user_id, date, time, guests) VALUES (?, ?, ?, ?)');
    $stmt->execute([$user_id, $date, $time, $guests]);

    echo "Réservation effectuée avec succès !";
}
?>

<h2>Faire une Réservation</h2>
<form method="POST">
    <label for="date">Date :</label>
    <input type="date" id="date" name="date" required>
    <label for="time">Heure :</label>
    <input type="time" id="time" name="time" required>
    <label for="guests">Nombre de convives :</label>
    <input type="number" id="guests" name="guests" min="1" required>
    <button type="submit">Réserver</button>
</form>
