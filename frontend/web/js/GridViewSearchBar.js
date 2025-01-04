function toggleClearButton()
{
    const searchValue = $('#filter-name').val();
    if (searchValue)
    {
        $('#clear-name').show();
    }
    else
    {
        $('#clear-name').hide();
    }
}

function registerEventListeners()
{
    $('#clear-name').off('click').on('click', function ()
    {
        $('#filter-name').val('');
        $.pjax.reload({
            container: '#pjax-container',
            url      : window.location.href.split('?')[0]
        });
        toggleClearButton();
    });

    $('#search-name').off('click').on('click', function ()
    {
        const searchValue = $('#filter-name').val();
        if (searchValue)
        {
            $('#filter-name').val('');
            $.pjax.reload({container: '#pjax-container'});
        }
    });

    toggleClearButton();
}

registerEventListeners();

$(document).on('pjax:success', function ()
{
    registerEventListeners();
});