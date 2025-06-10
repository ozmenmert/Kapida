<?php
include 'ayar.php';
$id = $_GET['id'] ?? -1;
$data = $conn->query("SELECT * FROM urunler WHERE urun_id = '$id' ")->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    header('Location: urun-urungorsel-listesi?durum=gecersizIslem');
    die();
}
$pageName = "Ürüne Görsel Ekle";
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
            <form action="islemler.php" method="POST">
                <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
                <div class="card">
                    <div class="card-header">
                        <h5><?=$data['urun_adi']?> | <span class="alert alert-danger px-1 py-1">(id: <?=$data['urun_id']?>)</span> | İçin Görsel Ekle</h5>
                    </div>
                    <div class="card-body">

                        <div class="row">

                            <div class="col-lg-12">
                                <div class="row">
                                    <?php
                                        $urungorselIdler = array();
                                        $veriCek = $conn->prepare("SELECT * FROM a_urunler_urungorselleri WHERE urun_id = ".$data['urun_id'].";");
                                        $veriCek->execute();
                                        while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                            $urungorselIdler[] = $row["urungorsel_id"];
                                        }
                                        $veriCek = $conn->prepare("SELECT * FROM a_urungorselleri;");
                                        $veriCek->execute();
                                        $checked = "";
                                        while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                            if(in_array($row['urungorsel_id'], $urungorselIdler)){
                                                $checked = "checked";
                                            }else{
                                                $checked = "";
                                            }
                                            ?>
                                            <div class="col-lg-1">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" name="urungorsel_id[]" type="checkbox" value="<?= $row['urungorsel_id'] ?>" <?= $checked ?>>
                                                    </div>
                                                </div>
                                                
                                                <a href="../<?= $row['img'] ?>" target="_BLANK">
                                                    <img class="tableImg1" src="../thumbs/<?= $row['img'] ?>" title="id: <?= $row['urungorsel_id'] ?>">
                                                </a>                                                    
                                            </div>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="col-lg-12 text-end">
                                <div class="btn-path">
                                    <button type="submit" name="uruneGorselEkle" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="sweetalert.min.js"></script>