<?php
if (!function_exists('generateToken')) {
    function generateToken()
    {
        return bin2hex(random_bytes(16));
    }
}

if (!function_exists('SiteUrl')) {
    function SiteUrl($page = '')
    {
        global $siteLink;
        return $siteLink . trim($page, '/');
    }
}

if (!function_exists('seo')) {
    function seo($s)
    {
        $tr = array('ş', 'Ş', 'ı', 'I', 'İ', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö', 'Ç', 'ç', '(', ')', '/', ' ', ',', '?');
        $eng = array('s', 's', 'i', 'i', 'i', 'g', 'g', 'u', 'u', 'o', 'o', 'c', 'c', '', '', '-', '-', '', '');
        $s = str_replace($tr, $eng, $s);
        $s = strtolower($s);
        $s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
        $s = preg_replace('/\s+/', '-', $s);
        $s = preg_replace('|-+|', '-', $s);
        $s = preg_replace('/#/', '', $s);
        $s = str_replace('\'', '-', $s);
        $s = str_replace('.', '', $s);
        $s = str_replace('!', '', $s);
        $s = str_replace('´', '', $s);
        $s = str_replace('’', '', $s);
        $s = str_replace('&', 've', $s);
        $s = trim($s, '-');
        return $s;
    }
}

if(!function_exists('SEOLink')){
    function SEOLink($baslik)
    {
        $metin_aranan = array("ş", "Ş", "ı", "ü", "Ü", "ö", "Ö", "ç", "Ç", "ş", "Ş", "ı", "ğ", "Ğ", "İ", "ö", "Ö", "Ç", "ç", "ü", "Ü");
        $metin_yerine_gelecek = array("s", "S", "i", "u", "U", "o", "O", "c", "C", "s", "S", "i", "g", "G", "I", "o", "O", "C", "c", "u", "U");
        $baslik = str_replace($metin_aranan, $metin_yerine_gelecek, $baslik);
        $baslik = preg_replace("@[^a-z0-9\-_şıüğçİŞĞÜÇ]+@i", "-", $baslik);
        $baslik = strtolower($baslik);
        $baslik = preg_replace('/&.+?;/', '', $baslik);
        $baslik = preg_replace('|-+|', '-', $baslik);
        $baslik = preg_replace('/#/', '', $baslik);
        $baslik = str_replace('.', '', $baslik);
        $baslik = trim($baslik, '-');
        return $baslik;
    }
}

if (!function_exists('securyText')) {
    function securyText($yazi)
    {
        $yazi = trim($yazi);
        $yazi = addslashes($yazi);
        $yazi = strip_tags($yazi);
        $yazi = filter_var($yazi, FILTER_SANITIZE_STRIPPED);
        return $yazi;
    }
}

if (!function_exists('kisalt')) {
    function kisalt($metin, $karakter_sayisi)
    {
        if (strlen($metin) > $karakter_sayisi) {
            return mb_substr($metin, 0, $karakter_sayisi, 'UTF-8') . '...';
        } else {
            return $metin;
        }
    }
}

if (!function_exists('tarihFormatla')) {
    function tarihFormatla($tarihsaat = null)
    {

        if ($tarihsaat == null) {
            return 'Tarih Bulunamadı.';
        }

        return date('d.m.Y', strtotime($tarihsaat));
    }
}

if (!function_exists('tarihSaatFormatla')) {
    function tarihSaatFormatla($tarihsaat = null)
    {

        if ($tarihsaat == null) {
            return 'Tarih Bulunamadı.';
        }

        return date('d.m.Y H:i', strtotime($tarihsaat));
    }
}

if (!function_exists('format_date')) {
    function format_date($timestamp)
    {

        $dayNamesTR = ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'];


        $now = new DateTime();
        $message_date = new DateTime($timestamp);
        $interval = $message_date->diff($now);

        if ($interval->days == 0) {
            return $message_date->format('H:i');
        } else if ($interval->days < 7) {
            $dayName = $dayNamesTR[$message_date->format('w')];
            return $dayName . ' ' . $message_date->format('H:i');
        } else {
            return $message_date->format('d.m.Y H:i');
        }
    }
}

if (!function_exists('kisaTarih')) {
    function kisaTarih($timestamp)
    {
        $now = new DateTime();
        $message_date = new DateTime($timestamp);
        $interval = $message_date->diff($now);
        return $message_date->format('H:i');
    }
}

if (!function_exists('telefonFormat')) {

    function telefonFormat($numara)
    {
        $sadeceRakam = preg_replace('/\D/', '', $numara);
        return $sadeceRakam;
    }
}

if (!function_exists('fisFiyatFormat')) {

    function fisFiyatFormat($veri)
    {
        return number_format($veri, 2, ',', '.');
    }
}

if (!function_exists('randomKartSonu')) {

    function randomKartSonu()
    {
        return str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('getCityFromIP')) {

    function getCityFromIP($ip = null)
    {
        $url = $ip ? "http://ip-api.com/json/{$ip}" : "http://ip-api.com/json/";
        $details = json_decode(file_get_contents($url));
        return isset($details->city) ? "Şehir: " . $details->city : "Şehir bilgisi bulunamadı.";
    }
}

if (!function_exists('ParaFormatla')) {
    function ParaFormatla($number)
    {
        return number_format($number, 2, ',', '.');
    }
}

if (!function_exists('countTable')) {
    function countTable($table, $step, $val)
    {
        global $conn;

        $data = $conn->query("SELECT COUNT(*) AS toplam FROM $table WHERE $step = $val")->fetch(PDO::FETCH_ASSOC);
        return $data['toplam'];
    }
}

if (!function_exists('updateColon')) {
    function updateColon($tablo, $kolon, $yeni_deger, $id, $id_deger)
    {
        global $conn;
        $guncelle_query = $conn->prepare("UPDATE  $tablo SET $kolon = $yeni_deger  WHERE $id = :id");

        $guncelle = $guncelle_query->execute(array("id" => $id_deger));
        return ($guncelle) ? 1 : 0;
    }
}

if (!function_exists('getDatas')) {
    function getDatas($table, $colon, $id)
    {
        global $conn;
        $data = $conn->query("SELECT * FROM $table WHERE $colon = $id")->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
}

if (!function_exists('generateUniqueId')) {
    function generateUniqueId()
    {
        return md5(uniqid());
    }
}

if (!function_exists('rasgeleSayiUret')) {
    function rasgeleSayiUret($basamakSayisi)
    {
        $min = pow(10, $basamakSayisi - 1);
        $max = pow(10, $basamakSayisi) - 1;
        return mt_rand($min, $max);
    }
}

if (!function_exists('generateOrderNumber')) {
    function generateOrderNumber()
    {
        $currentTime = time();
        $uniquePart = mt_rand(1, 999);
        $orderNumber = $currentTime . $uniquePart;
        return $orderNumber;
    }
}

if (!function_exists('checkPermission')) {
    function checkPermission($hizmet_id, $islem_turu)
    {
        @session_start();
        if (!isset($_SESSION["kul_id"])) {
            return false;
        }
        global $conn;
        $query = "SELECT * FROM islem_izinleri
      WHERE islem_hizmet_id = :hizmet_id AND islem_yonetici_id = :yonetici_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":hizmet_id", $hizmet_id);
        $stmt->bindParam(":yonetici_id", $_SESSION['kul_id']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            switch ($islem_turu) {
                case 'ekle':
                    return $result['islem_ekle_izin'] == 1;
                case 'duzenle':
                    return $result['islem_duzenle_izin'] == 1;
                case 'sil':
                    return $result['islem_sil_izin'] == 1;
                case 'liste':
                    return $result['islem_liste_izin'] == 1;
                default:
                    return false;
            }
        }
        return false;
    }
}

if (!function_exists('redirectToUnauthorized')) {
    function redirectToUnauthorized($hizmet_id, $islem_turu)
    {
        $izin = checkPermission($hizmet_id, $islem_turu);
        if (!$izin) {
            header("Location: index.php?status=izinsizGiris");
            exit();
        }
    }
}

if (!function_exists('bugunSiparisSayi')) {
    function bugunSiparisSayi($urun_id)
    {
        global $conn;
        $tarih = date('Y-m-d');
        $siparisAdet = $conn->query("SELECT COUNT(*) as toplam FROM siparisler WHERE siparis_urun = $urun_id AND DATE(siparis_tarih) = DATE('$tarih')")->fetch(PDO::FETCH_ASSOC);
        return (isset($siparisAdet['toplam']) and $siparisAdet['toplam'] > 0) ? $siparisAdet['toplam'] : 0;
    }
}

if (!function_exists('bugunOnayliSiparisSayi')) {
    function bugunOnayliSiparisSayi($urun_id)
    {
        global $conn;
        $tarih = date('Y-m-d');
        $siparisAdet = $conn->query("SELECT COUNT(*) as toplam FROM siparisler WHERE (siparis_durum = 3 or siparis_durum = 4) AND  siparis_urun = $urun_id AND DATE(siparis_tarih) = DATE('$tarih')")->fetch(PDO::FETCH_ASSOC);
        return (isset($siparisAdet['toplam']) and $siparisAdet['toplam'] > 0) ? $siparisAdet['toplam'] : 0;
    }
}

if (!function_exists('MaliyetOrt')) {
    function MaliyetOrt($maliyet_id)
    {
        global $conn;
        $ortalama = 0;
        $row = $conn->query("SELECT * FROM reklam_maliyetler WHERE rekalm_maliyet_id = $maliyet_id")->fetch(PDO::FETCH_ASSOC);

        $ortalama += $row['rekalm_maliyet_meta'];
        $ortalama += $row['rekalm_maliyet_tiktok'];
        $ortalama += $row['rekalm_maliyet_google'];
        $ortalama += $row['rekalm_maliyet_twitter'];
        $ortalama += $row['rekalm_maliyet_man'];
        $ortalama += $row['rekalm_maliyet_man_2'];
        return (isset($ortalama) and $ortalama > 0) ? $ortalama : 0;
    }
}


if (!function_exists('urunMaliyetOrt')) {
    function urunMaliyetOrt($urun_id)
    {
        global $conn;
        $sorgu = "SELECT SUM(
            rekalm_maliyet_meta + 
            rekalm_maliyet_tiktok + 
            rekalm_maliyet_google + 
            rekalm_maliyet_twitter + 
            rekalm_maliyet_man + 
            rekalm_maliyet_man_2
        ) AS toplam_maliyet
        FROM reklam_maliyetler 
        WHERE rekalm_maliyet_urun = $urun_id
        ";
        $row = $conn->query($sorgu)->fetch(PDO::FETCH_ASSOC);

        $ortalama = $row['toplam_maliyet'];
        return (isset($ortalama) and $ortalama > 0) ? $ortalama : 0;
    }
}