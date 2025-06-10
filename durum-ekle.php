<?php
include 'ayar.php';
$sayfa_hizmet_id = 8;
redirectToUnauthorized($sayfa_hizmet_id, 'ekle');
$pageName = 'Sipariş Durumu Ekle';

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
        <div class="page-header">
            <div class="content-page-header">
                <h5><?= $pageName ?></h5>

                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-primary" href="durum-listesi"><i class="fa fa-list me-2" aria-hidden="true"></i>Sipariş Durumları</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>



        <div class="row">

            <div class="col-xl-12 col-md-12">
                <div class="card w-100 pt-0">
                    <div class="card-body">
                        <form action="islemler.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="tur" value="metin">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Durum Adı</label>
                                        <input type="text" name="siparis_durum_adi" class="form-control" placeholder="Durum Adı" required>
                                    </div>


                                    <div class="col-lg-12 text-end">
                                        <div class="btn-path">
                                            <button type="submit" name="durumEkle" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
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