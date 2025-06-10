<?php
include 'ayar.php';

$id = $_GET['id'] ?? -1;
$data = $conn->query("SELECT * FROM a_urunler WHERE urun_id = '$id' ")->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    header('Location: urunler?durum=gecersizIslem');
    die();
}

$pageName = $data['urun_adi'] . " | " . "Ürün + Kargo Fiyatları";
$sayfa_hizmet_id = 3;
redirectToUnauthorized($sayfa_hizmet_id, 'ekle');
$meta = array(
    'title' => $pageName . $separator . $siteData['title'],
    'description' => $siteData['description'],
    'keywords' => $siteData['keywords'],
    'author' => $siteData['author']
);
include 'header.php';
?>
<style>
    .tab-pane .card {
        padding: 0;
    }
</style>
<script>
    function generateUniqueId() {
        return Math.random().toString(36).substr(2, 9);
    }

    function addValue(adet = '', onceki = '', fiyat = '', kargo_tutar = '0', kargo_durum = 0, durum = 1) {
        var uniqueId = generateUniqueId();
        html = ` 
        <tr id="adetRow${uniqueId}">
        <td class="text-left">
        <input type="number" min="1" name="adet[${uniqueId}]" value="${adet}"
        placeholder="Adet" class="form-control  border-danger" required />
        </td>
        <td class="text-left">
        <input type="number" min="0" name="onceki[${uniqueId}]" value="${onceki}"
        placeholder="Önceki Fiyat" class="form-control  border-danger" required />
        </td>
        <td class="text-left">
        <input type="number" min="0" name="fiyat[${uniqueId}]" value="${fiyat}"
        placeholder="Fiyat" class="form-control  border-danger" required />
        </td>
        <td class="text-left">
        <input type="number" min="0" name="kargo_tutar[${uniqueId}]" value="${kargo_tutar}"
        placeholder="Kargo Tutarı" class="form-control  border-danger" required />
        </td>
        <td class="text-left">
        <select name="kargo_durum[${uniqueId}]" class="form-control border-danger" required>
        <option value="0" ${kargo_durum == 0 ? 'selected' : ''}>Kargo Ücretsiz</option>
        <option value="1" ${kargo_durum == 1 ? 'selected' : ''}>+Kargo</option>
        </select>
        </td>
        <td class="text-right"><button type="button" onclick="$('#adetRow${uniqueId}').remove();"
        data-toggle="tooltip" title="Kaldır" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
        </td>';
        <td>
            <div class="d-flex flex-wrap justify-content-start align-items-center">
                <div class="form-check form-switch form-control-lg">
                    <input data-id="${uniqueId}" class="form-check-input urunFiyatlandirmaDurumDegistir" type="checkbox" ${durum == 1 ? 'checked' : ''}>
                    <input type="hidden" name="durum[${uniqueId}]" value="${durum}">
                </div>
                <span>${durum == 1 ? 'aktif' : 'pasif'}</span>
            </div>
        </td>
        </tr>
        `;
        $('#fiyatlandirmaTable tbody').append(html);
    }
    <?php
    $urun_id = $data['urun_id'];
    //$urun_id = $_GET['id'];
    $adetArr = [];
    $veriCek = $conn->prepare("SELECT * FROM a_urun_fiyatlandirma WHERE urun_id = " . $urun_id . " ORDER BY adet");
    $veriCek->execute();
    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
        $adetArr[] = $row['adet'];
    ?>
        addValue('<?= $row['adet'] ?>', '<?= $row['onceki'] ?>', '<?= $row['fiyat'] ?>', '<?= $row['kargo_tutar'] ?>', '<?= $row['kargo_durum'] ?>', '<?= $row['durum'] ?>');
    <?php } ?>
</script>
<div class="page-wrapper">
    <div class="content container-fluid">
        <?php include '../share/urun-guncelle-page-header.php'; ?>

        <form action="islemler.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Fiyatlandırma</h5>
                                    </div>
                                    <div class="card-body">
                                        <table id="fiyatlandirmaTable" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <td class="text-left">Adet</td>
                                                    <td class="text-left">Önceki Fiyat</td>
                                                    <td class="text-left">Fiyat</td>
                                                    <td class="text-left">Kargo Tutar</td>
                                                    <td class="text-left">Kargo Dahil</td>
                                                    <td width="50"></td>
                                                    <td width="80"></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $veriCek = $conn->prepare("SELECT * FROM a_urun_fiyatlandirma WHERE urun_id = " . $data['urun_id'] . ";");
                                                $veriCek->execute();
                                                $i = 0;
                                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                                    $i++; ?>

                                                    <tr id='adetRow<?= $i ?>'>
                                                        <td class="text-left">
                                                            <input type="number" min="1" name="adet[<?= $i ?>]" value="<?= $row['adet'] ?>"
                                                                placeholder="Adet" class="form-control border-danger" required />
                                                        </td>
                                                        <td class="text-left">
                                                            <input type="number" min="0" name="onceki[<?= $i ?>]" value="<?= $row['onceki'] ?>"
                                                                placeholder="Önceki Fiyat" class="form-control border-danger" required />
                                                        </td>
                                                        <td class="text-left">
                                                            <input type="number" min="0" name="fiyat[<?= $i ?>]" value="<?= $row['fiyat'] ?>"
                                                                placeholder="Fiyat" class="form-control border-danger" required />
                                                        </td>
                                                        <td class="text-left">
                                                            <input type="number" min="0" name="kargo_tutar[<?= $i ?>]" value="<?= $row['kargo_tutar'] ?>"
                                                                placeholder="Kargo Tutarı" class="form-control border-danger" required />
                                                        </td>
                                                        <td class="text-left">
                                                            <select name="kargo_durum[<?= $i ?>]" class="form-control border-danger" value="<?= $row['kargo_durum'] ?>" required>
                                                                <option value="1" <?= $row['kargo_durum'] == '1' ? 'selected' : '' ?>>+Kargo</option>
                                                                <option value="0" <?= $row['kargo_durum'] == '0' ? 'selected' : '' ?>>Kargo Ücretsiz</option>                                                                
                                                            </select>
                                                        </td>
                                                        <td class="text-right"><button type="button" onclick="$('#adetRow<?= $i ?>').remove();"
                                                                data-toggle="tooltip" title="Kaldır" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-wrap justify-content-start align-items-center">
                                                                <div class="form-check form-switch form-control-lg">
                                                                    <input name="durum[<?= $i ?>]" class="form-check-input" type="checkbox" <?= $row['durum']==1 ? 'checked' : '' ?>>
                                                                </div>
                                                                <span><?= $row['durum'] == 1 ? 'aktif' : 'pasif'?></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5"></td>
                                                    <td class="text-right"><button type="button" onclick="addValue();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Ekle"><i class="fa fa-plus-circle"></i></button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <button type="submit" name="urunKargoFiyati" class="btn btn-primary btn-block w-100 btn-lg mt-2"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<?php include 'footer.php'; ?>