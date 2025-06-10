<?php
//include(dirname(__FILE__, 2)."/ayar.php");
include "../ayar.php";
$pageName = 'Promosyon Ekle';
$sayfa_hizmet_id = 3;
redirectToUnauthorized($sayfa_hizmet_id, 'ekle');
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
        <?php include '../share/promosyon-page-header.php'; ?>
        <div class="row">
            <div class="col-md-6">
                <form action="islemler.php" method="POST">
                    <div class="card">
                        <div class="card-header">
                            <h5>Promosyon Bilgisi</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Promosyon Adı</label>
                                        <input type="text" name="promosyon_adi" class="form-control border-danger" placeholder="Promosyon Adı" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Promosyon Kısa Adı</label>
                                        <input type="text" name="promosyon_kisa_adi" class="form-control border-danger" placeholder="Promosyon Kısa Adı" required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Önceki Fiyatı</label>
                                        <input type="number" step="any" name="promosyon_onceki" class="form-control border-danger" placeholder="Önceki Fiyatı" required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Fiyatı</label>
                                        <input type="number" step="any" name="promosyon_ucret" class="form-control border-danger" placeholder="Fiyatı" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Promosyon Video Linki </label>
                                        <input type="text" name="promosyon_video" class="form-control" placeholder="Video Bağlantısı">
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" name="promosyonEkle" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                            
                </form>
            </div>
        </div>

    </div>
</div>
<?php include 'footer.php'; ?>