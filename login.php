
<?php
include 'db.php';
session_start(); // Démarrer la session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Préparer la requête pour récupérer l'utilisateur
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Vérifier le mot de passe
    if ($user && password_verify($password, $user['password'])) {
        // Définir les variables de session pour indiquer que l'utilisateur est connecté
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        // Rediriger vers la page d'accueil ou une page indiquant que la connexion est réussie
        header('Location: welcome.php');
        exit();
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 50px;
        }
        .card {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
    <?php include("header.php") ?>    
</head>

<!-- Title Page -->
<section class="bg-title-page flex-c-m p-t-160 p-b-80 p-l-15 p-r-15" style="background-image: url(images/login0.png);">
        <h2 class="txt1 t-center">
        <span style="font-style:italic;font-weight:bold;"><span style="color:#084709;">Connectez</span>-<span style="color:#d61c22">vous</span></span>	
        </h2>
</section>

<body class="body">
    <br><br><br>
    <div class="card">
        <h2 class="text-center mb-4">Connexion</h2>

        <!-- Formulaire de connexion -->
        <form method="POST">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>
        <div class="text-center mt-3">
            <a href="registrer.php">Pas encore inscrit ? Créer un compte</a>
        </div>
    </div>
    <br><br><br>
</body>
</html>

<?php include("footer.php") ?>