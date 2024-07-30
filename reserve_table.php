<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<?php include("header.php") ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver une Table</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

	<!-- Title Page -->
	<section class="bg-title-page flex-c-m p-t-160 p-b-80 p-l-15 p-r-15 " style="background-image: url(images/reserve_table.jpg);">
		<h2 class="txt1 t-center" style="font-style:italic;font-weight:bold;">
		    Réservation de table.
		</h2>
	</section>

<body style="">
    <br>
    <div class="container t-center">
        <h1 style="font-style:italic;font-weight:bold;"><span style="font-style:italic;font-weight:bold;">Réserver <span style="color:#084709;">votre</span> <span style="color:#d61c22"> Table</span></span> ici !</h1>
        <br><br>
        <div class="form-container">
            <form method="POST" action="process_reservation.php">
                <div class="row">

                    <div class="form-group col-6">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="phone">Numéro de Téléphone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>

                </div>

                <div class="row"> 
                    <div class="form-group col-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="date">Date de Réservation</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-6">
                        <label for="time">Heure de Réservation</label>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="guests">Nombre de Personnes</label>
                        <input type="number" class="form-control" id="guests" name="guests" min="1" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Réserver</button>
            </form>
        </div>
    </div>
</body>
<br><br><br>

<?php include("footer.php") ?>

</html>
