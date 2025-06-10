<?php
include 'ayar.php';
$sayfa_hizmet_id = 6;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');
$pageName = 'İçerik Listesi';


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
                                        <th>Tarih</th>
                                        <th width="150"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $veriCek = $conn->prepare("SELECT * FROM icerik order by id");
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>

                                        <tr>
                                            <td><?php echo $row['baslik']; ?></td>
                                            <td><?php echo tarihSaatFormatla($row['tarih']); ?></td>
                                            <td align="right">
                                                <a href="icerik-duzenle?id=<?= $row['id'] ?>" class="btn btn-success text-white btn-sm"><i class="fe fe-edit"></i>
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
</div>

<?php include 'footer.php'; ?>


<script src="sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on("click", ".icerikSilBtn", function(e) {
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
                                icerikSil: '1',
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
                                            "icerik-listesi";
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