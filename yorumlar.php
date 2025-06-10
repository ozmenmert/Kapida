<?php 
include 'ayar.php';
$pageName = 'Ürün Yorumları';


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
        </div>





        <div class="row">
            <div class="col-sm-12">


                <div class="card">
                    <div class="card-header">
                        <h2>Ürün Yorumları Listesi</h2>
                        <p>Yorum sırasını inputa giriş yapıldığı zaman güncelleme otomatik yapılır.</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>Yorum Görseli</th>
                                    <th>Ürün</th>
                                    <th width="100">Sıra</th>
                                    <th width="150"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $veriCek = $conn->prepare("SELECT * FROM yorumlar,urunler WHERE urunler.urun_id = yorumlar.yorum_urun ORDER BY yorumlar.sira");
                                $veriCek->execute();
                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { 
                                    ?>
                                <tr>
                                    <td>
                                        <img style="height: 50px;width: 50px;" class="tableGorsel"
                                            src="../<?php echo $row['yorum_img']; ?>">
                                    </td>
                                    <td><?=$row['urun_adi']?></td>


                                    <td>
                                        <input type="number" class="sliderSiraInput form-control"
                                            data-id="<?php echo $row['yorum_id']; ?>" value="<?php echo $row['sira']; ?>"
                                            placeholder="0">
                                    </td>
                                    <td>

                                        <a href="<?=SiteUrl($row['yorum_img'])?>" target="_BLANK"
                                            class="btn btn-info text-white btn-sm"><i class="fa fa-image"></i> </a>

                                        <a href="yorum-duzenle?id=<?=$row['yorum_id']?>"
                                            class="btn btn-success text-white btn-sm"><i class="fe fe-edit"></i> </a>

                                        <a href="#" data-id="<?=$row['yorum_id']?>"
                                            class="btn btn-danger text-white btn-sm SilBtn"><i
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
                                    window.location = "slider-listesi";
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
    $(document).on('keyup', '.sliderSiraInput', function() {
        $.ajax({
                method: "POST",
                url: "ajax/sira_guncelle.php",
                data: {
                    id: $(this).data('id'),
                    sira: $(this).val(),
                    tableName: 'yorumlar',
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
});
</script>