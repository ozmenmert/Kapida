<?php
include "../ayar.php";

$sayfa_hizmet_id = 3;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

$pageName = 'Ürünler';
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
            <div class="col-sm-12">
                <div class="card">
                    <!-- <div class="card-header">
                        <h2>
                            <?= $pageName ?>
                        </h2>
                    </div> -->

                    <div class="card-body table-responsive">
                        <table class="table table-striped dataTable">
                            <thead>
                                <tr>
                                    <th width="50">ID</th>
                                    <th width="50">Ana Görsel</th>
                                    <th>Ürün Adı / Subdomain</th>
                                    <th>Ürün Kısa Adı</th>
                                    <th>Stok Kodu</th>
                                    <th>Stok</th>
                                    <th>Fiyat</th>
                                    <th>Anasayfa</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $veriCek = $conn->prepare("SELECT * FROM a_urun_varyantlar;");
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { 
                                        $urunVaryantlar[$row['urun_id']][$row['urun_varyant_id']] = $row['varyant_adi'];
                                    }

                                    $veriCek = $conn->prepare("SELECT * FROM a_urunler_urungorselleri;");
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { 
                                        $urunGorselleri[$row['urun_id']][$row['urungorsel_id']] = $row['a_urunler_urungorselleri_id'];
                                    }

                                    $veriCek = $conn->prepare("SELECT * FROM a_urunler_promosyonlar;");
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { 
                                        $urunPromosyonlari[$row['urun_id']][$row['promosyon_id']] = $row['urunler_promosyonlar_id'];
                                    }

                                    $veriCek = $conn->prepare("SELECT * FROM a_yorumlar;");
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { 
                                        $urunYorumlari[$row['urun_id']][$row['yorum_id']] = $row['sira'];
                                    }

                                    $veriCek = $conn->prepare("SELECT * FROM a_urunler ORDER BY urun_id DESC");
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { 
                                        if(isset($urunVaryantlar[$row['urun_id']])){
                                            $varyanBtnColor = "btn-success";
                                        }else{
                                            $varyanBtnColor = "btn-warning";   
                                        }

                                        if(isset($urunGorselleri[$row['urun_id']])){
                                            $urunBtnColor = "btn-success";
                                        }else{
                                            $urunBtnColor = "btn-warning";
                                        }

                                        if(isset($urunPromosyonlari[$row['urun_id']])){
                                            $promosyonBtnColor = "btn-success";
                                        }else{
                                            $promosyonBtnColor = "btn-warning";
                                        }

                                        if(isset($urunYorumlari[$row['urun_id']])){
                                            $yorumBtnColor = "btn-success";
                                        }else{
                                            $yorumBtnColor = "btn-warning";
                                        }
                                ?>
                                    <tr <?php if($row['urun_klon']!=null) { ?> title="<?= $row['urun_klon'] ?> numaralı ürünün klonu"<?php } ?>>
                                        <td>
                                            <a href="urun-detayi?id=<?= $row['urun_id']; ?>">
                                                <?= $row['urun_id'] ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="../<?= $row['urun_img']; ?>" target="_BLANK">
                                                <img src="../<?= $row['urun_img'] ?>" class="tableImg">
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap justify-content-between  align-items-center">
                                                <span><?= $row['urun_adi'] ?></span>
                                                <span><?= $row['urun_subdomain'] ?></span>
                                            </div>
                                        </td>
                                        <td><?= $row['urun_kisa_adi'] ?></td>
                                        <td><?= $row['urun_stok_kodu'] ?></td>
                                        <td><?= $row['urun_stok'] ?></td>
                                        <td>
                                            <?= ParaFormatla($row['urun_fiyat']) ?> ₺
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap justify-content-start align-items-center">
                                                <div class="form-check form-switch form-control-lg">
                                                    <input data-id="<?= $row['urun_id'] ?>"
                                                        class="form-check-input durumDegistir" type="checkbox"
                                                        <?= ($row['urun_anasayfa'] == 1) ? 'checked' : ''; ?>>
                                                </div>
                                                <!-- <span><?= ($row['urun_anasayfa'] == 1) ? 'aktif' : 'pasif'; ?></span> -->
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?= $row['urun_subdomain']; ?>" target="_BLANK"
                                                class="btn btn-info text-white btn-sm" title="Ürün Web Sayfasını Görüntüle">
                                                <i class="fa-solid fa-link"></i> </a>                                           

                                            <a href="urun-guncelle?id=<?= $row['urun_id'] ?>"
                                                class="btn btn-success text-white btn-sm" title="Ürünü Güncelle">
                                                <i class="fe fe-edit"></i> </a>

                                            <a href="urun-yorumlari?id=<?= $row['urun_id'] ?>"
                                                class="btn <?=$yorumBtnColor?> text-white btn-sm" title="Ürün Yorumları">
                                                <i class="fa fa-comment"></i> </a>

                                            <a href="urun-varyant-kaydet?id=<?=$row["urun_id"]?>"
                                                class="btn <?=$varyanBtnColor?> text-white btn-sm" title=" Ürüne Özellik Ekle">
                                                <i class="fa fa-table"></i>
                                            </a>

                                            <a href="urune-gorsel-ekle?id=<?=$row["urun_id"]?>" 
                                                class="btn <?=$urunBtnColor?> text-white btn-sm" title=" Ürüne Görsel Ekle">
                                                <i class="fa fa-image"></i>
                                            </a>

                                            <a href="urune-promosyon-ekle?id=<?=$row["urun_id"]?>" 
                                                class="btn <?=$promosyonBtnColor?> text-white btn-sm" title=" Ürüne Promosyon Ekle">
                                                <i class="fa fa-gift" aria-hidden="true"></i>
                                            </a>

                                            <a href="#" data-id="<?= $row['urun_id'] ?>"
                                                class="btn btn-dark text-white btn-sm urunKlonla" title="Ürünü Klonla">
                                                <i class="fe fe-copy"></i>
                                            </a>

                                            <a href="#" data-id="<?= $row['urun_id'] ?>" 
                                                class="btn btn-danger text-white btn-sm urunSilBtn" title="Ürünü Sil">
                                                <i class="fe fe-trash-2"></i> 
                                            </a>
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
                            urunuSil: '1',
                            id: id,
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    title: 'Başarılı!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    window.location = "urunler";
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

    $(document).on("click", ".urunKlonla", function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        swal({
                title: "Klonlama İşlemi",
                text: "Ürünün tüm bilgileri klonlanacaktır. Emin misiniz?",
                icon: "warning",
                buttons: {
                    cancel: "Hayır İptal Et",
                    confirm: "Evet Klonla!"
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (!willDelete) {
                    swal("Klonlama İşlemi İptal Edildi.", {
                        icon: "error",
                    });
                } else {
                    $.ajax({
                        dataType: 'json',
                        type: "POST",
                        url: "ajax/ajax_urun_klonla.php",
                        data: {
                            urunKlonla: '1',
                            id: id
                        },
                        cache: false,
                        success: function(gelenData) {
                            console.log(gelenData);
                            Swal.fire({
                                title: 'Klonlama İşlemi',
                                text: gelenData.message,
                                icon: gelenData.status
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            swal("Hata! Klonlama Başarısız.", {
                                icon: "error",
                            });
                        }
                    });
                }
            });
    });

});
</script>

<script>
$(document).on('change', '.durumDegistir', function() {
    const durum = $(this).is(':checked') ? 1 : 0;
    const id = $(this).data('id');

    try {
        $.ajax({
            url: "ajax/ajax_action.php",
            type: "POST",
            data: {
                urunDurumu: true,
                durum: durum,
                id: id
            },
            cache: false,
            success: function(response) {

                try {
                    var responseData = JSON.parse(response);

                    if (responseData.status === "success") {
                        ToastTopEnd.fire({
                            icon: 'success',
                            title: responseData.message
                        });
                    } else {
                        ToastTopEnd.fire({
                            icon: 'error',
                            title: responseData.message
                        });
                    }
                } catch (error) {


                    ToastTopEnd.fire({
                        icon: 'error',
                        title: 'Bilinmeyen bir hata ile karşılaşıldı.'
                    });

                }
            },
            error: function(xhr, textStatus, errorThrown) {
                ToastTopEnd.fire({
                    icon: 'error',
                    title: 'Bir hata oluştu: ' + textStatus
                });
            }
        });
    } catch (error) {

        ToastTopEnd.fire({
            icon: 'error',
            title: 'Bilinmeyen bir hata ile karşılaşıldı.'
        });

    }
});
</script>