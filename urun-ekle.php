<?php
include 'ayar.php';
$pageName = 'Ürün Ekle';
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
function addValue() {
    var uniqueId = generateUniqueId();
    html = ` 
    <tr id="adetRow${uniqueId}">
    <td class="text-left">
    <input type="number" min="1" name="adet[${uniqueId}]" value=""
    placeholder="Adet" class="form-control border-danger" required />
    </td>
    <td class="text-left">
    <input type="number" min="0" name="onceki[${uniqueId}]" value=""
    placeholder="Önceki Fiyat" class="form-control border-danger" required />
    </td>
    <td class="text-left">
    <input type="number" min="0" name="fiyat[${uniqueId}]" value=""
    placeholder="Fiyat" class="form-control border-danger" required />
    </td>
    <td class="text-left">
    <input type="number" min="0" name="kargo_tutar[${uniqueId}]"
    placeholder="Kargo Tutarı" class="form-control border-danger" required />
    </td>
    <td class="text-left">
    <select name="kargo_durum[${uniqueId}]" class="form-control border-danger" required>
    <option value="0" selected>Kargo Ücretsiz</option>
    <option value="1">+Kargo</option>
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
                            <a class="btn btn-primary" href="urun-listesi"><i class="fa fa-list me-2" aria-hidden="true"></i>Ürün Listesi</a>
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
                                                <i class="fa fa-th "></i> İNFO
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#fiyatlandirma" data-bs-toggle="tab">
                                                <i class="fa-regular fa-check-circle "></i> Fiyatlandırma
                                            </a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" href="#seo" data-bs-toggle="tab"> <i class="fa-regular fa-message menu-icon"></i> Seo</a></li>
                                    </ul>
                                    <div class="tab-content">
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
                                                                                <input type="file" name="urun_img" id="image_sign" required>
                                                                                <div id="frames">
                                                                                    <img src="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="col-lg-9">
                                                                    <div class="form-group">
                                                                        <label>Ürün Adı</label>
                                                                        <input type="text" name="urun_adi" class="form-control border-danger" placeholder="Ürün Adı" required>
                                                                    </div>
                                                                </div> -->
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Ürün Adı</label>
                                                                        <input type="text" name="urun_adi" class="form-control border-danger" placeholder="Ürün Adı" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Ürün Kısa Adı</label>
                                                                        <input type="text" name="urun_kisa_adi" class="form-control border-danger" placeholder="Ürün Kısa Adı" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Ürün Fiyatı</label>
                                                                        <input type="number" step="any" name="urun_fiyat" class="form-control border-danger" placeholder="Ürün Fiyatı" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Stok Kodu</label>
                                                                        <input type="text" name="urun_stok_kodu" class="form-control border-danger" placeholder="Stok Kodu" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Stok Adet</label>
                                                                        <input type="number" name="urun_stok" class="form-control border-danger" placeholder="Stok Adet" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Alış Fiyatı</label>
                                                                        <input type="number" step="any" name="urun_maliyet" class="form-control" placeholder="Alış Fiyatı">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>İade Oranı</label>
                                                                        <input type="number" step="any" name="urun_iade_orani" class="form-control" placeholder="İade Oranı">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Ürün Bağlantı </label>
                                                                        <input type="text" name="urun_subdomain" class="form-control" placeholder="Ürün Bağlantı">
                                                                        <sub>Ürün listesinde tıklandığında
                                                                        yönlendirilecek subdomain</sub>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Whatsapp No (Boş bırakılırsa buton
                                                                        gözükmez)</label>
                                                                        <input type="text" name="urun_whatsapp" class="form-control" placeholder="Whatsapp No">
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Ürün Video Linki </label>
                                                                        <input type="text" name="urun_video" class="form-control" placeholder="Video  Bağlantısı">
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Promosyon Video Linki </label>
                                                                        <input type="text" name="promosyon_video" class="form-control" placeholder="Video Bağlantısı">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>Ürün Açıklaması</label>
                                                                        <textarea class="form-control " id="basic-example" rows="3"
                                                                        name="urun_aciklama"></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>Style Kodu</label>
                                                                        <textarea class="form-control" rows="2" name="urun_css" placeholder="Style kodu başlatmanıza gerek yoktur. Sadece kod içeriğini yapıştırın"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>İndex Script Kodu</label>
                                                                        <textarea class="form-control" rows="15" name="urun_script" placeholder="Script kodu başlatmanız gerekir"></textarea>
                                                                        <sub>(Yaprak Sayfa anasayfasına eklenir - Script
                                                                            etiketi arasında
                                                                        olması gerekir.)</sub>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Teşekkür Script Kodu</label>
                                                                        <textarea class="form-control" rows="15" name="urun_tesekkur_script" placeholder="Script kodu başlatmanız gerekir"></textarea>
                                                                        <sub>(Yaprak Sayfa Teşekkür sayfasına eklenir -
                                                                            Script etiketi arasında
                                                                        olması gerekir.)</sub>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="fiyatlandirma">
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
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="5"></td>
                                                                        <td class="text-right"><button type="button" onclick="addValue();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Ekle"><i class="fa fa-plus-circle"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="seo">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5>Seo Ayarları</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>Meta Başlık</label>
                                                                        <input type="text" name="urun_seo_title" class="form-control border-danger" placeholder="Meta Başlığı" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>Meta Açıklaması</label>
                                                                        <textarea name="urun_seo_desc" rows="3" class="form-control border-danger" required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>Meta Anahtar Kelimeler</label>
                                                                        <textarea name="urun_seo_keyw" rows="3" class="form-control border-danger" required></textarea>
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
                                        <button type="submit" name="urunEkle" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
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