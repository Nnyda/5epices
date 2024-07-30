<?php
include 'db.php';

$stmt = $pdo->query('SELECT * FROM menus');
$menus = $stmt->fetchAll();
?>

<!-- Affichage des menus -->
<h2>Nos Menus</h2>
<ul>
    <?php foreach ($menus as $menu): ?>
        <li>
            <strong><?php echo htmlspecialchars($menu['name']); ?></strong>
            <p><?php echo htmlspecialchars($menu['description']); ?></p>
            <span>Prix : <?php echo number_format($menu['price'], 2); ?> FCFA</span>
            <form method="POST" action="order.php">
                <input type="hidden" name="menu_id" value="<?php echo $menu['id']; ?>">
                <input type="number" name="quantity" value="1" min="1" required>
                <button type="submit">Ajouter au Panier</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
