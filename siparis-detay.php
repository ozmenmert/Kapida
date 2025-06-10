<?php
include 'ayar.php';




$id = $_GET['id'] ?? -1;
$siparisDetay = $conn->query("SELECT * FROM siparisler WHERE siparis_id = '$id' ")->fetch(PDO::FETCH_ASSOC);

if (isset($siparisDetay['siparis_icerik']) and $siparisDetay['siparis_icerik'] != '') {
    $temiz_veri = str_replace('"', '', $siparisDetay['siparis_icerik']);
    $parcalanmis_veri = explode(",", $temiz_veri);
    $adet = isset($parcalanmis_veri[1]) ? $parcalanmis_veri[1] : 1;
} else {
    $adet = 1;
}

if (isset($_GET['filtre'])) {
    $filtre = $_GET['filtre'];
} else {
    $filtre = '';
}


if (isset($_POST['odemeDurumGuncelle'])) {

    $siparis_id = $_POST['siparis_id'];

    $update_query = $conn->prepare("UPDATE siparisler SET
        odeme_durum = :odeme_durum
        where siparis_id = :siparis_id
        ");
    $update = $update_query->execute(array(
        "odeme_durum" => $_POST['odeme_durum'],
        "siparis_id" => $siparis_id
    ));

    if ($update) {
        header("Location: siparis-detay?id=$siparis_id&durum=basarili");
    } else {
        header("Location: siparis-detay?id=$siparis_id&durum=basarisiz");
    }
}



if (isset($_POST['durumGuncelle'])) {

    $tarih = date('Y-m-d H:i:s');

    $siparis_id = $_POST['siparis_id'];
    $siparis_durum = $_POST['siparis_durum'];

    if ($siparis_durum != 4) {
        $update_query = $conn->prepare("UPDATE siparisler SET
            siparis_durum = :siparis_durum,
            siparis_kargo = :siparis_kargo,
            durum_update = :durum_update
            where siparis_id=:siparis_id
            ");
        $update = $update_query->execute(array(
            "siparis_durum" => $siparis_durum,
            "siparis_kargo" => '',
            "durum_update" => $tarih,
            "siparis_id" => $siparis_id
        ));
    } else {
        $siparis_kargo = $_POST['siparis_kargo'];

        $update_query = $conn->prepare("UPDATE siparisler SET
            siparis_durum = :siparis_durum,
            siparis_kargo = :siparis_kargo,
            durum_update = :durum_update
            where siparis_id=:siparis_id
            ");
        $update = $update_query->execute(array(
            "siparis_durum" => $siparis_durum,
            "siparis_kargo" => $siparis_kargo,
            "durum_update" => $tarih,
            "siparis_id" => $siparis_id
        ));
    }

    if ($update) {
        header("Location: siparis-detay?id=$siparis_id&durum=basarili");
    } else {
        header("Location: siparis-detay?id=$siparis_id&durum=basarisiz");
    }
}

$pageName = '#' . $siparisDetay['siparis_no'] . $separator . ' Sipariş Detay';
$meta = array(
    'title' => $pageName . $separator . $siteData['title'],
    'description' => $siteData['description'],
    'keywords' => $siteData['keywords'],
    'author' => $siteData['author']
);

$siparis_id = $siparisDetay['siparis_id'];
$siparis_no = $siparisDetay['siparis_no'];

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
                            <a class="btn btn-primary" href="siparisler"><i class="fa fa-list me-2"
                                    aria-hidden="true"></i>Sipariş Listesi</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
                             <?php
                                  $telefon = $siparisDetay['siparis_telefon'];
                                  $ip = $siparisDetay['siparis_ip'];
                                  $gecerliSiparisId = $siparisDetay['siparis_id'];

                                  $sorguKontrol = $conn->prepare("
                                                                  SELECT COUNT(*) 
                                                                  FROM siparisler 
                                                                  WHERE (siparis_telefon = :telefon OR siparis_ip = :ip) 
                                                                  AND siparis_id != :siparis_id");
                                  $sorguKontrol->execute(['telefon' => $telefon, 'ip' => $ip, 'siparis_id' => $gecerliSiparisId]);
                                  $siparisSayisi = $sorguKontrol->fetchColumn();

                                  if ($siparisSayisi > 0) {

                                  $sorguOzet = $conn->prepare("SELECT s.*, sd.siparis_durum_adi 
                                                              FROM siparisler s 
                                                              LEFT JOIN siparis_durumlari sd ON s.siparis_durum = sd.siparis_durum_id 
                                                              WHERE (s.siparis_telefon = :telefon OR s.siparis_ip = :ip) 
                                                              AND s.siparis_id != :siparis_id 
                                                              ORDER BY s.siparis_tarih DESC");
                                  $sorguOzet->execute(['telefon' => $telefon, 'ip' => $ip, 'siparis_id' => $gecerliSiparisId]);
                                  $ozetSiparisler = $sorguOzet->fetchAll(PDO::FETCH_ASSOC);
                              ?>
        <div class="card w-100 pt-0 mt-4">
            <div class="card-body">
                    <h5 class="my-2">Önceki Siparişler</h5>
                        <div class="table-responsive">
                         <table class="table table-striped">
                               <thead>
                                    <tr>
                                     <th>Sipariş Tarihi</th>
                                     <th>İsim Soyisim</th>
                                     <th>Ürün</th>
                                     <th>Toplam Tutar</th>
                                     <th>Kargo Durumu</th>
                                     <th>Sipariş Notları</th>
                                    </tr>
                               </thead>
                             <tbody>
                                <?php foreach ($ozetSiparisler as $siparis) { 
                                      $urunBilgi = $conn->query("SELECT urun_adi FROM urunler WHERE urun_id = " . $siparis['siparis_urun'])->fetch(PDO::FETCH_ASSOC); ?>
                                  <tr>
                                     <td><?= tarihSaatFormatla($siparis['siparis_tarih']); ?></td>
                                    <td>
                                       <a href="siparis-detay?id=<?= $siparis['siparis_id'] ?>&filtre=<?= $gelenDurum ?>" class="text-primary">
                                        <?= $siparis['siparis_musteri']; ?>
                                    </a>
                                   </td>
                                     <td><?= $urunBilgi['urun_adi']; ?></td>
                                     <td><?= ParaFormatla($siparis['siparis_tutar'] - $siparis['siparis_indirim']); ?> TL</td>
                                     <td><?= $siparis['siparis_durum_adi']; ?></td>
                                     <td><?= $siparis['siparis_not']; ?></td>
                                  </tr>
                                 <?php } ?>
                              </tbody>
                         </table>
                        </div>
            </div>
         </div>
          <?php } ?> 

        <form method="POST" action="guncelle.php">
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
                                            <input type="hidden" class="form-control" name="onceki_url"
                                                value="<?= $filtre; ?>">

                                            <input type="hidden" class="form-control" name="siparis_id"
                                                value="<?= $siparisDetay['siparis_id']; ?>">
                                            <input type="text" class="form-control" name="siparis_musteri"
                                                value="<?= $siparisDetay['siparis_musteri']; ?>">
                                        </div>


                                        <div class="col-md-4 mb-1">Telefon</div>
                                        <div class="col-md-8 mb-1">
                                            <input type="text" class="form-control" name="siparis_telefon"
                                                value="<?= $siparisDetay['siparis_telefon']; ?>">
                                        </div>


                                        <div class="col-md-4 mb-1">Adres</div>
                                        <div class="col-md-8 mb-1">
                                            <textarea class="form-control" rows="1" name="siparis_adres"
                                                id=""><?= $siparisDetay['siparis_adres']; ?></textarea>
                                        </div>

                                        <div class="col-md-4 mb-1">Şehir / İlçe</div>
                                        <div class="col-md-4 mb-1">
                                            <select class="form-control select" name="siparis_il" id="siparis_il"
                                                required>
                                                <option value="">Seçiniz</option>
                                                <?php
                                                $veriCek = $conn->prepare("SELECT * FROM iller ORDER BY il_adi ASC");
                                                $veriCek->execute();
                                                while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option
                                                    <?= ($siparisDetay['siparis_il'] == $var['id']) ? 'selected' : ''; ?>
                                                    value="<?= $var['id'] ?>"><?= $var['il_adi'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-1">
                                            <select class="form-control select" name="siparis_ilce" id="siparis_ilce"
                                                required>
                                                <option value="">Seçiniz</option>
                                                <?php
                                                $veriCek = $conn->prepare("SELECT * FROM ilceler WHERE il_id = :il_id ORDER BY ilce_adi ASC");
                                                $veriCek->execute(array('il_id' => $siparisDetay['siparis_il']));
                                                while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option
                                                    <?= ($siparisDetay['siparis_ilce'] == $var['id']) ? 'selected' : ''; ?>
                                                    value="<?= $var['id'] ?>"><?= $var['ilce_adi'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-1">Sipariş Tarihi</div>
                                        <div class="col-md-8 mb-1">
                                            <input type="datetime-local" class="form-control" name="siparis_tarih"
                                                value="<?= $siparisDetay['siparis_tarih']; ?>">
                                        </div>

                                        <div class="col-md-4 mb-1">Ip Adres</div>
                                        <div class="col-md-8 mb-1">
                                            <?= $siparisDetay['siparis_ip']; ?>
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
                                            <select name="siparis_durum" class="form-control" required
                                                id="siparis_durum">
                                                <option value="">Seçiniz</option>
                                                <?php
                                                $veriCek = $conn->prepare("SELECT * FROM siparis_durumlari ORDER BY siparis_durum_id ASC");
                                                $veriCek->execute();
                                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option
                                                    <?= ($row['siparis_durum_id'] == $siparisDetay['siparis_durum']) ? 'selected' : ''; ?>
                                                    value="<?= $row['siparis_durum_id'] ?>">
                                                    <?= $row['siparis_durum_adi'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>


                                        <div class="col-md-4 mb-1">Ödeme Şekli</div>
                                        <div class="col-md-8 mb-1">
                                            <select name="siparis_odeme_tur" class="form-control" required
                                                id="siparis_odeme_tur">
                                                <option
                                                    <?= ($siparisDetay['siparis_odeme_tur'] == 'Kapıda Kart ile Ödeme') ? 'selected' : ''; ?>
                                                    value="Kapıda Kart ile Ödeme">Kapıda Kart ile Ödeme</option>
                                                <option
                                                    <?= ($siparisDetay['siparis_odeme_tur'] == 'Kapıda Nakit Ödeme') ? 'selected' : ''; ?>
                                                    value="Kapıda Nakit Ödeme">Kapıda Nakit Ödeme</option>
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
                                                <option
                                                    <?= ($row['kargo_id'] == $siparisDetay['siparis_kargo']) ? 'selected' : ''; ?>
                                                    value="<?= $row['kargo_id'] ?>">
                                                    <?= $row['kargo_adi'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-1">Sipariş Notları</div>
                                        <div class="col-md-8 mb-1">
                                            <textarea class="form-control" rows="1" name="siparis_not"
                                                id=""><?= $siparisDetay['siparis_not']; ?></textarea>
                                        </div>

                                        <div class="col-md-4 mb-1">Domain</div>
                                        <div class="col-md-8 mb-1">
                                            <?= $siparisDetay['siparis_domain']; ?>
                                        </div>
                                        <div class="col-md-4 mt-2">Ödenecek Tutar</div>
                                        <div class="col-md-8 mt-2">
                                            <input type="number" class="form-control" readonly name="siparis_tutar"
                                                id="siparis_tutar" value="<?= $siparisDetay['siparis_tutar']; ?>">
                                        </div>
                                        <div class="col-md-4 mt-2">İskonto Tutarı</div>
                                        <div class="col-md-8 mt-2">
                                            <input type="number" class="form-control" name="siparis_indirim"
                                                id="siparis_indirim" value="<?= $siparisDetay['siparis_indirim']; ?>">
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
                                        <option <?= ($row['urun_id'] == $siparisDetay['siparis_urun']) ? 'selected' : ''; ?>
                                            value="<?= $row['urun_id'] ?>">
                                            id: <?= $row['urun_id'] ?> | <?= $row['urun_adi'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-md-12 col-sm-12" id="urunSecenekleri">
                    <div class="card w-100 pt-0">
                        <div class="card-body">
                            <h6 class="my-2">Adet Seçimi</h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class='row'>
                                        <div class='radio'>
                                            <?php
                                            $veriCek = $conn->prepare("SELECT * FROM urun_fiyatlandirma WHERE urun_id = :urun_id ORDER BY adet");
                                            $veriCek->execute(array('urun_id' => $siparisDetay['siparis_urun']));
                                            while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                                $urunBilgi = $conn->query("SELECT * FROM urunler WHERE urun_id = " . $siparisDetay['siparis_urun'])->fetch(PDO::FETCH_ASSOC);

                                            ?>
                                            <label for="optionsRadios<?= $var['urun_fiyatlandirma_id']; ?>">
                                                <input type='radio' name='adet' required
                                                    data-adet="<?= $var['adet']; ?>"
                                                    <?= ($adet == $var['adet']) ? 'checked' : ''; ?>
                                                    data-fiyat="<?= $var['fiyat'] + $var['kargo_tutar']; ?>"
                                                    data-kargo="<?= $var['kargo_tutar']; ?>"
                                                    class='tutarHesapla optionsRadios form-check-input'
                                                    id='optionsRadios<?= $var['urun_fiyatlandirma_id']; ?>'
                                                    value='<?= $var['urun_fiyatlandirma_id'] . ':' . $var['adet'] . ':' . $var['fiyat'] . ':' . $var['kargo_tutar'] . ':' . $var['kargo_durum']; ?>' />
                                                <?= $var['adet']; ?> Adet <?= $urunBilgi['urun_adi']; ?> - <b>
                                                    <?= $var['fiyat']; ?>
                                                    TL</b>
                                                <?php if ($var['kargo_durum'] == 1 and $var['kargo_tutar'] > 0) { ?>
                                                <b style='background:#ffdbdb'>+ KARGO
                                                    (<?= $var['kargo_tutar'] . ' TL' ?>)</b>
                                                <?php } else { ?>
                                                <b style='background:#94c327;color:white'> ÜCRETSİZ KARGO</b>
                                                <?php } ?>
                                            </label>
                                            <div class="varyantlar" id="varyantSecim<?= $var['adet']; ?>">

                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <h6>Promosyon Ürünler</h6>
                                    <div class='row'>
                                        <?php
                                        if ($siparisDetay['siparis_promosyon'] != '') {
                                            $dataArray = json_decode($siparisDetay['siparis_promosyon'], true);
                                            $secilmisPromosyonlar = []; // Empty array to store promo IDs
                                            foreach ($dataArray as $item) {
                                                $promoId = explode(':', $item)[0]; // Extract promo ID from each item
                                                $secilmisPromosyonlar[] = $promoId; // Add promo ID to the array
                                            }
                                        } else {
                                            $secilmisPromosyonlar = '';
                                        }

                                        $promosyonSayi = $conn->query("SELECT COUNT(*) AS toplam FROM promosyon_urunler WHERE urun_id =" . $siparisDetay['siparis_urun'])->fetch(PDO::FETCH_ASSOC);
                                        if ($promosyonSayi['toplam'] > 0) { ?>
                                        <?php
                                            $veriCek = $conn->prepare("SELECT * FROM promosyon_urunler WHERE urun_id = :urun_id ORDER BY promosyon_ucret");
                                            $veriCek->execute(array('urun_id' => $siparisDetay['siparis_urun']));
                                            while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                                $promosyonId = $var['promosyon_id'];
                                                $secenekDegeri = $promosyonId . ':' . $var['promosyon_ucret'];
                                                if ($secilmisPromosyonlar != '') {
                                                    $isChecked = in_array($promosyonId, $secilmisPromosyonlar) ? 'checked' : '';
                                                } else {
                                                    $isChecked = '';
                                                }


                                            ?>
                                        <div class='col-md-12'>
                                            <label>
                                                <input <?= $isChecked; ?> type='checkbox' name='promosyon[]'
                                                    data-fiyat="<?= $var['promosyon_ucret']; ?>"
                                                    class='tutarHesapla form-check-input'
                                                    value='<?= $secenekDegeri; ?>' />
                                                <?= $var['promosyon_adi']; ?> <b> +<?= $var['promosyon_ucret']; ?>
                                                    TL</b>
                                            </label>
                                        </div>
                                        <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
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

    getirVaryant(<?= $adet; ?>);
    // ekleVaryant(<?= $adet; ?>);

    $(".select").select2();
    hesaplaSiparisUcret();

    $("#siparis_indirim").on("change keyup", function() {
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
                siparis_id: <?= $id; ?>
            },
            success: function(response) {
                $('#varyantSecim' + adet).html(response);
            }
        });
    }
});
</script>