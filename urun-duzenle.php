<?php
include 'ayar.php';
$id = $_GET['id'] ?? -1;
$data = $conn->query("SELECT * FROM urunler WHERE urun_id = '$id' ")->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    header('Location: urun-listesi?durum=gecersizIslem');
    die();
}
$pageName = $data['urun_adi'] . $separator;
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
                <h5 class="mb-4">
                    <?= $pageName ?> <span class="alert alert-danger px-1 py-1"><?= $id ?></span>
                </h5>
                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#urunGorselEkleModal">
                                <i class="fa fa-images me-2" aria-hidden="true"></i>Yeni Ürün Görseli</button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                data-bs-target="#promosyonGorselEkleModal">
                                <i class="fa fa-images me-2" aria-hidden="true"></i>Yeni Promosyon Görseli</button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#yorumGorselEkleModal">
                                <i class="fa fa-comment me-2" aria-hidden="true"></i>Yeni Yorum</button>
                        </li>
                        <li>
                            <a href="<?= $data['urun_subdomain']; ?>" target="_BLANK"
                                class="btn btn-info text-white btn-sm"><i class="fa-solid fa-paper-plane"></i> </a>
                        </li>
                        <li>
                            <a class="btn btn-primary" href="urun-listesi"><i class="fa fa-list me-2"
                                    aria-hidden="true"></i>Ürün Listesi</a>
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
                            <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#info" data-bs-toggle="tab">
                                                <i class="fa fa-th "></i> Bilgiler
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#fiyatlandirma" data-bs-toggle="tab">
                                                <i class="fa-regular fa-check-circle "></i> Fiyatlandırma
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#varyasyonlar" data-bs-toggle="tab">
                                                <i class="fa-regular fa-message"></i> Varyasyonlar
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#promosyonlar" data-bs-toggle="tab">
                                                <i class="fa-regular fa-plus"></i> Promosyonlar
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#promosyonGorsel" data-bs-toggle="tab">
                                                <i class="fa-regular fa-image"></i> Promosyon Görselleri
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#gorseller" data-bs-toggle="tab">
                                                <i class="fa-regular fa-images"></i> Görseller
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#yorumlar" data-bs-toggle="tab">
                                                <i class="fa-regular fa-comment"></i> Yorumlar
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#seo" data-bs-toggle="tab">
                                                <i class="fa-solid fa-chart-line"></i> Seo
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="varyasyonlar">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5>Varyasyonlar</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <table id="varyasyonTable"
                                                                class="table table-striped table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <td class="text-left">Varyant</td>
                                                                        <td class="text-left">Değerler</td>
                                                                        <td width="50"></td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="2"></td>
                                                                        <td class="text-right"><button type="button"
                                                                                onclick="addVariation();"
                                                                                data-toggle="tooltip" title=""
                                                                                class="btn btn-primary"
                                                                                data-original-title="Ekle"><i
                                                                                    class="fa fa-plus-circle"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="promosyonlar">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5>Promosyonlar</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <table id="promosyonTable"
                                                                class="table table-striped table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <td class="text-left">Ürün Başlığı</td>
                                                                        <td class="text-left">Önceki Tutar</td>
                                                                        <td class="text-left">Tutar</td>
                                                                        <td width="50"></td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="3"></td>
                                                                        <td class="text-right"><button type="button"
                                                                                onclick="addPromotion();"
                                                                                data-toggle="tooltip" title=""
                                                                                class="btn btn-primary"
                                                                                data-original-title="Ekle"><i
                                                                                    class="fa fa-plus-circle"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="promosyonGorsel">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Görsel</th>
                                                                    <th width="100">Sıra</th>
                                                                    <th width="150"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $urun_id = $data['urun_id'];
                                                                $veriCek = $conn->prepare("SELECT * FROM promosyon_gorseller WHERE urun_id = '$urun_id' ORDER BY sira");
                                                                $veriCek->execute();
                                                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <img class="tableImg"
                                                                                src="../<?php echo $row['img']; ?>">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number"
                                                                                class="urunGorselSiraInput form-control"
                                                                                data-id="<?php echo $row['id']; ?>"
                                                                                value="<?php echo $row['sira']; ?>"
                                                                                placeholder="0">
                                                                        </td>
                                                                        <td>
                                                                            <a href="<?= SiteUrl($row['img']) ?>"
                                                                                target="_BLANK"
                                                                                class="btn btn-info text-white btn-sm"><i
                                                                                    class="fa fa-image"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                data-id="<?= $row['id'] ?>"
                                                                                class="btn btn-danger text-white btn-sm promosyonGorselSilBtn"><i
                                                                                    class="fe fe-trash-2"></i> </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="info">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5>Ürün Bilgisi</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>Ürün Ana Görseli</label>
                                                                        <div
                                                                            class="form-group service-upload logo-upload mb-0">
                                                                            <span><img
                                                                                    src="assets/img/icons/img-drop.svg"
                                                                                    alt="upload"></span>
                                                                            <div class="drag-drop">
                                                                                <h6 class="drop-browse align-center">
                                                                                    <span class="text-info me-1">Tıkla
                                                                                        Değiştir </span> veya
                                                                                    Sürükle
                                                                                    Bırak
                                                                                </h6>
                                                                                <p class="text-muted">SVG, PNG,
                                                                                    JPG
                                                                                    (512*512px)</p>
                                                                                <input type="file" name="urun_img"
                                                                                    id="image_sign">
                                                                                <div id="frames">
                                                                                    <img
                                                                                        src="../<?= $data['urun_img'] ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 table-responsive my-3">
                                                                    <table
                                                                        class="table table-striped table-bordered table-hover text-center">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class=" align-middle bg-dark text-white"
                                                                                    width="50">ID</th>
                                                                                <th class=" align-middle bg-dark text-white"
                                                                                    width="50">Ürün</th>
                                                                                <th
                                                                                    class=" align-middle bg-dark text-white">
                                                                                    Satış</th>
                                                                                <th
                                                                                    class=" align-middle bg-dark text-white">
                                                                                    Alış</th>
                                                                                <th
                                                                                    class=" align-middle bg-dark text-white">
                                                                                    Reklam</th>
                                                                                <th
                                                                                    class=" align-middle bg-dark text-white">
                                                                                    İade</th>

                                                                                <?php
                                                                                $kargo_cek = $conn->prepare("SELECT * FROM kargo_firmalar WHERE durum = 1");
                                                                                $kargo_cek->execute();
                                                                                $aktif_kargolar = $kargo_cek->fetchAll(PDO::FETCH_ASSOC);
                                                                                foreach ($aktif_kargolar as $kargo) { ?>
                                                                                    <th
                                                                                        class="<?= $kargo['kargo_renk']; ?> text-white text-center">
                                                                                        <a href="kargo-duzenle?id=<?= $kargo['kargo_id']; ?>"
                                                                                            target="_blank"
                                                                                            class="text-white">
                                                                                            <?= $kargo['kargo_adi']; ?> <br>
                                                                                            Nakit
                                                                                        </a>
                                                                                    </th>
                                                                                    <th
                                                                                        class="<?= $kargo['kargo_renk']; ?> text-white text-center">
                                                                                        <a href="kargo-duzenle?id=<?= $kargo['kargo_id']; ?>"
                                                                                            target="_blank"
                                                                                            class="text-white">
                                                                                            <?= $kargo['kargo_adi']; ?> <br>
                                                                                            Kart
                                                                                        </a>
                                                                                    </th>
                                                                                    <th
                                                                                        class="<?= $kargo['kargo_renk']; ?> opaklik text-white text-center">
                                                                                        <a href="kargo-duzenle?id=<?= $kargo['kargo_id']; ?>"
                                                                                            target="_blank"
                                                                                            class="text-white">
                                                                                            <?= $kargo['kargo_adi']; ?> <br>
                                                                                            Kazanç
                                                                                        </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $veriCek = $conn->prepare("SELECT * FROM urunler WHERE urun_id = $id ORDER BY urun_id DESC");
                                                                            $veriCek->execute();
                                                                            while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                                                                $urun_satis_fiyat = $row['urun_fiyat'];
                                                                                $urun_alis_fiyat = $row['urun_maliyet'];

                                                                                $urun_iade_orani = $row['urun_iade_orani'];

                                                                                $bugun_siparis_sayi = bugunSiparisSayi($row['urun_id']);
                                                                                $urun_reklam_maliyet = urunMaliyetOrt($row['urun_id']);
                                                                                if ($urun_reklam_maliyet != 0 and $bugun_siparis_sayi != 0) {
                                                                                    $urun_reklam_maliyeti =  number_format(($urun_reklam_maliyet / $bugun_siparis_sayi), 2);
                                                                                } else {
                                                                                    $urun_reklam_maliyeti = 0;
                                                                                }


                                                                            ?>
                                                                                <tr>
                                                                                    <td><?= $row['urun_id'] ?></td>
                                                                                    <td>
                                                                                        <a href="urun-duzenle?id=<?= $row['urun_id'] ?>"
                                                                                            target="_blank"
                                                                                            class="text-dark">
                                                                                            <?= $row['urun_adi']; ?>
                                                                                        </a>

                                                                                    </td>
                                                                                    <td><?= ParaFormatla($urun_satis_fiyat) ?>
                                                                                        ₺</td>
                                                                                    <td><?= ParaFormatla($urun_alis_fiyat) ?>
                                                                                        ₺</td>
                                                                                    <td><?= ParaFormatla($urun_reklam_maliyeti) ?>
                                                                                        ₺</td>
                                                                                    <td><?= $urun_iade_orani ?></td>

                                                                                    <?php
                                                                                    // aktif kargolar çekilecek ve döngü ile aşağıdaki işlemler tamamlanacak 
                                                                                    $kargo_cek = $conn->prepare("SELECT * FROM kargo_firmalar WHERE durum = 1");
                                                                                    $kargo_cek->execute();
                                                                                    $aktif_kargolar = $kargo_cek->fetchAll(PDO::FETCH_ASSOC); // fetchAll kullanarak tüm aktif kargoları çekiyoruz
                                                                                    $kazanc = 0;
                                                                                    foreach ($aktif_kargolar as $kargo) {
                                                                                        $kargo_id = $kargo['kargo_id'];
                                                                                        $kargo_komisyon = $kargo['kargo_komisyon'];
                                                                                        $kargo_teslim = $kargo['kargo_teslim'];
                                                                                        $kargo_iade_ucreti = $kargo['kargo_iade'];
                                                                                        $kazanc = 0;

                                                                                        // kargo firmasına ait fiyatlandırma var ise aşağıda döngü ile bu fiyatlandırmalar çekilecek
                                                                                        $kargo_nakit_ucreti = 0 + $kargo_teslim;

                                                                                        $fiyatlandirma_cek = $conn->prepare("SELECT * FROM kargo_araliklar WHERE aralik_kargo_id = ?");
                                                                                        $fiyatlandirma_cek->execute([$kargo_id]);
                                                                                        $kargo_araliklar = $fiyatlandirma_cek->fetchAll(PDO::FETCH_ASSOC); // fetchAll kullanarak tüm fiyatlandırmaları çekiyoruz

                                                                                        foreach ($kargo_araliklar as $aralik) {
                                                                                            $baslangic_deger = $aralik['aralik_baslangic'];
                                                                                            $bitis_deger = $aralik['aralik_bitis'];

                                                                                            if ($urun_satis_fiyat >= $baslangic_deger &&  $urun_satis_fiyat <= $bitis_deger) {
                                                                                                $kargo_nakit_ucreti = $kargo_nakit_ucreti + $aralik['aralik_ucret'];
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                        <td
                                                                                            class="<?= $kargo['kargo_renk']; ?> text-white text-center">
                                                                                            <?= $kargo_nakit_ucreti ?>
                                                                                        </td>
                                                                                        <td
                                                                                            class="<?= $kargo['kargo_renk']; ?> text-white text-center">
                                                                                            <?php
                                                                                            $kargo_kart_ucreti = ($kargo_komisyon * $urun_satis_fiyat) + $kargo_teslim;
                                                                                            echo $kargo_kart_ucreti;
                                                                                            ?>
                                                                                        </td>
                                                                                        <td
                                                                                            class="<?= $kargo['kargo_renk']; ?> text-white text-center opaklik">
                                                                                            <?php
                                                                                            $kazanc = ($urun_satis_fiyat - $urun_alis_fiyat - $urun_reklam_maliyeti - ($urun_iade_orani * ($urun_reklam_maliyeti + $kargo_iade_ucreti)) - $kargo_nakit_ucreti);
                                                                                            echo $kazanc;
                                                                                            ?>
                                                                                        </td>
                                                                                    <?php } ?>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                                <!-- <div class="col-lg-9">
                                                                    <div class="form-group">
                                                                        <label>Ürün Adı</label>
                                                                        <input type="text" name="urun_adi"
                                                                            class="form-control border-danger"
                                                                            placeholder="Ürün Adı" required
                                                                            value="<?= $data['urun_adi'] ?>">
                                                                    </div>
                                                                </div> -->
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Ürün Adı</label>
                                                                        <input type="text" name="urun_adi" value="<?= $data['urun_adi'] ?>" class="form-control border-danger" placeholder="Ürün Adı" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Ürün Kısa Adı</label>
                                                                        <input type="text" name="urun_kisa_adi" value="<?= $data['urun_kisa_adi'] ?>" class="form-control border-danger" placeholder="Ürün Kısa Adı">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Ürün Fiyatı</label>
                                                                        <input type="number" step="any"
                                                                            name="urun_fiyat"
                                                                            class="form-control  border-danger"
                                                                            placeholder="Ürün Fiyatı" required
                                                                            value="<?= $data['urun_fiyat'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Stok Kodu</label>
                                                                        <input type="text" name="urun_stok_kodu"
                                                                            class="form-control  border-danger"
                                                                            placeholder="Stok Kodu" required
                                                                            value="<?= $data['urun_stok_kodu'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Stok Adet</label>
                                                                        <input type="number" name="urun_stok"
                                                                            class="form-control  border-danger"
                                                                            placeholder="Stok Adet" required
                                                                            value="<?= $data['urun_stok'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Alış Fiyatı</label>
                                                                        <input type="number" step="any"
                                                                            name="urun_maliyet" class="form-control"
                                                                            value="<?= $data['urun_maliyet'] ?>"
                                                                            placeholder="Alış Fiyatı">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>İade Oranı</label>
                                                                        <input type="number" step="any"
                                                                            name="urun_iade_orani" class="form-control"
                                                                            value="<?= $data['urun_iade_orani'] ?>"
                                                                            placeholder="İade Oranı">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Ürün Bağlantı</label>
                                                                        <input type="text" name="urun_subdomain"
                                                                            class="form-control"
                                                                            placeholder="Ürün Bağlantı"
                                                                            value="<?= $data['urun_subdomain'] ?>">
                                                                        <sub>Ürün listesinde tıklandığında
                                                                            yönlendirilecek subdomain</sub>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Whatsapp No (Boş bırakılırsa buton
                                                                            gözükmez)</label>
                                                                        <input type="text" name="urun_whatsapp"
                                                                            class="form-control"
                                                                            placeholder="Whatsapp No"
                                                                            value="<?= $data['urun_whatsapp'] ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Ürün Video Linki </label>
                                                                        <input type="text" name="urun_video" value="<?= $data['urun_video'] ?>" class="form-control" placeholder="Video  Bağlantısı">
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Promosyon Video Linki </label>
                                                                        <input type="text" name="promosyon_video" value="<?= $data['promosyon_video'] ?>" class="form-control" placeholder="Video Bağlantısı">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>Ürün Açıklaması</label>
                                                                        <textarea class="form-control " id="basic-example" rows="3"
                                                                            name="urun_aciklama"><?= $data['urun_aciklama'] ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>Style Kodu (style etiketi eklemenize
                                                                            gerek yoktur.)</label>
                                                                        <textarea class="form-control " rows="3"
                                                                            name="urun_css"><?= $data['urun_css'] ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>İndex Script Kodu</label>
                                                                        <textarea class="form-control " rows="15"
                                                                            name="urun_script"
                                                                            placeholder="Script Kodları arasına almalısınız"><?= $data['urun_script'] ?></textarea>
                                                                        <sub>(Yaprak Sayfa anasayfasına eklenir - Script
                                                                            etiketi arasında
                                                                            olması gerekir.)</sub>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Tesekkür Script Kodu </label>
                                                                        <textarea class="form-control " rows="15"
                                                                            name="urun_tesekkur_script"
                                                                            placeholder="Script Kodları arasına almalısınız"><?= $data['urun_tesekkur_script'] ?></textarea>
                                                                        <sub>(Yaprak Sayfa Teşekkür sayfasına eklenir -
                                                                            Script etiketi arasında
                                                                            olması gerekir.)</sub>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="fiyatlandirma">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5>Fiyatlandırma</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <table id="fiyatlandirmaTable"
                                                                class="table table-striped table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <td class="text-left">Adet</td>
                                                                        <td class="text-left">Önceki fiyat</td>
                                                                        <td class="text-left">Fiyat</td>
                                                                        <td class="text-left">Kargo Tutar</td>
                                                                        <td class="text-left">Kargo Dahil</td>
                                                                        <td width="50"></td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="5"></td>
                                                                        <td class="text-right"><button type="button"
                                                                                onclick="addValue();"
                                                                                data-toggle="tooltip" title=""
                                                                                class="btn btn-primary"
                                                                                data-original-title="Ekle"><i
                                                                                    class="fa fa-plus-circle"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="seo">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5>Seo Ayarları</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>Meta Başlık <span
                                                                                class="text-danger">(Seo Link - Meta Açıklaması seo linke dönüştürülür)</span></label>
                                                                        <input type="text" name="urun_seo_title"
                                                                            class="form-control  border-danger"
                                                                            placeholder="Meta Başlığı" disabled
                                                                            value="<?= $data['urun_seo_title'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>Meta Açıklaması <span
                                                                                class="text-danger">(Zorunlu)</span></label>
                                                                        <textarea name="urun_seo_desc" rows="3"
                                                                            class="form-control border-danger"
                                                                            required><?= $data['urun_seo_desc'] ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>Meta Anahtar Kelimeler <span
                                                                                class="text-danger ">(Zorunlu)</span></label>
                                                                        <textarea name="urun_seo_keyw" rows="3"
                                                                            class="form-control border-danger"
                                                                            required><?= $data['urun_seo_keyw'] ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="gorseller">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Görsel</th>
                                                                    <th width="100">Sıra</th>
                                                                    <th width="150"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $urun_id = $data['urun_id'];
                                                                $veriCek = $conn->prepare("SELECT * FROM urun_gorselleri WHERE urun_id = '$urun_id' ORDER BY sira");
                                                                $veriCek->execute();
                                                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <img class="tableImg"
                                                                                src="../<?php echo $row['img']; ?>">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number"
                                                                                class="urunGorselSiraInput form-control"
                                                                                data-id="<?php echo $row['urun_gorsel_id']; ?>"
                                                                                value="<?php echo $row['sira']; ?>"
                                                                                placeholder="0">
                                                                        </td>
                                                                        <td>
                                                                            <a href="<?= SiteUrl($row['img']) ?>"
                                                                                target="_BLANK"
                                                                                class="btn btn-info text-white btn-sm"><i
                                                                                    class="fa fa-image"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                data-id="<?= $row['urun_gorsel_id'] ?>"
                                                                                class="btn btn-danger text-white btn-sm urunGorselSilBtn"><i
                                                                                    class="fe fe-trash-2"></i> </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="yorumlar">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Yorum Yapan</th>
                                                                    <th>Puan</th>
                                                                    <th>Açıklama</th>
                                                                    <th>Görseller</th>
                                                                    <th width="100">Sıra</th>
                                                                    <th width="150"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $veriCek = $conn->prepare("SELECT * FROM yorumlar WHERE yorum_urun = $urun_id ORDER BY sira");
                                                                $veriCek->execute();
                                                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                                                    <tr>
                                                                        <td><?php echo $row['yorum_adi']; ?></td>
                                                                        <td><?php echo $row['yorum_puan']; ?></td>
                                                                        <td><?php echo substr($row['yorum_aciklama'], 0, 20); ?>...</td>

                                                                        <td>

                                                                            <div class="d-flex flex-wrap">
                                                                                <?php
                                                                                $gorseller = json_decode($row['yorum_img'], true);
                                                                                foreach ($gorseller as $gorsel): ?>


                                                                                    <div class="gorsel-item text-center mx-1" style="margin-bottom: 10px;">
                                                                                        <!-- Görseli gösteriyoruz -->
                                                                                        <img src="../<?php echo $gorsel; ?>" alt="Yorum Görseli" class="img-thumbnail" style="width:100%; max-height:70px; display:block; margin:auto;">

                                                                                        <!-- Görsel Silme Butonu (görselin altında) -->
                                                                                        <button type="button" class="btn btn-danger btn-sm mt-2 px-1 py-1 silGorselBtn" style="bottom: 45px;"
                                                                                            data-id="<?php echo $row['yorum_id']; ?>"
                                                                                            data-gorsel="<?php echo $gorsel; ?>"><i class="fa fa-trash"></i> Sil</button>
                                                                                    </div>
                                                                                <?php endforeach; ?>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                        <td>
                                                                            <input type="number"
                                                                                class="yorumGorselSiraInput form-control"
                                                                                data-id="<?php echo $row['yorum_id']; ?>"
                                                                                value="<?php echo $row['sira']; ?>"
                                                                                placeholder="0">
                                                                        </td>
                                                                        </td>

                                                                        <td>
                                                                            <a href="javascript:void(0)" data-id="<?= $row['yorum_id'] ?>"
                                                                                class="btn btn-info text-white btn-sm yorumDuzenleBtn"><i
                                                                                    class="fa fa-edit"></i>
                                                                            </a>
                                                                            <a href="#" data-id="<?= $row['yorum_id'] ?>"
                                                                                class="btn btn-danger text-white btn-sm yorumSilBtn"><i
                                                                                    class="fe fe-trash-2"></i> </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <hr>
                                </div>
                                <div class="col-md-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" name="urunDuzenle"
                                            class="btn btn-primary btn-block w-100 btn-lg"><i
                                                class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form method="POST" action="islemler.php">
                            <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
                            <div class="row mt-5">
                                <label>Yorum Sayısını Değiştir</label>
                                <div class="col-md-2">
                                    <input type="number" name="yorum_sayisi" class="form-control" value="<?php echo $data['yorum_sayisi']; ?>" placeholder="0">
                                </div>
                                <div class="col-md-10">
                                    <button type="submit" name="yorumSayisiDuzenle" class="btn btn-primary btn-block">
                                        <i class="fa-solid fa-floppy-disk"></i>&nbsp;Yorum Sayısı Kaydet
                                    </button>
                                    <button type="submit" name="yorumSayisiSil" class="btn btn-primary btn-block">
                                        <i class="fa-solid fa-trash"></i>&nbsp;Yorum Sayısı Kaldır
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="dosyaDetay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Dosya Düzenle
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="urunGorselEkleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Ürün Görsel Ekle
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="islemler.php" enctype="multipart/form-data">
                    <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Görseller</label>
                                <input type="file" name="gorseller[]" class="form-control" required=""
                                    accept=".jpg,.jpeg,.png,.gif" multiple>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" name="urunGorselEkle" class="btn btn-primary btn-block w-100"><i
                                    class="fa fa-save"></i> Ekle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="promosyonGorselEkleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Promosyon Görsel Ekle
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="islemler.php" enctype="multipart/form-data">
                    <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Görseller</label>
                                <input type="file" name="gorseller[]" class="form-control" required=""
                                    accept=".jpg,.jpeg,.png,.gif" multiple>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" name="promosyonGorselEkle" class="btn btn-primary btn-block w-100"><i
                                    class="fa fa-save"></i> Ekle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="yorumGorselEkleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelYorum"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelYorum">
                    Yorum Ekle
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="islemler.php" enctype="multipart/form-data">
                    <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Yorum yapan</label>
                                <input type="text" name="yorum_adi" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Yorum yapan</label>
                                <select class="form-control" name="yorum_puan" required>
                                    <?php for ($i = 0; $i <= 5; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?> Puan</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Görseller</label>
                                <input type="file" name="gorseller[]" class="form-control"
                                    accept=".jpg,.jpeg,.png,.gif" multiple>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Yorum Metni</label>
                                <textarea class="form-control" name="yorum_aciklama" rows="1"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" name="yorumGorselEkle" class="btn btn-primary btn-block w-100"><i
                                    class="fa fa-save"></i> Ekle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="yorumGorselDuzenleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelYorum"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelYorum">
                    Yorum Düzenle
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="islemler.php" enctype="multipart/form-data">
                    <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
                    <input type="hidden" class="yorum_id" name="yorum_id" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Yorum yapan</label>
                                <input type="text" name="yorum_adi" class="form-control yorum_adi" required="">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Yorum yapan</label>
                                <select class="form-control yorum_puan" name="yorum_puan" required>
                                    <?php for ($i = 0; $i <= 5; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?> Puan</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Görseller</label>
                                <input type="file" name="gorseller[]" class="form-control " accept=".jpg,.jpeg,.png,.gif" multiple>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Yorum Metni</label>
                                <textarea class="form-control yorum_aciklama" name="yorum_aciklama" rows="1" required></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" name="yorumGorselDuzenle" class="btn btn-primary btn-block w-100"><i
                                    class="fa fa-save"></i> Güncelle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="sweetalert.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.3.0/tinymce.min.js" integrity="sha512-RUZ2d69UiTI+LdjfDCxqJh5HfjmOcouct56utQNVRjr90Ea8uHQa+gCxvxDTC9fFvIGP+t4TDDJWNTRV48tBpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        tinymce.init({
            selector: 'textarea#basic-example',
            height: 350,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });

        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tap');

        function activateTab(tabId, contentId) {
            $('.tabMain .nav-link[href="' + tabId + '"]').addClass('active');
            $(contentId).addClass('show active');
        }
        switch (activeTab) {
            case 'fiyatlandirma':
                activateTab('#fiyatlandirma', '#fiyatlandirma');
                break;
            case 'varyasyonlar':
                activateTab('#varyasyonlar', '#varyasyonlar');
                break;
            case 'seo':
                activateTab('#seo', '#seo');
                break;
            case 'gorseller':
                activateTab('#gorseller', '#gorseller');
                break;
            case 'promosyonGorsel':
                activateTab('#promosyonGorsel', '#promosyonGorsel');
                break;
            case 'yorumlar':
                activateTab('#yorumlar', '#yorumlar');
                break;
            case 'promosyonlar':
                activateTab('#promosyonlar', '#promosyonlar');
                break;
            default:
                activateTab('#info', '#info');
                break;
        }
    });
</script> -->
<script>
    function generateUniqueId() {
        return Math.random().toString(36).substr(2, 9);
    }

    function addValue(adet = '', onceki = '', fiyat = '', kargo_tutar = '0', kargo_durum = 0) {
        var uniqueId = generateUniqueId();
        html = ` 
        <tr id="adetRow${uniqueId}">
        <td class="text-left">
        <input type="number" min="1" name="adet[${uniqueId}]" value="${adet}"
        placeholder="Adet" class="form-control  border-danger" required />
        </td>
        <td class="text-left">
        <input type="number" min="0" name="onceki[${uniqueId}]" value="${onceki}"
        placeholder="Önceki Fiyat" class="form-control  border-danger" required />
        </td>
        <td class="text-left">
        <input type="number" min="0" name="fiyat[${uniqueId}]" value="${fiyat}"
        placeholder="Fiyat" class="form-control  border-danger" required />
        </td>
        <td class="text-left">
        <input type="number" min="0" name="kargo_tutar[${uniqueId}]" value="${kargo_tutar}"
        placeholder="Kargo Tutarı" class="form-control  border-danger" required />
        </td>
        <td class="text-left">
        <select name="kargo_durum[${uniqueId}]" class="form-control border-danger" required>
        <option value="0" ${kargo_durum == 0 ? 'selected' : ''}>Kargo Ücretsiz</option>
        <option value="1" ${kargo_durum == 1 ? 'selected' : ''}>+Kargo</option>
        </select>
        </td>
        <td class="text-right"><button type="button" onclick="$('#adetRow${uniqueId}').remove();"
        data-toggle="tooltip" title="Kaldır" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
        </td>';
        </tr>
        `;
        $('#fiyatlandirmaTable tbody').append(html);
    }
    <?php
    $urun_id = $data['urun_id'];
    $adetArr = [];
    $veriCek = $conn->prepare("SELECT * FROM urun_fiyatlandirma WHERE urun_id = '$urun_id' ORDER BY adet");
    $veriCek->execute();
    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
        $adetArr[] = $row['adet'];
    ?>
        addValue('<?= $row['adet'] ?>', '<?= $row['onceki'] ?>', '<?= $row['fiyat'] ?>', '<?= $row['kargo_tutar'] ?>', '<?= $row['kargo_durum'] ?>');
    <?php } ?>

    function addVariation(varyasyon_adi = '', varyasyon_degerleri = '') {
        var uniqueVarId = generateUniqueId();
        html = ` 
        <tr id="varyasyonRow${uniqueVarId}">
        <td class="text-left">
        <input type="text" name="varyasyon_adi[${uniqueVarId}]" value="${varyasyon_adi}"
        placeholder="Varyant Adı" class="form-control" required />
        </td>
        <td class="text-left">
        <input type="text" name="varyasyon_degerleri[${uniqueVarId}]" value="${varyasyon_degerleri}"
        placeholder="Değerleri virgül ile ayırın" class="form-control" required />
        </td>
        <td class="text-right"><button type="button" onclick="$('#varyasyonRow${uniqueVarId}').remove();"
        data-toggle="tooltip" title="Kaldır" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
        </td>';
        </tr>
        `;
        $('#varyasyonTable tbody').append(html);
    }

    <?php
    $varyantArray = [];
    $veriCek = $conn->prepare("SELECT * FROM urun_varyantlar WHERE urun_id = '$urun_id' ORDER BY urun_varyant_id");
    $veriCek->execute();
    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
        $varyantArray[] = $row['varyant_adi'];
    ?>
        addVariation('<?= $row['varyant_adi'] ?>', '<?= $row['degerler'] ?>');
    <?php } ?>

    function addPromotion(promosyon_adi = '', promosyon_onceki = '', promosyon_ucret = '') {
        var uniqueProId = generateUniqueId();
        html = ` 
        <tr id="promosyonRow${uniqueProId}">
        <td class="text-left">
        <input type="text" name="promosyon_adi[${uniqueProId}]" value="${promosyon_adi}"
        placeholder="Promosyon Ürünü" class="form-control" required />
        </td>
        <td class="text-left">
        <input type="number" min="0" name="promosyon_onceki[${uniqueProId}]" value="${promosyon_onceki}"
        placeholder="Önceki Tutar" class="form-control" required />
        </td>
        <td class="text-left">
        <input type="number" min="0" name="promosyon_ucret[${uniqueProId}]" value="${promosyon_ucret}"
        placeholder="Tutar" class="form-control" required />
        </td>
        <td class="text-right"><button type="button" onclick="$('#promosyonRow${uniqueProId}').remove();"
        data-toggle="tooltip" title="Kaldır" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
        </td>';
        </tr>
        `;
        $('#promosyonTable tbody').append(html);
    }

    <?php
    $promosyonArray = [];
    $veriCek = $conn->prepare("SELECT * FROM promosyon_urunler WHERE urun_id = '$urun_id' ORDER BY promosyon_id");
    $veriCek->execute();
    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
        $promosyonArray[] = $row['promosyon_adi'];
    ?>
        addPromotion('<?= $row['promosyon_adi'] ?>', '<?= $row['promosyon_onceki'] ?>', '<?= $row['promosyon_ucret'] ?>');
    <?php } ?>
</script>
<?php $urun_id = $data['urun_id']; ?>
<script>
    $(document).ready(function() {
        $(document).on("click", ".urunGorselSilBtn", function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                    title: "Silme İşlemi",
                    text: "Silinen kayıtlar geri alınmaz silmek istediğinize emin misiniz?",
                    icon: "warning",
                    buttons: {
                        cancel: "Hayır Silme",
                        confirm: "Evet Sil!"
                    },
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (!willDelete) {
                        swal("Silme İşlemi İptal Edildi.", {
                            icon: "error",
                        });
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: "POST",
                            url: "ajax/ajax_delete.php",
                            data: {
                                urunGorselSil: '1',
                                id: id,
                            },
                            success: function(response) {
                                if (response.status == "success") {
                                    Swal.fire({
                                        title: 'Başarılı!',
                                        text: response.message,
                                        icon: 'success'
                                    }).then(() => {
                                        window.location =
                                            "urun-duzenle?tap=gorseller&id=<?= $urun_id ?>";
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Hata!',
                                        text: response.message,
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function() {
                                swal("Hata Silinmedi.", {
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
        });

        $(document).on("click", ".yorumDuzenleBtn", function(e) {
            var id = $(this).data('id');

            $.ajax({
                url: 'ajax/ajax_select.php',
                type: 'POST',
                data: {
                    id: id,
                    yorumDataGetir: '1'
                },
                dataType: 'json',
                success: function(response) {
                    $('.yorum_id').val(response.yorum_id);
                    $('.yorum_adi').val(response.yorum_adi);
                    var yorum_puan_int = parseInt(response.yorum_puan);
                    $('.yorum_puan').val(yorum_puan_int).trigger('change');
                    $('.yorum_aciklama').val(response.yorum_aciklama);
                    $('#yorumGorselDuzenleModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log('Bir hata oluştu: ' + error);
                }
            });
        });

        $(document).on("click", ".yorumSilBtn", function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                    title: "Silme İşlemi",
                    text: "Silinen kayıtlar geri alınmaz silmek istediğinize emin misiniz?",
                    icon: "warning",
                    buttons: {
                        cancel: "Hayır Silme",
                        confirm: "Evet Sil!"
                    },
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (!willDelete) {
                        swal("Silme İşlemi İptal Edildi.", {
                            icon: "error",
                        });
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: "POST",
                            url: "ajax/ajax_delete.php",
                            data: {
                                yorumGorselSil: '1',
                                id: id,
                            },
                            success: function(response) {
                                if (response.status == "success") {
                                    Swal.fire({
                                        title: 'Başarılı!',
                                        text: response.message,
                                        icon: 'success'
                                    }).then(() => {
                                        window.location =
                                            "urun-duzenle?tap=yorumlar&id=<?= $urun_id ?>";
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Hata!',
                                        text: response.message,
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function() {
                                swal("Hata Silinmedi.", {
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
        });
    });
</script>
<?php $urun_id = $data['urun_id']; ?>
<script>
    $(document).ready(function() {
        $(document).on('click', '.urunGorselSiraInput', function() {
            $.ajax({
                    method: "POST",
                    url: "ajax/sira_guncelle.php",
                    data: {
                        id: $(this).data('id'),
                        sira: $(this).val(),
                        tableName: 'urun_gorselleri',
                        idName: 'urun_gorsel_id'
                    }
                })
                .done(function() {
                    ToastTopEnd.fire({
                        icon: 'success',
                        title: 'Sıra Güncellendi.'
                    });
                });
        });

        $(document).on('click', '.yorumGorselSiraInput', function() {
            $.ajax({
                    method: "POST",
                    url: "ajax/sira_guncelle.php",
                    data: {
                        id: $(this).data('id'),
                        sira: $(this).val(),
                        tableName: 'yorumlar',
                        idName: 'yorum_id'
                    }
                })
                .done(function() {
                    ToastTopEnd.fire({
                        icon: 'success',
                        title: 'Sıra Güncellendi.'
                    });
                });
        });
        $(document).on('click', '.silGorselBtn', function() {
            var yorumId = $(this).data('id');
            var gorsel = $(this).data('gorsel');
            var $gorselItem = $(this).closest('.gorsel-item');

            if (confirm("Bu görseli silmek istediğinize emin misiniz?")) {
                $.ajax({
                    dataType: 'json',
                    url: 'ajax/ajax_sil.php',
                    type: 'POST',
                    data: {
                        yorum_id: yorumId,
                        gorsel: gorsel
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            $gorselItem.remove();

                            Swal.fire({
                                title: 'Başarılı!',
                                text: response.message,
                                icon: 'success'
                            });

                        } else {
                            Swal.fire({
                                title: 'Hata!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Hata!',
                            text: 'Görsel silinirken bir hata oluştu.',
                            icon: 'error'
                        });
                    }
                });
            }
        });



        $(document).on("click", ".promosyonGorselSilBtn", function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                    title: "Silme İşlemi",
                    text: "Silinen kayıtlar geri alınmaz silmek istediğinize emin misiniz?",
                    icon: "warning",
                    buttons: {
                        cancel: "Hayır Silme",
                        confirm: "Evet Sil!"
                    },
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (!willDelete) {
                        swal("Silme İşlemi İptal Edildi.", {
                            icon: "error",
                        });
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: "POST",
                            url: "ajax/ajax_delete.php",
                            data: {
                                promosyonGorselSil: '1',
                                id: id,
                            },
                            success: function(response) {
                                if (response.status == "success") {
                                    Swal.fire({
                                        title: 'Başarılı!',
                                        text: response.message,
                                        icon: 'success'
                                    }).then(() => {
                                        window.location =
                                            "urun-duzenle?tap=promosyonGorsel&id=<?= $urun_id ?>";
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Hata!',
                                        text: response.message,
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function() {
                                swal("Hata Silinmedi.", {
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
        });


    });
</script>