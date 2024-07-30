<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Récupérer toutes les réservations d'événements
$stmt = $pdo->query('
    SELECT er.id, er.user_id, er.date, er.time, er.guests, er.event_type, er.special_request, er.created_at, u.username, u.phone 
    FROM event_reservations er
    JOIN users u ON er.user_id = u.id
');
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Événements</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head> -->

<?php include ("header.php") ?>

<body>
    <br><br><br><br><br>
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

    <div class="container mt-5">
        <h1 class="mb-4">Gestion des Événements</h1>
        <?php if (count($events) > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Utilisateur</th>
                        <th>Téléphone</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Nombre d'invités</th>
                        <th>Type d'événement</th>
                        <th>Demande spéciale</th>
                        <th>Date de création</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['id']); ?></td>
                            <td><?php echo htmlspecialchars($event['username']); ?></td>
                            <td><?php echo htmlspecialchars($event['phone']); ?></td>
                            <td><?php echo htmlspecialchars($event['date']); ?></td>
                            <td><?php echo htmlspecialchars($event['time']); ?></td>
                            <td><?php echo htmlspecialchars($event['guests']); ?></td>
                            <td><?php echo htmlspecialchars($event['event_type']); ?></td>
                            <td><?php echo htmlspecialchars($event['special_request']); ?></td>
                            <td><?php echo htmlspecialchars($event['created_at']); ?></td>
                            <td>
                                <a href="delete_event.php?id=<?php echo $event['id']; ?>" class="btn btn-danger btn-sm">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun événement trouvé.</p>
        <?php endif; ?>
    </div>
</body>

<?php include ("footer.php") ?>
<br><br><br>
</html>
