<?php
include "../ayar.php";

$id = $_GET['id'] ?? -1;
$data = $conn->query("SELECT * FROM a_urunler WHERE urun_id = '$id' ")->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    header('Location: promosyon-listesi?durum=gecersizIslem');
    die();
}

$sayfa_hizmet_id = 3;
redirectToUnauthorized($sayfa_hizmet_id, 'ekle');

$pageName = $data['urun_adi']." | <span class='alert alert-danger p-1 m-1'>(id: ".$data['urun_id'].")</span>";

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
        <?php include '../share/promosyon-page-header.php'?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">                        
                        <h5>Ürüne Promosyon Ekle/Çıkar</h5>
                    </div>
                    <div class="card-body">
                        <form action="islemler.php" method="POST">
                            <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
                            <table id="promosyonTable" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-left fw-bold fs-6">Id</td>
                                        <td class="text-left fw-bold fs-6">Promosyon Adı</td>
                                        <td class="text-left fw-bold fs-6">Önceki Tutar</td>
                                        <td class="text-left fw-bold fs-6">Tutar</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $checked = "";
                                        $promosyonIdler = array();
                                        $veriCek = $conn->prepare("SELECT * FROM a_urunler_promosyonlar WHERE urun_id = ".$data['urun_id'].";");
                                        $veriCek->execute();
                                        while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                            $promosyonIdler[] = $row["promosyon_id"];
                                        }

                                        $veriCek = $conn->prepare("SELECT * FROM a_promosyonlar ORDER BY promosyon_id");
                                        $veriCek->execute();
                                        while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                            if(in_array($row['promosyon_id'], $promosyonIdler)){
                                                $checked = "checked";
                                            }else{
                                                $checked = "";
                                        }?>
                                        <tr>
                                            <td>
                                                <?= $row['promosyon_id'] ?>
                                            </td>
                                            <td>
                                                <?= $row['promosyon_adi'] ?>
                                            </td>
                                            <td>
                                                <?= ParaFormatla($row['promosyon_onceki']) ?>
                                            </td>
                                            <td>
                                                <?= ParaFormatla($row['promosyon_ucret']) ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" name="promosyon_id[]" type="checkbox" value="<?= $row['promosyon_id'] ?>" <?= $checked ?>>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php }?>
                                </tbody>
                            </table>

                            <div class="col-lg-12 mt-3">
                                <div class="btn-path">
                                    <button type="submit" name="urunePromosyonEkle" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
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
    $(document).on("click", ".promosyongorselSilBtn", function(e) {
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
                            promosyonGorselleriSil: '1',
                            id: id,
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    title: 'Başarılı!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    window.location = "promosyon-gorsel-listesi";
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

    $(document).on('click', '.promosyonGorselSiraInput', function(e) {
        $.ajax({
            method: "POST",
            url: "ajax/sira_guncelle.php",
            data: {
                id: $(this).data('id'),
                sira: $(this).val(),
                tableName: 'promosyongorselleri',
                idName: 'promosyongorsel_id'
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