<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: profile.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number Guess Game</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Welcome to the Number Guess Game!</h1>
        <div class="d-flex justify-content-center mt-4">
            <a href="register.php" class="btn btn-primary mx-2">Register</a>
            <a href="login.php" class="btn btn-secondary mx-2">Login</a>
        </div>
    </div>
</body>
</html>
