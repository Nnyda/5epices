<?php
session_start();
include 'db.php';

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['admin_id'])) {
    // Si l'utilisateur n'est pas connecté en tant qu'administrateur, rediriger vers la page de connexion
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Commandes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            vertical-align: middle !important;
        }
        .table thead th {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }
        .btn-view {
            padding: 5px 10px;
            font-size: 14px;
        }
    </style>
    <?php include ("header.php") ?>
</head>
<body>
    <br><br><br><br><br>
    <div class="container">
        <h1 class="text-center mt-3 mb-4">Gérer les Commandes</h1>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Utilisateur</th>
                        <th scope="col">Date de Commande</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Total</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Récupérer les commandes et les articles de commande
                    $stmt = $pdo->query('
                        SELECT 
                            o.id AS order_id, 
                            o.user_id, 
                            o.total_price, 
                            o.status, 
                            o.created_at, 
                            u.username AS user_name
                        FROM 
                            orders o
                        JOIN 
                            users u ON o.user_id = u.id
                        ORDER BY 
                            o.created_at DESC
                    ');
                    $orders = $stmt->fetchAll();

                    foreach ($orders as $index => $order) {
                        echo "<tr>";
                        echo "<td>" . ($index + 1) . "</td>";
                        echo "<td>{$order['user_name']} (ID: {$order['user_id']})</td>";
                        echo "<td>{$order['created_at']}</td>";
                        echo "<td>{$order['status']}</td>";
                        echo "<td>{$order['total_price']} FCFA</td>";
                        echo "<td><a href='view_order.php?id={$order['order_id']}' class='btn btn-primary btn-view'>Voir Détails</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<br><br><br>
<?php include ("footer.php") ?>
</html>
