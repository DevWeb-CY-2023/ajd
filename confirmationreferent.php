<?php
session_start();

// Lire les données du référent à partir de dataReferent.csv
$referentId = $_SESSION['id'];

$referentFile = fopen("dataReferent.csv", "r");

$referentInfos = array();
while (($row = fgetcsv($referentFile)) !== false) {
    if ($row[0] === $referentId) {
        $referentInfos[] = $row;
    }
}

fclose($referentFile);

// Récupérer l'ID du jeune associé au référent
$jeuneId = $_SESSION['id'];

// Lire les données du jeune à partir de dataJeune.csv
$jeuneFile = fopen("dataJeune.csv", "r");

$jeuneInfo = null;
while (($row = fgetcsv($jeuneFile)) !== false) {
    if ($row[0] === $jeuneId) {
        $jeuneInfo = $row;
        break;
    }
}

fclose($jeuneFile);

// Afficher les données du jeune et les référents
$nomJeune = $jeuneInfo[1];
$prenomJeune = $jeuneInfo[2];
$dateNaissanceJeune = $jeuneInfo[4];
$adresseMailJeune = $jeuneInfo[5];
$reseauSocialJeune = $jeuneInfo[6];
$centreInteretJeune = $jeuneInfo[7];
$engagementJeune = $jeuneInfo[8];
$dureeJeune = $jeuneInfo[9];
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


    <div class="left-container">
        <h1>Données de <?php echo $prenomJeune; ?> </h1>
        <p>Nom : <?php echo $nomJeune; ?></p>
        <p>Prénom : <?php echo $prenomJeune; ?></p>
        <p>Date de naissance : <?php echo $dateNaissanceJeune; ?></p>
        <p>Adresse mail : <?php echo $adresseMailJeune; ?></p>
        <p>Réseau social : <?php echo $reseauSocialJeune; ?></p>
        <p>Centre d'intérêt : <?php echo $centreInteretJeune; ?></p>
        <p>Engagement : <?php echo $engagementJeune; ?></p>
        <p>Durée : <?php echo $dureeJeune; ?></p>
    </div>

    <div class="right-container">
        <h1>Référent(s) contacté(s)</h1>
        <?php
        if (!empty($referentInfos)) {
            foreach ($referentInfos as $referentInfo) {
                $nomReferent = $referentInfo[1];
                $prenomReferent = $referentInfo[2];
                $emailReferent = $referentInfo[3];
                $presentationReferent=$referentInfo[4];
                echo "<p>Nom : $nomReferent</p>";
                echo "<p>Prénom : $prenomReferent</p>";
                echo "<p>Email : $emailReferent</p>";
                echo "<p>Email : $presentationReferent</p>";

                echo "<br>";
            }
        } else {
            echo "<p>Aucun référent contacté.</p>";
        }
        ?>
        <p> J'ajoute un <a href="referent.html"> référent.</a> </p>
        <p> Je génère mon CV en <a href="pdf.php"> pdf.</a> </p>
        <form action="logout.php" method="POST">
            <input type="submit" value="Se déconnecter">
        </form>
    </div>
    <br><br>
        
</body>
</html>
