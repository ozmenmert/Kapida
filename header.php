<?php
@ob_start();
@session_start();
if (!isset($_SESSION["giris"])) {
    header('location:giris');
    exit;
} else {
    //include '../ayar.php'; //Buna göre yok zaten mevcut
    $kul_id = $_SESSION['kul_id'];
    $userData = $conn->query("SELECT * FROM kullanicilar WHERE kul_id = $kul_id ")->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>
        <?= $meta['title'] ?>
    </title>
    <meta name="title" content="<?= $meta['title'] ?>">
    <meta name="description" content="<?= $meta['description'] ?>">
    <meta name="keywords" content="<?= $meta['keywords'] ?>">
    <meta name="robots" content="noindex, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="Turkish">
    <meta name="revisit-after" content="1 days">
    <meta name="author" content="<?= $meta['author'] ?>">
    <meta property="og:title" content="<?= $meta['title'] ?>" />
    <meta property="og:description" content="<?= $meta['description'] ?>" />
    <meta property="og:image" content="<?php echo $siteData['ayar_icon']; ?>" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="../<?= $siteData['ayar_icon'] ?>" type="image/x-icon" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="assets/plugins/feather/feather.css">

    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="custom.css">
    <style>
        html {
            zoom: .9;
        }

        .modal-backdrop {
            width: 100%;
            height: 100%;
        }

        :root {
            --anaRenk:
                #083355;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <div class="header header-one">
            <a href="javascript:void(0);" id="toggle_btn">
                <span class="toggle-bars">
                    <span class="bar-icons"></span>
                    <span class="bar-icons"></span>
                    <span class="bar-icons"></span>
                    <span class="bar-icons"></span>
                </span>
            </a>
            <a class="mobile_btn" id="mobile_btn">
                <i class="fas fa-bars"></i>
            </a>
            <ul class="nav nav-tabs user-menu">
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="user-link  nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">
                            <img src="../<?= $siteData['ayar_logo'] ?>" alt="img" class="profilesidebar">
                            <span class="animate-circle"></span>
                        </span>
                        <span class="user-content">
                            <span class="user-details">
                                Yönetici
                            </span>
                            <span class="user-name">
                                <?= $userData['adi'] ?>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilemenu">
                            <div class="subscription-menu">
                                <ul>
                                    <li>
                                        <a class="dropdown-item" href="profil">Profil</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="subscription-logout">
                                <ul>
                                    <li class="pb-0">
                                        <a class="dropdown-item" href="cikis">Çıkış</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <a href="./">
                        <img style="height:45px;" src="../<?= $siteData['ayar_logo'] ?>" class="img-fluid logo" alt>
                    </a>
                    <a href="./">
                        <img src="../<?= $siteData['ayar_logo'] ?>" class="img-fluid logo-small" alt>
                    </a>
                </div>
            </div>
            <div class="sidebar-inner slimscroll">
                <div style="padding-bottom: 120px;" id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title"><span>Ana Menü</span></li>
                        <li>
                            <a href="./"><i class="fe fe-home"></i> <span> Yönetim</span></a>
                        </li>
                    </ul>
                    <ul>
                        <li class="menu-title"><span>Sipariş</span></li>

                        <!-- <li class="submenu">
                            <a href="#"><i class="fa-solid fa-cart-shopping"></i> <span> Siparişler</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <?php

                                $siparisDurumData = $conn->query("SELECT * FROM siparis_durumlari ORDER BY sira ")->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($siparisDurumData as $row) {
                                    $durum_id = $row['siparis_durum_id'];
                                    $durumAdet = $conn->query("SELECT COUNT(*) as toplam FROM siparisler WHERE siparis_durum = $durum_id")->fetch(PDO::FETCH_ASSOC);
                                ?>
                                    <li>
                                        <a href="siparisler?filtre=&siparis_durum=<?= $row['siparis_durum_id'] ?>">
                                            <span>
                                                <?= $row['siparis_durum_adi'] ?> (<?= $durumAdet['toplam'] ?>)
                                            </span>
                                        </a>
                                    </li>
                                <?php }

                                $siparisAdeti = $conn->query("SELECT COUNT(*) as adet FROM siparisler")->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <li>
                                    <a href="siparisler" class="fw-bolder">
                                        <span>
                                            Tümü (<?= $siparisAdeti['adet'] ?>)
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li> -->


                        <li class="submenu">
                            <a href="#" class="text-danger"><i class="fa-solid fa-cart-shopping"></i> <span class="text-danger"> Siparişler</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <?php

                                $siparisDurumData = $conn->query("SELECT * FROM siparis_durumlari ORDER BY sira ")->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($siparisDurumData as $row) {
                                    $durum_id = $row['siparis_durum_id'];
                                    $durumAdet = $conn->query("SELECT COUNT(*) as toplam FROM a_siparisler WHERE siparis_durum = $durum_id")->fetch(PDO::FETCH_ASSOC);
                                ?>
                                    <li>
                                        <a href="siparis-listesi?filtre=&siparis_durum=<?= $row['siparis_durum_id'] ?>" class="text-danger">
                                            <span>
                                                <?= $row['siparis_durum_adi'] ?> (<?= $durumAdet['toplam'] ?>)
                                            </span>
                                        </a>
                                    </li>
                                <?php }

                                $siparisAdeti = $conn->query("SELECT COUNT(*) as adet FROM a_siparisler")->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <li>
                                    <a href="siparis-listesi" class="fw-bolder text-danger">
                                        <span>
                                            Tümü (<?= $siparisAdeti['adet'] ?>)
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li>
                            <a href="rapor"><i class="fa-solid fa-chart-simple"></i> <span>Rapor</span></a>
                        </li>
                    </ul>


                    <ul>
                        <li class="menu-title"><span>Genel Yönetim</span></li>
                        <!-- <li>
                            <a href="urun-listesi"><i class="fa-solid fa-list"></i> <span>Ürün Listesi</span></a>
                        </li> -->

                        <li>
                            <a href="urunler"><i class="fa-solid fa-list text-danger"></i> <span class="text-danger">Ürünler</span></a>
                        </li>

                        <li>
                            <a href="promosyon-listesi"><i class="fa-solid fa-list text-danger"></i> <span class="text-danger">Promosyonlar</span></a>
                        </li>

                        <li>
                            <a href="stok-listesi"><i class="fa-solid fa-list"></i> <span>Stok Listesi</span></a>
                        </li>

                        <li>
                            <a href="reklam-maliyet-listesi"><i class="fa-solid fa-cart-plus"></i> <span>Reklam Maliyeti
                                    Listesi</span></a>
                        </li>
                        <li>
                            <a href="kar-hesaplama"><i class="fa-solid fa-chart-pie"></i> <span>Kar
                                    Hesaplama</span></a>
                        </li>

                        <li>
                            <a href="icerik-listesi"><i class="fa-solid fa-list-ol"></i> <span>Metin
                                    İçerikleri</span></a>
                        </li>

                        <li>
                            <a href="kargolar"><i class="fa-solid fa-car"></i> <span>Kargo Firmaları</span></a>
                        </li>

                        <li>
                            <a href="durum-listesi"><i class="fa-solid fa-filter"></i> <span>Sipariş
                                    Durumları</span></a>
                        </li>
                        <li>
                            <a href="sss-listesi"><i class="fa-solid fa-question-circle"></i> <span> SSS</span></a>
                        </li>
                    </ul>


                    <ul>
                        <li class="menu-title"><span>Sistem</span></li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-users"></i> <span> Kullanıcı Yönetimi</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="kullanici-ekle">Kullanıcı Ekle</a></li>
                                <li><a href="kullanici-listesi">Kullanıcı Listesi</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="profil"><i class="fe fe-user"></i> <span>Profil</span></a>
                        </li>
                        <li>
                            <a href="genel-ayarlar"><i class="fe fe-settings"></i> <span>Genel Ayarlar</span></a>
                        </li>
                        <li>
                            <a href="cikis"><i class="fe fe-power"></i> <span>Çıkış</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>