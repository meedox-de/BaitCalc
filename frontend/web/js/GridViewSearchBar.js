function toggleClearButton() {
    const searchValue = $('#filter-name').val();
    if (searchValue) {
        $('#clear-name').show();
    } else {
        $('#clear-name').hide();
    }
}

// Funktion, um Event-Listener zu registrieren
function registerEventListeners() {
    // Event Listener für den 'X'-Button
    $('#clear-name').off('click').on('click', function () {
        $('#filter-name').val('');
        $('input[name="CategorySearch[name]"]').val('');
        $.pjax.reload({container: '#category-pjax-container', url: window.location.href.split('?')[0]});
        toggleClearButton();
    });

    // Event Listener für die Lupe
    $('#search-name').off('click').on('click', function () {
        const searchValue = $('#filter-name').val();
        if (searchValue) {
            $('input[name="CategorySearch[name]"]').val(searchValue);
            $.pjax.reload({container: '#category-pjax-container'});
        }
    });

    // Initialen Zustand des "X"-Buttons setzen
    toggleClearButton();
}

// Initiale Registrierung der Event-Listener
registerEventListeners();

// Sicherstellen, dass Event-Listener nach Pjax-Reload neu gebunden werden
$(document).on('pjax:success', function() {
    registerEventListeners();
});