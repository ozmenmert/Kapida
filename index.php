<?php
include 'ayar.php';
$bugun = date('Y-m-d');
$pageName = 'Anasayfa';
$meta = array(
    'title' => $pageName . $separator .  $siteData['title'],
    'description' => $siteData['description'],
    'keywords' => $siteData['keywords'],
    'author' => $siteData['author']
);
include 'header.php';
?>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">


            <?php
            $tarih = date('Y-m-d');
            ?>
            <?php
            $veriCek = $conn->prepare("SELECT * FROM siparis_durumlari ORDER BY siparis_durum_id ASC");
            $veriCek->execute();
            while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                $durum_id = $var['siparis_durum_id'];
                $durumAdet = $conn->query("SELECT COUNT(*) as toplam,SUM(siparis_tutar) as tutar FROM a_siparisler WHERE siparis_durum = $durum_id AND DATE(durum_update) = DATE('$tarih')")->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="col-md-6">
                <a href="siparisler?filtre=&siparis_durum=<?= $var['siparis_durum_id'] ?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon <?= $var['siparis_renk'] ?>">
                                    <i class="<?= $var['siparis_icon'] ?>"></i>
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Bugün <?= $var['siparis_durum_adi'] ?></div>
                                    <div class="dash-counts">
                                        <p class="countItem">
                                            <span><?= $durumAdet['toplam'] ?> Sipariş -
                                                <?= ($durumAdet['tutar']) ? $durumAdet['tutar'] : 0; ?> TL</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php }
            ?>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card table-responsive">
                    <div class="card-header">
                        <h6>Son Siparişler (<?= date('d.m.Y', strtotime($bugun)); ?>)</h6>
                    </div>
                    <div class="card-body table-responsive p-3">
                        <table class="table table-striped table-hover">
                            <thead class="">
                                <tr class="bg-primary">
                                    <th class=" text-white">Müşteri</th>
                                    <th class=" text-white">Ürün / Tarih</th>
                                    <th class=" text-white">Domain</th>
                                    <th class=" text-white">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sorgu = "SELECT * FROM a_siparisler,a_urunler
                                WHERE a_urunler.urun_id = a_siparisler.siparis_urun
                                AND DATE(a_siparisler.siparis_tarih) = '$bugun'
                                 ORDER BY a_siparisler.siparis_tarih DESC LIMIT 5";
                                $veriCek = $conn->prepare($sorgu);
                                $veriCek->execute();
                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {

                                    $temiz_veri = str_replace('"', '', $row['siparis_icerik']);
                                    $parcalanmis_veri = explode(",", $temiz_veri);
                                    $adet = $parcalanmis_veri[1];
                                ?>
                                <tr>
                                    <td><?= $row['siparis_musteri']; ?></td>
                                    <td><?= $adet . ' Adet ' . $row['urun_adi'] . ' - ' . ($row['siparis_tutar'] - $row['siparis_indirim']) . ' TL'; ?>
                                        -
                                        <?= date('H:i', strtotime($row['siparis_tarih'])); ?></td>
                                    <td><?= $row['siparis_domain']; ?></td>
                                    <td>
                                        <a href="siparis-detay?id=<?= $row['siparis_id']; ?>"
                                            class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card table-responsive">
                    <div class="card-header">
                        <h6>Sitelerdeki Satışlar (<?= date('d.m.Y', strtotime($bugun)); ?>)</h6>
                    </div>
                    <div class="card-body table-responsive p-3">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="bg-primary">
                                    <th class="text-white">Site</th>
                                    <th class="text-white">Sipariş Sayısı</th>
                                    <th class="text-white">Toplam Satış Tutarı</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sorgu = "SELECT *,COUNT(siparis_domain) as domain_adet, SUM(siparis_tutar - siparis_indirim) as totalSatis 
                               
                                FROM a_siparisler
                                WHERE DATE(siparis_tarih) = '$bugun'
                                 GROUP BY siparis_domain";
                                $veriCek = $conn->prepare($sorgu);
                                $veriCek->execute();
                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="https://<?= $row['siparis_domain'] ?>"
                                            target="_blank"><?= $row['siparis_domain'] ?></a>
                                    </td>
                                    <td><?= $row['domain_adet'] ?></td>
                                    <td><?= $row['totalSatis'] ?> TL</td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card table-responsive">
                    <div class="card-header">
                        <h6>Sipariş & Ürün Bazlı</h6>
                    </div>
                    <div class="card-body table-responsive  p-3">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Ürün</th>
                                    <th>Sipariş Sayısı</th>
                                    <th>Adet</th>
                                    <th>Tutar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $veriCek = $conn->prepare("SELECT * FROM a_urunler ORDER BY urun_adi ASC");
                                $veriCek->execute();
                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                    $urun_id = $row['urun_id'];

                                    $siparis_sayisi = 0;
                                    $siparis_adeti = 0;
                                    $siparis_tutari = 0;

                                    $siparisCek = $conn->prepare("SELECT * FROM a_siparisler WHERE siparis_urun  =:urun AND
                                     DATE(siparis_tarih) = '$bugun'");
                                    $siparisCek->execute(array('urun' => $urun_id));
                                    while ($siparis = $siparisCek->fetch(PDO::FETCH_ASSOC)) {

                                        $temiz_veri = str_replace('"', '', $siparis['siparis_icerik']);
                                        $parcalanmis_veri = explode(",", $temiz_veri);
                                        $adet = $parcalanmis_veri[1];
                                        $siparis_adeti += $adet;
                                        $siparis_sayisi += 1;
                                        $siparis_tutari += $siparis['siparis_tutar'] - $siparis['siparis_indirim'];
                                    }

                                ?>
                                <tr class="<?= ($siparis_sayisi < 1) ? 'd-none' : ''; ?>">
                                    <td><?= $row['urun_adi']; ?></td>
                                    <td><?= $siparis_sayisi; ?> Sipariş</td>
                                    <td><?= $siparis_adeti; ?> Adet</td>
                                    <td><?= $siparis_tutari; ?> TL</td>
                                </tr>
                                <?php
                                }
                                ?>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
				<div class="card table-responsive">
					<div class="card-header">
						<h6>Bugün Promosyonlu Siparişler</h6>
					</div>
					<div class="card-body table-responsive  p-3">
						<table class="table table-bordered table-hover">
							<thead class="bg-dark">
								<tr class="bg-primary">
									<th class=" text-white">Promosyon Ürün</th>
									<th class=" text-white">Toplam Tutar</th>
								</tr>
							</thead>

							<tbody>
								<?php
								$sql = "SELECT siparis_promosyon FROM a_siparisler WHERE DATE(siparis_tarih) = '$bugun'";
								$stmt = $conn->prepare($sql);
								$stmt->execute();

								$urunSayisi = 0;
								$toplamKazanc = 0.00;

								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									$siparis_promosyon = $row['siparis_promosyon'];
									if (!empty($siparis_promosyon)) {
										$entries = explode(",", trim($siparis_promosyon, "[]"));
										foreach ($entries as $entry) {
											list($urun_id, $fiyat) = explode(":", $entry);
											$urunSayisi++;
											$toplamKazanc += (float)$fiyat;
										}
									}
								}
								?>
								<tr>
									<td><?= $urunSayisi; ?> Promosyon Seçildi</td>
									<td><?= $toplamKazanc; ?> TL</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>