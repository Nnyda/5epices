<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Récupérer les réservations de l'utilisateur
$stmt = $pdo->prepare('SELECT * FROM reservations WHERE user_id = ?');
$stmt->execute([$user_id]);
$reservations = $stmt->fetchAll();
?>

<h2>Mes Réservations</h2>
<ul>
    <?php foreach ($reservations as $reservation): ?>
        <li>
            <strong>Réservation #<?php echo htmlspecialchars($reservation['id']); ?></strong>
            <p>Date : <?php echo htmlspecialchars($reservation['date']); ?></p>
            <p>Heure : <?php echo htmlspecialchars($reservation['time']); ?></p>
            <p>Nombre de convives : <?php echo htmlspecialchars($reservation['guests']); ?></p>
        </li>
    <?php endforeach; ?>
</ul>
