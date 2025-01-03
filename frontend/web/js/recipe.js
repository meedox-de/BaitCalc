document.addEventListener('DOMContentLoaded', function () {
    const ingredientInputs = document.querySelectorAll('.ingredient-input');
    const totalPercentageElement = document.getElementById('total-percentage');

    function calculateTotals() {
        // reset totals
        let totalFat = 0;
        let totalProtein = 0;
        let totalCarbohydrates = 0;
        let totalPercentage = 0;

        ingredientInputs.forEach(input => {
            const percentage = parseFloat(input.value) || 0; // Prozentualer Anteil (0, wenn leer)
            const fat = parseFloat(input.dataset.fat) || 0; // Fettgehalt
            const protein = parseFloat(input.dataset.protein) || 0; // Proteingehalt
            const carbohydrates = parseFloat(input.dataset.carbohydrates) || 0; // Kohlenhydratgehalt

            // Add percentage to total
            totalPercentage += percentage;

            // calculate
            totalFat += (percentage / 100) * fat;
            totalProtein += (percentage / 100) * protein;
            totalCarbohydrates += (percentage / 100) * carbohydrates;
        });

        // Update totals
        document.getElementById('total-fat').textContent = totalFat.toFixed(2);
        document.getElementById('total-protein').textContent = totalProtein.toFixed(2);
        document.getElementById('total-carbohydrates').textContent = totalCarbohydrates.toFixed(2);

        // Update total percentage display
        totalPercentageElement.textContent = totalPercentage.toFixed(2);

        // Change color if total percentage exceeds 100%
        if (totalPercentage > 100) {
            totalPercentageElement.style.color = 'red';
        } else {
            totalPercentageElement.style.color = ''; // Default color (inherit)
        }
    }

    // Event listener for all inputs
    ingredientInputs.forEach(input => {
        input.addEventListener('input', calculateTotals); // Neuberechnung bei jeder Eingabe
    });

    // Initial calculation
    calculateTotals();
});