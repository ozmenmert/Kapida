<?php
include 'ayar.php';
$sayfa_hizmet_id = 5;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');
$pageName = 'Reklam Maliyet Listesi';
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
        <div class="page-header">
            <div class="content-page-header">
                <h5>
                    <?= $pageName ?>
                </h5>
                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-primary" href="reklam-maliyet-ekle"><i class="fa fa-plus-circle me-2"
                                    aria-hidden="true"></i>Maliyet Ekle</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <?= $pageName ?>
                        </h2>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped dataTable">
                            <thead>
                                <tr>
                                    <th width="50">URUN ID</th>
                                    <th>Ürün</th>
                                    <th>Domain</th>
                                    <th>Meta</th>
                                    <th>Tiktok</th>
                                    <th>Google</th>
                                    <th>Twitter</th>
                                    <th>Manuel 1</th>
                                    <th>Manuel 2</th>

                                    <th class="bg-danger text-white">Bugün Sipariş</th>
                                    <th class="bg-danger text-white">Bugün Ort</th>

                                    <th class="bg-success text-white">Bugün Onaylı</th>
                                    <th class="bg-success text-white">Bugün Onaylı Ort</th>

                                    <th>Not</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $veriCek = $conn->prepare("SELECT * FROM reklam_maliyetler,urunler
                                    WHERE urunler.urun_id = reklam_maliyetler.rekalm_maliyet_urun
                                 ORDER BY reklam_maliyetler.rekalm_maliyet_urun ASC");
                                $veriCek->execute();
                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                    $ortalama = 0;
                                    $urun_id = $row['rekalm_maliyet_urun'];
                                    $maliyet_id = $row['rekalm_maliyet_id'];

                                    $bugun_siparis_sayi = bugunSiparisSayi($urun_id);
                                    $bugun_onayli_siparis_sayi = bugunOnayliSiparisSayi($urun_id);
                                    $maliyet_ortalama = MaliyetOrt($maliyet_id);
                                ?>
                                <tr>
                                    <td><?= $row['rekalm_maliyet_urun'] ?></td>
                                    <td><?= $row['urun_adi'] ?></td>
                                    <td><?= $row['rekalm_maliyet_domain'] ?></td>
                                    <td><?php $ortalama += $row['rekalm_maliyet_meta'];
                                            echo $row['rekalm_maliyet_meta']; ?>
                                    </td>
                                    <td><?php $ortalama += $row['rekalm_maliyet_tiktok'];
                                            echo $row['rekalm_maliyet_tiktok']; ?>
                                    </td>
                                    <td><?php $ortalama += $row['rekalm_maliyet_google'];
                                            echo $row['rekalm_maliyet_google']; ?>
                                    </td>
                                    <td><?php $ortalama += $row['rekalm_maliyet_twitter'];
                                            echo $row['rekalm_maliyet_twitter']; ?>
                                    </td>

                                    <td>
                                        <?php
                                            $ortalama += $row['rekalm_maliyet_man'];
                                            echo $row['rekalm_maliyet_man'];
                                            ?>
                                    </td>
                                    <td>
                                        <?php
                                            $ortalama += $row['rekalm_maliyet_man_2'];
                                            echo $row['rekalm_maliyet_man_2'];
                                            ?>
                                    </td>


                                    <td class="bg-danger text-white"><?= $bugun_siparis_sayi; ?></td>
                                    <td class="bg-danger text-white">
                                        <?php
                                            if ($maliyet_ortalama != 0 and $bugun_siparis_sayi != 0) {
                                                echo  number_format(($maliyet_ortalama / $bugun_siparis_sayi), 2);
                                            } else {
                                                echo 0;
                                            }
                                            ?>
                                    </td>

                                    <td class="bg-success text-white"><?= $bugun_onayli_siparis_sayi; ?></td>
                                    <td class="bg-success text-white">

                                        <?php
                                            if ($maliyet_ortalama != 0 and $bugun_onayli_siparis_sayi != 0) {
                                                echo number_format(($maliyet_ortalama / $bugun_onayli_siparis_sayi), 2);
                                            } else {
                                                echo 0;
                                            }
                                            ?>
                                    </td>

                                    <td><?= substr($row['rekalm_maliyet_not'], 0, 15) ?></td>
                                    <td>
                                        <a href="reklam-maliyet-duzenle?id=<?= $maliyet_id; ?>"
                                            class="btn btn-success text-white btn-sm"><i class="fe fe-edit"></i> </a>
                                        <a href="#" data-id="<?= $maliyet_id; ?>"
                                            class="btn btn-danger text-white btn-sm urunSilBtn"><i
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
<?php include 'footer.php'; ?>
<script src="sweetalert.min.js"></script>
<script>
$(document).ready(function() {

    $(document).on("click", ".urunSilBtn", function(e) {
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
                            reklamMaliyetSil: '1',
                            id: id,
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    title: 'Başarılı!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
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