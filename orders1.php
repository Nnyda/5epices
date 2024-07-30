<?php
session_start();
include 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Traitement du formulaire d'ajout au panier
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['menu_id'])) {
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];

    // Vérifier si l'utilisateur a déjà une commande en cours
    $stmt = $pdo->prepare('SELECT id FROM orders WHERE user_id = ? AND status = "pending"');
    $stmt->execute([$user_id]);
    $order = $stmt->fetch();

    if (!$order) {
        // Créer une nouvelle commande si aucune commande en cours n'est trouvée
        $stmt = $pdo->prepare('INSERT INTO orders (user_id, status) VALUES (?, "pending")');
        $stmt->execute([$user_id]);
        $order_id = $pdo->lastInsertId();
    } else {
        // Utiliser l'ID de la commande existante
        $order_id = $order['id'];
    }

    // Vérifier si l'article est déjà dans le panier
    $stmt = $pdo->prepare('SELECT * FROM order_items WHERE order_id = ? AND menu_id = ?');
    $stmt->execute([$order_id, $menu_id]);
    $order_item = $stmt->fetch();

    if ($order_item) {
        // Mettre à jour la quantité de l'article existant
        $new_quantity = $order_item['quantity'] + $quantity;
        $stmt = $pdo->prepare('UPDATE order_items SET quantity = ? WHERE order_id = ? AND menu_id = ?');
        $stmt->execute([$new_quantity, $order_id, $menu_id]);
    } else {
        // Ajouter l'article de commande
        $stmt = $pdo->prepare('INSERT INTO order_items (order_id, menu_id, quantity, price) VALUES (?, ?, ?, (SELECT price FROM menus WHERE id = ?))');
        $stmt->execute([$order_id, $menu_id, $quantity, $menu_id]);
    }

    echo "<script>alert('Menu ajouté au panier !');</script>";
}

// Supprimer un article du panier
if (isset($_GET['remove_menu'])) {
    $menu_id = $_GET['remove_menu'];

    // Vérifier si l'utilisateur a une commande en cours
    $stmt = $pdo->prepare('SELECT id FROM orders WHERE user_id = ? AND status = "pending"');
    $stmt->execute([$user_id]);
    $order = $stmt->fetch();

    if ($order) {
        // Supprimer l'article de commande
        $stmt = $pdo->prepare('DELETE FROM order_items WHERE order_id = ? AND menu_id = ?');
        $stmt->execute([$order['id'], $menu_id]);
        echo "<script>alert('Menu retiré du panier !'); window.location.href='orders.php';</script>";
    }
}

// Affichage des éléments du panier
$stmt = $pdo->prepare('SELECT menus.id AS menu_id, menus.name, menus.image_url, order_items.quantity, menus.price
                       FROM order_items
                       JOIN menus ON order_items.menu_id = menus.id
                       JOIN orders ON order_items.order_id = orders.id
                       WHERE orders.user_id = ? AND orders.status = "pending"');
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();

// Grouper les éléments du panier par menu_id
$grouped_cart_items = [];
foreach ($cart_items as $item) {
    $menu_id = $item['menu_id'];
    if (!isset($grouped_cart_items[$menu_id])) {
        $grouped_cart_items[$menu_id] = $item;
    } else {
        $grouped_cart_items[$menu_id]['quantity'] += $item['quantity'];
    }
}
$cart_items = array_values($grouped_cart_items);
?>

<?php include("header.php") ?>

<!-- <!DOCTYPE html>
<html lang="fr">
<head> -->
    <!-- Métadonnées, liens CSS, etc. -->
<!-- </head>
<body> -->
    <!-- Contenu HTML avec affichage du panier -->
<!-- </body>
</html> -->


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
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .cart-item {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            width: 80%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background-color: #fff;
        }
        .cart-item:hover {
            transform: scale(1.02);
        }
        .cart-item img {
            max-width: 100px;
            height: auto;
            border-radius: 6px;
            margin-right: 10px;
        }
        .item-details {
            flex-grow: 1;
        }
        .total-price {
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 20px;
        }
        .btn-danger {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <br><br><br><br><br><br>
    <h1>Votre Panier</h1>
    <div class="cart-container">
        <?php
        if (count($cart_items) > 0) {
            $total_price = 0;
            foreach ($cart_items as $item) {
                echo "<div class='cart-item'>";
                if (isset($item['image_url'])) {
                    echo "<img src='{$item['image_url']}' alt='{$item['name']}' class='img-fluid'>";
                }
                echo "<div class='item-details'>";
                echo "<h5>{$item['name']}</h5>";
                echo "<p>Quantité: {$item['quantity']}</p>";
                echo "<p>Prix unitaire: {$item['price']} FCFA</p>";
                echo "</div>";
                echo "<div><strong>Total: " . ($item['price'] * $item['quantity']) . " FCFA</strong></div>";
                echo "<a href='orders.php?remove_menu={$item['menu_id']}' class='btn btn-danger'>Retirer</a>";
                echo "</div>";
                $total_price += ($item['price'] * $item['quantity']);
            }
            echo "<div class='total-price'>Total: {$total_price} FCFA</div>";
        } else {
            echo "<p>Votre panier est vide.</p>";
        }
        ?>
    </div>
</body>
<br><br><br>
<?php include("footer.php") ?>

</html>
