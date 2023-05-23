
function valider() {
    var checkboxes = document.getElementsByName('choix');
    var checkedCount = 0;

    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checkedCount++;
        }
    }

    if (checkedCount > 4) {
        alert("Vous ne pouvez sélectionner que 4 choix au maximum.");
        return false; // Empêche l'envoi du formulaire
    }

    return true; // Permet l'envoi du formulaire si le nombre de cases cochées est valide
}

