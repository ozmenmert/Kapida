<?php
include 'ayar.php';
$pageName = 'Yorum Düzenle';



if (!isset($_GET['id'])) {
    header('location:index.php?durum=izinsizGiris');
}


$id = $_GET['id'];
$data = $conn->query("SELECT * FROM yorumlar WHERE yorum_id = '$id' ")->fetch(PDO::FETCH_ASSOC);


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
                <h5>Yorum Düzenle</h5>

                <div class="list-btn">
                    <ul class="filter-list">


                        <li>
                            <a class="btn btn-primary" href="yorumlar"><i class="fa fa-list me-2"
                                aria-hidden="true"></i>Yorum Listesi</a>
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
                                <input type="hidden" name="yorum_id" value="<?= $data['yorum_id'] ?>">
                                <div class="row">

                                    <div class="col-md-12 text-center mb-4">
                                        <img style="height: 250px;width: auto;" src="../<?php echo $data['yorum_img']; ?>">
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Yorum Görseli</label>
                                            <input type="file" class="form-control" name="yorum_img">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Ürün</label>
                                            <select class="form-select w-100 select2 "
                                            name="yorum_urun" required>
                                            <option value="">Ürün Seçiniz</option>
                                            <?php
                                            $veriCek = $conn->prepare("SELECT * FROM urunler ORDER BY urun_adi ASC");
                                            $veriCek->execute();
                                            while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option <?=($data['yorum_urun']==$row['urun_id']) ? 'selected' : '' ; ?> value="<?= $row['urun_id'] ?>">
                                                    <?= $row['urun_adi'] ?>
                                                </option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" name="yorumDuzenle"
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