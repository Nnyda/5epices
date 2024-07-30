<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Créer une nouvelle commande
    $stmt = $pdo->prepare('INSERT INTO orders (user_id, total_price) VALUES (?, ?)');
    $stmt->execute([$user_id, $total]);

    // Vider le panier (supprimer les éléments de la table order_items pour cet utilisateur)
    $stmt = $pdo->prepare('DELETE FROM order_items WHERE order_id = ?');
    $stmt->execute([$user_id]);

    echo "Commande passée avec succès !";
} else {
    echo "Erreur lors du traitement de la commande.";
}
?>
