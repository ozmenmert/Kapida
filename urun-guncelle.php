<?php
include 'ayar.php';

$id = $_GET['id'] ?? -1;
$data = $conn->query("SELECT * FROM a_urunler WHERE urun_id = '$id' ")->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    header('Location: urunler?durum=gecersizIslem');
    die();
}

$pageName = $data['urun_adi'] . " | " . "Ürün Güncelle";
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

<div class="page-wrapper">
    <div class="content container-fluid">
        <?php include '../share/urun-guncelle-page-header.php'; ?>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card w-100 p-0">
                    <div class="card-body tabMain p-0">

                        <form action="islemler.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="tab-pane active show" id="info">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Ürün Bilgisi</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Ürün Ana Görseli</label>
                                                                    <div class="form-group service-upload logo-upload mb-0">
                                                                        <span><img src="assets/img/icons/img-drop.svg" alt="upload"></span>
                                                                        <div class="drag-drop">
                                                                            <h6 class="drop-browse align-center">
                                                                                <span class="text-info me-1">Tıkla
                                                                                    Değiştir </span> veya Sürükle
                                                                                Bırak
                                                                            </h6>
                                                                            <p class="text-muted">SVG, PNG, JPG
                                                                                (512*512px)</p>
                                                                            <input type="file" name="urun_img" id="image_sign">
                                                                            <div id="frames">
                                                                                <img src="../<?= $data['urun_img'] ?>" alt="urun_img" class="img-fluid">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Ürün Adı</label>
                                                                    <input type="text" name="urun_adi" value="<?= $data['urun_adi'] ?>" class="form-control border-danger" placeholder="Ürün Adı" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label>Ürün Kısa Adı</label>
                                                                    <input type="text" name="urun_kisa_adi" value="<?= $data['urun_kisa_adi'] ?>" class="form-control border-danger" placeholder="Ürün Kısa Adı">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label>Ürün Fiyatı</label>
                                                                    <input type="number" step="any" name="urun_fiyat" value="<?= $data['urun_fiyat'] ?>" class="form-control border-danger" placeholder="Ürün Fiyatı" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label>Stok Kodu</label>
                                                                    <input type="text" name="urun_stok_kodu" value="<?= $data['urun_stok_kodu'] ?>" class="form-control border-danger" placeholder="Stok Kodu" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label>Stok Adet</label>
                                                                    <input type="number" name="urun_stok" value="<?= $data['urun_stok'] ?>" class="form-control border-danger" placeholder="Stok Adet" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label>Alış Fiyatı</label>
                                                                    <input type="number" step="any" name="urun_maliyet" value="<?= $data['urun_maliyet'] ?>" class="form-control" placeholder="Alış Fiyatı">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label>İade Oranı</label>
                                                                    <input type="number" step="any" name="urun_iade_orani" value="<?= $data['urun_iade_orani'] ?>" class="form-control" placeholder="İade Oranı">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Ürün Bağlantı </label>
                                                                    <input type="text" name="urun_subdomain" value="<?= $data['urun_subdomain'] ?>" class="form-control" placeholder="Ürün Bağlantı">
                                                                    <sub>Ürün listesinde tıklandığında
                                                                        yönlendirilecek subdomain</sub>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Whatsapp No (Boş bırakılırsa buton
                                                                        gözükmez)</label>
                                                                    <input type="text" name="urun_whatsapp" value="<?= $data['urun_whatsapp'] ?>" class="form-control" placeholder="Whatsapp No">
                                                                </div>
                                                            </div>


                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Ürün Video Linki </label>
                                                                    <input type="text" name="urun_video" value="<?= $data['urun_video'] ?>" class="form-control" placeholder="Video  Bağlantısı">
                                                                </div>
                                                            </div>


                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Promosyon Video Linki </label>
                                                                    <input type="text" name="promosyon_video" value="<?= $data['promosyon_video'] ?>" class="form-control" placeholder="Video Bağlantısı">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Ürün Açıklaması</label>
                                                                    <textarea class="form-control " id="basic-example" rows="3"
                                                                        name="urun_aciklama"><?= $data['urun_aciklama'] ?></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Style Kodu</label>
                                                                    <textarea class="form-control" rows="2" name="urun_css" placeholder="Style kodu başlatmanıza gerek yoktur. Sadece kod içeriğini yapıştırın"><?= $data['urun_css'] ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>İndex Script Kodu</label>
                                                                    <textarea class="form-control" rows="15" name="urun_script" placeholder="Script kodu başlatmanız gerekir"><?= $data['urun_script'] ?></textarea>
                                                                    <sub>(Yaprak Sayfa anasayfasına eklenir - Script
                                                                        etiketi arasında
                                                                        olması gerekir.)</sub>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Teşekkür Script Kodu</label>
                                                                    <textarea class="form-control" rows="15" name="urun_tesekkur_script" placeholder="Script kodu başlatmanız gerekir"><?= $data['urun_tesekkur_script'] ?></textarea>
                                                                    <sub>(Yaprak Sayfa Teşekkür sayfasına eklenir -
                                                                        Script etiketi arasında
                                                                        olması gerekir.)</sub>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12 mt-3">
                                                                <div class="form-group">
                                                                    <label>Meta Başlık (Seo Link - Meta Açıklaması seo linke dönüştürülür)</label>
                                                                    <input type="text" name="urun_seo_title" value="<?= $data['urun_seo_title'] ?>" class="form-control" placeholder="Meta Başlığı" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Meta Açıklaması</label>
                                                                    <textarea name="urun_seo_desc" rows="3" class="form-control border-danger" required><?= $data['urun_seo_desc'] ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Meta Anahtar Kelimeler</label>
                                                                    <textarea name="urun_seo_keyw" rows="3" class="form-control border-danger" required><?= $data['urun_seo_keyw'] ?></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12">
                                                                <button type="submit" name="urunGuncelle" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form method="POST" action="islemler.php">
                            <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
                            <div class="row mb-5 mx-2">
                                <label>Yorum Sayısını Değiştir</label>
                                <div class="col-md-2">
                                    <input type="number" name="yorum_sayisi" class="form-control" value="<?php echo $data['yorum_sayisi']; ?>" placeholder="0">
                                </div>
                                <div class="col-md-10">
                                    <button type="submit" name="a_yorumSayisiDuzenle" class="btn btn-primary btn-block">
                                        <i class="fa-solid fa-floppy-disk"></i>&nbsp;Yorum Sayısı Kaydet
                                    </button>
                                    <button type="submit" name="a_yorumSayisiSil" class="btn btn-primary btn-block">
                                        <i class="fa-solid fa-trash"></i>&nbsp;Yorum Sayısı Kaldır
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

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
                    <input type="hidden" name="urun_id" value="<?= $data['urun_id'] ?>">
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

<?php include 'footer.php'; ?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.3.0/tinymce.min.js" integrity="sha512-RUZ2d69UiTI+LdjfDCxqJh5HfjmOcouct56utQNVRjr90Ea8uHQa+gCxvxDTC9fFvIGP+t4TDDJWNTRV48tBpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        tinymce.init({
            selector: 'textarea#basic-example',
            height: 350,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    });
</script> -->