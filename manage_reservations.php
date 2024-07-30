<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

include 'db.php';

// Requête pour obtenir les informations des réservations et des utilisateurs
$stmt = $pdo->query('
    SELECT reservations.id, users.username, users.phone, reservations.date, reservations.time, reservations.guests, reservations.created_at
    FROM reservations
    JOIN users ON reservations.user_id = users.id
');
$reservations = $stmt->fetchAll();
?>

<!-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les Réservations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head> -->

<?php include ("header.php") ?>

<body>
    <br><br><br><br><br><br>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="admin_dashboard.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_orders.php">Gérer les Commandes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_reservations.php">Gérer les Réservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_events.php">Gérer les Événements</a>
                </li>
            </ul>
            <a href="admin_logout.php" class="btn btn-danger logout">Se Déconnecter</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-5">Gérer les Réservations</h1>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom d'utilisateur</th>
                    <th>Téléphone</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Nombre d'invités</th>
                    <th>Date de Création</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['id']) ?></td>
                        <td><?= htmlspecialchars($reservation['username']) ?></td>
                        <td><?= htmlspecialchars($reservation['phone']) ?></td>
                        <td><?= htmlspecialchars($reservation['date']) ?></td>
                        <td><?= htmlspecialchars($reservation['time']) ?></td>
                        <td><?= htmlspecialchars($reservation['guests']) ?></td>
                        <td><?= htmlspecialchars($reservation['created_at']) ?></td>
                        <td>
                            <a href="delete_reservation.php?id=<?= $reservation['id'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
 
<?php include ("footer.php") ?>
<br><br><br>
</html>
