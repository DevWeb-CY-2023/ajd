<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php
		function utilisateurExiste($utilisateur){  //retourne true si l'email du nouveau utilisateur existe déja, false sinon
			$dataJeune = fopen("dataJeune.csv","r");
			
			while(!feof($dataJeune)){
				$line=fgets($dataJeune);
				$mots=explode(";", $line);
				
				if($mots[4] == $utilisateur){ return true;}//compare l'email du nouveau compte à chacun des emails déja utilisé
			}
			return false;
		}
		// Vérifie si le formulaire a été soumis
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			// Récupère les valeurs des champs de formulaire
			$nom = $_POST["nom"];
			$prenom = $_POST["prenom"];
			$mdp = $_POST["mdp"];
			$birthday = $_POST["birthday"];
			$email = $_POST["email"];
			$reseauSocial = $_POST["reseauSocial"];
			$centreInteret = $_POST["centreInteret"];
			$engagement = $_POST["engagement"];
			$duree = $_POST["duree"];

			$choix1 = $_POST["choix1"];
			$choix2 = $_POST["choix2"];
			$choix3 = $_POST["choix3"];
			$choix4 = $_POST["choix4"];
			$choix5 = $_POST["choix5"];
			$choix6 = $_POST["choix6"];
			$choix7 = $_POST["choix7"];
			$choix8 = $_POST["choix8"];
			$choix9 = $_POST["choix9"];
			$choix10 = $_POST["choix10"];

			$dataJeune = fopen("dataJeune.csv","a");

			if(!utilisateurExiste($email)){
				fwrite($dataJeune, $nom.";".$prenom.";".$mdp.";".$birthday.";".$email.";".$reseauSocial.";".$centreInteret.";".$engagement.";".$duree.";".$choix1.";".$choix2.";".$choix3.";".$choix4.";".$choix5.";".$choix6.";".$choix7.";".$choix8.";".$choix9.";".$choix10.
";\n");}
			fclose($dataJeune);
			header("Location: connexion.html");

		} else {
			// Si le formulaire n'a pas été soumis, affiche un message d'erreur
			echo "<p>Le formulaire n'a pas été soumis.</p>";
		}
	?>
</body>
</html>
