<?php
session_start();
include 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Supprimer un article du panier
if (isset($_POST['remove_item'])) {
    $order_item_id = $_POST['order_item_id'];
    $stmt = $pdo->prepare('DELETE FROM order_items WHERE id = ?');
    $stmt->execute([$order_item_id]);
}

// Valider et passer au paiement
if (isset($_POST['validate_order'])) {
    $order_id = $_POST['order_id'];
    $total_price = $_POST['total_price'];

    // Mettre à jour le statut de la commande
    $stmt = $pdo->prepare('UPDATE orders SET status = "validated", total_price = ? WHERE id = ?');
    $stmt->execute([$total_price, $order_id]);

    // Rediriger vers la page de paiement
    header("Location: payment.php?order_id=$order_id");
    exit();
}

// Récupérer la commande en cours de l'utilisateur
$stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id = ? AND status = "pending"');
$stmt->execute([$user_id]);
$order = $stmt->fetch();

// Récupérer les articles de la commande
$order_items = [];
if ($order) {
    $stmt = $pdo->prepare('SELECT oi.*, m.name, m.price, m.image_url FROM order_items oi JOIN menus m ON oi.menu_id = m.id WHERE oi.order_id = ?');
    $stmt->execute([$order['id']]);
    $order_items = $stmt->fetchAll();
}

// Calculer le prix total de la commande
$total_price = 0;
foreach ($order_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

?>

<?php include("header.php") ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .order-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-item img {
            max-width: 50px;
            height: auto;
            margin-right: 10px;
        }
        .order-item-details {
            flex-grow: 1;
        }
        .order-item-actions {
            display: flex;
            align-items: center;
        }
        .order-item-actions form {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <br><br><br>
    <h1>Mon Panier</h1>
    <div class="order-container">
        <?php if (empty($order_items)): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <?php foreach ($order_items as $item): ?>
                <div class="order-item">
                    <img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>">
                    <div class="order-item-details">
                        <h5><?= $item['name'] ?></h5>
                        <p>Quantité: <?= $item['quantity'] ?></p>
                        <p>Prix: <?= $item['price'] ?> FCFA</p>
                    </div>
                    <div class="order-item-actions">
                        <form method="POST">
                            <input type="hidden" name="order_item_id" value="<?= $item['id'] ?>">
                            <button type="submit" name="remove_item" class="btn btn-danger btn-sm">Retirer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="order-summary">
                <h4>Total: <?= $total_price ?> FCFA</h4>
                <form method="POST">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <input type="hidden" name="total_price" value="<?= $total_price ?>">
                    <button type="submit" name="validate_order" class="btn btn-success btn-lg btn-block">Valider et Payer</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
<br><br><br>
<?php include("footer.php") ?>
</html>
