<?php


include('../ayar.php');

$urun_id = $_POST['urun_id'];

?>

<div class="card w-100 pt-0">
    <div class="card-body">
        <h6 class="my-2">Adet Seçimi</h6>
        <div class="row">
            <div class="col-md-6 mb-2">
                <div class='row'>
                    <div class='radio'>
                        <?php
                        $veriCek = $conn->prepare("SELECT * FROM urun_fiyatlandirma WHERE urun_id = :urun_id ORDER BY adet");
                        $veriCek->execute(array('urun_id' => $urun_id));
                        while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                         $data = $conn->query("SELECT * FROM urunler WHERE urun_id = ".$urun_id)->fetch(PDO::FETCH_ASSOC);
                         ?>
                        <label for="optionsRadios<?= $var['urun_fiyatlandirma_id']; ?>">
                            <input type='radio' name='adet' required data-adet="<?= $var['adet']; ?>"
                                data-fiyat="<?= $var['fiyat'] + $var['kargo_tutar']; ?>"
                                data-kargo="<?= $var['kargo_tutar']; ?>"
                                class='tutarHesapla optionsRadios form-check-input'
                                id='optionsRadios<?= $var['urun_fiyatlandirma_id']; ?>'
                                value='<?= $var['urun_fiyatlandirma_id'] . ':' . $var['adet'] . ':' . $var['fiyat'] . ':' . $var['kargo_tutar'] . ':' . $var['kargo_durum']; ?>' />
                            <?= $var['adet']; ?> Adet <?= $data['urun_adi']; ?> - <b>
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
                    $promosyonSayi = $conn->query("SELECT COUNT(*) AS toplam FROM promosyon_urunler WHERE urun_id =" . $urun_id)->fetch(PDO::FETCH_ASSOC);
                    if ($promosyonSayi['toplam'] > 0) { ?>
                    <?php
                        $veriCek = $conn->prepare("SELECT * FROM promosyon_urunler WHERE urun_id = :urun_id ORDER BY promosyon_ucret");
                        $veriCek->execute(array('urun_id' => $urun_id));
                        while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                            $promosyonId = $var['promosyon_id'];
                            $secenekDegeri = $promosyonId . ':' . $var['promosyon_ucret'];

                        ?>
                    <div class='col-md-12'>
                        <label>
                            <input type='checkbox' name='promosyon[]' data-fiyat="<?= $var['promosyon_ucret']; ?>"
                                class='tutarHesapla form-check-input' value='<?= $secenekDegeri; ?>' />
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