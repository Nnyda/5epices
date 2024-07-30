<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver un Événement</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .reservation-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="reservation-container">
        <h1>Réserver un Événement</h1>
        <form action="process_event_reservation.php" method="POST">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Heure</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>
            <div class="form-group">
                <label for="guests">Nombre d'invités</label>
                <input type="number" class="form-control" id="guests" name="guests" required>
            </div>
            <div class="form-group">
                <label for="event_type">Type d'Événement</label>
                <input type="text" class="form-control" id="event_type" name="event_type" required>
            </div>
            <div class="form-group">
                <label for="special_request">Demande Spéciale</label>
                <textarea class="form-control" id="special_request" name="special_request"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Réserver</button>
        </form>
    </div>
</body>
</html>
