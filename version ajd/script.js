// Sélectionner le formulaire
const form = document.querySelector('#experience-form');

// Sélectionner le champ d'email
const emailInput = form.querySelector('#email');

// Sélectionner toutes les cases à cocher
const checkboxes = form.querySelectorAll('input[type="checkbox"][name="choix"]');

// Ajouter un écouteur d'événements sur la soumission du formulaire
form.addEventListener('submit', function (event) {
    // Vérifier si l'adresse email contient un @
    if (!emailInput.value.includes('@')) {
        // Empêcher la soumission du formulaire
        event.preventDefault();
        // Afficher un message d'erreur
        alert("L'adresse email doit contenir un @");
    }

    // Compter le nombre de cases cochées
    let checkedCount = 0;
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            checkedCount++;
        }
    });

    // Vérifier si le nombre de cases cochées dépasse 4
    if (checkedCount > 4) {
        // Empêcher la soumission du formulaire
        event.preventDefault();
        // Afficher un message d'erreur
        alert("Vous ne pouvez pas cocher plus de 4 cases.");
    }
});
