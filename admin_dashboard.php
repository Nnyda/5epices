

<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .logout {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>

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
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Bienvenue, Administrateur!</h5>
                <p class="card-text">Utilisez les liens de navigation pour gérer les différentes sections du site.</p>
            </div>
        </div>
    </div>
</body>
<br><br><br>

<?php include ("footer.php") ?>

</html>
