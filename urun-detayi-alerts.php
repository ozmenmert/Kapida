<?php
$product = ($conn->query("SELECT * FROM a_urunler WHERE urun_id=" . $_GET['id'])->fetchAll(PDO::FETCH_ASSOC))[0];

$sql = "SELECT u_g.a_urunler_urungorselleri_id, g.urungorsel_id, g.img, u_g.sira FROM a_urungorselleri AS g
        LEFT OUTER JOIN a_urunler_urungorselleri AS u_g ON g.urungorsel_id = u_g.urungorsel_id
        LEFT OUTER JOIN urunler AS u ON u.urun_id = u_g.urun_id
        WHERE u.urun_id = " . $_GET['id'] . "
        ORDER BY u_g.sira;";
$productPictures = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM a_urun_fiyatlandirma WHERE urun_id = " . $_GET['id'] . " ORDER BY adet;";
$productCargoPrices = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM a_urun_varyantlar WHERE urun_id = " . $_GET['id'] . ";";
$productVaryants = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT p.promosyon_id, p.promosyon_adi, u.urun_id FROM a_promosyonlar AS p
        LEFT OUTER JOIN a_urunler_promosyonlar AS u_p ON u_p.promosyon_id = p.promosyon_id
        LEFT OUTER JOIN a_urunler AS u ON u.urun_id = u_p.urun_id
        WHERE u.urun_id = " . $_GET['id'] . ";";
$productPromos = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM a_yorumlar WHERE urun_id = " . $_GET['id'] . " ORDER BY sira;";
$productComments = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

if (count($productPictures) == 0) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Uyarı!</strong> Bu ürünün resimleri bulunmamaktadır.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}

if (count($productCargoPrices) == 0) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Uyarı!</strong> Bu ürünün ürün+kargo fiyatları bulunmamaktadır.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}

if (count($productVaryants) == 0) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Uyarı!</strong> Bu ürünün varyantı bulunmamaktadır.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}

if (count($productPromos) == 0) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Uyarı!</strong> Bu ürünün promosyonu bulunmamaktadır.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}

if (count($productComments) == 0) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Uyarı!</strong> Bu ürünün yorumu bulunmamaktadır.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}
