<?php
include 'ayar.php';
$pageName = 'Stok Ekle';
$meta = array(
    'title' => $pageName . $separator . $siteData['title'],
    'description' => $siteData['description'],
    'keywords' => $siteData['keywords'],
    'author' => $siteData['author']
);
include 'header.php';
?>
<style>
    .tab-pane .card {
        padding: 0;
    }
</style>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="content-page-header">
                <h5>
                    <?= $pageName ?>
                </h5>
                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-primary" href="stok-listesi"><i class="fa fa-list me-2"
                                aria-hidden="true"></i>Stok Listesi</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card w-100 pt-0">
                        <div class="card-body tabMain">
                            <form action="islemler.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#info" data-bs-toggle="tab">
                                                    <i class="fa fa-th "></i> İNFO
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active show" id="info">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Stok Bilgisi</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label>Stok Görseli</label>
                                                                            <div
                                                                            class="form-group service-upload logo-upload mb-0">
                                                                            <span><img
                                                                                src="assets/img/icons/img-drop.svg"
                                                                                alt="upload"></span>
                                                                                <div class="drag-drop">
                                                                                    <h6 class="drop-browse align-center">
                                                                                        <span class="text-info me-1">Tıkla
                                                                                        Değiştir </span> veya Sürükle
                                                                                        Bırak
                                                                                    </h6>
                                                                                    <p class="text-muted">SVG, PNG, JPG
                                                                                    (512*512px)</p>
                                                                                    <input type="file" name="stok_img"
                                                                                    id="image_sign" required>
                                                                                    <div id="frames">
                                                                                        <img src="">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label>Stok Adı</label>
                                                                            <input type="text" name="stok_adi" class="form-control border-danger" placeholder="Stok Adı" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            

                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-end">
                                        <div class="btn-path">
                                            <button type="submit" name="stokEkle"
                                            class="btn btn-primary btn-block w-100 btn-lg"><i
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