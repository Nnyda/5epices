<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérifier que les mots de passe correspondent
    if ($password != $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Hacher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Connexion à la base de données
        $conn = new mysqli("localhost", "root", "", "les_5_epices");

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Préparer et exécuter la requête
        $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password, role, created_at) VALUES (?, ?, ?, ?, ?, ?)");
        $role = 'user'; // Définir le rôle par défaut
        $created_at = date('Y-m-d H:i:s'); // Définir la date de création actuelle
        $stmt->bind_param("ssssss", $username, $email, $phone, $hashed_password, $role, $created_at);

        if ($stmt->execute()) {
            $success = "Compte créé avec succès.";
        } else {
            $error = "Erreur: " . $stmt->error;
        }

        // Fermer la connexion
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Les 5 Épices</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .form-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .form-container .form {
            width: 60%;
            padding-right: 20px;
        }
        .form-container .photo {
            width: 35%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Créer un compte</h2>
        <?php
        if (!empty($error)) {
            echo '<div class="alert alert-danger">' . $error . '</div>';
        }
        if (!empty($success)) {
            echo '<div class="alert alert-success">' . $success . '</div>';
        }
        ?>

        <div class="form-container row">
            <div class="col-md-7">
                <form action="registrer.php" method="post" class="form">
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Numéro de téléphone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                    <span id="password-toggle" class="fa fa-eye-slash"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmer le mot de passe</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                    <span id="confirm-password-toggle" class="fa fa-eye-slash"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Créer un compte</button>
                </form>
            </div>
            <div class="col-md-5">
                <img src="images/register.jpg" alt="Photo d'inscription" class="img-fluid">
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function togglePassword(fieldId) {
            var field = document.getElementById(fieldId);
            var toggleIcon = document.getElementById(fieldId + '-toggle');
            if (field.type === "password") {
                field.type = "text";
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                field.type = "password";
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>
</html>
