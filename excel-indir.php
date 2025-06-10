<?php
if (isset($_GET['dosya_adi']) && $_GET['dosya_adi'] != '') {
    $dosya_adi = $_GET['dosya_adi'];
    $dosya_yolu = __DIR__ . '/excel/' . $dosya_adi;

    if (file_exists($dosya_yolu)) {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $dosya_adi . '"');
        header('Cache-Control: max-age=0');
        readfile($dosya_yolu);
        exit;
    } else {
        echo 'Dosya bulunamadı: ' . $dosya_adi;
    }
}
