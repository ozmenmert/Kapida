<?php
include 'ayar.php';
$sayfa_hizmet_id = 1;
redirectToUnauthorized($sayfa_hizmet_id, 'ekle');

$pageName = 'Sipariş Ekleme';
$meta = array(
    'title' => $pageName . $separator . $siteData['title'],
    'description' => $siteData['description'],
    'keywords' => $siteData['keywords'],
    'author' => $siteData['author']
);

include 'header.php';
?>



<div class="page-wrapper">
    <div class="content container-fluid">



        <div class="page-header">
            <div class="content-page-header">
                <h5>
                    <?= $pageName ?>
                </h5>

                <div class="list-btn">
                    <ul class="filter-list">


                        <li>
                            <a class="btn btn-primary" href="siparisler"><i class="fa fa-list me-2" aria-hidden="true"></i>Sipariş Listesi</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>



        <form method="POST" action="ekle.php">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="card w-100 pt-0">
                        <div class="card-body">
                            <h4 class="my-2">Müşteri Bilgileri</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row ">
                                        <div class="col-md-4 mb-1">Müşteri Adı Soyadı</div>
                                        <div class="col-md-8 mb-1">
                                            <input type="text" class="form-control" name="siparis_musteri" required>
                                        </div>


                                        <div class="col-md-4 mb-1">Telefon</div>
                                        <div class="col-md-8 mb-1">
                                            <input type="number" class="form-control" name="siparis_telefon" required>
                                        </div>


                                        <div class="col-md-4 mb-1">Adres</div>
                                        <div class="col-md-8 mb-1">
                                            <textarea class="form-control" rows="1" name="siparis_adres" required></textarea>
                                        </div>

                                        <div class="col-md-4 mb-1">Şehir / İlçe</div>
                                        <div class="col-md-4 mb-1">
                                            <select class="form-control select" name="siparis_il" id="siparis_il" required>
                                                <option value="">Seçiniz</option>
                                                <?php
                                                $veriCek = $conn->prepare("SELECT * FROM iller ORDER BY il_adi ASC");
                                                $veriCek->execute();
                                                while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <option value="<?= $var['id'] ?>"><?= $var['il_adi'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-1">
                                            <select class="form-control select" name="siparis_ilce" id="siparis_ilce" required>
                                                <option value="">Şehir Seçiniz</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-1">Sipariş Tarihi</div>
                                        <div class="col-md-8 mb-1">
                                            <input type="datetime-local" class="form-control" name="siparis_tarih" required value="<?= date('Y-m-d H:i'); ?>">
                                        </div>

                                        <div class="col-md-4 mb-1">Ip Adres</div>
                                        <div class="col-md-8 mb-1">
                                            //
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="card w-100 pt-0">
                        <div class="card-body">
                            <h4 class="my-2">Sipariş Bilgileri</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row ">
                                        <div class="col-md-4 mb-1">Sipariş Durumu</div>
                                        <div class="col-md-8 mb-1">
                                            <select name="siparis_durum" class="form-control" required id="siparis_durum">
                                                <option value="">Seçiniz</option>
                                                <?php
                                                $veriCek = $conn->prepare("SELECT * FROM siparis_durumlari ORDER BY siparis_durum_id ASC");
                                                $veriCek->execute();
                                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <option value="<?= $row['siparis_durum_id'] ?>">
                                                        <?= $row['siparis_durum_adi'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>


                                        <div class="col-md-4 mb-1">Ödeme Şekli</div>
                                        <div class="col-md-8 mb-1">
                                            <select name="siparis_odeme_tur" class="form-control" required id="siparis_odeme_tur">
                                                <option value="Kapıda Kart ile Ödeme">Kapıda Kart ile Ödeme</option>
                                                <option value="Kapıda Nakit Ödeme">Kapıda Nakit Ödeme</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-1">Kargo Firması</div>
                                        <div class="col-md-8 mb-1">
                                            <select name="siparis_kargo" class="form-control" id="siparis_durum">
                                                <option value="">Seçiniz</option>
                                                <?php
                                                $veriCek = $conn->prepare("SELECT * FROM kargo_firmalar ORDER BY kargo_adi ASC");
                                                $veriCek->execute();
                                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <option value="<?= $row['kargo_id'] ?>">
                                                        <?= $row['kargo_adi'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-1">Sipariş Notları</div>
                                        <div class="col-md-8 mb-1">
                                            <textarea class="form-control" rows="1" name="siparis_not" id=""></textarea>
                                        </div>

                                        <div class="col-md-4 mb-1">Domain</div>
                                        <div class="col-md-8 mb-1">
                                            <input type="text" class="form-control" name="siparis_domain" required>
                                        </div>
                                        <div class="col-md-4 mt-2">Ödenecek Tutar</div>
                                        <div class="col-md-8 mt-2">
                                            <input type="number" class="form-control" name="siparis_tutar" readonly id="siparis_tutar">
                                        </div>
                                        <div class="col-md-4 mt-2">İskonto Tutarı</div>
                                        <div class="col-md-8 mt-2">
                                            <input type="number" class="form-control" value="0" name="siparis_indirim" id="siparis_indirim">
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            Total Ücret:
                                        </div>
                                        <div class="col-md-8 mt-2">
                                            <span class="h6 fw-bolder" id="siparisUcret"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card w-100 pt-0">
                        <div class="card-body">
                            <h4 class="my-2">Sipariş Ürünü</h4>
                            <div class="row">
                                <div class="col-md-2 mb-1">Ürün Seçimi</div>
                                <div class="col-md-10 mb-1">
                                    <select name="siparis_urun" class="form-control select" required id="siparis_urun">
                                        <option value="">Seçiniz</option>
                                        <?php
                                        $veriCek = $conn->prepare("SELECT * FROM urunler ORDER BY urun_adi ASC");
                                        $veriCek->execute();
                                        while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value="<?= $row['urun_id'] ?>">
                                                <?= $row['urun_adi'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-md-12 col-sm-12" id="urunSecenekleri">
                </div>
                <div class="col-md-12 mb-2 mt-2">
                    <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
<?php include 'footer.php'; ?>

<script>
    $(document).ready(function() {

        $(".select").select2();



        $("#siparis_indirim")
            .val(0)
            .on("change keyup", function() {
                const indirimDegeri = parseFloat($(this).val());
                if (indirimDegeri < 0 || isNaN(indirimDegeri)) {
                    $(this).val(0);
                }
                hesaplaSiparisUcret();
            });

        function hesaplaSiparisUcret() {
            const siparisTutar = parseFloat($("#siparis_tutar").val());
            const iskonto = parseFloat($("#siparis_indirim").val());
            if (isNaN(siparisTutar) || siparisTutar === 0) {
                $("#siparisUcret").html("");
                return;
            }

            const siparisUcret = siparisTutar - iskonto;
            $("#siparisUcret").html(siparisUcret.toFixed(2));
        }

        $(document).on('click', '.tutarHesapla', function() {
            const seciliElementler = $(".tutarHesapla:checked");
            let toplamFiyat = 0;
            seciliElementler.each(function() {
                const fiyat = $(this).data("fiyat");
                toplamFiyat += parseFloat(fiyat);
            });
            const siparisTutarInput = $("input[name='siparis_tutar']");
            siparisTutarInput.val(toplamFiyat);
            hesaplaSiparisUcret();
        });

        $("#siparis_indirim").on("change keyup", function(e) {
            hesaplaSiparisUcret();
        });
        $("#siparis_tutar").on("change", function(e) {
            hesaplaSiparisUcret();
        });


        $(document).on('change', 'select#siparis_urun', function(e) {
            e.preventDefault();
            var urun_id = $(this).val();
            if (urun_id != '') {
                $.ajax({
                    type: 'POST',
                    url: 'secenekleri_getir.php',
                    data: {
                        urun_id: urun_id,
                    },
                    success: function(data) {
                        $('#urunSecenekleri').html('');
                        $('#urunSecenekleri').html(data);
                    }
                });
            } else {
                $('select#siparis_ilce').html('');
                ToastTopEnd.fire({
                    icon: 'error',
                    title: 'Şehir Seçiniz.'
                });
            }

        });

        $(document).on('change', 'select#siparis_il', function(e) {
            e.preventDefault();
            var pr_id = $(this).val();
            if (pr_id != '') {
                $.ajax({
                    type: 'POST',
                    url: 'town.php',
                    data: {
                        city_code: pr_id,
                    },
                    success: function(data) {
                        $('select#siparis_ilce').html('');
                        $('select#siparis_ilce').html(data);
                    }
                });
            } else {
                $('select#siparis_ilce').html('');
                ToastTopEnd.fire({
                    icon: 'error',
                    title: 'Şehir Seçiniz.'
                });
            }

        });



        $("#siparis_durum").change(function() {
            var siparis_durum = $(this).val();
            if (siparis_durum === "4") {
                $("#kargoDiv input, #kargoDiv select").prop("required", true);
                $("#kargoDiv").fadeIn().removeClass("d-none");

            } else {
                $("#kargoDiv input, #kargoDiv select").prop("required", false);
                $("#kargoDiv").fadeOut().addClass("d-none");
            }
        });

        $(document).on('click', '.optionsRadios', function() {
            var adet = $(this).data('adet');
            ekleVaryant(adet);
        });

        function ekleVaryant(adet) {
            $('.varyantlar').empty();
            var urun_id = $('select#siparis_urun').val();
            var varyantHTML = '';
            $.ajax({
                url: 'varyant_ajax.php',
                type: 'POST',
                data: {
                    adet: adet,
                    urun_id: urun_id
                },
                success: function(response) {
                    $('#varyantSecim' + adet).html(response);
                }
            });
        }

        function getirVaryant(adet) {
            $('.varyantlar').empty();
            var urun_id = $('select#siparis_urun').val();
            var varyantHTML = '';
            $.ajax({
                url: 'varyant_getir.php',
                type: 'POST',
                data: {
                    adet: adet,
                    urun_id: urun_id,
                    siparis_ekle: '1'
                },
                success: function(response) {
                    $('#varyantSecim' + adet).html(response);
                }
            });
        }
    });
</script>