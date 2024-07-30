<?php
session_start();
include 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger l'utilisateur vers la page de connexion si nécessaire
    header("Location: login.php");
    exit();
}

// Gérer l'ajout au panier
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];

    // Vérifier si le menu est déjà dans le panier de l'utilisateur
    $stmt = $pdo->prepare('SELECT * FROM cart WHERE user_id = ? AND menu_id = ?');
    $stmt->execute([$user_id, $menu_id]);
    $cart_item = $stmt->fetch();

    if ($cart_item) {
        // Si le menu est déjà dans le panier, mettre à jour la quantité
        $new_quantity = $cart_item['quantity'] + $quantity;
        $stmt = $pdo->prepare('UPDATE cart SET quantity = ? WHERE user_id = ? AND menu_id = ?');
        $stmt->execute([$new_quantity, $user_id, $menu_id]);
    } else {
        // Sinon, ajouter le menu au panier avec la quantité spécifiée
        $stmt = $pdo->prepare('INSERT INTO cart (user_id, menu_id, quantity) VALUES (?, ?, ?)');
        $stmt->execute([$user_id, $menu_id, $quantity]);
    }

    // Rediriger l'utilisateur vers la page des commandes après l'ajout au panier
    header("Location: orders.php");
    exit();
}

// Gérer le vidage du panier
if (isset($_GET['clear_cart'])) {
    $user_id = $_SESSION['user_id'];

    // Supprimer tous les articles du panier pour l'utilisateur connecté
    $stmt = $pdo->prepare('DELETE FROM cart WHERE user_id = ?');
    $stmt->execute([$user_id]);

    // Rediriger l'utilisateur vers la page des commandes après le vidage du panier
    header("Location: orders.php");
    exit();
}

// Gérer la suppression d'un article spécifique du panier
if (isset($_GET['remove_item'])) {
    $user_id = $_SESSION['user_id'];
    $menu_id = $_GET['remove_item'];

    // Supprimer l'article spécifié du panier
    $stmt = $pdo->prepare('DELETE FROM cart WHERE user_id = ? AND menu_id = ?');
    $stmt->execute([$user_id, $menu_id]);

    // Rediriger l'utilisateur vers la page des commandes après la suppression de l'article
    header("Location: orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenu du Panier</title>
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
        .cart-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item img {
            max-width: 100px;
            border-radius: 6px;
        }
        .cart-item .item-details {
            flex-grow: 1;
            margin-left: 10px;
        }
        .cart-item .item-details h5 {
            margin: 0;
        }
        .cart-item .item-details p {
            margin: 5px 0;
        }
        .cart-item .remove-item {
            margin-left: 10px;
        }
        .total-price {
            text-align: right;
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Votre Panier</h1>
    <div class="cart-container">
        <?php
        include 'db.php';

        // Récupérer les articles de la commande en cours
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare('SELECT menus.id AS menu_id, menus.name, menus.image_url, SUM(cart.quantity) AS quantity, menus.price * SUM(cart.quantity) AS price
                               FROM cart
                               JOIN menus ON cart.menu_id = menus.id
                               WHERE cart.user_id = ?
                               GROUP BY cart.menu_id');
        $stmt->execute([$user_id]);
        $cart_items = $stmt->fetchAll();

        if (count($cart_items) > 0) {
            $total_price = 0;
            foreach ($cart_items as $item) {
                echo "<div class='cart-item'>";
                echo "<img src='{$item['image_url']}' alt='{$item['name']}'>";
                echo "<div class='item-details'>";
                echo "<h5>{$item['name']}</h5>";
                echo "<p>Quantité: {$item['quantity']}</p>";
                echo "<p>Prix unitaire: " . ($item['price'] / $item['quantity']) . " FCFA</p>";
                echo "</div>";
                echo "<div><strong>Total: " . $item['price'] . " FCFA</strong></div>";
                echo "<a href='orders.php?remove_item={$item['menu_id']}' class='btn btn-danger remove-item'>Retirer</a>";
                echo "</div>";
                $total_price += $item['price'];
            }
            echo "<div class='total-price'>Total: {$total_price} FCFA</div>";
        } else {
            echo "<p>Votre panier est vide.</p>";
        }
        ?>
    </div>

    <a href="orders.php?clear_cart=true" class="btn btn-danger">Vider le Panier</a>

</body>
</html>
