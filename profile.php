<?php
session_start();
require 'db.php';
//Vérifie si un utilisateur est connecté en s'assurant que son nom d'utilisateur est stocké dans la session:
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
//Récupération des données de session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch game history
$stmt = $pdo->prepare('SELECT * FROM rounds WHERE user_id = ? ORDER BY date DESC');
$stmt->execute([$user_id]);
$history = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guessing Game | Profile</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Welcome, <?= htmlspecialchars($username) ?>!</h1>

    <div class="d-flex justify-content-between mt-4">
        <button id="start-new-round" class="btn btn-primary">Start New Round</button>
        <button id="reveal-number" class="btn btn-danger">Reveal Number</button>
    </div>

    <div id="game-area" class="mt-4">
        <h2>Guess the Number</h2>
        <form id="guess-form" class="d-flex">
            <input type="number" id="guess-input" class="form-control me-2" placeholder="Enter your guess (1-100)" min="1" max="100">
            <button type="submit" class="btn btn-success">Submit Guess</button>
        </form>
        <p id="feedback" class="mt-3"></p>
    </div>

    <h2 class="mt-5">Game History</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Date</th>
            <th>Status</th>
            <th>Target Number</th>
            <th>Guesses Used</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($history as $round): ?>
            <tr>
                <td><?= htmlspecialchars($round['date']) ?></td>
                <td><?= htmlspecialchars($round['status']) ?></td>
                <td><?= htmlspecialchars($round['target_number']) ?></td>
                <td><?= htmlspecialchars($round['num_guesses']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center align-items-center mb-1">
  <!-- Logout Button -->
    <a href="logout.php" class="btn btn-danger">
       Logout
    </a>
</div>
<script src="assets/js/game.js"></script>
</body>
</html>



