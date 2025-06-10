<?php
include 'ayar.php';

if (isset($_GET['id']) and $_GET['id'] != '' and $_GET['id'] != 0) {
    $id = $_GET['id'];

    $data = $conn->query("SELECT * FROM stok_urunler WHERE stok_id = $id")->fetch(PDO::FETCH_ASSOC);
    if (!$data) {
        header('Location: stok-listesi?durum=gecersizIslem');
        die();
    }
} else {
    header('Location: stok-listesi?durum=gecersizIslem');
    die();
}


$pageName = $data['stok_adi'] . ' Düzenle';
$meta = array(
    'title' => $pageName,
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

.bg-giris {
    background: #ddffb4 !important;
}

.bg-cikis {
    background: #ffe8e8 !important;
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
                                                <i class="fa fa-th "></i> İNFO
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#hareketler" data-bs-toggle="tab">
                                                <i class="fa-regular fa-check-circle "></i> Hareketler
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="info">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5>Stok Bilgisi</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>Stok Görseli</label>
                                                                        <div
                                                                            class="form-group service-upload logo-upload mb-0">
                                                                            <span><img
                                                                                    src="assets/img/icons/img-drop.svg"
                                                                                    alt="upload"></span>
                                                                            <div class="drag-drop">
                                                                                <h6 class="drop-browse align-center">
                                                                                    <span class="text-info me-1">Tıkla
                                                                                        Değiştir </span> veya Sürükle
                                                                                    Bırak
                                                                                </h6>
                                                                                <p class="text-muted">SVG, PNG, JPG
                                                                                    (512*512px)</p>
                                                                                <input type="file" name="stok_img"
                                                                                    id="image_sign">
                                                                                <div id="frames">
                                                                                    <img src="<?= $data['stok_img'] ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <div class="form-group">
                                                                        <label>Stok Adı</label>
                                                                        <input type="hidden" name="stok_id"
                                                                            value="<?= $data['stok_id'] ?>">

                                                                        <input type="text" name="stok_adi"
                                                                            class="form-control border-danger"
                                                                            placeholder="Stok Adı"
                                                                            value="<?= $data['stok_adi'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label>Stok Adeti</label>
                                                                        <input type="number" name="stok_adet"
                                                                            class="form-control border-danger"
                                                                            value="<?= $data['stok_adet'] ?>" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="hareketler">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5>Stok Hareketleri</h5>
                                                        </div>
                                                        <div class="my-2">
                                                            <a href="hareket-ekle?id=<?= $id ?>"
                                                                class="btn btn-primary text-white btn-sm"><i
                                                                    class="fa-solid fa-chart-simple"></i> Stok Hareketi
                                                                Ekle</a>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table table-striped exportTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="50">Giriş / Çıkış</th>
                                                                        <th>Adet</th>
                                                                        <th>Alış Tutar</th>
                                                                        <th>Toplam Alış Maliyeti</th>
                                                                        <th>Açıklama</th>
                                                                        <th>Belge</th>
                                                                        <th width="100">Tarih</th>
                                                                        <th width="50"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $veriCek = $conn->prepare("SELECT * FROM stok_hareketler WHERE hareket_stok_id = :stok_id ORDER BY hareket_tarih DESC");
                                                                    $veriCek->execute(array('stok_id' => $id));
                                                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                                                    <tr
                                                                        class=" <?= ($row['hareket_tur'] == 1) ? 'bg-giris' : 'bg-cikis'; ?>">
                                                                        <td>
                                                                            <?= ($row['hareket_tur'] == 1) ? 'Giriş' : 'Çıkış'; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?= $row['hareket_adet'] ?>
                                                                        </td>

                                                                        <td>
                                                                            <?php echo $alis_tutar = (isset($row['hareket_alist_tutar']) and $row['hareket_alist_tutar'] != '') ? $row['hareket_alist_tutar'] : '0'; ?>
                                                                        </td>
                                                                        <td><?= number_format(($row['hareket_adet'] * $alis_tutar), 2) ?>
                                                                        </td>


                                                                        <td>
                                                                            <?= (isset($row['hareket_aciklama']) and $row['hareket_aciklama'] != '') ? substr($row['hareket_aciklama'], 0, 25) : 'Girilmedi'; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if (isset($row['hareket_belge']) and $row['hareket_belge'] != '') { ?>
                                                                            <a target="_blank"
                                                                                class="btn btn-sm btn-success text-white"
                                                                                href="<?= $row['hareket_belge'] ?>"><i
                                                                                    class="fa fa-paperclip"></i> Belgeyi
                                                                                Gör</a>
                                                                            <?php } else {
                                                                                    echo 'Belge Yüklenmedi';
                                                                                } ?>
                                                                        </td>
                                                                        <td>
                                                                            <?= date('d.m.Y H:i', strtotime($row['hareket_tarih'])); ?>
                                                                        </td>
                                                                        <td>
                                                                            <a href="hareket-duzenle?id=<?= $row['hareket_id'] ?>"
                                                                                class="btn btn-success text-white btn-sm"><i
                                                                                    class="fe fe-edit"></i> </a>
                                                                            <a href="#"
                                                                                data-id="<?= $row['hareket_id'] ?>"
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
                                </div>
                                <div class="col-lg-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" name="stokDuzenle"
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
                            hareketSil: '1',
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