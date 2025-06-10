<?php
include 'ayar.php';
$sayfa_hizmet_id = 7;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');
$pageName = 'Kargo Listesi';


$meta = array(
    'title' => $pageName . $separator .  $siteData['title'],
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
                <h5><?= $pageName ?></h5>
                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-primary" href="kargo-ekle"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Kargo Ekle</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>





        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-center table-hover dataTable">

                                <thead class="thead-light">
                                    <tr>
                                        <th>Başlık</th>
                                        <th>Aktif</th>
                                        <th>Kapıda Nakit</th>
                                        <th>Kapıda Kart</th>
                                        <th width="150"></th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <?php
                                    $veriCek = $conn->prepare("SELECT * FROM kargo_firmalar ORDER BY kargo_adi");
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>

                                        <tr>
                                            <td><?php echo $row['kargo_adi']; ?></td>
                                            <td>
                                                <div class="form-check form-switch form-control-lg">
                                                    <input data-id="<?= $row['kargo_id'] ?>" class="form-check-input durumDegistir" type="checkbox" <?= ($row['durum'] == 1) ? 'checked' : ''; ?>>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch form-control-lg">
                                                    <input data-id="<?= $row['kargo_id'] ?>" class="form-check-input kapidaNakitDegistir" type="checkbox" <?= ($row['kapida_nakit'] == 1) ? 'checked' : ''; ?>>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch form-control-lg">
                                                    <input data-id="<?= $row['kargo_id'] ?>" class="form-check-input kapidaKartDegistir" type="checkbox" <?= ($row['kapida_kart'] == 1) ? 'checked' : ''; ?>>
                                                </div>
                                            </td>
                                            <td align="right">
                                                <a href="kargo-duzenle?id=<?= $row['kargo_id'] ?>" class="btn btn-success text-white btn-sm"><i class="fe fe-edit"></i>
                                                </a>
                                                <a href="#" data-id="<?= $row['kargo_id'] ?>" class="btn btn-danger text-white btn-sm SilBtn"><i class="fe fe-trash-2"></i> </a>
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

<?php include 'footer.php'; ?>


<script src="sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        
        $(document).on("click", ".SilBtn", function(e) {
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
                                kargoSil: '1',
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
                                            "kargolar";
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


        $(document).on('change', '.durumDegistir', function() {
            const durum = $(this).is(':checked') ? 1 : 0;
            const id = $(this).data('id');

            try {
                $.ajax({
                    url: "ajax/ajax_action.php",
                    type: "POST",
                    data: {
                        kargoDurum: true,
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



        $(document).on('change', '.kapidaNakitDegistir', function() {
            const kapida_nakit = $(this).is(':checked') ? 1 : 0;
            const id = $(this).data('id');
            try {
                $.ajax({
                    url: "ajax/ajax_action.php",
                    type: "POST",
                    data: {
                        kapidaNakit: true,
                        kapida_nakit: kapida_nakit,
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




        $(document).on('change', '.kapidaKartDegistir', function() {
            const kapida_kart = $(this).is(':checked') ? 1 : 0;
            const id = $(this).data('id');

            try {
                $.ajax({
                    url: "ajax/ajax_action.php",
                    type: "POST",
                    data: {
                        kapidaKart: true,
                        kapida_kart: kapida_kart,
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



    });
</script>