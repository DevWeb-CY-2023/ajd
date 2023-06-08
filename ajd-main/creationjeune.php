<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $mdp = $_POST["mdp"];
    $anniv = $_POST["birthday"];
    $email = $_POST["email"];
    $reseauSocial = $_POST["reseauSocial"];
    $centreInteret = $_POST["centreInteret"];
    $engagement = $_POST["engagement"];
    $duree = $_POST["duree"];

    // Récupérer les choix des savoirs-être
    $savoirsEtre = array();
    for ($i = 1; $i <= 10; $i++) {
        if (isset($_POST["choix" . $i])) {
            $savoirsEtre[] = $_POST["choix" . $i];
        }
    }

    // Créer une ligne CSV avec les données
    $csvData = array(
        $nom,
        $prenom,
        $mdp,
        $anniv,
        $email,
        $reseauSocial,
        $centreInteret,
        $engagement,
        $duree,
        implode(", ", $savoirsEtre) // Ajouter les choix des savoirs-être séparés par une virgule
    );
    $csvLine = implode(",", $csvData);

    // Écrire la ligne CSV dans un fichier
    $file = fopen("dataJeune.csv", "a"); // "a" pour ajouter les données à un fichier existant
    fwrite($file, $csvLine . "\n");
    fclose($file);

    // Redirection vers connexion.html
    header("Location: connexion.html");
    exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
}
?>
