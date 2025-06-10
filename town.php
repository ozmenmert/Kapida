<?php

include('../ayar.php');

if (isset($_POST['city_code']) and $_POST['city_code'] != '') {
    $il_id = $_POST['city_code'];
    $veriCek = $conn->prepare("SELECT * FROM ilceler WHERE il_id = $il_id ORDER BY ilce_adi ASC");
    $veriCek->execute();
    echo '<option value="">İlçe Seçiniz</option>';
    while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $var['id'] . '">' . $var['ilce_adi'] . '</option>';
    }
}
