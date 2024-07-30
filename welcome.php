

<?php
session_start(); // Démarrer la session

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Autres styles CSS personnalisés -->

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            text-align: center;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .btn-container .btn {
            margin: 0 10px;
        }
    </style>
    <?php include("header.php") ?>
</head>

	<!-- Title Page -->
	<section class="bg-title-page flex-c-m p-t-160 p-b-80 p-l-15 p-r-15" style="background-image: url(images/welcom.jpg);">
		<h2 class="txt1 t-center">
		    Le Menu des <span style="font-style:italic;font-weight:bold;"><span style="color:#084709;">5</span> <span style="color:#d61c22">épices</span></span>	
		</h2>
	</section>

<body>
    <br><br><br><br><br>
    <div class="container">
        <h1 class="mt-5">Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Qu'aimeriez-vous faire aujourd'hui?</p>
        <div class="btn-container">
            <a href="order.php" class="btn btn-primary">Commander</a>
            <a href="reserve_table.php" class="btn btn-success">Réserver une table</a>
            <a href="reserve_event.php" class="btn btn-warning">Réserver un événement</a>
        </div>
        <div class="btn-container mt-3">
            <!-- <a href="account_settings.php" class="btn btn-info">Paramètres du compte</a> -->
            <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
        </div>
        <div class="mt-5">
            <p>Contactez-nous pour toute assistance ou information supplémentaire.</p>
            <p>Téléphone: +123456789</p>
            <p>Email: contact@5epices.com</p>
        </div>
    </div>
    <!-- Scripts JS, Bootstrap, etc. -->
</body>
</html>
<?php include("footer.php") ?>
