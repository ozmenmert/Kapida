<div class="modal fade" id="quickViewModal" aria-labelledby="quickViewModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0 py-5">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">

                <form id="siparisForm">

                    <input type="hidden" name="urun_id" value="<?= $urun_id ?>">
                    <input type="hidden" name="domain" value="<?= $domain ?>">

                    <div id="step1" class="step">
                        <div class="checkout">
                            <h4 class="fs-4 text-center">Teslimat Bilgileriniz</h4>
                            <h6 class="text-warningform">Eksik bilgi girilirse siparişiniz tamamlanamayabilir, lütfen doğru ve eksiksiz doldurun.</h6>

                            <div class="mb-7">
                                <label class="mb-5 fs-13px letter-spacing-01 fw-semiboldform text-uppercase">İsim Soyisim<span style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-controlform" id="name" name="name" placeholder="İsim Soyisim" required="">
                                <div id="name_error" style="color: red;"></div>
                            </div>

                            <div class="mb-7">
                                <label class="mb-5 fs-13px letter-spacing-01 fw-semiboldform text-uppercase">Telefon Numaranız<span style="color: red; font-weight: bold;">*</span></label>
                                <input type="text" class="form-controlform" id="telefon" name="telefon" placeholder="(0 ile başlayınız) 0 5..." required="">
                                <div id="telefon_error" style="color: red;"></div>
                            </div>

                            <div class="mb-7">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="mb-5 fs-13px letter-spacing-01 fw-semiboldform text-uppercase">Şehir<span style="color: red; font-weight: bold;">*</span></label>
                                        <div id="il_div">
                                            <select id="il" name="il" class="validate[required] line-one il form-controlform">
                                                <option value="">Şehir Seçiniz</option>
                                                <?php
                                                $veriCek = getSql("SELECT * FROM iller ORDER BY il_adi ASC");
                                                foreach ($veriCek as $var) { ?>
                                                    <option value="<?= $var['id'] ?>"><?= $var['il_adi'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div id="il_error" style="color: red;"></div>
                                        <input type="hidden" name="ip_adres" value="<?= $_SERVER["REMOTE_ADDR"]; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-5 fs-13px letter-spacing-01 fw-semiboldform text-uppercase">İlçe<span style="color: red; font-weight: bold;">*</span></label>
                                        <div id="ilce_div">
                                            <select id="ilce" name="ilce" class="validate[required] line-one ilce form-controlform">
                                                <option value="">İlçe Seçiniz</option>
                                            </select>
                                        </div>
                                        <div id="ilce_error" style="color: red;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-7">
                                <label class="mb-5 fs-13px letter-spacing-01 fw-semiboldform text-uppercase">Teslimat Adresi<span style="color: red; font-weight: bold;">*</span></label>
                                <textarea class="form-controlform" rows="2" id="textarea-1" name="adres" placeholder="Mahalle, cadde & sokak, kapı ve daire no yazınız" required=""></textarea>
                                <div id="adres_error" style="color: red;"></div>
                            </div>

                            <div class="mb-7">
                                <label class="mb-5 fs-13px letter-spacing-01 fw-semiboldform text-uppercase" for="textarea-2">Sipariş Notunuz</label>
                                <div class="row">
                                    <div class="col-md-12 mb-md-0 mb-7">
                                        <textarea class="form-controlform" rows="1" id="textarea-2" name="not" placeholder="" required=""></textarea>
                                    </div>
                                </div>
                            </div>
                            <div style="background-color: #f0f8ff; border: 1px solid #b0c4de; padding: 5px; border-radius: 10px; font-size: 16px; color: #333;">
                                <p style="margin: 0; line-height: 1.5;">
                                    Değerli müşterimiz, lütfen gereksiz siparişler oluşturmaktan kaçının.
                                    Verdiğiniz siparişi özenle takip etmenizi ve zamanında teslim almanızı rica ederiz.
                                </p>
                            </div>

                            <div class="d-flex policy mb-3" style="margin-top: 20px;">
                                <input checked class="policyCheck" type="checkbox" value="1" name="policy" />
                                <div style="margin-left: 4%;">
                                    <a id="showContract" data-fancybox="" data-id="1" href="javascript:void(0);"> Mesafeli Satış Sözleşme</a>'sini okudum ve kabul ediyorum.
                                </div>
                                <div id="policy_error" style="color: red;"></div>
                            </div>

                            <button type="button" class="btn urun-aciklamasi w-100 nextStep">Devam Et</button>
                            <button type="button" class="btn urun-aciklamasi-geri w-100" data-bs-dismiss="modal" aria-label="Close" style="margin-bottom: 150px;">Geri Git</button>
                        </div>
                    </div>

                    <div id="step2" class="step" style="display: none;">
                        <div class="extra-product-offer" style="text-align: center; background-color: #f8f9fa; padding: 9px; border-radius: 0px 0px 15px 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <button type="button" class="btn urun-aciklamasi w-100 mt-4 siparisTamamla">Siparişi Tamamla</button>
                            <button type="button" class="btn urun-aciklamasi-geri w-100 prevStep">Geri Git</button>

                            <div class="form-group shop-swatch mb-7 promosyon-background align-items-center">
                                <div class="container mb-5">

                                    <div style="background-color: #dddddd;padding: 8px;border-radius: 15px; margin-top:10px;">
                                        <h4 class="mb-101" style="text-align: center;">Ödeme Şekli</h4>

                                        <div class="mb-7-step22 mb-100 d-flex justify-content-start radio-container">
                                            <div class="form-check mb-2 pb-4 adetSecimpro d-flex border border-primary active" data-odeme="1">
                                                <input class="form-check-input odemeSecim" type="radio" name="odeme" id="odeme1" value="Kapıda Nakit Ödeme" style="display:none" checked>
                                                <label class="form-check-label text-body-emphasis-sabit-form " for="odeme1">Kapıda Nakit</label>
                                            </div>
                                            <div class="form-check mb-2 pb-4 adetSecimpro d-flex border border-primary" data-odeme="0">
                                                <input class="form-check-input odemeSecim" type="radio" name="odeme" id="odeme2" style="display:none" value="Kapıda Kart ile Ödeme">
                                                <label class="form-check-label text-body-emphasis-sabit-form " for="odeme2"> Kapıda Kredi Kartı </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="kargo_firmalari"></div>

                                    <div class="text-center" style="font-size:15px">
                                        <p>Siparişiniz <strong style="color:red;">1-5 iş günü</strong> içerisinde şeffaf kargo ile adresinize teslim edilecektir.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <h4 class="mb-101" style="text-align: center;">Toplam Ödemeniz:</h4>
                                <p class="toplamOdemesayafasi toplamtutar-tamamla"></p>
                            </div>

                            <div class="checkout">
                                <?php
                                $promosyonSayi = getOneSql("SELECT COUNT(*) AS toplam FROM a_urunler_promosyonlar WHERE urun_id = $urun_id");
                                if ($promosyonSayi['toplam'] > 0) { ?>
                                    <div class="form-group shop-swatch mb-7 promosyon-background align-items-center">
                                        <div class="container mb-5">
                                            <div class="row">
                                                <div class="col-12 col-lg-4"></div>
                                                <div class="col-12 col-lg-4">
                                                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                                                        <h4 style="color: #27ae60; font-size: 22px; font-weight: bold; margin-top:5px; text-transform: uppercase;"> Ekstra Ürün Al | %50 İNDİRİM! </h4>
                                                        <div class="carousel-inner">
                                                            <?php
                                                            $sayac = 0;

                                                            $sql = "SELECT g.img FROM a_promosyongorselleri AS g
                                                        LEFT OUTER JOIN a_promosyonlar_promosyongorselleri AS p_g ON g.promosyongorsel_id = p_g.promosyongorsel_id
                                                        LEFT OUTER JOIN a_promosyonlar AS p ON p.promosyon_id = p_g.promosyon_id
                                                        LEFT OUTER JOIN a_urunler_promosyonlar AS u_p ON u_p.promosyon_id = p.promosyon_id
                                                        WHERE u_p.urun_id = " . $urun_id . " ORDER BY p_g.sira;";
                                                            $veriCek = getSql($sql);

                                                            foreach ($veriCek as $var) {
                                                                $src = $anasayfa_url . '/' . $var['img'];
                                                                //$src =  'https://localhost/mehdi/panel-yeni/thumbs/'.$var['img'];
                                                            ?>
                                                                <div class="carousel-item <?= ($sayac == 0) ? 'active' : ''; ?>">
                                                                    <img class="d-block w-100" src="<?= $src ?>" alt="<?= $data['urun_adi'] ?>" style="max-height: 300px;width: auto;">
                                                                </div>
                                                            <?php $sayac++;
                                                            } ?>
                                                        </div>
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                                                            <span class="fa fa-arrow-left text-whitepro fs-3" aria-hidden="true"></span>
                                                            <span class="visually-hidden">previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                                                            <span class="fa fa-arrow-right text-whitepro fs-3" aria-hidden="true"></span>
                                                            <span class="visually-hidden">next</span>
                                                        </button>

                                                        <?php if ($data['promosyon_video']) { ?>
                                                            <div class="text-center">
                                                                <a href="<?= $data['promosyon_video'] ?>" class=" view-video btn btn-info text-white urunPromoBtn px-2 py-1">
                                                                    <i class="fa fa-play"></i> Promosyon videosunu izle
                                                                </a>
                                                            </div>
                                                        <?php } ?>
                                                    </div>

                                                    <p style="text-align: center; font-size: 18px; font-weight: bold;">
                                                        <span class="red-text">SÜRPRİZ YOK!</span>
                                                        <span class="blue-text">MASRAF YOK!</span>
                                                        <span class="green-text">KARGO BİZDEN!</span>
                                                    </p>

                                                </div>
                                                <div class="col-12 col-lg-4"></div>
                                            </div>
                                        </div>

                                        <ul class="list-inline flex-column justify-content-start mb-0form">
                                            <?php
                                            $sql = "SELECT p.promosyon_id, p.promosyon_adi, p.promosyon_onceki, p.promosyon_ucret, p.promosyon_video FROM a_promosyonlar AS p
                                            LEFT OUTER JOIN a_urunler_promosyonlar AS u_p ON u_p.promosyon_id = p.promosyon_id
                                            WHERE u_p.urun_id = " . $urun_id . " ORDER BY p.promosyon_ucret;";
                                            $veriCek = getSql($sql);
                                            $firstItem = true; // Variable to check if it's the first item
                                            foreach ($veriCek as $var) { ?>
                                                <li class="list-inline-item me-4 mb-3 fw-semibold position-relative" style="width:100%">
                                                    <input type="checkbox" id="checkbox-<?= $var['promosyon_id']; ?>"
                                                        value='<?= $var['promosyon_id']; ?>:<?= $var['promosyon_ucret']; ?>'
                                                        name='promosyon[]' data-fiyat="<?= $var['promosyon_ucret']; ?>"
                                                        class="product-info-size d-none">

                                                    <label for="checkbox-<?= $var['promosyon_id']; ?>" class="promosyon-isim p-4 d-block rounded text-decoration-none border" style="border:1px solid #a0a0a0" data-var="full size">
                                                        <span><?= $var['promosyon_adi']; ?></span><br>
                                                        <span class="text-decoration-line-through mx-3 onceki-text-body"><?= $var['promosyon_onceki']; ?> TL</span>
                                                        <b> +<?= $var['promosyon_ucret']; ?> TL</b>
                                                    </label>
                                                    <?php if ($firstItem) { ?>
                                                        <i class="fas fa-fire flame-icon" aria-hidden="true"></i>
                                                        <?php $firstItem = false; // Set it to false after the first item 
                                                        ?>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        </ul>

                                        <div class="text-center">
                                            <h4 class="mb-101" style="text-align: center;">Toplam Ödemeniz:</h4>
                                            <p class="toplamOdemesayafasi toplamtutar-tamamla"></p>
                                        </div>

                                    </div>
                            </div>

                        <?php } ?>
                        </div>
                        <button type="button" class="btn urun-aciklamasi w-100 mt-4 siparisTamamla">Siparişi Tamamla</button>
                        <button type="button" class="btn urun-aciklamasi-geri w-100 prevStep" style="margin-bottom: 100px;">Geri Git</button>

                        <div class="position-fixed z-index-10 end-0 p-5" style="bottom: 250px !important;">
                            <a href="#" id="scrlBotm" class="smooth-slide text-decoration-none bg-body text-primary bg-primary-hover text-light-hover shadow square p-0 rounded d-flex align-items-center justify-content-center"
                                title="Back To Top" style="--square-size: 48px"><i class="fa-solid fa-arrow-down"></i>
                            </a>
                        </div>

                </form>

                <div class="position-fixed z-index-10 end-0 p-5" style="bottom: 185px !important;">
                    <a href="#" class="gtf-back-to-top text-decoration-none bg-body text-primary bg-primary-hover text-light-hover shadow square p-0 rounded-circle d-flex align-items-center justify-content-center" title="Back To Top" style="--square-size: 48px"><i class="fa-solid fa-arrow-up"></i></a>
                </div>

            </div>
        </div>
    </div>
</div>