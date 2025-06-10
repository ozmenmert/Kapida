<?php
include('../ayar.php');

$adet = $_POST['adet'];
$urun_id = $_POST['urun_id'];
$veriCek = $conn->prepare("SELECT * FROM a_urun_varyantlar WHERE urun_id = :urun_id ORDER BY varyant_adi");
$veriCek->execute(array('urun_id' => $urun_id));

$varyantHTML = '';
while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) {
    $varyantHTML .= "<div style='display: flex;flex-wrap:wrap;
    flex-direction: row;'>";
    for ($i = 1; $i <= $adet; $i++) {
        $varyantHTML .= '<div class="ozel-select" style="padding:5px;margin: 10px 0px;">';
        $varyantHTML .= '<div id="varyant-button" class="ozel-select-btn">';
        $varyantHTML .= "<h6 class='validate[required] line-one varyant '>{$var['varyant_adi']}</h6>";
        $varyantHTML .= "<select id='varyant' name='varyant[]' class='form-control varyant' required>";
        $varyantHTML .= "<option value=''>{$i}. {$var['varyant_adi']} Seçiniz</option>";

        $degerler = explode(",", $var['degerler']);
        foreach ($degerler as $deger) {
            $varyantHTML .= "<option value='{$var['varyant_adi']}:{$deger}'>{$deger}</option>";
        }

        $varyantHTML .= "</select>";
        $varyantHTML .= "</div>";
        $varyantHTML .= "</div>";
    }
    $varyantHTML .= "</div>";
}
echo $varyantHTML;
