<?php
session_start();
include 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: login.php");
    exit();
}
?>

<?php
// Traitement du formulaire d'ajout au panier
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];

    // Récupérer le prix du menu
    $stmt = $pdo->prepare('SELECT price FROM menus WHERE id = ?');
    $stmt->execute([$menu_id]);
    $menu = $stmt->fetch();

    // Calculer le prix total de la commande
    $total_price = $menu['price'] * $quantity;

    // Insérer la commande dans la table orders
    $stmt = $pdo->prepare('INSERT INTO orders (user_id, menu_id, total_price, status) VALUES (?, ?, ?, "pending")');
    $stmt->execute([$user_id, $menu_id, $total_price]);

    // Récupérer l'ID de la commande insérée
    $order_id = $pdo->lastInsertId();

    // Insérer l'article de commande dans la table order_items
    $stmt = $pdo->prepare('INSERT INTO order_items (order_id, menu_id, quantity, price) VALUES (?, ?, ?, ?)');
    $stmt->execute([$order_id, $menu_id, $quantity, $menu['price']]);

    echo "<script>alert('Menu ajouté au panier !');</script>";
}
?>

<?php include("header.php") ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Ajoutez ici d'autres styles CSS si nécessaire -->
</head>
<body>
    <!-- Votre contenu HTML et le formulaire d'ajout au panier -->
</body>
</html>

<?php include("footer.php") ?>
