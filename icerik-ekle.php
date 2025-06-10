<?php
include 'ayar.php';

$pageName = 'İçerik Ekle';

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
                            <a class="btn btn-primary" href="icerik-listesi"><i class="fa fa-list me-2" aria-hidden="true"></i>İçerik Listesi</a>
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
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Başlık</label>
                                        <input type="text" name="baslik" class="form-control" placeholder="İçerik başlığı" required>
                                    </div>
                                    <div class="form-group">
                                        <label>İçerik</label>
                                        <textarea id="" class="form-control customSummernote" name="icerik" required></textarea>

                                    </div>

                                </div>

                                <div class="col-lg-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" name="icerikEkle" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
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