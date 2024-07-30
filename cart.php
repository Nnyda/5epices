<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT menus.name, menus.price, order_items.quantity FROM order_items INNER JOIN menus ON order_items.menu_id = menus.id WHERE order_items.order_id = ?');
$stmt->execute([$user_id]);
$items = $stmt->fetchAll();
?>

<!-- Affichage du panier -->
<h2>Votre Panier</h2>
<ul>
    <?php foreach ($items as $item): ?>
        <li>
            <strong><?php echo htmlspecialchars($item['name']); ?></strong>
            <span>Quantité : <?php echo $item['quantity']; ?></span>
            <span>Prix unitaire : <?php echo number_format($item['price'], 2); ?> €</span>
        </li>
    <?php endforeach; ?>
</ul>

<!-- Total du panier -->
<?php
$total = array_reduce($items, function ($acc, $item) {
    return $acc + ($item['price'] * $item['quantity']);
}, 0);
?>
<p>Total : <?php echo number_format($total, 2); ?> €</p>

<!-- Formulaire pour passer la commande -->
<form method="POST" action="place_order.php">
    <button type="submit">Passer la Commande</button>
</form>
