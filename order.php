
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

    // Vérifier si le menu est déjà dans le panier
    $stmt = $pdo->prepare('SELECT id, quantity FROM order_items WHERE order_id = ? AND menu_id = ?');
    $stmt->execute([$order_id, $menu_id]);
    $order_item = $stmt->fetch();
    
    if ($order_item) {
        // Mettre à jour la quantité existante
        $new_quantity = $order_item['quantity'] + $quantity;
        $stmt = $pdo->prepare('UPDATE order_items SET quantity = ? WHERE id = ?');
        $stmt->execute([$new_quantity, $order_item['id']]);
    } else {
        // Récupérer le prix du menu
        $stmt = $pdo->prepare('SELECT price FROM menus WHERE id = ?');
        $stmt->execute([$menu_id]);
        $menu = $stmt->fetch();
        
        // Ajouter l'article de commande
        $stmt = $pdo->prepare('INSERT INTO order_items (order_id, menu_id, quantity, price) VALUES (?, ?, ?, ?)');
        $stmt->execute([$order_id, $menu_id, $quantity, $menu['price'] * $quantity]);
    }

    echo "<script>alert('Menu ajouté au panier !');</script>";
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande</title>
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
        .menu-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
            margin-top: 20px;
        }
        .menu-item {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            width: 250px;
            position: relative;
            background-color: #fff;
        }
        .menu-item:hover {
            transform: scale(1.05);
        }
        .menu-item img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            margin-bottom: 10px;
        }
        .menu-item .menu-details h2 {
            margin-bottom: 5px;
            font-size: 1.2rem;
        }
        .menu-item .menu-details p {
            margin-bottom: 5px;
        }
        .menu-item .view-more {
            margin-top: 10px;
        }
        .popup {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 60px;
        }
        .popup-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
            text-align: center;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        </style>

<?php include("header.php") ?>

</head>
<body>
    <!-- Title Page -->
        <section class="bg-title-page flex-c-m p-t-160 p-b-80 p-l-15 p-r-15" style="background-image: url(images/order.png);">
            <h2 class="txt1 t-center" style="font-style:italic;font-weight:bold;">
                <span style="font-style:italic;font-weight:bold;">Commande</span>	
            </h2>
        </section>

<div style="margin: 30px;">
    <br><br>
    <h3 class="txt1 t-center" style="font-style:italic;font-weight:bold; color:black;">
		    Passez <span style="font-style:italic;font-weight:bold;"><span style="color:#084709;">votre</span> <span style="color:#d61c22">commande </span>ici !</span>	
	</h3>
    <br><br>
    <!-- Barre de recherche -->
    <form method="GET" class="search-container form-inline justify-content-center mb-4">
        <label for="search" class="mr-2 font-weight-bold">Recherche de menu:</label>
        <input type="text" id="search" name="search" class="form-control mr-2" placeholder="Nom du menu">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <!-- Affichage des menus avec formulaire d'ajout au panier -->
    <div class="menu-container">
        <?php
        // Recherche de menus si un terme de recherche est soumis
        $menus = [];
        if (isset($_GET['search'])) {
            $search_term = '%' . $_GET['search'] . '%';
            $stmt = $pdo->prepare('SELECT * FROM menus WHERE name LIKE ?');
            $stmt->execute([$search_term]);
            $menus = $stmt->fetchAll();
        } else {
            $stmt = $pdo->query('SELECT * FROM menus');
            $menus = $stmt->fetchAll();
        }

        // Afficher chaque menu
        foreach ($menus as $menu) {
            echo "<div class='menu-item'>";
            if (isset($menu['image_url'])) {
                echo "<img src='{$menu['image_url']}' alt='{$menu['name']}'>";
            }
            echo "<div class='menu-details'>";
            echo "<h2>{$menu['name']}</h2>";
            echo "<p>{$menu['description']}</p>";
            echo "<p><strong>{$menu['price']} FCFA</strong></p>";
            echo "<button class='btn btn-info view-more' onclick='showPopup(\"{$menu['name']}\", \"{$menu['description']}\", \"{$menu['price']}\", \"{$menu['image_url']}\", {$menu['id']})'>Voir Plus</button>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>

    <!-- Popup pour ajouter au panier -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="hidePopup()">&times;</span>
            <h2 id="popup-title"></h2>
            <img id="popup-image" src="" alt="" style="max-width: 100%; height: auto; border-radius: 6px;">
            <p id="popup-description"></p>
            <p id="popup-price"></p>
            <form method="POST">
                <input type="hidden" id="popup-menu-id" name="menu_id" value="">
                <div class="form-group">
                    <label for="quantity">Quantité:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Ajouter au Panier</button>
            </form>
        </div>
    </div>

</div>

    <script>
        function showPopup(name, description, price, imageUrl, menuId) {
            document.getElementById('popup-title').innerText = name;
            document.getElementById('popup-description').innerText = description;
            document.getElementById('popup-price').innerText = price + ' FCFA';
            document.getElementById('popup-image').src = imageUrl;
            document.getElementById('popup-menu-id').value = menuId;
            document.getElementById('popup').style.display = 'block';
        }

        function hidePopup() {
            document.getElementById('popup').style.display = 'none';
        }
    </script>
</body>
<br><br><br>
</html>

<?php include("footer.php") ?>
