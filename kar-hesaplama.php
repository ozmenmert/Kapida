<?php
include 'ayar.php';


$sayfa_hizmet_id = 11;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

$pageName = 'Kar Hesaplama';
$meta = array(
    'title' => $pageName . $separator . $siteData['title'],
    'description' => $siteData['description'],
    'keywords' => $siteData['keywords'],
    'author' => $siteData['author']
);
include 'header.php';
?>
<style>
    .opaklik {
        filter: saturate(0.5);
        font-weight: 500 !important;
        text-shadow: 1px 1px BLACK;
    }
</style>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="content-page-header">
                <h5>
                    <?= $pageName ?>
                </h5>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">


                    <div class="card-body table-responsive">
                        <table class="table table-striped table-bordered table-hover text-center ozelTablo">
                            <thead>
                                <tr>
                                    <th class=" align-middle bg-dark text-white" width="50">ID</th>
                                    <th class=" align-middle bg-dark text-white" width="50">Ürün</th>
                                    <th class=" align-middle bg-dark text-white">Satış</th>
                                    <th class=" align-middle bg-dark text-white">Alış</th>
                                    <th class=" align-middle bg-dark text-white">Reklam</th>
                                    <th class=" align-middle bg-dark text-white">İade</th>

                                    <?php
                                    $kargo_cek = $conn->prepare("SELECT * FROM kargo_firmalar WHERE durum = 1");
                                    $kargo_cek->execute();
                                    $aktif_kargolar = $kargo_cek->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($aktif_kargolar as $kargo) { ?>
                                        <th class="<?= $kargo['kargo_renk']; ?> text-white text-center">
                                            <a href="kargo-duzenle?id=<?= $kargo['kargo_id']; ?>" target="_blank" class="text-white">
                                                <?= $kargo['kargo_adi']; ?> <br> Nakit
                                            </a>
                                        </th>
                                        <th class="<?= $kargo['kargo_renk']; ?> text-white text-center">
                                            <a href="kargo-duzenle?id=<?= $kargo['kargo_id']; ?>" target="_blank" class="text-white">
                                                <?= $kargo['kargo_adi']; ?> <br> Kart
                                            </a>
                                        </th>
                                        <th class="<?= $kargo['kargo_renk']; ?> opaklik text-white text-center">
                                            <a href="kargo-duzenle?id=<?= $kargo['kargo_id']; ?>" target="_blank" class="text-white">
                                                <?= $kargo['kargo_adi']; ?> <br> Kazanç
                                            </a>
                                        </th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $veriCek = $conn->prepare("SELECT * FROM urunler ORDER BY urun_id DESC");
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
                                            <a href="urun-duzenle?id=<?= $row['urun_id'] ?>" target="_blank" class="text-dark">
                                                <?= $row['urun_adi']; ?>
                                            </a>

                                        </td>
                                        <td><?= ParaFormatla($urun_satis_fiyat) ?> ₺</td>
                                        <td><?= ParaFormatla($urun_alis_fiyat) ?> ₺</td>
                                        <td><?= ParaFormatla($urun_reklam_maliyeti) ?> ₺</td>
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
                                            <td class="<?= $kargo['kargo_renk']; ?> text-white text-center">
                                                <?= $kargo_nakit_ucreti ?>
                                            </td>
                                            <td class="<?= $kargo['kargo_renk']; ?> text-white text-center">
                                                <?php
                                                $kargo_kart_ucreti = ($kargo_komisyon * $urun_satis_fiyat) + $kargo_teslim;
                                                echo $kargo_kart_ucreti;
                                                ?>
                                            </td>
                                            <td class="<?= $kargo['kargo_renk']; ?> text-white text-center opaklik">
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
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>