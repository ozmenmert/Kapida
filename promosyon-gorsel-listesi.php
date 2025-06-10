<?php
include "../ayar.php";

$sayfa_hizmet_id = 3;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

$pageName = 'Promosyon Görsel Deposu';
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
                        <h5>Promosyon Görselleri</h5>
                    </div>
                    <div class="card-body">

                        <table id="promosyonGorselTable" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-left fw-bold fs-6">Görsel Id</td>
                                    <td class="text-left fw-bold fs-6">Görsel</td>
                                    <td class="text-left fw-bold fs-6">Görsel Dosya Adı</td>
                                    <td></td>
                                    <td class="text-left fw-bold fs-6">Görselin Kullanıldığı Promosyonlar</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $promosyonGorsel_promosyonIdleri = array();
                                    $sql = "SELECT g.promosyongorsel_id, p_g.promosyon_id, p.promosyon_adi FROM a_promosyongorselleri AS g
                                            LEFT OUTER JOIN a_promosyonlar_promosyongorselleri AS p_g ON g.promosyongorsel_id = p_g.promosyongorsel_id
                                            LEFT OUTER JOIN a_promosyonlar AS p ON p.promosyon_id = p_g.promosyon_id
                                            ORDER BY p.promosyon_id, g.promosyongorsel_id, p_g.promosyonlar_gorseller_id;";
                                    $veriCek = $conn->prepare($sql);
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                        $promosyonGorsel_promosyonIdleri[$row['promosyongorsel_id']][$row['promosyon_id']] = $row['promosyon_adi'];
                                    }

                                    $veriCek = $conn->prepare("SELECT * FROM a_promosyongorselleri ORDER BY promosyongorsel_id");
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td>
                                            <?= $row['promosyongorsel_id'] ?>
                                        </td>
                                        <td>
                                            <a href="../uploads/<?= $row['img'] ?>" target="_BLANK">
                                                <img class="tableImg" src="../thumbs/uploads/<?= $row['img'] ?>" title="görsel id: <?= $row['promosyongorsel_id']?>">
                                            </a>                                            
                                        </td>
                                        <td>
                                            <?= $row['img'] ?>
                                        </td>
                                        <td>
                                            <a href="#" data-id="<?= $row['promosyongorsel_id'] ?>" class="btn btn-danger text-white btn-sm promosyongorselSilBtn" title="Görseli Sil"><i class="fe fe-trash-2"></i> </a>
                                        </td>
                                        <td>
                                            <div class="list-btn">
                                                <ul class="filter-list">
                                                <?php
                                                    if(isset($promosyonGorsel_promosyonIdleri[$row['promosyongorsel_id']])){
                                                        foreach($promosyonGorsel_promosyonIdleri[$row['promosyongorsel_id']] as $key=>$data){
                                                            if($data!=""){?>
                                                                <li>
                                                                    <a class="btn btn-info" href="promosyon-duzenle?id=<?=$key?>" title="promosyon-duzenle?id=<?=$key?>"><?= $data ?></a>
                                                                </li>
                                                            <?php }
                                                        }
                                                    }
                                                ?>
                                                </ul>
                                            </div>
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
                            Swal.fire({
                                title: 'Hata!',
                                text: response.message,
                                icon: 'error'
                            });
                            /*swal("Hata Silinmedi.", {
                                icon: "error",
                            });*/
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