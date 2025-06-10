<?php
include 'ayar.php';


if (!isset($_GET['id'])) {
    header('Location: ' . SiteUrl('panel'));
}



$id = $_GET['id'];
$data = $conn->query("SELECT * FROM kargo_firmalar WHERE kargo_id = $id")->fetch(PDO::FETCH_ASSOC);

$pageName = 'Kargo Firmasını Düzenle';

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
                            <a class="btn btn-info" href="kargolar"><i class="fa fa-list me-2"></i>Kargo Firmaları</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>


        <form action="islemler.php" method="POST" enctype="multipart/form-data">

            <div class="row">

                <div class="col-xl-12 col-md-12">
                    <div class="card w-100 pt-0">
                        <div class="card-body">
                            <input type="hidden" name="kargo_id" value="<?= $data['kargo_id'] ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Firma Adı</label>
                                        <input type="text" name="kargo_adi" class="form-control" placeholder="Firma Adı"
                                            required value="<?= $data['kargo_adi'] ?>">
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Teslim Tutarı</label>
                                        <input type="number" step="any" name="kargo_teslim" class="form-control"
                                            placeholder="Teslim Tutarı" required value="<?= $data['kargo_teslim'] ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Komisyon Yuzdesi</label>
                                        <input type="number" step="any" name="kargo_komisyon" class="form-control"
                                            placeholder="Komisyon Yuzdesi" required
                                            value="<?= $data['kargo_komisyon'] ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>İade Tutarı</label>
                                        <input type="number" step="any" name="kargo_iade" class="form-control"
                                            placeholder="İade Tutarı" required value="<?= $data['kargo_iade'] ?>">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Fiyat Aralıkları</h5>
                        </div>
                        <div class="card-body">
                            <table id="fiyatlandirmaTable" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-left">Başlangıç Değer</td>
                                        <td class="text-left">Bitiş Değer</td>
                                        <td class="text-left">Tutar</td>
                                        <td width="50"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-right"><button type="button" onclick="addValue();"
                                                data-toggle="tooltip" title="" class="btn btn-primary"
                                                data-original-title="Ekle"><i class="fa fa-plus-circle"></i></button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 text-end">
                    <div class="btn-path">
                        <button type="submit" name="kargoDuzenle" class="btn btn-primary btn-block w-100 btn-lg"><i
                                class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
                    </div>
                </div>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
<script>
function generateUniqueId() {
    return Math.random().toString(36).substr(2, 9);
}

function addValue(baslangic = '0', bitis = '0', tutar = '0') {
    var uniqueId = generateUniqueId();
    html = ` 
                <tr id="baslangicRow${uniqueId}">
                <td class="text-left">
                <input type="number" step="any" min="1" name="baslangic[${uniqueId}]" value="${baslangic}"
                placeholder="Başlangıç Değeri" class="form-control  border-danger" required />
                </td>

                <td class="text-left">
                <input type="number" step="any" min="0" name="bitis[${uniqueId}]" value="${bitis}"
                placeholder="Bitiş Değeri" class="form-control  border-danger" required />
                </td>

                <td class="text-left">
                <input type="number" step="any" min="0" name="tutar[${uniqueId}]" value="${tutar}"
                placeholder="Tutar" class="form-control  border-danger" required />
                </td>

                <td class="text-right"><button type="button" onclick="$('#baslangicRow${uniqueId}').remove();"
                data-toggle="tooltip" title="Kaldır" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                </td>';
                </tr>
                `;
    $('#fiyatlandirmaTable tbody').append(html);
}
<?php
    $kargo_id = $data['kargo_id'];
    $tutarArr = [];
    $veriCek = $conn->prepare("SELECT * FROM kargo_araliklar WHERE aralik_kargo_id = '$kargo_id' ORDER BY aralik_ucret");
    $veriCek->execute();
    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
        $tutarArr[] = $row['aralik_ucret'];
    ?>
addValue('<?= $row['aralik_baslangic'] ?>', '<?= $row['aralik_bitis'] ?>', '<?= $row['aralik_ucret'] ?>');
<?php } ?>
</script>