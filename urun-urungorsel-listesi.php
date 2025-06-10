<?php
include "../ayar.php";

$sayfa_hizmet_id = 3;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

$pageName = 'Ürüne Görsel Ekle';
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
                                    <th>Ürün Adı</th>
                                    <th>Görsel Ekle/Çıkar</th>
                                    <th>Ürün Görselleri</th>
                                    <th>Görsel Sırala</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $urunGorsel_urunIdleri = array();
                                $sql = "SELECT g.urungorsel_id, u_g.urun_id, g.img FROM a_urungorselleri AS g
                                        LEFT OUTER JOIN a_urunler_urungorselleri AS u_g ON g.urungorsel_id = u_g.urungorsel_id
                                        LEFT OUTER JOIN a_urunler AS u ON u.urun_id = u_g.urun_id
                                        WHERE u_g.urun_id IS NOT NULL
                                        ORDER BY u_g.sira, u.urun_id, g.urungorsel_id, u_g.a_urunler_urungorselleri_id;";
                                $veriCek = $conn->prepare($sql);
                                $veriCek->execute();
                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                    $urunGorsel_urunIdleri[$row['urun_id']][$row['urungorsel_id']] = $row['img'];
                                }

                                $veriCek = $conn->prepare("SELECT * FROM a_urunler ORDER BY urun_id DESC");
                                $veriCek->execute();
                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                    if (isset($urunGorsel_urunIdleri[$row['urun_id']])) {
                                        $gorselButtonColor = "btn-success";
                                    } else {
                                        $gorselButtonColor = "btn-warning";
                                    }
                                ?>
                                    <tr>
                                        <td>
                                            <?= $row['urun_id'] ?>
                                        </td>
                                        <td>
                                            <a href="../<?= $row['urun_img']; ?>" target="_BLANK">
                                                <img src="../<?= $row['urun_img'] ?>" class="tableImg">
                                            </a>
                                        </td>
                                        <td>
                                            <?= $row['urun_adi'] ?>
                                        </td>
                                        <td>
                                            <a href="urune-gorsel-ekle?id=<?= $row["urun_id"] ?>" class="btn <?= $gorselButtonColor ?> text-white btn-sm" title=" Ürüne Görsel Ekle">
                                                Görsel Ekle
                                            </a>
                                        </td>
                                        <td>
                                            <div class="list-btn">
                                                <ul class="filter-list">
                                                    <?php
                                                    if (isset($urunGorsel_urunIdleri[$row['urun_id']])) {
                                                        foreach ($urunGorsel_urunIdleri[$row['urun_id']] as $key => $data) {
                                                            if ($data != "") { ?>
                                                                <li>
                                                                    <a href="../uploads/<?= $data ?>" target="_BLANK">
                                                                        <img class="img-fluid" src="../thumbs/<?= $data ?>" title="görsel id: <?= $id ?>" width="50" height="50">
                                                                    </a>
                                                                </li>
                                                    <?php }
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="urun-urungorsel-listesi?id=<?= $row["urun_id"] ?>" class="btn btn-info text-white btn-sm" title=" Ürüne Görseli Sırala">
                                                Görsel Sırala
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

        <?php if (isset($_GET['id'])) { ?>
            <?php
                $id = $_GET['id'] ?? -1;
                $data = $conn->query("SELECT * FROM a_urunler WHERE urun_id = '$id' ")->fetch(PDO::FETCH_ASSOC);

                if (!$data) {
                    header('Location: urun-urungorsel-listesi?durum=gecersizIslem');
                    die();
                }
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><?= $data['urun_adi'] ?> | <span class="alert alert-danger px-1 py-1">id: <?= $data['urun_id'] ?></span> | Ürün Görselleri</h5>
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
                                    $sql = "SELECT a_urunler_urungorselleri_id, g.urungorsel_id, u_g.urun_id, g.img, u_g.sira FROM a_urungorselleri AS g
                                            LEFT OUTER JOIN a_urunler_urungorselleri AS u_g ON g.urungorsel_id = u_g.urungorsel_id
                                            LEFT OUTER JOIN a_urunler AS u ON u.urun_id = u_g.urun_id
                                            WHERE u_g.urun_id = ".$id."
                                            ORDER BY u_g.sira, u_g.a_urunler_urungorselleri_id;";
                                    $veriCek = $conn->prepare($sql);
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td>
                                                <a href="../<?= $row['img'] ?>" target="_BLANK">
                                                    <img class="tableImg" src="../<?= $row['img'] ?>" title="id: <?= $row['urun_id'] ?> (Büyük resim için tıklayınız)">
                                                </a>
                                            </td>
                                            <td>
                                                <input type="number"
                                                    class="urun_urunGorselSiraInput form-control"
                                                    data-id="<?= $row['a_urunler_urungorselleri_id'] ?>"
                                                    value="<?= $row['sira'] ?>"
                                                    placeholder="0" min="0" max="100">
                                            </td>
                                            <td align="center">
                                                <a href="#" data-id="<?= $row['a_urunler_urungorselleri_id'] ?>" class="btn btn-danger text-white btn-sm urun_urungorselSilBtn" title="Görseli Üründen Kaldır"><i class="fe fe-trash-2"></i> </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <td colspan="3">
                                        <a href="urune-gorsel-ekle?id=<?= $data['urun_id'] ?>" class="btn btn-info text-white btn-sm" title="urune-gorsel-ekle?id=<?= $data['urun_id'] ?>"><i class="fa fa-image"></i> Görsel Ekle</a>
                                    </td>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>

<?php include 'footer.php'; ?>
<script src="sweetalert.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on("click", ".urun_urungorselSilBtn", function(e) {
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
                            urun_urunGorseliSil: '1',
                            id: id,
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    title: 'Başarılı!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    window.location = "urun-urungorsel-listesi?id=<?=$_GET["id"]?>";
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

    $(document).on('click', '.urun_urunGorselSiraInput', function(e) {
        $.ajax({
            method: "POST",
            url: "ajax/sira_guncelle.php",
            data: {
                id: $(this).data('id'),
                sira: $(this).val(),
                tableName: 'a_urunler_urungorselleri',
                idName: 'a_urunler_urungorselleri_id'
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