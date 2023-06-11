<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'adresse e-mail du formulaire
    $email = $_POST["email"];

    // Vérifier si l'adresse e-mail existe déjà dans les données dataJeune.csv
    $dataJeune = file("dataJeune.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($dataJeune as $line) {
        $info = explode(",", $line);
        if ($info[5] == $email) {
            // Adresse e-mail déjà utilisée, afficher un message d'erreur
            echo "Cette adresse mail est déjà utilisée. Veuillez en utiliser une autre.";
            exit(); // Terminer le script
        }
    }

    // Générer un identifiant unique pour le jeune
    $jeuneId = uniqid();

    // Récupérer les autres données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $mdp = $_POST["mdp"];
    $anniv = $_POST["birthday"];
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

    // Récupérer l'ID du référent associé
    $referentId = $_POST["referent_id"];

    // Créer une ligne CSV avec les données
    $csvData = array(
        $jeuneId,
        $nom,
        $prenom,
        $mdp,
        $anniv,
        $email,
        $reseauSocial,
        $centreInteret,
        $engagement,
        $duree,
        implode(", ", $savoirsEtre),
        $referentId // Ajouter l'ID du référent associé
    );
    $csvLine = implode(",", $csvData);

    // Écrire la ligne CSV dans un fichier
    $file = fopen("dataJeune.csv", "a"); // "a" pour ajouter les données à un fichier existant
    fwrite($file, $csvLine . "\n");
    fclose($file);

    // Redirection vers connexion.html
    header("Location: connexion.html");
    http_response_code(302);
    echo "hello";
}
?>
