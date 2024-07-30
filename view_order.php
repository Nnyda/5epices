<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

include 'db.php';

$order_id = $_GET['id'];

$stmt = $pdo->prepare('
    SELECT 
        o.id AS order_id, 
        u.username, 
        u.phone, 
        o.total_price, 
        o.status, 
        o.created_at,
        oi.menu_id, 
        oi.quantity, 
        oi.price,
        m.name AS menu_name
    FROM orders o
    JOIN users u ON o.user_id = u.id
    LEFT JOIN order_items oi ON o.id = oi.order_id
    LEFT JOIN menus m ON oi.menu_id = m.id
    WHERE o.id = ?
');
$stmt->execute([$order_id]);
$order = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commande #<?= $order_id ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<?php include("header.php"); ?>

<body>
    <br><br><br><br><br>

    <div class="container">
        <h1 class="mt-5">Détails de la Commande #<?= $order_id ?></h1>
        <p><strong>Utilisateur:</strong> <?= htmlspecialchars($order[0]['username']) ?></p>
        <p><strong>Téléphone:</strong> <?= htmlspecialchars($order[0]['phone']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($order[0]['status']) ?></p>
        <p><strong>Date et Heure:</strong> <?= $order[0]['created_at'] ?></p>
        <p><strong>Prix Total:</strong> <?= $order[0]['total_price'] ?></p>
        <h2>Détails des articles</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom de l'article</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Prix Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['menu_name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= $item['price'] ?></td>
                        <td><?= $item['quantity'] * $item['price'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="manage_orders.php" class="btn btn-primary">Retour</a>
    </div>
</body>
<br><br><br>
<?php include("footer.php"); ?>
</html>
