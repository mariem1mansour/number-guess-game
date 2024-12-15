<?php
//Inclut le fichier db.php, qui contient le code pour se connecter à la base de données via PDO.
require 'db.php';
// la méthode HTTP utilisée pour accéder à la page = post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//Récupère les valeurs des champs du formulaire soumis,trim() : Supprime les espaces inutiles au début et à la fin 
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if ($username && $password) {
      //Vérification de l'existence de l'utilisateur
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        //Gestion des cas où l'utilisateur existe déjà
        if ($stmt->rowCount() > 0) {
            $error = "Username already exists!";
        } else {
          //Enregistrement du nouvel utilisateur
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT); //utilisant l'algorithme bcrypt pour le sécuriser avant de le stockage
            $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
            $stmt->execute([$username, $hashedPassword]);
            header('Location: login.php'); // Redirige l'utilisateur vers la page de connexion après l'enregistrement
            exit();
        }
    } else {
        $error = "All fields are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Register</h1>
        <!-- Vérifie si une erreur a été définie dans le code PHP -->
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
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>
</html>
