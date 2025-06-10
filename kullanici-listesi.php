<?php
include 'ayar.php';
$pageName = 'Kullanıcı Listesi';
$sayfa_hizmet_id = 10;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

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
                <h5>Kullanıcı Yönetimi</h5>
                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-primary" href="kullanici-ekle"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Kullanıcı Ekle</a>
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
                            <table class="table table-center table-hover customTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Kullanıcı</th>
                                        <th>Telefon</th>
                                        <th>Son Giriş Tarihi</th>
                                        <th width="50"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $veriCek = $conn->prepare("SELECT * FROM kullanicilar");
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>

                                        <tr>
                                            <td><?= $row['kul_id'] ?></td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="kullanici-duzenle?id=<?= $row['kul_id'] ?>"><?= $row['adi'] ?>
                                                        <span><?= $row['email'] ?></span></a>
                                                </h2>
                                            </td>
                                            <td><a href="tel:+9<?= telefonFormat($row['tel']) ?>"><?= $row['tel'] ?></a>
                                            </td>
                                            <td><?= tarihSaatFormatla($row['son_giris_tarih']) ?></td>



                                            <td class="islemlerRow">
                                                <a href="kullanici-duzenle?id=<?= $row['kul_id'] ?>" class="btn btn-success text-white btn-sm"><i class="fe fe-edit"></i>
                                                </a>
                                                <button type="button" data-id="<?= $row['kul_id'] ?>" class="btn btn-danger text-white btn-sm kullaniciSilBtn"><i class="fe fe-trash-2"></i> </button>
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
        $(document).on("click", ".kullaniciSilBtn", function(e) {
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
                                kullaniciSil: '1',
                                id: id,
                            },
                            success: function(response) {

                                if (response.status == "success") {
                                    Swal.fire({
                                        title: 'Başarılı!',
                                        text: response.message,
                                        icon: 'success'
                                    }).then(() => {
                                        window.location = "kullanici-listesi";
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