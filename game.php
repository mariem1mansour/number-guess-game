<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
//Vérifie si la requête est de type POST:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //Récupère l'action que l'utilisateur souhaite effectuer (ex. "start", "guess", ou "reveal")
    $action = $_POST['action'] ?? null; //Si action n'est pas définie, sa valeur sera null

    if ($action === 'start') {
        $guess_limit = (int)($_POST['guess_limit'] ?? 4);
        $guess_limit = max(4, $guess_limit); // Ensure at least 4 guesses

        $_SESSION['target_number'] = rand(1, 100);
        $_SESSION['remaining_guesses'] = $guess_limit; //Stocke le nombre de suppositions restantes
        $_SESSION['guesses'] = [];// Initialise une liste vide pour enregistrer les suppositions de l'utilisateur

        echo json_encode(['message' => "New round started! Guess a number between 1 and 100. You have $guess_limit guesses."]);
        exit();
    }

    if ($action === 'guess') {
        $guess = (int)($_POST['guess'] ?? 0);

        if (!isset($_SESSION['target_number']) || $_SESSION['remaining_guesses'] <= 0) {
            echo json_encode(['message' => "Please start a new round first."]);
            exit();
        }

        $_SESSION['guesses'][] = $guess;//La supposition est ajoutée à la liste $_SESSION['guesses']
        $_SESSION['remaining_guesses']--;//Le nombre de suppositions restantes est décrémenté
//Success :
        if ($guess == $_SESSION['target_number']) {
          //Sauvegarde le résultat dans la table rounds de la base de données
            $stmt = $pdo->prepare("INSERT INTO rounds (user_id, username, status, target_number, num_guesses) VALUES (?, ?, 'Success', ?, ?)");
            $stmt->execute([$user_id, $username, $_SESSION['target_number'], count($_SESSION['guesses'])]);

            echo json_encode(['message' => "Congratulations! You guessed the number correctly.", 'status' => 'Success', 'target_number' => $_SESSION['target_number']]);
            session_unset();//Termine la session
            exit();
//L’utilisateur a épuisé toutes ses suppositions            
        } elseif ($_SESSION['remaining_guesses'] == 0) {
            $stmt = $pdo->prepare("INSERT INTO rounds (user_id, username, status, target_number, num_guesses) VALUES (?, ?, 'Fail', ?, ?)");
            $stmt->execute([$user_id, $username, $_SESSION['target_number'], count($_SESSION['guesses'])]);

            echo json_encode(['message' => "Game over! The correct number was {$_SESSION['target_number']}.", 'status' => 'Fail', 'target_number' => $_SESSION['target_number']]);
            session_unset();
            exit();
//L’utilisateur n’a pas encore trouvé le nombre          
        } else {
            $feedback = $guess < $_SESSION['target_number'] ? "Higher than $guess" : "Lower than $guess";
            echo json_encode([
                'message' => $feedback,
                'remaining_guesses' => $_SESSION['remaining_guesses'],
                'guesses' => $_SESSION['guesses']
            ]);
            exit();
        }
    }

    if ($action === 'reveal') {
        echo json_encode(['message' => "The correct number was {$_SESSION['target_number']}."]);
        session_unset();
        exit();
    }
}
?>
