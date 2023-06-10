<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/Applications/MAMP/htdocs/ajd-main/PHPMailer/src/Exception.php';
require '/Applications/MAMP/htdocs/ajd-main/PHPMailer/src/PHPMailer.php';
require '/Applications/MAMP/htdocs/ajd-main/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Lire les adresses e-mail enregistrées dans le fichier dataConsultant.csv
    $file = fopen("dataConsultant.csv", "r");
    $recipients = array();
    while (($line = fgetcsv($file)) !== false) {
        $recipients[] = $line[3]; // L'adresse e-mail est à l'index 3
    }
    fclose($file);

    // Récupérer l'ID du jeune connecté depuis la session
    session_start();
    $jeuneId = $_SESSION['id'];

    // Récupérer les informations du jeune connecté à partir du fichier dataJeune.csv
    $dataJeune = file("dataJeune.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $jeuneInfo = array();
    foreach ($dataJeune as $line) {
        $info = explode(",", $line);
        if ($info[0] == $jeuneId) {
            $jeuneInfo = $info;
            break;
        }
    }

    // Récupérer les référents attribués au jeune à partir du fichier dataReferent.csv
    $dataReferent = file("dataReferent.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $referents = array();
    foreach ($dataReferent as $line) {
        $info = explode(",", $line);
        if ($info[0] == $jeuneId) {
            $referentId = $info[0]; // ID du référent est à l'index 0
            $referentData = array();
            foreach ($dataReferent as $referentLine) {
                $referentInfo = explode(",", $referentLine);
                if ($referentInfo[0] == $referentId) {
                    $referentData[] = $referentInfo;
                }
            }
            $referents = $referentData;
            break; // Sortir de la boucle une fois les référents récupérés
        }
    }

    // Envoi de l'e-mail au dernier référent ajouté
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'confirmationreference@gmail.com';
        $mail->Password = 'ffsbgqghdwlumoum';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('confirmationreference@gmail.com');
        
        $lastRecipient = end($recipients);
        $mail->addAddress($lastRecipient);

        $mail->isHTML(true);
        $mail->Subject = 'Consultant';

        // Construire le contenu de l'e-mail avec les informations du jeune et des référents
        $mail->Body = 'Informations du jeune :<br>';
        $mail->Body .= 'Nom : ' . $jeuneInfo[1] . '<br>';
        $mail->Body .= 'Prénom : ' . $jeuneInfo[2] . '<br>';
        $mail->Body .= 'Date de naissance : ' . $jeuneInfo[4] . '<br>';
        $mail->Body .= 'Adresse mail : ' . $jeuneInfo[5] . '<br>';
        $mail->Body .= 'Réseau social : ' . $jeuneInfo[6] . '<br>';
        $mail->Body .= 'Hobby : ' . $jeuneInfo[7] . '<br>';
        $mail->Body .= 'Engagement : ' . $jeuneInfo[8] . '<br>';
        $mail->Body .= 'Durée : ' . $jeuneInfo[9] . '<br>';

        $mail->Body .= '<br>Informations des référents :<br>';
        foreach ($referents as $referentData) {
            $mail->Body .= 'Nom et prénom : ' . $referentData[1] . ' ' . $referentData[2] . '<br>';
            $mail->Body .= 'Adresse mail : ' . $referentData[3] . '<br>';
            $mail->Body .= 'Présentation : ' . $referentData[4] . '<br>';
            $mail->Body .= '<br>';
        }

        $mail->send();
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
    }
}
?>
