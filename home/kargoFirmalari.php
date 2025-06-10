<?php
    include('../ayar.php');

    if ($_POST["selectedOdeme"] == 1) { ?>
        <h4 class="mb-101" style="text-align: center;">Kargo Firmasını Seç</h4>								
        <div class="mb-7 text-center">
            <table style="width:100%!important; text-align: center;">
                <?php
                    $sayac = 0;
                    $veriCek = getSql("SELECT * FROM kargo_firmalar WHERE durum = 1 AND kapida_nakit = 1 ORDER BY kargo_adi ASC");
                    foreach($veriCek as $var){ ?>
                        <tr>
                            <td>
                                <label for="kargo-<?=$var['kargo_id']?>" class="kargo-label">
                                    <input type="radio" name="kargo" id="kargo-<?=$var['kargo_id']?>" 
                                           value="<?=$var['kargo_id']?>" <?= $sayac == 0 ? 'checked="checked"' : ''; ?> />
                                    <img src="<?=$anasayfa_url.'/'.$var['kargo_img']; ?>" 
                                         alt="<?=$var['kargo_adi'] ?>" class="kargo-logo">
                                </label>
                            </td>
                        </tr>
                <?php $sayac++; } ?>
            </table>
        </div>
<?php } elseif ($_POST["selectedOdeme"] == 0) { ?>
        <h4 class="mb-101" style="text-align: center;">Kargo Firmasını Seç</h4>								
        <div class="mb-7 text-center">
            <table style="width:100%!important; text-align: center;">
                <?php
                    $sayac = 0;
                    $veriCek = getSql("SELECT * FROM kargo_firmalar WHERE durum = 1 AND kapida_kart = 1 ORDER BY kargo_adi ASC");
                    foreach($veriCek as $var){ ?>
                        <tr>
                            <td>
                                <label for="kargo-<?=$var['kargo_id']?>" class="kargo-label">
                                    <input type="radio" name="kargo" id="kargo-<?=$var['kargo_id']?>" 
                                           value="<?=$var['kargo_id']?>" <?= $sayac == 0 ? 'checked="checked"' : ''; ?> />
                                    <img src="<?=$anasayfa_url.'/'.$var['kargo_img']; ?>" 
                                         alt="<?=$var['kargo_adi'] ?>" class="kargo-logo">
                                </label>
                            </td>
                        </tr>
                <?php $sayac++; } ?>
            </table>
        </div>
<?php } else { ?>
        <p>Ödeme yöntemi seçiniz.</p>
<?php } ?>


<style>
/* Kargo logosunun kapsayıcı alanı */
.kargo-label {
    cursor: pointer; /* İşaretçiyi el simgesine çevirir */
    display: inline-block;
    margin: 10px;
    text-align:  center;
    position: relative;
}

/* Görsellerin boyutu ve ayarı */
.kargo-logo {
    width: 200px;
    height: auto;
    border: 2px solid transparent; /* Seçili olmayan durum için boş border */
    border-radius: 10px;
    transition: border 0.3s ease-in-out; /* Seçim geçiş efekti */
}

/* Input'un görünmez hale getirilmesi */
.kargo-label input[type="radio"] {
    display: none;
}

/* Seçili durumdaki kargo logosu için çerçeve efekti */
.kargo-label input[type="radio"]:checked + .kargo-logo {
    border: 2px solid #fe0200; /* Mavi renkli border */
    box-shadow: 0 0 10px rgb(254 2 0 / 60%);
}
</style>