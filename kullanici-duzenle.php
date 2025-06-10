<?php
include 'ayar.php';


$sayfa_hizmet_id = 10;
redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');


if (!isset($_GET['id'])) {
    header('location:index.php?durum=izinsizGiris');
}
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM kullanicilar WHERE kul_id = '$id' ")->fetch(PDO::FETCH_ASSOC);
$pageName = 'Kullanıcı Düzenle' . $separator . $data['adi'];
$meta = array(
    'title' => $pageName . $separator .  $siteData['title'],
    'description' => $siteData['description'],
    'keywords' => $siteData['keywords'],
    'author' => $siteData['author']
);
include 'header.php';
?>
<style>
.form-switch .form-check-input {
    width: 3.5rem;
    height: 20px;
}

.form-check-input {
    background-color: #b5b5b5;
}

.form-check-input:checked {
    background-color: #00e752;
    border-color: #00e752;
}
</style>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="content-page-header">
                <h5>Kullanıcı Düzenle <?= $separator . $data['adi'] ?></h5>
                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-primary" href="kullanici-listesi"><i class="fa fa-list me-2"
                                    aria-hidden="true"></i>Kullanıcı Listesi</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card w-100 pt-0">
                    <div class="card-body">
                        <form action="islemler.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="kul_id" value="<?= $data['kul_id'] ?>">
                            <input type="hidden" name="backUrl" value="kullanici-duzenle">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Kullanıcı Adı</label>
                                        <input type="text" name="adi" class="form-control" placeholder="Kullanıcı Adı"
                                            required value="<?= $data['adi'] ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Şifre</label>
                                        <input type="password" name="sifre" class="form-control" placeholder="Şifre"
                                            required value="<?= $data['sifre'] ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>E-Mail</label>
                                        <input type="email" name="email" class="form-control" placeholder="E-Mail"
                                            required value="<?= $data['email'] ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Telefon</label>
                                        <input type="text" name="tel" class="form-control phoneMask"
                                            placeholder="Telefon" required value="<?= $data['tel'] ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <div class="btn-path">
                                        <button type="submit" name="kullaniciDuzenle"
                                            class="btn btn-primary btn-block w-100 btn-lg"><i
                                                class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="content" class="main-content">
                            <div class="layout-px-spacing">
                                <div class="account-settings-container layout-top-spacing">
                                    <div class="account-content">
                                        <div class="row mb-3">
                                            <div class="col-md-8">
                                                <h2><?= $data['adi'] ?> İşlem İzinleri</h2>
                                            </div>
                                        </div>
                                        <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
                                            <div class="statbox widget box box-shadow">
                                                <div class="widget-content widget-content-area">
                                                    <div class="table-responsive">
                                                        <table id="izinler" class="table table-hover table-bordered"
                                                            style="width:100%">
                                                            <thead class="bg-dark ">
                                                                <tr>
                                                                    <th class="align-middle text-white" width="10%">#
                                                                    </th>
                                                                    <th class="align-middle text-white" width="30%">
                                                                        İşlem
                                                                        Türü</th>
                                                                    <th class="align-middle text-white" width="15%">
                                                                        Listeleme</th>
                                                                    <th class="align-middle text-white" width="15%">Ekle
                                                                    </th>
                                                                    <th class="align-middle text-white" width="15%">
                                                                        Düzenle</th>
                                                                    <th class="align-middle text-white" width="15%">Sil
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $veriCek = $conn->prepare("SELECT * FROM hizmetler ");
                                                                $veriCek->execute();
                                                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                                                    $islem_hizmet_id = $row['hizmet_id'];
                                                                    $izinData = $conn->query("SELECT * FROM islem_izinleri WHERE
                                                                     islem_hizmet_id = $islem_hizmet_id AND
                                                                     islem_yonetici_id = $id
                                                                     ")->fetch(PDO::FETCH_ASSOC);
                                                                ?>
                                                                <tr>
                                                                    <td class="align-middle">
                                                                        <?= $row['hizmet_id'] ?></td>
                                                                    <td class="align-middle"><b
                                                                            class="font-weight-bolder"><?= $row['hizmet_adi'] ?></b>
                                                                    </td>
                                                                    <td class="align-middle" class="text-center">



                                                                        <div class="form-check form-switch">
                                                                            <input type="checkbox"
                                                                                data-hizmet_id="<?= $row['hizmet_id'] ?>"
                                                                                data-yonetici_id="<?= $id ?>"
                                                                                data-izin_tipi="islem_liste_izin"
                                                                                <?= ($izinData['islem_liste_izin'] == '1') ? 'checked' : ''; ?>
                                                                                class="form-check-input izinDegisInput"
                                                                                id="listele<?= $row['hizmet_id'] ?>">
                                                                            <label class="custom-control-label"
                                                                                for="listele<?= $row['hizmet_id'] ?>"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="align-middle" class="text-center">
                                                                        <div class="form-check form-switch">
                                                                            <input
                                                                                data-hizmet_id="<?= $row['hizmet_id'] ?>"
                                                                                data-yonetici_id="<?= $id ?>"
                                                                                data-izin_tipi="islem_ekle_izin"
                                                                                class="form-check-input izinDegisInput"
                                                                                id="ekle<?= $row['hizmet_id'] ?>"
                                                                                type="checkbox" role="switch"
                                                                                <?= ($izinData['islem_ekle_izin'] == '1') ? 'checked' : ''; ?>>
                                                                            <label class="custom-control-label ekle"
                                                                                for="ekle<?= $row['hizmet_id'] ?>"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="align-middle" class="text-center">
                                                                        <div class="form-check form-switch">
                                                                            <input
                                                                                data-hizmet_id="<?= $row['hizmet_id'] ?>"
                                                                                data-yonetici_id="<?= $id ?>"
                                                                                data-izin_tipi="islem_duzenle_izin"
                                                                                class="form-check-input izinDegisInput"
                                                                                id="duzenle<?= $row['hizmet_id'] ?>"
                                                                                type="checkbox" role="switch"
                                                                                <?= ($izinData['islem_duzenle_izin'] == '1') ? 'checked' : ''; ?>>
                                                                            <label class="custom-control-label"
                                                                                for="duzenle<?= $row['hizmet_id'] ?>"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="align-middle" class="text-center">
                                                                        <div class="form-check form-switch">
                                                                            <input
                                                                                data-hizmet_id="<?= $row['hizmet_id'] ?>"
                                                                                data-yonetici_id="<?= $id ?>"
                                                                                data-izin_tipi="islem_sil_izin"
                                                                                class="form-check-input izinDegisInput"
                                                                                id="sil<?= $row['hizmet_id'] ?>"
                                                                                type="checkbox" role="switch"
                                                                                <?= ($izinData['islem_sil_izin'] == '1') ? 'checked' : ''; ?>>
                                                                            <label class="custom-control-label"
                                                                                for="sil<?= $row['hizmet_id'] ?>"></label>
                                                                        </div>
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
                            </div>
                        </div>
                    </div>
                </div>
                <?php include 'footer.php'; ?>
                <script type="text/javascript">
                $(document).ready(function() {
                    $(document).on('change', '.izinDegisInput', function() {
                        var durum = $(this).is(':checked') ? 1 : 0;
                        var hizmet_id = $(this).data('hizmet_id');
                        var yonetici_id = $(this).data('yonetici_id');
                        var izin_tipi = $(this).data('izin_tipi');
                        $.ajax({
                            url: "ajax/ajax_izin_durum.php",
                            type: "POST",
                            data: {
                                durum: durum,
                                hizmet_id: hizmet_id,
                                yonetici_id: yonetici_id,
                                izin_tipi: izin_tipi
                            },
                            dataType: "json",
                            success: function(gelenData) {
                                if (gelenData.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'İzin Durumu Güncellendi.',
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        toast: true
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Hata!',
                                        text: gelenData.message,
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Hata!',
                                    text: 'Bir hata meydana geldi. Lütfen daha sonra tekrar deneyin.',
                                    icon: 'error'
                                });
                            }
                        });
                    });
                });
                </script>