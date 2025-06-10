<?php
include 'ayar.php';


if (!isset($_GET['id'])) {
    header('Location: ' . SiteUrl('panel'));
}



$id = $_GET['id'];
$data = $conn->query("SELECT * FROM icerik WHERE id = '$id' ")->fetch(PDO::FETCH_ASSOC);
$pageName = 'İçerik Düzenle';

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
                            <a class="btn btn-info" href="icerik-listesi"><i class="fa fa-list me-2" ></i>İçerik Listesi</a>
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
                            <input type="hidden" name="id" value="<?= $data['id'] ?>">

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Başlık</label>
                                        <input type="text" name="baslik" class="form-control" placeholder="İçerik başlığı" required value="<?= $data['baslik'] ?>" <?=($data['id']==1) ? 'readonly' : '' ; ?>>
                                    </div>


                                    <div class="form-group">
                                        <label>İçerik</label>
                                        <textarea class="form-control customSummernote" name="icerik" required><?= $data['icerik'] ?></textarea>
                                    </div>

                                </div>

                                <div class="col-lg-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" name="icerikDuzenle" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
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