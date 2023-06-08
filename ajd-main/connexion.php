<?php
session_start(); // Démarre la session pour utiliser les variables de session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST["email"];
    $mdp = $_POST["mdp"];

    // Lire le fichier CSV contenant les données des utilisateurs
    $usersFile = fopen("dataJeune.csv", "r");
    $isAuthenticated = false;
    $userData = array();

    while (($row = fgetcsv($usersFile)) !== false) {
        // Vérifier si les données d'identification correspondent à un utilisateur
        if ($row[4] === $email && $row[2] === $mdp) {
            $isAuthenticated = true;
            $userData = $row;
            break;
        }
    }

    fclose($usersFile);

    if ($isAuthenticated) {
        // Stocker les informations de l'utilisateur dans des variables de session
        $_SESSION['nom'] = $userData[0];
        $_SESSION['prenom'] = $userData[1];
        // Ajoutez ici d'autres informations que vous souhaitez stocker

        // Redirection vers la page de succès
        header("Location: accueiljeune.php");
        exit();
    } else {
        // Redirection vers la page d'erreur
        header("Location: error.html");
        exit();
    }
} else {
    // Redirection vers la page de connexion
    header("Location: connexion.html");
    exit();
}
?>
