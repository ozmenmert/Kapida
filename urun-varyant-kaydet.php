<?php
//include(dirname(__FILE__, 2)."/ayar.php");
include "../ayar.php";

$id = $_GET['id'] ?? -1;
$data = $conn->query("SELECT * FROM a_urunler WHERE urun_id = '$id' ")->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    header('Location: urun-urungorsel-listesi?durum=gecersizIslem');
    die();
}
$pageName = $data['urun_adi'];

$sayfa_hizmet_id = 3;
redirectToUnauthorized($sayfa_hizmet_id, 'ekle');
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
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Özellikler</h5>
                    </div>
                    <div class="card-body">
                        <table id="varyantTable" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-left fw-bold fs-6">Id</td>
                                    <td class="text-left fw-bold fs-6">Özellik Adı</td>
                                    <td class="text-left fw-bold fs-6">Özellik Değerleri</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $veriCek = $conn->prepare("SELECT * FROM a_urun_varyantlar WHERE urun_id = ".$data['urun_id']);
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td>
                                            <?= $row['urun_varyant_id'] ?>
                                        </td>
                                        <td>
                                            <?= $row['varyant_adi'] ?>
                                        </td>
                                        <td>
                                            <?= $row['degerler'] ?>
                                        </td>
                                        <td>
                                            <a href="urun-varyant-guncelle?id=<?= $row['urun_varyant_id'] ?>"
                                                class="btn btn-success text-white btn-sm" title="Varyant Düzenle"><i class="fe fe-edit"></i> </a>
                                            <a href="#" data-id="<?= $row['urun_varyant_id'] ?>"
                                                class="btn btn-danger text-white btn-sm varyantSilBtn" title="Varyant Sil"><i
                                                    class="fe fe-trash-2"></i> </a>
                                        </td>
                                    </tr>
                                    <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <form action="islemler.php" method="POST">
                    <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
                    <div class="card">
                        <div class="card-header">
                            <h5>Özellik Ekle</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Ürün Özelliği Adı (Örnek: Renk)</label>
                                        <!-- <input type="text" name="promosyon_adi" class="form-control border-danger" placeholder="Promosyon Adı" required> -->
                                        <input type="text" name="varyant_adi" placeholder="Varyant Adı" class="form-control" required="">
                                    </div>
                                </div>                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Özellik Değerleri (Örnek: Siyah, Kırmızı, Yeşil)</label>
                                        <!-- <input type="number" step="any" name="promosyon_onceki" class="form-control border-danger" placeholder="Önceki Fiyatı" required> -->
                                        <input type="text" name="varyasyon_degerleri" placeholder="Değerleri virgül ile ayırın" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" name="varyantKaydet" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                            
                </form>
            </div>
        </div>

    </div>
</div>
<?php include 'footer.php'; ?>

<script src="sweetalert.min.js"></script>

<script>
$(document).ready(function() {
    $(document).on("click", ".varyantSilBtn", function(e) {
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
                            varyantSil: '1',
                            id: id,
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    title: 'Başarılı!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    window.location = "urun-varyant-kaydet?id=<?= $data['urun_id'] ?>";
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