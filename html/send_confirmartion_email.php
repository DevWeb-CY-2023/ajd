<?php
// Récupération des données du formulaire de la page 5
$email = $_POST['email'];

// Fonction pour générer un token aléatoire
function generateToken($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = '';

    // Génération du token aléatoire
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $token;
}

// Détermine la longueur souhaitée pour le token
$length = 32; // longueur de 32 caractères

// Génération d'un token pour la confirmation
$token = generateToken($length);

// Lien vers la page de confirmation avec les paramètres d'e-mail et de token
$confirmationLink = '#' . urlencode($email) . '&token=' . urlencode($token);

// Compose le contenu de l'e-mail
$subject = 'Confirmation de référent';
$message = 'Cher référent, veuillez confirmer votre engagement en cliquant sur le lien suivant : ' . $confirmationLink;

$headers = 'From: mail@exemple.com' . "\r\n" .
           'Reply-To: mail@exemple.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

// Envoie l'e-mail de confirmation
if (mail($email, $subject, $message, $headers)) {
    echo "E-mail de confirmation envoyé avec succès ! Veuillez vérifier votre boîte de réception.";
} else {
    echo "Une erreur s'est produite lors de l'envoi de l'e-mail de confirmation.";
}
?>

