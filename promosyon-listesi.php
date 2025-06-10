<?php
include "../ayar.php";

$sayfa_hizmet_id = 3;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

$pageName = 'Promosyon Deposu';
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Promosyonlar</h5>
                    </div>
                    <div class="card-body">
                        <table id="promosyonTable" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-left fw-bold fs-6">Id</td>
                                    <td class="text-left fw-bold fs-6">Promosyon Adı</td>
                                    <td class="text-left fw-bold fs-6">Önceki Tutar</td>
                                    <td class="text-left fw-bold fs-6">Tutar</td>
                                    <td class="text-left fw-bold fs-6">Promosyon Video</td>
                                    <td>Promosyon Görselleri</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $promosyongorselleri = array();
                                    $sql = "SELECT pg.promosyongorsel_id, pg.img, p_pg.promosyon_id FROM a_promosyongorselleri AS pg
                                    LEFT OUTER JOIN a_promosyonlar_promosyongorselleri AS p_pg ON pg.promosyongorsel_id = p_pg.promosyongorsel_id
                                    ORDER BY p_pg.promosyon_id;";
                                    $veriCek = $conn->prepare($sql);
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { 
                                        $promosyongorselleri[$row['promosyon_id']][$row['promosyongorsel_id']] = $row["img"];
                                    }

                                    $veriCek = $conn->prepare("SELECT * FROM a_promosyonlar ORDER BY promosyon_id");
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
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
                                            <?= $row['promosyon_video'] ?>
                                        </td>

                                        <td>
                                            <div class="row">
                                                <?php
                                                    if(isset($promosyongorselleri[$row['promosyon_id']])){
                                                        foreach($promosyongorselleri[$row['promosyon_id']] as $id=>$gorsel){ ?>
                                                        <div class="col-lg-1">
                                                            <a href="../uploads/<?= $gorsel ?>" target="_BLANK">
                                                                <img class="img-fluid" src="../thumbs/uploads/<?= $gorsel ?>" title="görsel id: <?=$id?>">
                                                            </a>
                                                        </div>                                                    
                                                <?php }} ?>
                                            </div>                                        
                                        </td>

                                        <td>
                                            <a href="promosyon-duzenle?id=<?= $row['promosyon_id'] ?>"
                                                class="btn btn-success text-white btn-sm" title="Promosyon Düzenle"><i class="fe fe-edit"></i> </a>
                                            <a href="#" data-id="<?= $row['promosyon_id'] ?>"
                                                class="btn btn-danger text-white btn-sm promosyonSilBtn" title="Promosyon Sil"><i
                                                    class="fe fe-trash-2"></i> </a>
                                            <a href="promosyona-gorsel-ekle?id=<?= $row['promosyon_id'] ?>"
                                                    class="btn btn-info text-white btn-sm" title="Promosyona Görsel Ekle"><i class="fa fa-image"></i> </a>
                                        </td>
                                    </tr>
                                    <?php }?>
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
    $(document).on("click", ".promosyonSilBtn", function(e) {
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
                            promosyonSil: '1',
                            id: id,
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    title: 'Başarılı!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    window.location = "promosyon-listesi";
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