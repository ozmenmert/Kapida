<div class="altMenu bg-light pb-0 pt-3">
    <div class="row d-flex justify-content-between align-items-center p-415">
        <div class="col">
            <div class="d-flex w-100 align-items-center">
                <div class="me-6 mobile-hidden">
                    <img src="<?=$anasayfa_url.'/'.$data['urun_img'] ?>" class="loaded" width="60" height="50" alt="<?=$data['urun_adi'] ?>" loading="lazy" data-ll-status="loaded">
                </div>
                <div class="d-flex flex-column p-3">

                    <h4 id="product-title-adet" class="product-title card-title text-body-emphasis-sabitform fs-15px fw-500 mb-3">
                        <?=$data['urun_adi'] ?>
                    </h4>

                    <div id="adetBilgisi" class="price altmenufiyatcolor fw-bold justify-content-center fs-6 badge toplamOdeme">		
                    </div>

                </div>
            </div>
        </div>				
    </div>
</div>

<div class="notification-container" id="orderNotification" style="display: none;">
    <i class="fa fa-bell"></i>
    <span id="orderMessage"></span>
    <button class="close-notification" onclick="hideOrderNotification()">×</button>
</div>
<div class="feature-container" id="featureNotification"></div>