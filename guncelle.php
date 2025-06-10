<?php
include('../ayar.php');

if (isset($_POST['siparis_id'])) {
    $siparis_id = $_POST['siparis_id'];
    $urun_id = $_POST['siparis_urun'];
    $siparis_indirim = $_POST['siparis_indirim'];

    $siparis_total = 0;
    $parcalar = explode(':', $_POST['adet']);
    $adetArray = [];
    foreach ($parcalar as $index => $deger) {
        $adetArray[] = "$deger";
    }

    $siparis_icerik = $adetArray;
    if (isset($_POST['adet'])) {
        $adetData = $conn->query("SELECT * FROM a_urun_fiyatlandirma WHERE urun_fiyatlandirma_id = " . $adetArray[0])->fetch(PDO::FETCH_ASSOC);
        $tutar = $adetData['fiyat'];
        $kargo_tutar = $adetData['kargo_tutar'];

        $siparis_total += $kargo_tutar + $tutar;
        $siparis_icerik = json_encode($siparis_icerik, JSON_UNESCAPED_UNICODE);
    }

    $siparis_varyant = '';
    if (isset($_POST['varyant'])) {
        $siparis_varyant = $_POST['varyant'];
        $siparis_varyant = json_encode($siparis_varyant, JSON_UNESCAPED_UNICODE);
    }
    $siparis_promosyon = '';
    if (isset($_POST['promosyon'])) {
        $siparis_promosyon = $_POST['promosyon'];
        foreach ($siparis_promosyon as $item) {
            $split = explode(':', $item);
            $anahtar = $split[0];
            $promosyonData = $conn->query("SELECT * FROM a_promosyonlar WHERE promosyon_id = $anahtar")->fetch(PDO::FETCH_ASSOC);
            $ucret = $promosyonData['promosyon_ucret'];

            $siparis_total += $ucret;
        }
        $siparis_promosyon = json_encode($siparis_promosyon, JSON_UNESCAPED_UNICODE);
    }
    $siparis_no = rand(10, 99) . time() . rand(10, 99);

    $query = $conn->prepare("UPDATE a_siparisler SET  
      siparis_urun = :siparis_urun,
      siparis_tutar = :siparis_tutar,
      siparis_indirim = :siparis_indirim,
      siparis_icerik = :siparis_icerik,
      siparis_varyant = :siparis_varyant,
      siparis_promosyon = :siparis_promosyon,
      siparis_musteri = :siparis_musteri,
      siparis_telefon = :siparis_telefon,
      siparis_adres = :siparis_adres,
      siparis_il = :siparis_il,
      siparis_ilce = :siparis_ilce,
      siparis_tarih = :siparis_tarih,
      siparis_durum = :siparis_durum,
      siparis_kargo = :siparis_kargo,
      siparis_not = :siparis_not,
      siparis_odeme_tur = :siparis_odeme_tur
      WHERE siparis_id = :siparis_id
      ");
    $update = $query->execute(array(
        "siparis_urun" => $urun_id,
        "siparis_tutar" => $siparis_total,
        "siparis_indirim" => $siparis_indirim,
        "siparis_icerik" => $siparis_icerik,
        "siparis_varyant" => $siparis_varyant,
        "siparis_promosyon" => $siparis_promosyon,
        "siparis_musteri" => $_POST['siparis_musteri'],
        "siparis_telefon" => $_POST['siparis_telefon'],
        "siparis_adres" => $_POST['siparis_adres'],
        "siparis_il" => $_POST['siparis_il'],
        "siparis_ilce" => $_POST['siparis_ilce'],
        "siparis_tarih" => $_POST['siparis_tarih'],
        "siparis_durum" => $_POST['siparis_durum'],
        "siparis_kargo" => $_POST['siparis_kargo'],
        "siparis_not" => $_POST['siparis_not'],
        "siparis_odeme_tur" => $_POST['siparis_odeme_tur'],
        "siparis_id" => $siparis_id
    ));

    (isset($_POST['onceki_url']) and $_POST['onceki_url'] != '') ? $filtre = $_POST['onceki_url'] : $filtre = '';
    if ($update) {
        header("location:siparis-listesi?filtre=&siparis_durum=$filtre&durum=basarili");
    } else {
        header("location:siparis-listesi?filtre=&siparis_durum=$filtre&durum=basarisiz");
    }
}
