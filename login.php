<?php
require 'db.php';
session_start();//Démarre une session PHP, ce qui permet de stocker des données utilisateur dans la variable globale $_SESSION 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $stmt = $pdo->prepare('SELECT id, password FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();//Récupère la première ligne du résultat et la stocke dans $user  //Si aucun utilisateur correspondant n'est trouvé, $user sera false
  
    if ($user && password_verify($password, $user['password'])) {
// Stocke l'ID de l'utilisateur et son nom d'utilisateur dans la session, ce qui permet de l'identifier sur d'autres pages      
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        header('Location: profile.php');
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Login</h1>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
