<?php
include 'ayar.php';

$sayfa_hizmet_id = 1;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

function sqlSorgusuOlustur($gelenDurum, $gelenBaslangic, $gelenBitis, $gelenMusteriAdi, $gelenMusteriTelefon)
{
    $sorgu = "SELECT * FROM siparisler,siparis_durumlari 
    WHERE 
    siparisler.siparis_durum = siparis_durumlari.siparis_durum_id";
    if (isset($gelenDurum) and $gelenDurum != '') {
        $sorgu .= " AND siparisler.siparis_durum = " . $gelenDurum;
    }
    if (!empty($gelenBaslangic)) {
        $sorgu .= " AND DATE(siparisler.siparis_tarih) >= '" . $gelenBaslangic . "'";
    }
    if (!empty($gelenBitis)) {
        $sorgu .= " AND DATE(siparisler.siparis_tarih) <= '" . $gelenBitis . "'";
    }
    if (!empty($gelenMusteriAdi)) {
        $sorgu .= " AND siparisler.siparis_musteri LIKE '%" . $gelenMusteriAdi . "%'";
    }
    if (!empty($gelenMusteriTelefon)) {
        $sorgu .= " AND siparisler.siparis_telefon LIKE '%" . $gelenMusteriTelefon . "%'";
    }
    return $sorgu;
}


if (isset($_GET['filtre'])) {

    if (isset($_GET['tarihSecimi']) and $_GET['tarihSecimi'] != '') {
        $tarihSecimi = $_GET['tarihSecimi'];
        $tarihler = explode(' - ', $tarihSecimi);
        $baslangic = $tarihler[0];
        $bitis = $tarihler[1];

        $gelenBaslangic = date("Y-m-d", strtotime(str_replace(".", "-", $baslangic)));
        $gelenBitis = date("Y-m-d", strtotime(str_replace(".", "-", $bitis)));
    } else {
        $gelenBaslangic = '';
        $gelenBitis = '';
    }



    $gelenDurum = isset($_GET["siparis_durum"]) ? $_GET["siparis_durum"] : '';
    $gelenMusteriAdi = isset($_GET["musteri"]) ? $_GET["musteri"] : '';
    $gelenMusteriTelefon = isset($_GET["telefon"]) ? $_GET["telefon"] : '';
    $sorgu = sqlSorgusuOlustur($gelenDurum, $gelenBaslangic, $gelenBitis, $gelenMusteriAdi, $gelenMusteriTelefon);
    $sorgu .= " ORDER BY siparisler.siparis_tarih DESC";
} else {
    $gelenDurum = '';
    $sorgu = "SELECT * FROM siparisler,siparis_durumlari WHERE
    siparisler.siparis_durum = siparis_durumlari.siparis_durum_id ORDER BY siparisler.siparis_tarih DESC LIMIT 300";
}

if ($gelenDurum != '') {
    $data = $conn->query("SELECT * FROM siparis_durumlari WHERE siparis_durum_id =" . $gelenDurum)->fetch(PDO::FETCH_ASSOC);
}

$pageName = $data['siparis_durum_adi'] ?? 'Tüm Siparişler';

$meta = array(
    'title' => $pageName . $separator . $siteData['title'],
    'description' => $siteData['description'],
    'keywords' => $siteData['keywords'],
    'author' => $siteData['author']
);


include 'header.php';
?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    tr,
    td,
    th {
        font-size: 1rem;
    }
</style>


<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="content-page-header d-flex justify-content-between">
                <h5>
                    <?= $pageName ?>
                </h5>
                <a href="siparis-ekle" class="btn btn-primary"><i class="fas fa-plus"></i> Sipariş Ekle</a>

            </div>
        </div>


        <div class="card">
            <form method="GET">
                <div class="row p-3">
                    <div class="col-md-12">
                        <h4 class="mb-3">Filtrele</h4>
                    </div>
                    <div class="col-md-10 col-9 mb-2">
                        <input type="text" name="tarihSecimi" id="reportrange" class="form-control">
                    </div>
                    <div class="col-md-2 col-3 mb-2">
                        <a href="javascript:void(0)" class="btn btn-sm btn-warning tumTarihBtn px-1 w-100">Tüm Tarih</a>
                    </div>
                    <div class="col-md-4">
                        <label for="siparis_durum">Durum</label>
                        <select name="siparis_durum" id="siparis_durum" class="form-control">
                            <option value="">Seçiniz</option>
                            <?php
                            $veriCek = $conn->prepare("SELECT * FROM siparis_durumlari ORDER BY siparis_durum_id");
                            $veriCek->execute();
                            while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                <option <?= (isset($gelenDurum) and $gelenDurum == $row['siparis_durum_id']) ? 'selected' : ''; ?> value="<?= $row['siparis_durum_id']; ?>"><?= $row['siparis_durum_adi']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="musteri">Müşteri</label>
                        <input type="text" name="musteri" class="form-control <?= (isset($gelenMusteriAdi) && ($gelenMusteriAdi != '' and $gelenMusteriAdi != ' ')) ? 'border border-danger' : ''; ?>" value="<?= (isset($gelenMusteriAdi)) ? $gelenMusteriAdi : ''; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="telefon">Telefon</label>
                        <input type="number" name="telefon" class="form-control <?= (isset($gelenMusteriTelefon) && ($gelenMusteriTelefon != '' and $gelenMusteriTelefon != ' ')) ? 'border border-danger' : ''; ?>" value="<?= (isset($gelenMusteriTelefon)) ? $gelenMusteriTelefon : ''; ?>">
                    </div>
                    <div class="col-md-12 mt-3 d-flex justify-content-between">
                        <button type="submit" name="filtre" class="btn btn-primary w-100 mx-1">Filtrele</button>
                        <a href="siparisler" class="btn btn-secondary mx-1">Temizle</a>
                    </div>

                </div>
            </form>
        </div>


        <div class="row">
            <div class="col-sm-12">


                <div class="card">
                    <div class="card-header d-flex flex-wrap justify-content-between">


                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="dropdown mx-1">
                                <span class="h6 mr-2 mb-1">Seçilen: <span class="bg-dark rounded px-1 py-1 text-white" id="secimAdeti">0</span></span>
                                <button class="btn btn-secondary dropdown-toggle mb-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Durum Belirle
                                </button>
                                <ul class="dropdown-menu">
                                    <?php
                                    $veriCek = $conn->prepare("SELECT * FROM siparis_durumlari ORDER BY siparis_durum_id");
                                    $veriCek->execute();
                                    while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <li><a class="dropdown-item durumBelirle" data-durum="<?= $row['siparis_durum_id']; ?>" href="javascript:void(0);"><?= $row['siparis_durum_adi']; ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-success btn-sm mx-1 mb-1 hepsiniExcel"><i class="fas fa-download"></i>
                                Excele
                            Dök</button>
                            <button type="button" class="btn btn-danger btn-sm mx-1 mb-1 hepsiniSil"><i class="fas fa-trash"></i>
                            Seçilenleri Sil</button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped ozelTablo">
                            <thead>
                                <tr>
                                    <th>
                                        <input class="form-check-input hepsiniSec" type="checkbox">
                                    </th>
                                    <th>Tarih</th>
                                    <th>İsim Soyisim</th>
                                    <th>Telefon</th>
                                    <th>Ürün</th>
                                    <th>Tutar</th>
                                    <th>Şehir</th>
                                    <th>Web Site</th>
                                    <th>Sipariş Durumu</th>
                                    <th>Detay</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ilDatas = $conn->query("SELECT * FROM iller")->fetchAll(PDO::FETCH_ASSOC);
								foreach ($ilDatas as $il) {
									$ilData[$il['id']] = $il['il_adi'];
								}

								$urunDatas = $conn->query("SELECT * FROM urunler")->fetchAll(PDO::FETCH_ASSOC);
								foreach ($urunDatas as $urun) {
									$urunData[$urun['urun_id']] = $urun['urun_adi'];
								}
                               
                                $mukerrerVeriCek = $conn->prepare("SELECT siparis_urun, siparis_telefon FROM siparisler");
                                $mukerrerVeriCek->execute();
                                $mukerrerRows = $mukerrerVeriCek->fetchAll(PDO::FETCH_ASSOC);
                                foreach($mukerrerRows as $m) {
									//@$mukerrerKontrol[$m['siparis_urun']][$m['siparis_musteri']][$m['siparis_telefon']] += 1;
									@$mukerrerKontrol[$m['siparis_urun']][$m['siparis_telefon']] += 1;
								}

                                $veriCek = $conn->prepare($sorgu);
                                $veriCek->execute();
                                $rows = $veriCek->fetchAll(PDO::FETCH_ASSOC);

                                //while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                foreach($rows as $row) {
                                    // $mukerrerKontrol = $conn->query("SELECT COUNT(*) as toplam FROM siparisler 
                                    //     WHERE siparis_telefon = '" . $row['siparis_telefon'] . "'
                                    //     ")->fetch(PDO::FETCH_ASSOC);
                                    // $adres_il = $row['siparis_il'];
                                    // $ilData = $conn->query("SELECT * FROM iller WHERE id = '$adres_il' ")->fetch(PDO::FETCH_ASSOC);
                                    // $urunData = $conn->query("SELECT * FROM urunler WHERE urun_id =" . $row['siparis_urun'])->fetch(PDO::FETCH_ASSOC);
                                        //$mukerrerSayisi = $mukerrerKontrol[$row['siparis_urun']][$row['siparis_musteri']][$row['siparis_telefon']];
                                        $mukerrerSayisi = $mukerrerKontrol[$row['siparis_urun']][$row['siparis_telefon']];
                                    ?>

                                    <tr>
                                        <td>
                                            <input class="form-check-input secimInput" type="checkbox" value="<?= $row['siparis_id'] ?>" name=" secimler">
                                        </td>
                                        <td>
                                            <?= tarihSaatFormatla($row['siparis_tarih']) ?>
                                        </td>
                                        <td class="<?= $mukerrerSayisi > 1 ? 'warning bg-warning' : '' ?>">
                                            <a href="siparis-detay?id=<?= $row['siparis_id'] ?>&filtre=<?= $gelenDurum ?>" class="text-primary">
                                                <?= $row['siparis_musteri']; ?>
                                                <span class="px-1 py-1 fs-bold">[<?= $mukerrerSayisi ?>]</span>
                                            </a>
                                        </td>
                                        <td>
                                            <?= $row['siparis_telefon'] ?> <a href=" https://wa.me/+<?= $row['siparis_telefon'] ?>" target="_blank" class="btn btn-sm"><i class="fa-brands fa-whatsapp text-success"></i></a>
                                        </td>
                                        <td>

                                            <?php
                                            if (isset($row['siparis_icerik']) and $row['siparis_icerik'] != '') {
                                                $temiz_veri = str_replace('"', '', $row['siparis_icerik']);
                                                $parcalanmis_veri = explode(",", $temiz_veri);
                                                $adet = isset($parcalanmis_veri[1]) ? $parcalanmis_veri[1] : '-';
                                                echo ($adet) ? $adet . ' Adet ' . $urunData[$row['siparis_urun']] : $urunData[$row['siparis_urun']];
                                            } else {
                                                echo $urunData[$row['siparis_urun']];
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?= ParaFormatla($row['siparis_tutar'] - $row['siparis_indirim']) ?> TL
                                        </td>

                                        <td>
                                            <?= $ilData[$row['siparis_il']] ?>
                                        </td>

                                        <td>
                                            <a href="https://<?= $row['siparis_domain'] ?>" target="_blank"><?= $row['siparis_domain'] ?></a>
                                        </td>

                                        <td>
                                            <?= $row['siparis_durum_adi'] ?> | <?= tarihSaatFormatla($row['durum_update']) ?>
                                        </td>

                                        <td class="align-middle">
                                            <a href="siparis-detay?id=<?= $row['siparis_id'] ?>&filtre=<?= $gelenDurum ?>" class="btn btn-success text-white btn-sm px-1 py-1 fs-7"><i class="fa fa-eye"></i>
                                            Detaylar</a>
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
<script type="text/javascript" src="assets/js//moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="sweetalert.min.js"></script>



<script>
    $(document).ready(function() {
        $(function() {
            function cb(start, end) {
                $("#reportrange span").html(
                    start.format("D MMMM, YYYY") + " - " + end.format("D MMMM, YYYY")
                    );
            }

            var tarihSecimi = getUrlParameter('tarihSecimi');

            if (tarihSecimi) {
                var tarihler = tarihSecimi.split(' - ');
                var startDate = moment(tarihler[0], 'DD.MM.YYYY');
                var endDate = moment(tarihler[1], 'DD.MM.YYYY');
            } else {
                var startDate = moment().subtract(29, "days");
                var endDate = moment();
            }

            $("#reportrange").daterangepicker({
                startDate: startDate,
                endDate: endDate,
                ranges: {
                    Bugün: [moment(), moment()],
                    Dün: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Son 7 Gün": [moment().subtract(6, "days"), moment()],
                    "Son 14 Gün": [moment().subtract(13, "days"), moment()],
                    "Son 30 Gün": [moment().subtract(29, "days"), moment()],
                    "Bu Ay": [moment().startOf("month"), moment().endOf("month")],
                    "Geçen Ay": [
                        moment().subtract(1, "month").startOf("month"),
                        moment().subtract(1, "month").endOf("month"),
                        ],
                },
                locale: {
                    customRangeLabel: "Özel Aralık",
                    format: "DD.MM.YYYY",
                    separator: " - ",
                    applyLabel: "Uygula",
                    cancelLabel: "İptal",
                    daysOfWeek: ["Pz", "Pt", "Sa", "Ça", "Pe", "Cu", "Ct"],
                    monthNames: [
                        "Ocak",
                        "Şubat",
                        "Mart",
                        "Nisan",
                        "Mayıs",
                        "Haziran",
                        "Temmuz",
                        "Ağustos",
                        "Eylül",
                        "Ekim",
                        "Kasım",
                        "Aralık",
                        ],
                    firstDay: 1,
                },
            },
            cb
            );
            cb(startDate, endDate);
        });

        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        };
    });


    var selected = {};

    function hesaplaSecimAdeti() {
        var sayi = Object.keys(selected).filter(function(key) {
            return selected[key] === true;
        }).length;

        $("#secimAdeti").text(sayi);
        console.log(selected);
    }

    $(document).ready(function() {

        $('.ozelTablo').on('draw', function() {
            $('input.secimInput:checkbox').each(function() {
                var checkbox = $(this);
                var id = checkbox.attr('id');
                checkbox.prop('checked', selected[id] === true);
            });

            // Checkboxları say ve göster
            hesaplaSecimAdeti();
        });

        $(document).on('click', '.hepsiniSec', function() {
            // Eğer checkbox seçili ise
            if ($(this).prop('checked')) {
                // Tabloda bulunan tüm checkbox'ları seç
                $('.ozelTablo input.secimInput:checkbox').prop('checked', true);
                // Seçili checkbox'ların değerlerini sakla
                $('.ozelTablo input.secimInput:checkbox').each(function() {
                    var id = $(this).val();
                    selected[id] = true;
                });
            } else {
                // Eğer checkbox seçili değilse, tüm checkbox'ları seçimi kaldır
                $('.ozelTablo input.secimInput:checkbox').prop('checked', false);
                // Seçili checkbox'ların değerlerini kaldır
                $('.ozelTablo input.secimInput:checkbox').each(function() {
                    var id = $(this).val();
                    selected[id] = false;
                });
            }
            // Seçim adedini hesapla ve göster
            hesaplaSecimAdeti();
        });

        $(document).on('change', 'input.secimInput:checkbox', function() {
            var checkbox = $(this);
            var id = checkbox.val();
            selected[id] = checkbox.prop('checked');
            hesaplaSecimAdeti();
        });

        $('.durumBelirle').on('click', function() {
            var selectedNumbers = Object.keys(selected).filter(function(key) {
                return selected[key] === true;
            }).map(Number);
            var selectedNumbersJson = JSON.stringify(selectedNumbers);

            swal({
                title: "Durum Belirleme",
                text: "İşlemi tamamlamak istediğinize emin misiniz?",
                icon: "info",
                buttons: ["Hayır", "Evet"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    var secilenDurum = $(this).data('durum');
                    if (selectedNumbersJson === '{}' || selectedNumbersJson === '[]') {
                        swal({
                            title: "Seçili sipariş bulunamadı",
                            icon: "error"
                        })
                            return; // İşlemi durdur
                        }
                        $.ajax({
                            url: 'ajax/toplu_islem.php', // Silme işlemini gerçekleştirecek olan scriptin yolunu belirt
                            type: 'POST',
                            data: {
                                islem: 'durum',
                                secilen: secilenDurum,
                                siparisler: selectedNumbersJson
                            }, // Silinecek siparişlerin JSON formatındaki verisi
                            success: function(response) {
                                if (response == 'ok') {
                                    swal({
                                        title: "İşlem Başarılı",
                                        icon: "success"
                                    }).then(function() {
                                        location.reload();
                                    });

                                } else if (response == 'izin') {
                                    swal({
                                        title: "Bu işlem için yetkiniz yok!",
                                        icon: "error"
                                    }).then(function() {
                                        location.reload();
                                    });

                                } else {
                                    swal({
                                        title: "İşlem Başarısız",
                                        icon: "error"
                                    }).then(function() {
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Siparişleri silerken bir hata oluştu: ' +
                                    error);
                            }
                        });
                    } else {
                        // Kullanıcı işlemi iptal ettiğinde gerekli işlemleri yapabilirsiniz
                        console.log('İşlem iptal edildi.');
                    }
                });

        });



        $('.hepsiniExcel').on('click', function() {
            var selectedNumbers = Object.keys(selected).filter(function(key) {
                return selected[key] === true;
            }).map(Number);
            var selectedNumbersJson = JSON.stringify(selectedNumbers);

            swal({
                title: "Kargo Şablonu İndir",
                text: "İşlemi tamamlamak istediğinize emin misiniz?",
                icon: "info",
                buttons: ["Hayır", "Evet"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    if (selectedNumbersJson === '{}' || selectedNumbersJson === '[]') {
                        swal({
                            title: "Seçili sipariş bulunamadı",
                            icon: "error"
                        })
                            return; // İşlemi durdur
                        }
                        $.ajax({
                            url: 'ajax/toplu_islem.php',
                            type: 'POST',
                            data: {
                                islem: 'excel',
                                siparisler: selectedNumbersJson
                            },
                            success: function(response) {
                                if (response == 'hata') {
                                    swal({
                                        title: "İşlem Başarısız",
                                        icon: "error"
                                    }).then(function() {
                                        location.reload();
                                    });
                                } else if (response == 'izin') {
                                    swal({
                                        title: "Bu işlem için yetkiniz yok!",
                                        icon: "error"
                                    }).then(function() {
                                        location.reload();
                                    });

                                } else {
                                    var dosya_adi = response;
                                    window.location.href = 'excel-indir.php?dosya_adi=' +
                                    dosya_adi;

                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Şablon oluşturulurken bir hata oluştu: ' +
                                    error);
                            }
                        });
                    } else {
                        // Kullanıcı işlemi iptal ettiğinde gerekli işlemleri yapabilirsiniz
                        console.log('İşlem iptal edildi.');
                    }
                });

        });


        $('.hepsiniSil').on('click', function() {
            var selectedNumbers = Object.keys(selected).filter(function(key) {
                return selected[key] === true;
            }).map(Number);
            var selectedNumbersJson = JSON.stringify(selectedNumbers);
            swal({
                title: "Toplu Silme",
                text: "İşlemi tamamlamak istediğinize emin misiniz?",
                icon: "info",
                buttons: ["Hayır", "Evet"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    if (selectedNumbersJson === '{}' || selectedNumbersJson === '[]') {
                        swal({
                            title: "Seçili sipariş bulunamadı",
                            icon: "error"
                        })
                            return; // İşlemi durdur
                        }
                        $.ajax({
                            url: 'ajax/toplu_islem.php', // Silme işlemini gerçekleştirecek olan scriptin yolunu belirt
                            type: 'POST',
                            data: {
                                islem: 'sil',
                                siparisler: selectedNumbersJson
                            }, // Silinecek siparişlerin JSON formatındaki verisi
                            success: function(response) {
                                if (response == 'ok') {
                                    swal({
                                        title: "İşlem Başarılı",
                                        icon: "success"
                                    }).then(function() {
                                        location.reload();
                                    });

                                } else if (response == 'izin') {
                                    swal({
                                        title: "Bu işlem için yetkiniz yok!",
                                        icon: "error"
                                    }).then(function() {
                                        location.reload();
                                    });

                                } else {
                                    swal({
                                        title: "İşlem Başarısız",
                                        icon: "error"
                                    }).then(function() {
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Siparişleri silerken bir hata oluştu: ' +
                                    error);
                            }
                        });
                    } else {
                        console.log('İşlem iptal edildi.');
                    }
                });
        });
        $('.tumTarihBtn').on('click', function() {
            var startDate = "01.01.1970";
            var today = new Date();
            var day = String(today.getDate()).padStart(2, '0');
            var month = String(today.getMonth() + 1).padStart(2, '0');
            var year = today.getFullYear();
            var endDate = day + '.' + month + '.' + year;
            $('#reportrange').val(startDate + ' - ' + endDate);
        });
    });
</script>