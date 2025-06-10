<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3>
                <a href="urun-guncelle?id=<?= $_GET['id'] ?>"
                    title="Ürün Özellikleri">
                    <i class="fa fa-table"></i> Ürün Özellikleri</a>
            </h3>
        </div>
        <!-- <div class="col-md-2">
            <img src="<?= "../" . $product["urun_img"] ?>" class="card-img-top" alt="...">
        </div> -->
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Ürün Resmi:</th>
                    <td>
                        <div class="col-md-2">
                            <img src="<?= "../" . $product["urun_img"] ?>" class="card-img-top" alt="...">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Ürün Adı:</th>
                    <td><?= $product["urun_adi"] ?></td>
                </tr>
                <tr>
                    <th>Ürün Kısa Adı:</th>
                    <td><?= $product["urun_kisa_adi"] ?></td>
                </tr>
                <tr>
                    <th>Whatsapp:</th>
                    <td><?= $product["urun_whatsapp"] ?></td>
                </tr>
                <tr>
                    <th>Ürün Fiyatı:</th>
                    <td><?= $product["urun_fiyat"] ?></td>
                </tr>
                <tr>
                    <th>Ürün Seo Başlığı:</th>
                    <td><?= $product["urun_seo_title"] ?></td>
                </tr>
                <tr>
                    <th>Ürün Seo Tanımı:</th>
                    <td><?= $product["urun_seo_desc"] ?></td>
                </tr>
                <tr>
                    <th>Ürün Seo Keyword:</th>
                    <td><?= $product["urun_seo_keyw"] ?></td>
                </tr>
                <tr>
                    <th>Ürün Script:</th>
                    <td><?= $product["urun_script"] ?></td>
                </tr>
                <tr>
                    <th>Ürün Teşekkür Script:</th>
                    <td><?= $product["urun_tesekkur_script"] ?></td>
                </tr>
                <tr>
                    <th>Ürün CSS:</th>
                    <td><?= $product["urun_css"] ?></td>
                </tr>
                <tr>
                    <th>Ürün Subdomain:</th>
                    <td><?= $product["urun_subdomain"] ?></td>
                </tr>
                <tr>
                    <th>Ürün Stok:</th>
                    <td><?= $product["urun_stok"] ?></td>
                </tr>
                <tr>
                    <th>Ürün Stok Kodu:</th>
                    <td><?= $product["urun_stok_kodu"] ?></td>
                </tr>
                <tr>
                    <th>Ürün Maliyet:</th>
                    <td><?= ParaFormatla($product["urun_maliyet"]) ?></td>
                </tr>
                <tr>
                    <th>Ürün İade Oranı:</th>
                    <td><?= ParaFormatla($product["urun_iade_orani"]) ?></td>
                </tr>
                <tr>
                    <th>Vitrin Ürünü:</th>
                    <td><?= $product["urun_anasayfa"] == "1" ? "Evet" : "Hayır" ?></td>
                </tr>
                <tr>
                    <th>Ürün Video:</th>
                    <td><?= $product["urun_video"] ?></td>
                </tr>
                <tr>
                    <th>Promosyon Videosu:</th>
                    <td><?= $product["promosyon_video"] ?></td>
                </tr>
                <tr>
                    <th>Ürün Açıklaması:</th>
                    <td><?= $product["urun_aciklama"] ?></td>
                </tr>
                <tr>
                    <th>Yorum Sayısı:</th>
                    <td><?= $product["yorum_sayisi"] ?></td>
                </tr>

            </table>
        </div>
    </div>
</div>