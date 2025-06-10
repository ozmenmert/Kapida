<?php
//include(dirname(__FILE__, 2)."/ayar.php");
include "../ayar.php";

$id = $_GET['id'] ?? -1;
$data = $conn->query("SELECT * FROM a_urun_varyantlar WHERE urun_varyant_id = '$id' ")->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    header('Location: urun-urungorsel-listesi?durum=gecersizIslem');
    die();
}
$pageName = $data['varyant_adi'];

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
        <?php include '../share/urun-page-header.php'; ?>
        
        <div class="row">
            <div class="col-md-6">
                <form action="islemler.php" method="POST">
                    <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
                    <input type="hidden" name="urun_varyant_id" value="<?= $data['urun_varyant_id'] ?>">
                    <div class="card">
                        <div class="card-header">
                            <h5>Varyant Güncelle</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Varyant</label>
                                        <input type="text" name="varyant_adi" value="<?= $data['varyant_adi'] ?>" placeholder="Varyant Adı" class="form-control" required>
                                    </div>
                                </div>                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Önceki Fiyatı</label>
                                        <input type="text" name="varyasyon_degerleri" value="<?= $data['degerler'] ?>" placeholder="Değerleri virgül ile ayırın" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" name="varyantGuncelle" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
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