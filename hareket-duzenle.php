<?php
include 'ayar.php';

$id = $_GET['id'] ?? -1;
$data = $conn->query("SELECT * FROM stok_hareketler WHERE hareket_id = $id")->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    header('Location: stok-listesi?durum=gecersizIslem');
    die();
}


$pageName = 'Hareket Düzenle';


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
                        <a class="btn btn-info" href="stok-duzenle?id=<?=$data['hareket_stok_id']; ?>"><i class="fa fa-eye me-2"
                                aria-hidden="true"></i> Ürüne Git</a>

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
                                                    <i class="fa fa-th "></i> Hareket Düzenle
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active show" id="info">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Hareket Bilgisi</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label>Hareket Belgesi</label>
                                                                            <?php if(isset($data['hareket_belge']) and $data['hareket_belge']!=''){ ?>
                                                                                <div class="mb-3">
                                                                                    <a href="<?=$data['hareket_belge']; ?>" target="_blank" class="btn btn-sm btn-success text-white"> <i class="fa fa-paperclip"></i> Görüntüle</a>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <div
                                                                            class="form-group service-upload logo-upload mb-0">
                                                                            <span><img
                                                                                src="assets/img/icons/belge.svg" style="height:50px"
                                                                                alt="upload"></span>
                                                                                <div class="drag-drop">
                                                                                    <h6 class="drop-browse align-center">
                                                                                        <span class="text-info me-1">Tıkla
                                                                                        Değiştir </span> veya
                                                                                        Sürükle
                                                                                        Bırak
                                                                                    </h6>
                                                                                    <input type="file" name="hareket_belge"
                                                                                    id="image_sign">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label>Ürün Seçimi</label>
                                                                            <select class="form-control border-danger" name="hareket_stok_id" disabled>
                                                                                <option value="">Seçiniz</option>
                                                                                <?php
                                                                                $veriCek = $conn->prepare("SELECT * FROM stok_urunler ORDER BY stok_adi ASC");
                                                                                $veriCek->execute();
                                                                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                                                                    <option

                                                                                    <?=($data['hareket_stok_id']==$row['stok_id']) ? 'selected' : ''; ?>
                                                                                    value="<?=$row['stok_id']; ?>"><?=$row['stok_adi']; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label>Hareket Türü</label>
                                                                            <select class="form-control border-danger" name="hareket_tur" required>
                                                                                <option value="">Seçiniz</option>
                                                                                <option 
                                                                                <?=($data['hareket_tur']==1) ? 'selected' : '' ;?>
                                                                                value="1">Giriş</option>
                                                                                <option 
                                                                                <?=($data['hareket_tur']==0) ? 'selected' : '' ;?>
                                                                                value="0">Çıkış</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label>Hareket Adet</label>
                                                                            <input type="hidden" name="hareket_id" value="<?= $data['hareket_id'] ?>">

                                                                            <input type="number" name="hareket_adet" class="form-control border-danger" value="<?=$data['hareket_adet']; ?>" placeholder="Hareket Adet" required>
                                                                        </div>
                                                                    </div>

                                                                        <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label>Alış Tutarı</label>
                                                                            <input type="number" name="hareket_alist_tutar" class="form-control" value="<?=$data['hareket_alist_tutar']; ?>" placeholder="Alış Tutarı">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-8">
                                                                        <div class="form-group">
                                                                            <label>Hareket Açıklaması</label>
                                                                            <input type="text" name="hareket_aciklama" class="form-control" value="<?=$data['hareket_aciklama']; ?>" placeholder="Hareket Açıklaması">
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
                                            <button type="submit" name="hareketDuzenle"
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