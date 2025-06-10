<?php
include 'ayar.php';




$id = $_GET['id'] ?? -1;
$siparisDetay = $conn->query("SELECT * FROM siparisler WHERE siparis_id = '$id' ")->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['odemeDurumGuncelle'])) {

    $siparis_id = $_POST['siparis_id'];

    $update_query = $conn->prepare("UPDATE siparisler SET
        odeme_durum = :odeme_durum
        where siparis_id = :siparis_id
        ");
    $update = $update_query->execute(array(
        "odeme_durum" => $_POST['odeme_durum'],
        "siparis_id" => $siparis_id
    ));

    if ($update) {
        header("Location: siparis-detay?id=$siparis_id&durum=basarili");
    } else {
        header("Location: siparis-detay?id=$siparis_id&durum=basarisiz");
    }
}



if (isset($_POST['durumGuncelle'])) {

    $tarih = date('Y-m-d H:i:s');

    $siparis_id = $_POST['siparis_id'];
    $siparis_durum = $_POST['siparis_durum'];

    if ($siparis_durum != 4) {
        $update_query = $conn->prepare("UPDATE siparisler SET
            siparis_durum = :siparis_durum,
            siparis_kargo = :siparis_kargo,
            durum_update = :durum_update
            where siparis_id=:siparis_id
            ");
        $update = $update_query->execute(array(
            "siparis_durum" => $siparis_durum,
            "siparis_kargo" => '',
            "durum_update" => $tarih,
            "siparis_id" => $siparis_id
        ));
    } else {
        $siparis_kargo = $_POST['siparis_kargo'];

        $update_query = $conn->prepare("UPDATE siparisler SET
            siparis_durum = :siparis_durum,
            siparis_kargo = :siparis_kargo,
            durum_update = :durum_update
            where siparis_id=:siparis_id
            ");
        $update = $update_query->execute(array(
            "siparis_durum" => $siparis_durum,
            "siparis_kargo" => $siparis_kargo,
            "durum_update" => $tarih,
            "siparis_id" => $siparis_id
        ));
    }

    if ($update) {
        header("Location: siparis-detay?id=$siparis_id&durum=basarili");
    } else {
        header("Location: siparis-detay?id=$siparis_id&durum=basarisiz");
    }
}

$pageName = '#' . $siparisDetay['siparis_no'] . $separator . ' Sipariş Detay';
$meta = array(
    'title' => $pageName . $separator . $siteData['title'],
    'description' => $siteData['description'],
    'keywords' => $siteData['keywords'],
    'author' => $siteData['author']
);

$siparis_id = $siparisDetay['siparis_id'];
$siparis_no = $siparisDetay['siparis_no'];

include 'header.php';
?>



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
                            <a class="btn btn-primary" href="siparisler"><i class="fa fa-list me-2" aria-hidden="true"></i>Sipariş Listesi</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>



        <div class="row">

            <div class="col-xl-12 col-md-12">
                <div class="card w-100 pt-0">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-12 order-md-2 order-sm-1">

                                <div class="d-flex flex-wrap justify-content-between align-items-start mb-5">
                                    <span class="fs-5 bg-light p-1 border rounded mb-3">#<?= $siparisDetay['siparis_no'] ?></span>
                                    <div class="d-flex flex-wrap justify-content-start align-items-start">


                                        <form method="POST">
                                            <input type="hidden" name="siparis_id" value="<?= $siparis_id; ?>">

                                            <div class="mb-3 m-1">
                                                <label>Sipariş Ödeme Durumu Güncelle</label>
                                                <select name="odeme_durum" class="form-control" required>
                                                    <option value="">Seçiniz</option>
                                                    <option <?= (0 == $siparisDetay['odeme_durum']) ? 'selected' : ''; ?> value="0">Ödenmedi</option>
                                                    <option <?= (1 == $siparisDetay['odeme_durum']) ? 'selected' : ''; ?> value="1">Ödendi</option>
                                                </select>
                                            </div>
                                            <div class="m-1">

                                                <button type="submit" name="odemeDurumGuncelle" class="btn btn-primary btn-block mt-1 w-100"> Güncelle</button>



                                            </div>
                                        </form>


                                        <form method="POST">
                                            <div class="mb-3 m-1">
                                                <label>Sipariş Durumu Güncelle</label>
                                                <select name="siparis_durum" class="form-control" required id="siparis_durum">
                                                    <option value="">Seçiniz</option>
                                                    <?php
                                                    $veriCek = $conn->prepare("SELECT * FROM siparis_durumlari ORDER BY siparis_durum_id ASC");
                                                    $veriCek->execute();
                                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <option <?= ($row['siparis_durum_id'] == $siparisDetay['siparis_durum']) ? 'selected' : ''; ?> value="<?= $row['siparis_durum_id'] ?>">
                                                            <?= $row['siparis_durum_adi'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="m-1">

                                                <div class="m-1  <?= ($siparisDetay['siparis_durum'] != 3) ? 'd-none' : ''; ?> " id="kargoDiv">
                                                    <label>Kargo Firması Seç</label>
                                                    <input type="hidden" name="siparis_id" value="<?= $siparis_id; ?>">
                                                    <select name="siparis_kargo" class="form-control mb-2" <?= ($siparisDetay['siparis_durum'] == 2) ? 'required' : ''; ?>>
                                                        <option value="">Seçiniz</option>
                                                        <?php
                                                        $veriCek = $conn->prepare("SELECT * FROM kargo_firmalar ORDER BY kargo_id ASC");
                                                        $veriCek->execute();
                                                        while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <option <?= ($row['kargo_id'] == $siparisDetay['siparis_kargo']) ? 'selected' : ''; ?> value="<?= $row['kargo_id'] ?>"><?= $row['kargo_adi'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <button type="submit" name="durumGuncelle" class="btn btn-primary btn-block mt-1 w-100"> Güncelle</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Tarih</th>
                                                <th scope="col">Alıcı</th>
                                                <th scope="col">Adres</th>
                                                <th scope="col">Tutar</th>
                                                <th scope="col">Sipariş Durumu</th>
                                                <th scope="col">Ödeme Durum</th>
                                                <th scope="col">Ödeme Şekli</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="align-middle">
                                                    <?= date('d.m.Y H:i', strtotime($siparisDetay['siparis_tarih'])) ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?= $siparisDetay['siparis_musteri'] ?> <br>
                                                    <a href="te:<?= $siparisDetay['siparis_telefon'] ?>"><?= $siparisDetay['siparis_telefon'] ?></a>
                                                </td>
                                                <td>
                                                    <?php
                                                    $ilData = $conn->query("SELECT * FROM iller WHERE id =" . $siparisDetay['siparis_il'])->fetch(PDO::FETCH_ASSOC);
                                                    $ilceData = $conn->query("SELECT * FROM ilceler WHERE id =" . $siparisDetay['siparis_ilce'])->fetch(PDO::FETCH_ASSOC);
                                                    echo $ilData['il_adi'] . '/' . $ilceData['ilce_adi'];
                                                    ?>
                                                    <br>
                                                    <?= $siparisDetay['siparis_adres'] ?>
                                                </td>
                                                <td class="align-middle"><?= $siparisDetay['siparis_tutar'] ?> ₺</td>
                                                <td class="align-middle">
                                                    <?= getDatas('siparis_durumlari', 'siparis_durum_id', $siparisDetay['siparis_durum'])['siparis_durum_adi'] ?>

                                                    <?php if (isset($siparisDetay['siparis_kargo'])) {
                                                        $kargoBilgi = getDatas('kargo_firmalar', 'kargo_id', $siparisDetay['siparis_kargo']);
                                                    ?>
                                                        <br>
                                                        <b><?= $kargoBilgi['kargo_adi'] ?></b>
                                                    <?php } ?>

                                                </td>
                                                <td class="align-middle">
                                                    <?= ($siparisDetay['odeme_durum'] == 0) ? 'Ödenmedi' : 'Ödendi'; ?>
                                                </td>
                                                <td class="align-middle"><?= $siparisDetay['siparis_odeme_tur'] ?></td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card mb-4 mt-2">
                                    <div class="card-header">
                                        <h4 class="mb-0">Sipariş İçeriği</h4>
                                    </div>
                                    <div class="card-body card-body table-responsive p-0">
                                        <table class="table table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Ürün</th>
                                                    <th scope="col">Adet</th>
                                                    <th scope="col">Varyasyon</th>
                                                    <th scope="col">Promosyon</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $urunBilgi = $conn->query("SELECT * FROM urunler WHERE urun_id =" . $siparisDetay['siparis_urun'])->fetch(PDO::FETCH_ASSOC);

                                                ?>
                                                <tr>
                                                    <th class="align-middle" scope="row">
                                                        <a href="<?= $urunBilgi['urun_subdomain'] ?>" target="_blank">
                                                            <img src="../<?= $urunBilgi['urun_img'] ?>" style="width: auto;height: 50px;">
                                                            <br>
                                                            <span><?= $urunBilgi['urun_adi'] ?></span>
                                                        </a>
                                                    </th>

                                                    <td class="align-middle">
                                                        <?php
                                                        $temiz_veri = str_replace('"', '', $siparisDetay['siparis_icerik']);
                                                        $parcalanmis_veri = explode(",", $temiz_veri);
                                                        $adet_id = $parcalanmis_veri[0];
                                                        $adet = $parcalanmis_veri[1];
                                                        $fiyat = $parcalanmis_veri[2];
                                                        $kargo = $parcalanmis_veri[3];
                                                        $kargo_durum = $parcalanmis_veri[4];
                                                        echo $adet . ' Adet => ' . $fiyat . ' TL <br>';
                                                        echo ($kargo_durum == 1) ? 'Kargo Ücretli => ' . $kargo . ' TL' : 'Kargo Ücretsiz';
                                                        ?>
                                                    </td>

                                                    <td class="align-middle">
                                                        <?php
                                                        if ($siparisDetay['siparis_varyant'] != '') {
                                                            $temiz_veri = str_replace(['[', ']', '"'], '', $siparisDetay['siparis_varyant']);
                                                            $parcalanmis_veri = explode(",", $temiz_veri);

                                                            $varyantlar = [];
                                                            foreach ($parcalanmis_veri as $parca) {
                                                                $parca_parcalari = explode(":", $parca);
                                                                $anahtar = $parca_parcalari[0];
                                                                $deger = $parca_parcalari[1];
                                                                $varyantlar[$anahtar][] = $deger;
                                                            }

                                                            foreach ($varyantlar as $anahtar => $degerler) {
                                                                echo ucfirst($anahtar) . ":<br>";
                                                                foreach ($degerler as $index => $deger) {
                                                                    echo ($index + 1) . ". => $deger <br>";
                                                                }
                                                                echo "<br>";
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="align-middle">
                                                        <?php
                                                        if ($siparisDetay['siparis_promosyon'] != '') {

                                                            $temiz_veri = str_replace(['[', ']', '"'], '', $siparisDetay['siparis_promosyon']);
                                                            $parcalanmis_veri = explode(",", $temiz_veri);
                                                            foreach ($parcalanmis_veri as $promosyon) {
                                                                $promosyon_parcalari = explode(":", $promosyon);

                                                                $promosyon_id = $promosyon_parcalari[0];
                                                                $ucret = $promosyon_parcalari[1];
                                                                $promosyonData = $conn->query("SELECT * FROM promosyon_urunler WHERE promosyon_id = $promosyon_id")->fetch(PDO::FETCH_ASSOC);
                                                                $promosyon_adi = $promosyonData['promosyon_adi'];
                                                                echo "$promosyon_adi => $ucret TL <br>";
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>
                                    </div>

                                </div>

                                <div class="card">
                                    <h3>Sipariş Notu</h3>
                                    <div class="bg-light border px-3 py-4">
                                        <?= $siparisDetay['siparis_not'] ?>
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
</div>
</div>
<?php include 'footer.php'; ?>

<script>
    $(document).ready(function() {
        $("#siparis_durum").change(function() {
            var siparis_durum = $(this).val();
            if (siparis_durum === "4") {
                $("#kargoDiv input, #kargoDiv select").prop("required", true);
                $("#kargoDiv").fadeIn().removeClass("d-none");

            } else {
                $("#kargoDiv input, #kargoDiv select").prop("required", false);
                $("#kargoDiv").fadeOut().addClass("d-none");
            }
        });
    });
</script>