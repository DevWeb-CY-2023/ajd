<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    // Rediriger vers la page de connexion
    header("Location: connexion.html");
    exit();
}

// Lire les données de l'utilisateur à partir de dataJeune.csv
$users = array();
$isUpdated = false;

$usersFile = fopen("dataJeune.csv", "r");

while (($row = fgetcsv($usersFile)) !== false) {
    if ($row[0] === $_SESSION['nom'] && $row[1] === $_SESSION['prenom']) {
        $userData = $row;
        $isUpdated = true;
        break;
    }
}

fclose($usersFile);

if (!$isUpdated) {
    // Rediriger vers la page accueiljeune.php si les données de l'utilisateur ne sont pas trouvées
    header("Location: accueiljeune.php");
    exit();
}

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $userData[0] = $_POST['nom'];
    $userData[1] = $_POST['prenom'];
    $userData[2] = $_POST['mdp'];
    $userData[3] = $_POST['dateNaissance'];
    $userData[4] = $_POST['email'];
    $userData[5] = $_POST['reseauSocial'];
    $userData[6] = $_POST['centreInteret'];
    $userData[7] = $_POST['engagement'];
    $userData[8] = $_POST['duree'];

    // Mettre à jour le fichier dataJeune.csv
    $usersFile = fopen("dataJeune.csv", "r+");
    $tempFile = fopen("dataJeune_temp.csv", "w");

    while (($row = fgetcsv($usersFile)) !== false) {
        if ($row[0] === $_SESSION['nom'] && $row[1] === $_SESSION['prenom']) {
            fputcsv($tempFile, $userData, ",");
        } else {
            fputcsv($tempFile, $row, ",");
        }
    }

    fclose($usersFile);
    fclose($tempFile);

    // Supprimer le fichier dataJeune.csv existant
    unlink("dataJeune.csv");

    // Renommer le fichier temporaire
    rename("dataJeune_temp.csv", "dataJeune.csv");

    // Rediriger l'utilisateur vers la page accueiljeune.php après la mise à jour
    header("Location: accueiljeune.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Accueil Jeune</title>
    <link rel="stylesheet" type="text/css" href="accueiljeune.css">
</head>

<body>
    <div class="bande">
        <div class="m_header">
            <a href="page4.html"> <img src="LOGOS_JEUNES.svg" alt="Your Image"> </a>
            <div class="text">
                <h2> JEUNE </h2>
                <h3> Je donne de la valeur à mon engagement </h3>
            </div>
        </div>

        <!-- Contenu principal de la page -->
        <div class="header">
            <h1>Décrivez votre expérience et mettez en avant ce que vous en avez retiré.</h1>
        </div>

        <form action="accueiljeune.php" method="POST">
            <div form>
                <!-- Champs de formulaire pré-remplis avec les données de l'utilisateur -->
                <table>
                    <tr>
                        <td><label for="nom">Nom:</label></td>
                        <td><input type="text" id="nom" name="nom" value="<?php echo isset($userData[0]) ? $userData[0] : ''; ?>" required><br><br></td>
                    </tr>
                    <tr>
                        <td><label for="prenom">Prénom:</label></td>
                        <td><input type="text" id="prenom" name="prenom" value="<?php echo isset($userData[1]) ? $userData[1] : ''; ?>" required><br><br></td>
                    </tr>
                    <tr>
                        <td><label for="mdp">Mot de passe:</label></td>
                        <td><input type="password" id="mdp" name="mdp" value="<?php echo isset($userData[2]) ? $userData[2] : ''; ?>" required><br><br></td>
                    </tr>
                    <tr>
                        <td><label for="dateNaissance">Date de naissance:</label></td>
                        <td><input type="date" id="dateNaissance" name="dateNaissance" value="<?php echo isset($userData[3]) ? $userData[3] : ''; ?>"><br><br></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email:</label></td>
                        <td><input type="email" id="email" name="email" value="<?php echo isset($userData[4]) ? $userData[4] : ''; ?>" required><br><br></td>
                    </tr>
                    <tr>
                        <td><label for="reseauSocial">Réseau social:</label></td>
                        <td><input type="text" id="reseauSocial" name="reseauSocial" value="<?php echo isset($userData[5]) ? $userData[5] : ''; ?>"><br><br></td>
                    </tr>
                    <tr>
                        <td><label for="centreInteret">Centre d'intérêt:</label></td>
                        <td><input type="text" id="centreInteret" name="centreInteret" value="<?php echo isset($userData[6]) ? $userData[6] : ''; ?>"><br><br></td>
                    </tr>
                    <tr>
                        <td><label for="engagement">Engagement:</label></td>
                        <td><input type="text" id="engagement" name="engagement" value="<?php echo isset($userData[7]) ? $userData[7] : ''; ?>"><br><br></td>
                    </tr>
                    <tr>
                        <td><label for="duree">Durée:</label></td>
                        <td><input type="teext" id="duree" name="duree" value="<?php echo isset($userData[8]) ? $userData[8] : ''; ?>"><br><br></td>
                    </tr>
                    <tr>
                        <td colspan="2">J'ajoute un ou des <a href="referent.html">référent(s)</a>.</td>
                    </tr>
                </table>
                <input type="submit" value="Enregistrer les modifications">
            </div>
        </form>
    </div>
</body>

</html>

