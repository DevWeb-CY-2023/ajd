<?php
$id = $_POST["id"];
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$email = $_POST["email"];
$presentation = $_POST["presentation"];

$data = array($id, $nom, $prenom, $email, $presentation);
$fp = fopen('dataReferent.csv', 'a');
fputcsv($fp, $data);
fclose($fp);

    // Redirection vers ref.html
    header("Location: ref.html");
    exit();

?>
