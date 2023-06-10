<?php
$id = $_GET["id"];

$referents = [];
if (($handle = fopen("dataReferent.csv", "r")) !== false) {
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        if ($data[0] === $id) {
            $referent = [
                "nom" => $data[1],
                "prenom" => $data[2],
                "email" => $data[3],
                "presentation" => $data[4]
            ];
            array_push($referents, $referent);
        }
    }
    fclose($handle);
}

echo json_encode($referents);
?>



