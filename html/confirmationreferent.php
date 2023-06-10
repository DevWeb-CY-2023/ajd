<?php
session_start();

// Lire les données du référent à partir de dataReferent.csv
$referentInfo = array();
$isUpdated = false;

$referentFile = fopen("dataReferent.csv", "r");

while (($row = fgetcsv($referentFile)) !== false) {
    if ($row[0] === $_SESSION['nom'] && $row[1] === $_SESSION['prenom']) {
        $referentInfo = $row;
        $isUpdated = true;
        break;
    }
}

fclose($referentFile);

$nomInput = $referentInfo[0];
$prenomInput = $referentInfo[1];
$emailInput = $referentInfo[2];


// Traitement des modifications envoyées par le référent
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données envoyées par le formulaire
    $nomReferent = $_POST["nom_referent"];
    $prenomReferent = $_POST["prenom_referent"];
    $emailReferent = $_POST["email_referent"];

    // Mettre à jour les informations du référent dans le tableau
    $referentInfo[0] = $nomReferent;
    $referentInfo[1] = $prenomReferent;
    $referentInfo[2] = $emailReferent;

    // Enregistrer les modifications dans le fichier dataReferent.csv
    $referentFile = fopen("dataReferent.csv", "r+");
    $tempFile = fopen("dataReferent_temp.csv", "w");

    while (($row = fgetcsv($referentFile)) !== false) {
        if ($row[0] === $_SESSION['nom'] && $row[1] === $_SESSION['prenom']) {
            fputcsv($tempFile, $referentInfo);
        } else {
            fputcsv($tempFile, $row);
        }
    }

    fclose($referentFile);
    fclose($tempFile);

    // Supprimer le fichier dataReferent.csv existant
    unlink("dataReferent.csv");

    // Renommer le fichier temporaire
    rename("dataReferent_temp.csv", "dataReferent.csv");

    // Mettre à jour les données affichées dans le formulaire
    $nomInput = $referentInfo[0];
    $prenomInput = $referentInfo[1];
    $emailInput = $referentInfo[2];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmation Référent</title>
    <link rel="stylesheet" type="text/css" href="style-confirmation-referent.css">
</head>
<body>
<div class="bande">
            <div class="m_header">
                <img src="LOGOS_JEUNES.svg" alt="Your Image"> 
                <div class="text">
                    <h2> Référent </h2>
                    <h3> Je confirme la valeur de ton engagement </h3>
                </div>
            </div>

            <!-- Bande de couleur avec des boutons -->
            <div class="m_buttons m_flex-parent">
                <a href="page3.html" style="color:pink" rel="noreferrer"> JEUNE </a>
                <a href="page6.html" style="color:rgb(147,142,143)" rel="noreferrer"> PARTENAIRES </a>
            </div>
        </div>
    <br> <br>

    <div class="container">
        <div class="left-container">
            <h1>Données du Jeune</h1>
            <?php
            // Récupérer les informations du jeune à partir du fichier dataJeune.csv
            $dataJeune = file("dataJeune.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $lastLine = end($dataJeune);
            $jeuneInfo = explode(",", $lastLine);
            $nomJeune = $jeuneInfo[0];
            $prenomJeune = $jeuneInfo[1];
            $dateNaissanceJeune = $jeuneInfo[3];
            $adresseMailJeune = $jeuneInfo[4];
            $reseauSocialJeune = $jeuneInfo[5];
            $centreInteretJeune = $jeuneInfo[6];
            $engagementJeune = $jeuneInfo[7];
            $dureeJeune = $jeuneInfo[8];
            ?>
            <p>Nom : <?php echo $nomJeune; ?></p>
            <p>Prénom : <?php echo $prenomJeune; ?></p>
            <p>Date de Naissance : <?php echo $dateNaissanceJeune; ?></p>
            <p>Adresse mail : <?php echo $adresseMailJeune; ?></p>
            <p>Réseau social : <?php echo $reseauSocialJeune; ?></p>
            <p>Centre d'intérêt : <?php echo $centreInteretJeune; ?></p>
            <p>Engagement : <?php echo $engagementJeune; ?></p>
            <p>Durée : <?php echo $dureeJeune; ?></p>
        </div>

        <div class="right-container">
            <h1>Données du Référent</h1>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table> 
                <tr> 
                <td> <label for="nom_referent">Nom:</label> </td>
                <td>  <input type="text" id="nom_referent" name="nom_referent" value="<?php echo $nomInput; ?>"> </td> <br> 
                </tr>
                <tr>
                <td> <label for="prenom_referent">Prénom:</label> </td>
                <td> <input type="text" id="prenom_referent" name="prenom_referent" value="<?php echo $prenomInput; ?>"> </td> <br>
                </tr>
                <tr>
                <td>  <label for="email_referent">Email:</label> </td>
                <td> <input type="email" id="email_referent" name="email_referent" value="<?php echo $emailInput; ?>"> </td> <br>
                </tr>
                <tr>
                <td> <input type="submit" value="Enregistrer"> </td> <br>
                </tr>
            </table>
            </form>
        </div>
    </div>
</body>
</html>
