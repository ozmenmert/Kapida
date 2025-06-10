$(document).ready(function() {
    function calculateTotal() {
        var selectedRadio = $('input[name="adet"]:checked');
        var selectedRadioPrice = parseFloat(selectedRadio.data('fiyat')) || 0;
        var selectedAdet = selectedRadio.data('adet') || 1; // Seçili adet sayısı
        var selectedPromoPrice = 0;
        var selectedKargoPrice = parseFloat(selectedRadio.data('kargo')) || 0;

        $('input[name="promosyon[]"]:checked').each(function() {
            selectedPromoPrice += parseFloat($(this).data('fiyat')) || 0;
        });

        var totalPrice = selectedRadioPrice + selectedPromoPrice;

        if (selectedKargoPrice > 0) {
            totalPrice += selectedKargoPrice;
        }

        if (selectedKargoPrice === 0) {
            $('.toplamOdeme').html(selectedAdet + " Adet - " + totalPrice.toFixed(2) + ' TL <span class="kargo-bedava"> | KARGO BEDAVA</span>');
        } else {
            $('.toplamOdeme').html(selectedAdet + " Adet - " + totalPrice.toFixed(2) + ' TL <span class="kargo-dahil"> | Kargo Dahil</span>');
        }

        if (selectedKargoPrice === 0) {
            $('.toplamOdemesayafasi').html(totalPrice.toFixed(2) + ' TL <br><span class="kargo-bedava">KARGO BEDAVA</span>');
        } else {
            $('.toplamOdemesayafasi').html(totalPrice.toFixed(2) + ' TL <br><span class="kargo-dahil">Kargo Dahil</span>');
        }
    }

    calculateTotal();

    $('input[name="adet"], input[name="promosyon[]"]').on('change', function() {
        calculateTotal();
    });
});