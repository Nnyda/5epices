<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];

    $stmt = $pdo->prepare('INSERT INTO menus (name, description, price, category, image_url) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$name, $description, $price, $category, $image_url]);

    echo "Menu ajouté avec succès !";
}
?>

<!-- Formulaire pour ajouter des menus -->
<form method="POST">
    <input type="text" name="name" placeholder="Nom du plat" required>
    <textarea name="description" placeholder="Description du plat" required></textarea>
    <input type="number" step="0.01" name="price" placeholder="Prix" required>
    <input type="text" name="category" placeholder="Catégorie" required>
    <input type="text" name="image_url" placeholder="URL de l'image" required>
    <button type="submit">Ajouter</button>
</form>
