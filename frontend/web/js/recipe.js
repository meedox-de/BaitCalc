document.addEventListener('DOMContentLoaded', function () {
    // Selektiere alle Eingabefelder für Zutaten
    const ingredientInputs = document.querySelectorAll('.ingredient-input');

    // Funktion zur Berechnung der Totals
    function calculateTotals() {
        // Totals zurücksetzen
        let totalFat = 0;
        let totalProtein = 0;
        let totalCarbohydrates = 0;

        // Iteriere über alle Zutaten-Inputs
        ingredientInputs.forEach(input => {
            const percentage = parseFloat(input.value) || 0; // Prozentualer Anteil (0, wenn leer)
            const fat = parseFloat(input.dataset.fat) || 0; // Fettgehalt
            const protein = parseFloat(input.dataset.protein) || 0; // Proteingehalt
            const carbohydrates = parseFloat(input.dataset.carbohydrates) || 0; // Kohlenhydratgehalt

            // Berechne die Anteile für diese Zutat
            totalFat += (percentage / 100) * fat;
            totalProtein += (percentage / 100) * protein;
            totalCarbohydrates += (percentage / 100) * carbohydrates;
        });

        // Ergebnisse in die Totals-Felder schreiben
        document.getElementById('total-fat').textContent = totalFat.toFixed(2);
        document.getElementById('total-protein').textContent = totalProtein.toFixed(2);
        document.getElementById('total-carbohydrates').textContent = totalCarbohydrates.toFixed(2);
    }

    // Event-Listener für Änderungen in den Inputs
    ingredientInputs.forEach(input => {
        input.addEventListener('input', calculateTotals); // Neuberechnung bei jeder Eingabe
    });

    // Initiale Berechnung (falls Werte geladen werden)
    calculateTotals();
});