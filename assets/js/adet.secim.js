$('#quickViewModal').on('shown.bs.modal', function() {
    $('.adetSecimpro').click(function(e) {
        e.preventDefault();
        var selectedOdeme = $(this).data('odeme');
        $.ajax({
            type: 'POST',
            url: 'home/kargoFirmalari.php',
            data: {
                selectedOdeme: selectedOdeme,
            },
            success: function(response) {
                console.log(response);
                $('#kargo_firmalari').html('');
                $('#kargo_firmalari').html(response);
            },
            error: function(xhr, status, error) {
                console.log("Bir hata oluştu: " + error);
            }
        });					
    });
    $('.adetSecimpro input[type="radio"]:checked').closest('.adetSecimpro').trigger('click');
});