<form class="product-info-custom">
    <div style="background-color: #dddddd;padding: 8px;border-radius: 15px;" >
        <h4 class="mb-101" style="text-align: center;">Ürün Adedini Seç</h4>
        <?php
        $sayac = 0;
        $veriCek = getSql("SELECT * FROM a_urun_fiyatlandirma WHERE urun_id = $urun_id ORDER BY adet");
        foreach($veriCek as $var){ ?>
            <div class="form-checkmb-2 pb-4 adetSecim d-flex border border-primary">
                <input type="radio" 
                    name='adet' 
                        data-adet="<?= $var['adet']; ?>" 
                        data-onceki="<?= $var['onceki']; ?>" 
                        data-fiyat="<?= $var['fiyat']; ?>" 
                        data-kargo="<?= $var['kargo_tutar']; ?>"
                        class="optionsRadios form-check-input product-info-input"
                        id='optionsRadios<?= $var['urun_fiyatlandirma_id']; ?>' 
                        value='<?= $var['urun_fiyatlandirma_id'] . ':' . $var['adet'] . ':' . $var['fiyat'] . ':' . $var['kargo_tutar'] . ':' . $var['kargo_durum']; ?>'  <?= ($sayac === 0) ? 'checked' : ''; ?>
                    class="me-4 form-check-input product-info-input">
                <label for="optionsRadios<?= $var['urun_fiyatlandirma_id']; ?>" class="mx-3 text-body-emphasis-sabit-form form-check-label">
                    <?= $var['adet']; ?> Adet 
                    <span class="text-decoration-line-through mx-3 text-body-form"><?= $var['onceki']; ?> TL Yerine</span>
                    <span class="fw-bold"><?= $var['fiyat']; ?> TL</span><br>
                    <?php if ($var['kargo_durum'] == 1 and $var['kargo_tutar'] > 0) { ?>
                        <span class="badge badge-danger fs-6 border text-danger fw-bold ms-4">
                            + KARGO (<?= $var['kargo_tutar'] . ' TL' ?>)
                        </span>
                    <?php } else { ?>
                        <span class="badge badge-success fs-6 border text-success-form fw-bold ms-4">
                            ÜCRETSİZ KARGO
                        </span>
                    <?php } ?>
                </label>
            </div>

            <div class="varyantlar"  id="varyantSecim<?= $var['adet']; ?>"></div>
            <?php
            $sayac++;
        } ?>
        <button type="button" class="satinAlBtn btn btn-lg urun-aciklamasi mb-7 mt-7 w-100 btn-hover-bg-primary btn-hover-border-primary"> SİPARİŞİ OLUŞTUR</button>
    </div>
</form>