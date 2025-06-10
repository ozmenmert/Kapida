<?php
include 'ayar.php';
$pageName = 'Ürün Yorumları';
$urun_id = $_GET['id'];
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

        <!-- <div class="page-header">
            <div class="content-page-header">
                <h5>Ürün Yorumları</h5>
                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-primary" href="yorum-ekle"><i class="fa fa-plus-circle me-2"
                                    aria-hidden="true"></i>Ürün Yorumu Ekle</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div> -->

        <?php
        include '../share/urun-guncelle-page-header.php';
        $sql = "SELECT y.yorum_id, y.urun_id, y.yorum_img, y.sira, y.durum, y.yorum_adi, y.yorum_puan, y.yorum_aciklama, y.tarih, u.urun_adi FROM a_yorumlar AS y
                LEFT OUTER JOIN a_urunler AS u ON y.urun_id = u.urun_id
                WHERE y.urun_id = " . $urun_id . "
                ORDER BY y.sira;";
        $veriCek = $conn->prepare($sql);
        $veriCek->execute();
        $rows = $veriCek->fetchAll(PDO::FETCH_ASSOC);
        if (count($rows) > 0) {
        ?>

        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header">
                        <h2><?=$rows[0]['urun_adi'] ?> Ürün Yorumları</h2>
                        <p>Yorum sırasını inputa giriş yapıldığı zaman güncelleme otomatik yapılır.</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>Yorum Görseli</th>                                    
                                    <th>Yorum</th>
                                    <th>Puan</th>
                                    <th width="100">Sıra</th>
                                    <th width="150"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($rows as $row) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php
                                                if ($row['yorum_img'] != null) {
                                                    $yorumImages = json_decode($row['yorum_img']);
                                                    foreach ($yorumImages as $yorumImage) {
                                                        echo "<img style='height: 50px;width: 50px;' class='tableGorsel mx-1' src='../$yorumImage'>";
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td><?= $row['yorum_aciklama'] ?></td>
                                        <td><?= $row['yorum_puan'] ?></td>
                                        <td>
                                            <input type="number" class="siraInput form-control"
                                                data-id="<?php echo $row['yorum_id']; ?>" value="<?php echo $row['sira']; ?>"
                                                placeholder="0">
                                        </td>
                                        <td>
                                            <a href="<?= SiteUrl($row['yorum_img']) ?>" target="_BLANK" class="btn btn-info text-white btn-sm">
                                                <i class="fa fa-image"></i>
                                            </a>
                                            <!-- <a href="yorum-duzenle?id=<?= $row['yorum_id'] ?>" class="btn btn-success text-white btn-sm">
                                                <i class="fe fe-edit"></i>
                                            </a> -->

                                            <a href="javascript:void(0)" data-id="<?= $row['yorum_id'] ?>" class="btn btn-success text-white btn-sm yorumDuzenleBtn">
                                                <i class="fe fe-edit"></i>
                                            </a>

                                            <a href="#" data-id="<?= $row['yorum_id'] ?>" class="btn btn-danger text-white btn-sm SilBtn">
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

        <?php
        }else{
            echo "<div class='alert alert-danger'>Ürünün yorumu bulunmamaktadır.</div>";
        }
        ?>

    </div>
</div>

<div class="modal fade" id="yorumGorselEkleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelYorum"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelYorum">
                    Yorum Ekle
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="islemler.php" enctype="multipart/form-data">
                    <input type="hidden" name="urun_id" value="<?= $urun_id ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Yorum yapan</label>
                                <input type="text" name="yorum_adi" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Yorum yapan</label>
                                <select class="form-control" name="yorum_puan" required>
                                    <?php for ($i = 0; $i <= 5; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?> Puan</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Görseller</label>
                                <input type="file" name="gorseller[]" class="form-control"
                                    accept=".jpg,.jpeg,.png,.gif" multiple>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Yorum Metni</label>
                                <textarea class="form-control" name="yorum_aciklama" rows="1"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" name="urunYorumEkle" class="btn btn-primary btn-block w-100"><i
                                    class="fa fa-save"></i> Ekle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="yorumGorselDuzenleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelYorum"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelYorum">
                    Yorum Düzenle
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="islemler.php" enctype="multipart/form-data">
                    <input type="hidden" name="urun_id" value="<?= $urun_id ?>">
                    <input type="hidden" class="yorum_id" name="yorum_id" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Yorum yapan</label>
                                <input type="text" name="yorum_adi" class="form-control yorum_adi" required="">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Yorum yapan</label>
                                <select class="form-control yorum_puan" name="yorum_puan" required>
                                    <?php for ($i = 0; $i <= 5; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?> Puan</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Görseller</label>
                                <input type="file" name="gorseller[]" class="form-control " accept=".jpg,.jpeg,.png,.gif" multiple>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Yorum Metni</label>
                                <textarea class="form-control yorum_aciklama" name="yorum_aciklama" rows="1" required></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" name="ayorumGorselDuzenle" class="btn btn-primary btn-block w-100"><i
                                    class="fa fa-save"></i> Güncelle</button>
                        </div>
                    </div>
                </form>
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
                                yorumSil: '1',
                                id: id,
                            },
                            success: function(response) {

                                if (response.status == "success") {
                                    Swal.fire({
                                        title: 'Başarılı!',
                                        text: response.message,
                                        icon: 'success'
                                    }).then(() => {
                                        window.location = "urun-yorumlari?id=<?=$urun_id?>";
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



<script>
    $(document).ready(function() {
        $(document).on('change', '.siraInput', function() {
            $.ajax({
                    method: "POST",
                    url: "ajax/sira_guncelle.php",
                    data: {
                        id: $(this).data('id'),
                        sira: $(this).val(),
                        tableName: 'a_yorumlar',
                        idName: 'yorum_id'
                    }
                })
                .done(function() {
                    ToastTopEnd.fire({
                        icon: 'success',
                        title: 'Sıra Güncellendi.'
                    });
                });
        });

        $(document).on("click", ".yorumDuzenleBtn", function(e) {
            var id = $(this).data('id');

            $.ajax({
                url: 'ajax/ajax_select.php',
                type: 'POST',
                data: {
                    id: id,
                    ayorumDataGetir: '1'
                },
                dataType: 'json',
                success: function(response) {
                    $('.yorum_id').val(response.yorum_id);
                    $('.yorum_adi').val(response.yorum_adi);
                    var yorum_puan_int = parseInt(response.yorum_puan);
                    $('.yorum_puan').val(yorum_puan_int).trigger('change');
                    $('.yorum_aciklama').val(response.yorum_aciklama);
                    $('#yorumGorselDuzenleModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log('Bir hata oluştu: ' + error);
                }
            });
        });
    });
</script>