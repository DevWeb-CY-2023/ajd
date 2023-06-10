<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion
    header("Location: connexion.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'ID du jeune depuis la session
    $jeuneId = $_SESSION['id'];

    // Récupérer les données du formulaire du référent
    $nomConsultant = $_POST["nom"];
    $prenomConsultant = $_POST["prenom"];
    $emailConsultant = $_POST["email"];

    // Créer une ligne CSV avec les données
    $csvData = array(
        $jeuneId,
        $nomConsultant,
        $prenomConsultant,
        $emailConsultant,
    );
    $csvLine = implode(",", $csvData);

    // Écrire la ligne CSV dans un fichier
    $file = fopen("dataConsultant.csv", "a"); // "a" pour ajouter les données à un fichier existant
    fwrite($file, $csvLine . "\n");
    fclose($file);

    // Redirection vers une autre page
    header("Location: accueiljeune.php");
    exit;
}
?>