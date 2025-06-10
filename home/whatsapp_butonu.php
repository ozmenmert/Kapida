<?php if ($data['urun_whatsapp'] != '') { ?>
    <a href="https://api.whatsapp.com/send/?phone=+<?= $data['urun_whatsapp']; ?>&text=<?= urlencode($data['urun_adi'] . ' ürününden sipariş vermek istiyorum'); ?>" target="_blank" id="whatsapBtn">
        <img src="<?= $anasayfa_url . '/'; ?>img/whatsapp.svg" alt="<?= $data['urun_adi']; ?>" style="width: 50px;height: 50px;">
    </a>
<?php } ?>