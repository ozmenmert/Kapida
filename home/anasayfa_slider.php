<div class="row">
    <div class="col-12 order-0 position-relative">
        <div id="vertical-slider-slides" class="slick-slider slick-slider-arrow-inside g-0"
                data-slick-options="{&quot;arrows&quot;:true,&quot;dots&quot;:false,&quot;slidesToShow&quot;:1,&quot;autoplay&quot;:true,&quot;autoplaySpeed&quot;:3000,&quot;asNavFor&quot;:&quot;#vertical-slider-thumb&quot;}">
            <?php
                $sql = "SELECT u_g.urun_id, u_g.urungorsel_id, g.img FROM a_urunler_urungorselleri AS u_g
                        LEFT OUTER JOIN a_urungorselleri AS g ON g.urungorsel_id = u_g.urungorsel_id
                        WHERE u_g.urun_id = ".$urun_id." ORDER BY u_g.sira;";
                $veriCek = getSql($sql);
                foreach($veriCek as $var){ 
                    $src = $anasayfa_url . '/' . $var['img'];
                    $th_src = $anasayfa_url . '/' . $var['img'];

                    //$src =  'https://localhost/mehdi/panel-yeni/' . $var['img'];
                    //$th_src =  'https://localhost/mehdi/panel-yeni/thumbs/' . $var['img'];
                ?>
                    <a href="<?= $src ?>" data-gallery="product-gallery" data-thumb-src="<?= $th_src ?>">
                    <img src="#" data-src="<?= $src ?>" width="540" height="720" class="h-auto lazy-image" alt="<?= $data['urun_adi']; ?>">
                </a>
            <?php } ?>
        </div>

        <?php if($data['urun_video']) { ?>
        <div class="col-12 text-center urunVideoBtn-bosluk">
            <a href="<?=$data['urun_video']?>" class="view-video btn btn-warning text-white urunVideoBtn px-4 py-2">
                <i class="fa fa-play"></i> Ürün videosunu izle
            </a>
        </div>
        <?php } ?>
    </div>

    <div class="col-12 order-1 mt-3">
        <div id="vertical-slider-thumb" class="slick-slider slick-slider-thumb ps-1"
                data-slick-options="{&quot;arrows&quot;:false,&quot;dots&quot;:false,&quot;slidesToShow&quot;:4,&quot;focusOnSelect&quot;:true,&quot;asNavFor&quot;:&quot;#vertical-slider-slides&quot;,&quot;infinite&quot;:true}">
            <?php
                foreach($veriCek as $var){ 
                    $th_src = $anasayfa_url . '/' . $var['img'];
                    //$th_src =  'https://localhost/mehdi/panel-yeni/thumbs/' . $var['img'];
            ?>
                <img src="#" data-src="<?= $th_src ?>" class="cursor-pointer lazy-image mx-2 px-0 mb-2" width="75" height="100" alt="<?= $data['urun_adi']; ?>">
            <?php } ?>
        </div>
    </div>
</div>