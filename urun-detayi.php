<?php
include 'ayar.php';

$sayfa_hizmet_id = 3;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

$pageName = 'Ürün Detayı';
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
            </div>
        </div>

        <?php include "urun-detayi-alerts.php"; ?>

        <div class="row">
            <?php include "urun-detayi-urunOzellikleri.php"; ?>
            <?php include "urun-detayi-urunResimleri.php"; ?>
            <?php include "urun-detayi-urunkargo.php"; ?>
            <?php include "urun-detayi-varyantlar.php"; ?>
            <?php include "urun-detayi-promosyonlar.php"; ?>
            <?php include "urun-detayi-yorumlar.php"; ?>
        </div>

    </div>
</div>
<?php include 'footer.php'; ?>
<script src="sweetalert.min.js"></script>