function genererPDF() {
    // Soumettre le formulaire pour générer le PDF
    document.getElementById("cvForm").submit()
}

// maximum 4 checkbox selectionnées

function limiteSelection(checkbox) {
    let nombreMax = 4;
    let collect_checkboxes = document.querySelectorAll('.checkbox-savoir-etre');
    let nombreSelectionnes = 0;

    for (let i = 0; i < collect_checkboxes.length; i++) {
        if (collect_checkboxes[i].checked) {
            nombreSelectionnes++;
        }
    }
    if (nombreSelectionnes > nombreMax) {
        checkbox.checked = false;
    }
}



