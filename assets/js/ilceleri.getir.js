$(document).on('change', 'select.il', function(e) {
    e.preventDefault();
    var pr_id = $(this).val();
    $.ajax({
        type: 'POST',
        url: 'town.php',
        data: {
            city_code: pr_id,
        },
        success: function(data) {
            $('select.ilce').html('');
            $('select.ilce').html(data);
        }
    });
});