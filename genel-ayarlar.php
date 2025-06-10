<?php
include 'ayar.php';
$sayfa_hizmet_id = 9;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');
$pageName = 'Genel Ayarlar';
$meta = array(
    'title' => $pageName . $separator .  $siteData['title'],
    'description' => $siteData['description'],
    'keywords' => $siteData['keywords'],
    'author' => $siteData['author']
);
include 'header.php';
?>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card w-100 pt-0">
                    <div class="card-body">
                        <div class="content-page-header">
                            <h5>Genel Ayarlar</h5>
                        </div>
                        <form action="islemler.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Logo</label>
                                        <div class="form-group service-upload logo-upload mb-0">
                                            <span><img src="assets/img/icons/img-drop.svg" alt="upload"></span>
                                            <div class="drag-drop">
                                                <h6 class="drop-browse align-center">
                                                    <span class="text-info me-1">Tıkla Değiştir </span> veya Sürükle
                                                    Bırak
                                                </h6>
                                                <p class="text-muted">SVG, PNG, JPG (512*512px)</p>
                                                <input type="file" name="logo" id="image_sign">
                                                <div id="frames">
                                                    <img src="../<?= $siteData['ayar_logo'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Favicon</label>
                                        <div class="form-group service-upload logo-upload mb-0">
                                            <span><img src="assets/img/icons/img-drop.svg" alt="upload"></span>
                                            <div class="drag-drop">
                                                <h6 class="drop-browse align-center">
                                                    <span class="text-info me-1">Tıkla Değiştir </span> veya Sürükle
                                                    Bırak
                                                </h6>
                                                <p class="text-muted">SVG, PNG, JPG (512*512px)</p>
                                                <input type="file" name="favicon" id="image_sign2">
                                                <div id="frames2">
                                                    <img src="../<?= $siteData['ayar_icon'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Sistem Başlığı</label>
                                        <input type="text" name="title" class="form-control"
                                            placeholder="Sistem Başlığı" value="<?= $siteData['title'] ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Site Açıklama</label>
                                        <input type="text" name="description" class="form-control"
                                            placeholder="Site Açıklama" value="<?= $siteData['description'] ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Site Kelimeler</label>
                                        <input type="text" name="keywords" class="form-control"
                                            placeholder="Site Kelimeler" value="<?= $siteData['keywords'] ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Site Yazar</label>
                                        <input type="text" name="author" class="form-control" placeholder="Site Yazar"
                                            value="<?= $siteData['author'] ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Ana Site Url</label>
                                        <input type="text" name="anasayfa_url" class="form-control"
                                            placeholder="Ana Site Url" value="<?= $siteData['anasayfa_url'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Detay Kodu</label>
                                        <textarea class="form-control" rows="15"
                                            name="ek_detay"><?= $siteData['ek_detay'] ?></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Purchase Kodu</label>
                                        <textarea class="form-control" rows="15"
                                            name="ek_purchase"><?= $siteData['ek_purchase'] ?></textarea>
                                    </div>
                                </div>
                                
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Ek Script</label>
                                        <textarea class="form-control" rows="15"
                                            name="ek_script"><?= $siteData['ek_script'] ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Ek Css (style etiketi eklemenize gerek yoktur.)</label>
                                        <textarea class="form-control"
                                            name="ek_css"><?= $siteData['ek_css'] ?></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" name="siteAyarGuncelle"
                                            class="btn btn-info btn-block w-100 btn-lg"><i
                                                class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>