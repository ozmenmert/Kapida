<?php


include 'giris-kontrol.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);


$sayfa_hizmet_id = 10;
redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $durum = $_POST['durum'];
    $hizmet_id = $_POST['hizmet_id'];
    $yonetici_id = $_POST['yonetici_id'];
    $izin_tipi = $_POST['izin_tipi'];

    $checkQuery = "SELECT COUNT(*) FROM islem_izinleri 
    WHERE islem_hizmet_id = :hizmet_id AND islem_yonetici_id = :yonetici_id";

    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindValue(':hizmet_id', $hizmet_id, PDO::PARAM_INT);
    $checkStmt->bindValue(':yonetici_id', $yonetici_id, PDO::PARAM_INT);
    $checkStmt->execute();

    $rowCount = $checkStmt->fetchColumn();


    try {
        if ($rowCount > 0) {

            $updateQuery = "UPDATE islem_izinleri
            SET $izin_tipi = :durum
            WHERE islem_hizmet_id = :hizmet_id AND islem_yonetici_id = :yonetici_id";

            $stmt = $conn->prepare($updateQuery);
            $stmt->bindValue(':durum', $durum, PDO::PARAM_INT);
            $stmt->bindValue(':hizmet_id', $hizmet_id, PDO::PARAM_INT);
            $stmt->bindValue(':yonetici_id', $yonetici_id, PDO::PARAM_INT);
            $stmt->execute();
        } else {

            $insertQuery = "INSERT INTO islem_izinleri (islem_hizmet_id, islem_yonetici_id, $izin_tipi)
            VALUES (:hizmet_id, :yonetici_id, :durum)";

            $stmt = $conn->prepare($insertQuery);
            $stmt->bindValue(':durum', $durum, PDO::PARAM_INT);
            $stmt->bindValue(':hizmet_id', $hizmet_id, PDO::PARAM_INT);
            $stmt->bindValue(':yonetici_id', $yonetici_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        $response = array('status' => 'success');
    } catch (PDOException $e) {
        $response = array('status' => 'error', 'message' => 'Veritaban覺 hatas覺: ' . $e->getMessage());
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
