<?php
include 'ayar.php';
$sayfa_hizmet_id = 4;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

$pageName = 'Stok Listesi';
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
                            <a class="btn btn-primary" href="stok-ekle"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Yeni Ürün Ekle</a>
                        </li>
                        <li>
                            <a class="btn btn-warning" href="toplu-hareket-ekle"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Toplu Hareket Ekle</a>
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
                                    <th width="50">#</th>
                                    <th width="50">Görsel</th>
                                    <th>Stok Adı</th>
                                    <th>Stok</th>
                                    <th>Alış Toplamları </th>
                                    <th>Ortlama Alış Maliyeti</th>
                                    <th width="100">Tarih</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $veriCek = $conn->prepare("SELECT * FROM stok_urunler ORDER BY stok_adi ASC");
                                $veriCek->execute();
                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                    $stok_urun = $row['stok_id'];
                                ?>
                                    <tr>
                                        <td>
                                            <?= $row['stok_id'] ?>
                                        </td>
                                        <td><img src="<?= $row['stok_img'] ?>" class="tableImg"></td>
                                        <td>
                                            <?= $row['stok_adi'] ?>
                                        </td>
                                        <td>
                                            <?= $row['stok_adet'] ?>
                                        </td>
                                        <td>
                                            <?php
                                            $alislar = $conn->prepare("SELECT SUM(hareket_alist_tutar * hareket_adet) as total, SUM(hareket_adet) as toplam_alis FROM stok_hareketler WHERE hareket_stok_id = :stok_urun");
                                            $alislar->bindParam(':stok_urun', $stok_urun, PDO::PARAM_INT);
                                            $alislar->execute();
                                            $result = $alislar->fetch(PDO::FETCH_ASSOC);

                                            // Sonucu kontrol ederek ekrana yazdırın
                                            if ($result && isset($result['total'])) {
                                                $toplam_alis_m = $result['total'];
                                            } else {
                                                $toplam_alis_m = 0;
                                            }
                                            echo number_format($toplam_alis_m, 2);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if ($result['toplam_alis'] == null) {
                                                    echo "0.00";
                                                } else {
                                                    echo number_format(($toplam_alis_m / $result['toplam_alis']), 2);
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?= date('d.m.Y', strtotime($row['stok_tarih'])); ?>
                                        </td>
                                        <td>
                                            <a href="hareket-ekle?id=<?= $row['stok_id'] ?>" class="btn btn-primary text-white btn-sm"><i class="fa-solid fa-chart-simple"></i> Stok Hareketi Ekle</a>


                                            <a href="stok-duzenle?id=<?= $row['stok_id'] ?>" class="btn btn-success text-white btn-sm"><i class="fe fe-edit"></i> </a>
                                            <a href="#" data-id="<?= $row['stok_id'] ?>" class="btn btn-danger text-white btn-sm urunSilBtn"><i class="fe fe-trash-2"></i> </a>
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
                                stokSil: '1',
                                id: id,
                            },
                            success: function(response) {
                                if (response.status == "success") {
                                    Swal.fire({
                                        title: 'Başarılı!',
                                        text: response.message,
                                        icon: 'success'
                                    }).then(() => {
                                        window.location = "stok-listesi";
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