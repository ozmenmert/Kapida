<?php
include 'ayar.php';
$sayfa_hizmet_id = 5;
redirectToUnauthorized($sayfa_hizmet_id, 'ekle');
$pageName = 'Reklam Maliyet Ekle';
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
                            <a class="btn btn-primary" href="reklam-maliyet-listesi"><i class="fa fa-list me-2"
                                    aria-hidden="true"></i> Reklam Maliyet Listesi</a>
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
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="info">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Ürün Seçimi</label>
                                                                        <select
                                                                            class="form-control select2 border-danger"
                                                                            name="urun_id" required id="urun_id">
                                                                            <option value="">Seçiniz</option>
                                                                            <?php
                                                                            $veriCek = $conn->prepare("SELECT * FROM urunler ORDER BY urun_adi ASC");
                                                                            $veriCek->execute();
                                                                            while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                                                            <option value="<?= $row['urun_id']; ?>"
                                                                                data-domain="<?= $row['urun_subdomain']; ?>">
                                                                                <?= $row['urun_adi']; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Domain</label>
                                                                        <input type="text" name="domain" id="domain"
                                                                            class="form-control border-danger"
                                                                            placeholder="Domain" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label>Meta</label>
                                                                        <input type="number" name="meta"
                                                                            class="form-control border-danger"
                                                                            placeholder="Meta" value="0">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label>Tiktok</label>
                                                                        <input type="number" name="tiktok"
                                                                            class="form-control border-danger"
                                                                            placeholder="Tiktok" value="0">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label>Google</label>
                                                                        <input type="number" name="google"
                                                                            class="form-control border-danger"
                                                                            placeholder="Google" value="0">
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label>Twitter</label>
                                                                        <input type="number" name="twitter"
                                                                            class="form-control border-danger"
                                                                            placeholder="Twitter" value="0">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label>Manuel Ekleme</label>
                                                                        <input type="number" name="manuel_1"
                                                                            class="form-control border-danger"
                                                                            placeholder="Manuel Ekleme" value="0">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label>Manuel Ekleme 2</label>
                                                                        <input type="number" name="manuel_2"
                                                                            class="form-control border-danger"
                                                                            placeholder="Manuel Ekleme 2" value="0">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label>Not</label>
                                                                        <input type="text" name="not"
                                                                            class="form-control border-danger"
                                                                            placeholder="Not">
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
                                        <button type="submit" name="reklamMaliyetEkle"
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
$(document).ready(function() {
    $('#urun_id').change(function() {
        var selectedOption = $(this).find('option:selected');
        var domainValue = selectedOption.data('domain');

        if (domainValue) {
            $('#domain').val(domainValue);
        } else {
            $('#domain').val('');
        }
    });
});
</script>