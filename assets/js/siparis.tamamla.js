$('.siparisTamamla').click(function(event) {
    event.preventDefault();

    var telefon = $('#telefon').val();
    var numericTelefon = telefon.replace(/\D/g, '');

    var adet = $('input[name="adet"]:checked').val();
    var isim = $('input[name="name"]').val();
    var il = $('select[name="il"]').val();
    var ilce = $('select[name="ilce"]').val();
    var policy = $('input[name="policy"]').is(':checked');
    
    var varyantEksik = false;
    $('select[name="varyant[]"]').each(function() {
        if ($(this).val() === "") {
            varyantEksik = true;
            $(this)[0].scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            return false;
        }
    });

    if (varyantEksik) {
        $('#quickViewModal').modal('hide');
        toastr.error('Lütfen Tüm Varyantları Seçiniz', 'Eksik Seçim!');
        return;
    }

    var formData = {
        urun_id: $('input[name="urun_id"]').val(),
        name: $('input[name="name"]').val(),
        telefon: numericTelefon,
        adres: $('textarea[name="adres"]').val(),
        not: $('textarea[name="not"]').val(),
        il: $('select[name="il"]').val(),
        ilce: $('select[name="ilce"]').val(),
        ip_adres: $('input[name="ip_adres"]').val(),
        odeme : $('input[name="odeme"]:checked').val(),
        kargo : $('input[name="kargo"]:checked').val(),
        adet: adet,
        policy: policy,
        varyant: $('select[name="varyant[]"]').map(function() {
            return $(this).val();
        }).get()
    };

    var promosyonlar = [];
    $('input[name="promosyon[]"]:checked').each(function() {
        promosyonlar.push($(this).val());
    });

    formData.promosyon = promosyonlar;

    $.ajax({
        url: 'tesekkurler.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            console.log(response);

            if (response === 'success') {
                window.location.href = 'tesekkurler.php';
            } else if (response === 'error_order') {
                toastr.error('Son 10 dakika içerisinde bu üründen sipariş verildi. Lütfen biraz bekleyip tekrar deneyin.', 'Sipariş Hatası');
            } else if (response === 'error') {
                toastr.error('Siparişiniz işlenirken bir hata oluştu. Lütfen tekrar deneyin.', 'Sipariş Hatası');
            }				
        },
        error: function(xhr, status, error) {
            //console.log("Bir hata oluştu: " + error);
            toastr.error('Sunucuya bağlanırken bir sorun oluştu. Lütfen tekrar deneyin.', 'Bağlantı Hatası');
        }
    });
});