<?php
include 'ayar.php';
$id = $_GET['id'] ?? -1;
$data = $conn->query("SELECT * FROM a_promosyonlar WHERE promosyon_id = '$id' ")->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    header('Location: promosyon-listesi?durum=gecersizIslem');
    die();
}
$pageName = "Promosyona Görsel Ekle";
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

            <form action="islemler.php" method="POST">
                <input type="hidden" name="promosyon_id" value="<?= $data['promosyon_id'] ?>">
                <div class="card">
                    <div class="card-header">
                        <h5><?=$data['promosyon_adi']?> | <span class="alert alert-danger px-1 py-1">(id: <?=$data['promosyon_id']?>)</span> | İçin Görsel Ekle</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="row">
                                    <?php
                                        $promosyongorselIdler = array();
                                        $veriCek = $conn->prepare("SELECT * FROM a_promosyonlar_promosyongorselleri WHERE promosyon_id = ".$data['promosyon_id'].";");
                                        $veriCek->execute();
                                        while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                            $promosyongorselIdler[] = $row["promosyongorsel_id"];
                                        }
                                        $veriCek = $conn->prepare("SELECT * FROM a_promosyongorselleri;");
                                        $veriCek->execute();
                                        $checked = "";
                                        while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                            if(in_array($row['promosyongorsel_id'], $promosyongorselIdler)){
                                                $checked = "checked";
                                            }else{
                                                $checked = "";
                                            }
                                            ?>
                                            <div class="col-lg-1">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" name="promosyongorsel_id[]" type="checkbox" value="<?= $row['promosyongorsel_id'] ?>" <?= $checked ?>>
                                                    </div>
                                                </div>
                                                
                                                <a href="../uploads/<?= $row['img'] ?>" target="_BLANK">
                                                    <img class="tableImg1" src="../thumbs/uploads/<?= $row['img'] ?>" title="id: <?= $row['promosyongorsel_id'] ?>">
                                                </a>                                                    
                                            </div>
                                    <?php }?>
                                </div>
                            </div>

                            <div class="col-lg-12 text-end">
                                <div class="btn-path">
                                    <button type="submit" name="promosyonaGorselEkle" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
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