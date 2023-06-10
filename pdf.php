<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion
    header("Location: connexion.html");
    exit();
}

// L'utilisateur est connecté, continuer avec la génération du PDF

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();

ob_start();
require_once 'confirmationreferent.php';
$htmlContent = ob_get_clean();

// Supprimer les parties indésirables du contenu HTML
$htmlContent = preg_replace('/<p> J\'ajoute un <a href="referent.html"> référent.<\/a> <\/p>/', '', $htmlContent);
$htmlContent = preg_replace('/<p> Je génère mon CV en <a href="pdf.php"> pdf.<\/a> <\/p>/', '', $htmlContent);
$htmlContent = preg_replace('/<button type="button" onclick="window.location.href=\'logout.php\'">\s*Se déconnecter\s*<\/button>/', '', $htmlContent);

// Charger le CSS depuis le fichier style-confirmation-referent.css
$cssContent = file_get_contents('style-confirmation-referent.css');
//$htmlContent = '<style>' . $cssContent . '</style>' . $htmlContent;

$dompdf->loadHtml($htmlContent);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream('Mon CV', array('Attachment' => 0));
?>


