<?php
include 'ayar.php';
$sayfa_hizmet_id = 10;
redirectToUnauthorized($sayfa_hizmet_id, 'ekle');
$pageName = 'Kullanıcı Ekle';


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
                <h5>Kullanıcı Ekle</h5>

                <div class="list-btn">
                    <ul class="filter-list">


                        <li>
                            <a class="btn btn-primary" href="kullanici-listesi"><i class="fa fa-list me-2" aria-hidden="true"></i>Kullanıcı Listesi</a>
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
                            <div class="row">


                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Kullanıcı Adı</label>
                                        <input type="text" name="adi" class="form-control" placeholder="Kullanıcı Adı" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Şifre</label>
                                        <input type="password" name="sifre" class="form-control" placeholder="Şifre" required>
                                    </div>
                                </div>




                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>E-Mail</label>
                                        <input type="email" name="email" class="form-control" placeholder="E-Mail" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Telefon</label>
                                        <input type="text" name="tel" class="form-control phoneMask" placeholder="Telefon" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" name="kullaniciEkle" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
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