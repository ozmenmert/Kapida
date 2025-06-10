<?php
include "../ayar.php";

$sayfa_hizmet_id = 3;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

$pageName = 'Ürün Görsel Deposu';
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
            <div class="col-md-6">
                <form action="urun-gorsel-listesi.php" method="GET">
                    <!-- <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>"> -->
                    <div class="card">
                        <div class="card-header">
                            <!-- <h5><?= $data['urun_adi'] ?> | <span class="alert alert-danger px-1 py-1">(id: <?= $data['urun_id'] ?>)</span> | İçin Görsel Ekle</h5> -->
                            <h5>Ürün Görseli Ara</h5>
                        </div>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Ürün Görseli Ara</label>
                                        <input type="text" name="urun_gorsel_adi" placeholder="Ürün Görsel Adı" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-search"></i>&nbsp;Bul</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Ürün Görseli Ekle</h5>
                    </div>
                    <div class="card-body">

                        <table id="urunGorselTable" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-left fw-bold fs-6">Görsel Id</td>
                                    <td class="text-left fw-bold fs-6">Görsel</td>
                                    <td class="text-left fw-bold fs-6">Dosya adı</td>
                                    <td></td>
                                    <td class="text-left fw-bold fs-6">Görselin Kullanıldığı Ürünler</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $urunGorsel_urunIdleri = array();
                                $sql = "SELECT g.urungorsel_id, u_g.urun_id, u.urun_adi FROM a_urungorselleri AS g
                                            LEFT OUTER JOIN a_urunler_urungorselleri AS u_g ON g.urungorsel_id = u_g.urungorsel_id
                                            LEFT OUTER JOIN urunler AS u ON u.urun_id = u_g.urun_id
                                            ORDER BY u.urun_id, g.urungorsel_id, u_g.a_urunler_urungorselleri_id;";
                                $veriCek = $conn->prepare($sql);
                                $veriCek->execute();
                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                    $urunGorsel_urunIdleri[$row['urungorsel_id']][$row['urun_id']] = $row['urun_adi'];
                                }

                                if(isset($_GET['urun_gorsel_adi'])) {
                                    $sql ="SELECT * FROM a_urungorselleri WHERE img LIKE '%" . $_GET['urun_gorsel_adi'] . "%' ORDER BY urungorsel_id";
                                }else{
                                    $sql ="SELECT * FROM a_urungorselleri ORDER BY urungorsel_id";
                                }
                                $veriCek = $conn->prepare($sql);
                                $veriCek->execute();
                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td>
                                            <?= $row['urungorsel_id'] ?>
                                        </td>
                                        <td>
                                            <a href="../<?= $row['img'] ?>" target="_BLANK">
                                                <img class="tableImg" src="../thumbs/<?= $row['img'] ?>" title="görsel id: <?= $row['urungorsel_id'] ?>">
                                            </a>
                                        </td>
                                        <td>
                                            <?= $row['img'] ?>
                                        </td>
                                        <td>
                                            <a href="#" data-id="<?= $row['urungorsel_id'] ?>" class="btn btn-danger text-white btn-sm urungorselSilBtn" title="Görseli Sil"><i class="fe fe-trash-2"></i> </a>
                                        </td>
                                        <td>
                                            <div class="list-btn">
                                                <ul class="filter-list">
                                                    <?php
                                                    if (isset($urunGorsel_urunIdleri[$row['urungorsel_id']])) {
                                                        foreach ($urunGorsel_urunIdleri[$row['urungorsel_id']] as $key => $data) {
                                                            if ($data != "") { ?>
                                                                <li>
                                                                    <a class="btn btn-info" href="urun-duzenle?id=<?= $key ?>" title="urun-duzenle?id=<?= $key ?>"><?= $data ?></a>
                                                                </li>
                                                    <?php }
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
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
        $(document).on("click", ".urungorselSilBtn", function(e) {
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
                                urunGorselleriSil: '1',
                                id: id,
                            },
                            success: function(response) {
                                if (response.status == "success") {
                                    Swal.fire({
                                        title: 'Başarılı!',
                                        text: response.message,
                                        icon: 'success'
                                    }).then(() => {
                                        window.location = "urun-gorsel-listesi";
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