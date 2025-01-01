document.addEventListener('DOMContentLoaded', function ()
{
    const ingredientInputs = document.querySelectorAll('.ingredient-input');

    function calculateTotals()
    {
        // reset totals
        let totalFat           = 0;
        let totalProtein       = 0;
        let totalCarbohydrates = 0;

        ingredientInputs.forEach(input =>
        {
            const percentage    = parseFloat(input.value) || 0; // Prozentualer Anteil (0, wenn leer)
            const fat           = parseFloat(input.dataset.fat) || 0; // Fettgehalt
            const protein       = parseFloat(input.dataset.protein) || 0; // Proteingehalt
            const carbohydrates = parseFloat(input.dataset.carbohydrates) || 0; // Kohlenhydratgehalt

            // calculate
            totalFat += (percentage / 100) * fat;
            totalProtein += (percentage / 100) * protein;
            totalCarbohydrates += (percentage / 100) * carbohydrates;
        });

        document.getElementById('total-fat').textContent           = totalFat.toFixed(2);
        document.getElementById('total-protein').textContent       = totalProtein.toFixed(2);
        document.getElementById('total-carbohydrates').textContent = totalCarbohydrates.toFixed(2);
    }

    // eventlistener for all inputs
    ingredientInputs.forEach(input =>
    {
        input.addEventListener('input', calculateTotals); // Neuberechnung bei jeder Eingabe
    });

    calculateTotals();
});