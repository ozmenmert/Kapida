<?php
include 'ayar.php';
$id = $_GET['id'] ?? -1;
$data = $conn->query("SELECT * FROM a_promosyonlar WHERE promosyon_id = '$id' ")->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    header('Location: promosyon-listesi?durum=gecersizIslem');
    die();
}
$pageName = "Promosyon Bilgileri Düzenle";
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
        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>
                            <?= $data['promosyon_adi'] ?> | <span class="alert alert-danger px-1 py-1">id: <?= $data['promosyon_id'] ?></span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="islemler.php" method="POST">
                            <input type="hidden" name="promosyon_id" value="<?= $data['promosyon_id'] ?>">

                                <div class="form-group col-lg-12">
                                    <label>Promosyon Adı</label>
                                    <input type="text" name="promosyon_adi" value="<?=$data['promosyon_adi']?>" class="form-control border-danger" placeholder="Promosyon Adı" required>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Promosyon Kısa Adı</label>
                                        <input type="text" name="promosyon_kisa_adi" value="<?=$data['promosyon_kisa_adi']?>" class="form-control border-danger" placeholder="Promosyon Kısa Adı" required>
                                    </div>
                                </div>

                                <div class="form-group col-lg-3">
                                    <label>Önceki Fiyatı</label>
                                    <input type="number" step="any" name="promosyon_onceki" value="<?=$data['promosyon_onceki']?>" class="form-control border-danger" placeholder="Önceki Fiyatı" required>
                                </div>

                                <div class="form-group col-lg-3">
                                    <label>Fiyatı</label>
                                    <input type="number" step="any" name="promosyon_ucret" value="<?=$data['promosyon_ucret']?>" class="form-control border-danger" placeholder="Fiyatı" required>
                                </div>

                                <div class="form-group col-lg-12">
                                    <label>Promosyon Video Linki </label>
                                    <input type="text" name="promosyon_video" value="<?= $data['promosyon_video'] ?>" class="form-control" placeholder="Video Bağlantısı">
                                </div>

                                <div class="col-lg-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" name="promosyonDuzenle" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Güncelle</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><?= $data['promosyon_adi'] ?> | <span class="alert alert-danger px-1 py-1">id: <?= $data['promosyon_id'] ?></span> | Promosyon Resimleri</h5>
                    </div>
                    <div class="card-body">

                        <table id="promosyonGorselTable" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-left fw-bold fs-6">Görsel</td>
                                    <td class="text-left fw-bold fs-6">Sıra</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT p_g.promosyonlar_gorseller_id, g.promosyongorsel_id, g.img, p_g.sira FROM a_promosyonlar_promosyongorselleri AS p_g
                                            LEFT OUTER JOIN a_promosyongorselleri AS g ON g.promosyongorsel_id = p_g.promosyongorsel_id
                                            WHERE p_g.promosyon_id = ".$data['promosyon_id']."
                                            ORDER BY p_g.sira;";
                                    $veriCek = $conn->prepare($sql);
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td>
                                            <a href="../<?= $row['img'] ?>" target="_BLANK">
                                                <img class="tableImg" src="../<?= $row['img'] ?>" title="id: <?= $row['promosyongorsel_id'] ?> (Büyük resim için tıklayınız)">
                                            </a>                                            
                                        </td>
                                        <td>
                                            <input type="number"
                                            class="promosyon_promosyonGorselSiraInput form-control"
                                            data-id="<?= $row['promosyonlar_gorseller_id'] ?>"
                                            value="<?= $row['sira'] ?>"
                                            placeholder="0" min="0" max="100">
                                        </td>
                                        <td align="center">
                                            <a href="#" data-id="<?= $row['promosyonlar_gorseller_id'] ?>" class="btn btn-danger text-white btn-sm promosyon_promosyongorselSilBtn" title="Görseli Promosyondan Kaldır"><i class="fe fe-trash-2"></i> </a>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <td colspan="3">
                                        <a href="promosyona-gorsel-ekle?id=<?= $data['promosyon_id'] ?>" class="btn btn-info text-white btn-sm" title="promosyona-gorsel-ekle?id=<?=$data['promosyon_id']?>"><i class="fa fa-image"></i> Resim Ekle</a>
                                    </td>
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
    $(document).on("click", ".promosyon_promosyongorselSilBtn", function(e) {
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
                            promosyon_promosyonGorseliSil: '1',
                            id: id,
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    title: 'Başarılı!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    window.location = "promosyon-duzenle?id=<?=$_GET["id"]?>";
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

    $(document).on('click', '.promosyon_promosyonGorselSiraInput', function(e) {
        $.ajax({
            method: "POST",
            url: "ajax/sira_guncelle.php",
            data: {
                id: $(this).data('id'),
                sira: $(this).val(),
                tableName: 'a_promosyonlar_promosyongorselleri',
                idName: 'promosyonlar_gorseller_id'
            }
        })
        .done(function() {
            ToastTopEnd.fire({
                icon: 'success',
                title: 'Sıra Güncellendi.'
            });
        });
    });

});
</script>