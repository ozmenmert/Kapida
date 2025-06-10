<?php
include('../ayar.php');

$varyantHTML = '';

if (isset($_POST['siparis_id']) and isset($_POST['adet'])) {

    $adet = $_POST['adet'];
    $urun_id = $_POST['urun_id'];
    $siparis_id = $_POST['siparis_id'];

    $siparisDetay = $conn->query("SELECT * FROM a_siparisler WHERE siparis_id = " . $siparis_id)->fetch(PDO::FETCH_ASSOC);

    if ($siparisDetay['siparis_varyant'] != '') {
        $veri = json_decode($siparisDetay['siparis_varyant'], true);
        sort($veri);
    } else {
        $veri = '';
    }

    $sayac = 0;
    
    // Gelen veriyi bir dizi olarak işleyelim
    $seciliVaryantlar = json_decode($siparisDetay['siparis_varyant'], true);

    $veriCek = $conn->prepare("SELECT * FROM a_urun_varyantlar WHERE urun_id = :urun_id ORDER BY varyant_adi");
    $veriCek->execute(array('urun_id' => $urun_id));

$varyantHTML = ''; // HTML değişkeni

$index = 0;

while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) {

    $varyantHTML .= "<div style='display: flex;flex-wrap:wrap; flex-direction: row;'>";
    
    for ($i = 1; $i <= $adet; $i++) {
        $varyantHTML .= '<div class="ozel-select" style="padding:5px;margin: 10px 0px;">';
        $varyantHTML .= '<div id="varyant-button" class="ozel-select-btn">';
        $varyantHTML .= "<h6 class='validate[required] line-one varyant '>{$var['varyant_adi']}</h6>";
        $varyantHTML .= "<select id='varyant' name='varyant[]' class='form-control varyant' required>";
        $varyantHTML .= "<option value=''>{$i}. {$var['varyant_adi']} Seçiniz</option>";

        // Varyant değerlerini virgülle ayrılmış olarak al ve bir diziye dönüştür
        $degerler = explode(",", $var['degerler']);

        // seciliVaryantlar dizisinden bu varyant için seçili değeri al
        $seciliDeger = $seciliVaryantlar[$index] ?? '';

        foreach ($degerler as $deger) {
            // Seçenek değeri olarak varyant adı ve değer birleştiriliyor
            $secenekDegeri = $var['varyant_adi'] . ':' . $deger;
            
            // Sadece ilgili seciliDeger ile eşleşen değeri selected yap
            $selected = ($secenekDegeri == $seciliDeger) ? 'selected' : '';
            
            $varyantHTML .= "<option value='{$secenekDegeri}' {$selected}>{$deger}</option>";
        }

        $varyantHTML .= "</select>";
        $varyantHTML .= "</div>";
        $varyantHTML .= "</div>";

        // Bir sonraki select için seciliVaryantlar dizisinde ilerleyelim
        $index++;
    }
    
    $varyantHTML .= "</div>";
}



} elseif (isset($_POST['siparis_ekle']) and isset($_POST['urun_id'])) {
    $varyantHTML .= "ekleme isteği geldi";
} else {
    $varyantHTML .= "veri getirilemedi!";
}
echo $varyantHTML;
