<<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $presentation = $_POST["presentation"];
    

    // Créer une ligne CSV avec les données
    $csvData = array(
        $nom,
        $prenom,
        $email,
        $presentation,
    );
    $csvLine = implode(",", $csvData);

    // Écrire la ligne CSV dans un fichier
    $file = fopen("dataReferent.csv", "a"); // "a" pour ajouter les données à un fichier existant
    fwrite($file, $csvLine . "\n");
    fclose($file);

    // Redirection vers connexion.html
    header("Location: index2.html");
    exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
}
?>