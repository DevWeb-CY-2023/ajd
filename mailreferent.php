<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/Applications/MAMP/htdocs/ajd-main/PHPMailer/src/Exception.php';
require '/Applications/MAMP/htdocs/ajd-main/PHPMailer/src/PHPMailer.php';
require '/Applications/MAMP/htdocs/ajd-main/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Lire les adresses e-mail enregistrées dans le fichier dataReferent.csv
    $file = fopen("dataReferent.csv", "r");
    $recipients = array();
    while (($line = fgetcsv($file)) !== false) {
        $recipients[] = $line[3]; // L'adresse e-mail est à l'index 3
    }
    fclose($file);

    // Récupérer les informations du jeune connecté à partir du fichier dataJeune.csv
    $dataJeune = file("dataJeune.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lastLine = end($dataJeune);
    $jeuneInfo = explode(",", $lastLine);
    $nomJeune = $jeuneInfo[1];
    $prenomJeune = $jeuneInfo[2];

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

        $mail->setFrom('confirmationreference@gmail.com', 'Je confirme ma reference');
        
        $lastRecipient = end($recipients);
        $mail->addAddress($lastRecipient);

        $mail->isHTML(true);
        $mail->Subject = 'Confirmation de reference';
        $mail->Body = $nomJeune . ' ' . $prenomJeune . ' souhaite vous ajouter comme référent. Si oui, veuillez vous diriger vers la page confirmationreference.php pour confirmer.';

        $mail->send();
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
    }
}
?>
