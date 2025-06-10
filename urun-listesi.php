<?php
include 'ayar.php';

$sayfa_hizmet_id = 3;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

$pageName = 'Ürün Listesi';
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
                            <a class="btn btn-primary" href="urun-ekle"><i class="fa fa-plus-circle me-2"
                                    aria-hidden="true"></i>Ürün Ekle</a>
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
                                    <th width="50">ID</th>
                                    <th width="50">Ana Görsel</th>
                                    <th>Ürün Adı</th>
                                    <th>Stok Kodu</th>
                                    <th>Stok</th>
                                    <th width="100">Fiyat</th>
                                    <th>Anasayfa</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $veriCek = $conn->prepare("SELECT * FROM urunler ORDER BY urun_klon DESC,urun_id DESC");
                                $veriCek->execute();
                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td>
                                        <?= $row['urun_id'] ?>
                                    </td>
                                    <td><img src="../<?= $row['urun_img'] ?>" class="tableImg"></td>
                                    <td>
                                        <div class="d-flex flex-wrap justify-content-between  align-items-center">
                                            <span>
                                                <?= $row['urun_adi'] ?>
                                            </span>

                                            <span><?= ($row['urun_subdomain'] != '') ? $row['urun_subdomain'] : '' ?></span>

                                            <?php if (isset($row['urun_klon']) and $row['urun_klon'] != '') {
                                                    $urun_getir = $conn->query("SELECT * FROM urunler WHERE urun_id = " . $row['urun_klon'])->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                            <div class="popover-list">
                                                <button
                                                    class="example-popover btn btn-light btn-sm px-2 py-1 border-secondary"
                                                    type="button" data-bs-trigger="focus" data-container="body"
                                                    data-bs-toggle="popover" data-bs-placement="bottom"
                                                    title="Klon Bilgisi" data-offset="-20px -20px"
                                                    data-bs-content="Bu  <?= $row['urun_klon'] ?> ID'li <?= ($urun_getir) ? $urun_getir['urun_adi'] . ' ürününün' : 'ürünün'; ?> klonudur">
                                                    <i class="fa fa-copy"></i>
                                                </button>
                                            </div>

                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?= $row['urun_stok_kodu'] ?>
                                    </td>
                                    <td>
                                        <?= $row['urun_stok'] ?>
                                    </td>
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
                                            <span><?= ($row['urun_anasayfa'] == 1) ? 'aktif' : 'pasif'; ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="<?= $row['urun_subdomain']; ?>" target="_BLANK"
                                            class="btn btn-info text-white btn-sm"><i class="fa-solid fa-link"></i> </a>
                                        <a href="urun-duzenle?id=<?= $row['urun_id'] ?>"
                                            class="btn btn-success text-white btn-sm"><i class="fe fe-edit"></i> </a>

                                        <a href="#" data-id="<?= $row['urun_id'] ?>" title="Ürünü Klonla"
                                            class="btn btn-dark text-white btn-sm urunKlonla"><i class="fe fe-copy"></i>
                                        </a>


                                        <a href="#" data-id="<?= $row['urun_id'] ?>"
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
                            urunSil: '1',
                            id: id,
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    title: 'Başarılı!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    window.location = "urun-listesi";
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
                        url: "ajax/ajax_klonla.php",
                        data: {
                            urunKlon: '1',
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
                urunDurum: true,
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