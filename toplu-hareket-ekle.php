<?php
include 'ayar.php';
$sayfa_hizmet_id = 4;
redirectToUnauthorized($sayfa_hizmet_id, 'ekle');
$pageName = 'Toplu Hareket Ekle';


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
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="content-page-header">
                <h5>
                    <?= $pageName ?>
                </h5>
                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-primary" href="stok-listesi"><i class="fa fa-list me-2"
                                    aria-hidden="true"></i>Stok Listesi</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card w-100 pt-0">
                    <div class="card-body tabMain">
                        <form action="islemler.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#info" data-bs-toggle="tab">
                                                <i class="fa fa-th "></i> Toplu Hareket Ekle
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="info">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5>Hareket Bilgisi</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>Hareket Belgesi</label>
                                                                        <div
                                                                            class="form-group service-upload logo-upload mb-0">
                                                                            <span><img src="assets/img/icons/belge.svg"
                                                                                    style="height:50px"
                                                                                    alt="upload"></span>
                                                                            <div class="drag-drop">
                                                                                <h6 class="drop-browse align-center">
                                                                                    <span class="text-info me-1">Tıkla
                                                                                        Değiştir </span> veya
                                                                                    Sürükle
                                                                                    Bırak
                                                                                </h6>
                                                                                <input type="file" name="hareket_belge"
                                                                                    id="image_sign" required>
                                                                                <div id="frames">
                                                                                    <img src="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for="hareket_aciklama">Hareket
                                                                        Açıklaması</label>
                                                                    <input type="text" class="form-control"
                                                                        name="hareket_aciklama"
                                                                        placeholder="Hareket Açıklaması" required>
                                                                </div>

                                                                <div class="col-md-12 mt-5 mb-2">
                                                                    <div class="card-body p-0">

                                                                        <table id="fiyatlandirmaTable"
                                                                            class="table table-striped table-bordered table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td class="text-left">Ürün</td>
                                                                                    <td class="text-left">Adet</td>
                                                                                    <td class="text-left">Alış Tutar
                                                                                    </td>
                                                                                    <td class="text-left">Hareket Tipi
                                                                                    </td>
                                                                                    <td width="50"></td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                            </tbody>

                                                                            <tfoot>
                                                                                <tr>
                                                                                    <td colspan="4"></td>
                                                                                    <td class="text-right"><button
                                                                                            type="button"
                                                                                            onclick="addValue();"
                                                                                            data-toggle="tooltip"
                                                                                            title=""
                                                                                            class="btn btn-primary"
                                                                                            data-original-title="Ekle"><i
                                                                                                class="fa fa-plus-circle"></i></button>
                                                                                    </td>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>



                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" name="topluHareketEkle"
                                            class="btn btn-primary btn-block w-100 btn-lg"><i
                                                class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

<script>
function generateUniqueId() {
    return Math.random().toString(36).substr(2, 9);
}



function addValue() {
    var uniqueId = generateUniqueId();


    html = ` 
            <tr id="adetRow${uniqueId}">

          
            <td class="text-left">
            <select name="urun[${uniqueId}]" class="form-control border-danger" required>
            <option value="">Seçiniz</option>
            <?php
            $veriCek = $conn->prepare("SELECT * FROM stok_urunler ORDER BY stok_adi ASC");
            $veriCek->execute();
            while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
            <option value="<?= $row['stok_id']; ?>"><?= $row['stok_adi']; ?></option>
            <?php } ?>
            </select>
            </td>

            <td class="text-left">

            <input type="number" min="0" name="adet[${uniqueId}]"
            placeholder="Adet" value="0" class="form-control border-danger" required />
            </td>

            <td class="text-left">
            <input type="number" min="0" name="alis_tutar[${uniqueId}]"
            placeholder="Alış Tutarı" value="0" class="form-control border-danger" required />
            </td>

            <td class="text-left">
            <select name="hareket_tipi[${uniqueId}]" class="form-control border-danger" required>
            <option value="1" selected>Giriş</option>
            <option value="0">Çıkış</option>

            </select>
            </td>



            <td class="text-right"><button type="button" onclick="$('#adetRow${uniqueId}').remove();"
            data-toggle="tooltip" title="Kaldır" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
            </td>';
            </tr>
            `;

    $('#fiyatlandirmaTable tbody').append(html);

}
</script>