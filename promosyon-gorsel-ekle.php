<?php
include "../ayar.php";

$sayfa_hizmet_id = 3;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

$pageName = 'Promosyon Görsel Deposu';
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
                <div class="card">
                    <div class="card-header">                        
                        <h5>Promosyon Görseli Ekle</h5>
                    </div>
                    <div class="card-body">

                        <div class="col-lg-12">
                            <form method="POST" action="islemler.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Görseller</label>
                                            <input type="file" name="gorseller[]" class="form-control" required="" accept=".jpg,.jpeg,.png,.gif,.webp" multiple>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" name="promosyonGorselleriEkle" class="btn btn-primary btn-block w-100 mb-1"><i
                                            class="fa fa-plus"></i> Ekle</button>
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
</div>

<?php include 'footer.php'; ?>
<script src="sweetalert.min.js"></script>