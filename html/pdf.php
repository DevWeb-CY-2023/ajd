<?php
require_once 'vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

if (!empty($_POST['nom'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $reseauSocial = htmlspecialchars($_POST['reseauSocial']);
    $centreInteret = htmlspecialchars($_POST['centreInteret']);
    $engagement = htmlspecialchars($_POST['engagement']);
    $duree = htmlspecialchars($_POST['duree']);

    $html2pdf = new Html2Pdf('P', 'A4', 'fr');

    $html = "
    <page>
        <page_header> Mon CV : </page_header>
        <br />
        Je m'appelle $prenom $nom et mon adresse mail est $email. Je suis inscrit(e) sur $reseauSocial et mon centre
        d'intérêt est $centreInteret. Je souhaite un engagement en $engagement pour une durée de $duree.
    </page>
    ";

    $html2pdf->writeHTML($html);
    $html2pdf->output('mon_cv.pdf');
}
?>

