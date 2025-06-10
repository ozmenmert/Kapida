$('.satinAlBtn').on('click', function(event) {
    var selectedAdet = $('input[name="adet"]:checked').length > 0;
    var allVaryantsSelected = true;
    $('.varyantSecim').each(function() {
        if ($(this).val() === "") {
            allVaryantsSelected = false;
        }
    });

    if (!selectedAdet) {
        event.preventDefault();
        $('#quickViewModal').modal('hide');
        toastr.error('Lütfen bir ürün seçimi yapınız!', '');
        $('input[name="adet"]').first()[0].scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

    } else if (!allVaryantsSelected) {
        event.preventDefault();
        $('#quickViewModal').modal('hide');
        toastr.error('Lütfen Ürün Rengini Seçiniz.', '');

        $('select[name="varyant[]"]').first()[0].scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

    } else {
        $('#quickViewModal').modal('show');
    }
});