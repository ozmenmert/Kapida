<?php
include 'ayar.php';


$sayfa_hizmet_id = 2;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

$pageName = 'Rapor';
$meta = array(
	'title' => $pageName . $separator .  $siteData['title'],
	'description' => $siteData['description'],
	'keywords' => $siteData['keywords'],
	'author' => $siteData['author']
);
include 'header.php';


if (isset($_GET['filtre'])) {
	$tarihSecimi = $_GET['tarihSecimi'];
	$siparis_durum = $_GET['siparis_durum'];
	$siparis_urun = $_GET['siparis_urun'];
	$tarihler = explode(' - ', $tarihSecimi);
	$baslangic = $tarihler[0];
	$bitis = $tarihler[1];

	$gelenBaslangic = date("Y-m-d", strtotime(str_replace(".", "-", $baslangic)));
	$gelenBitis = date("Y-m-d", strtotime(str_replace(".", "-", $bitis)));
} else {
	$gelenBaslangic = date('Y-m-d');
	$gelenBitis = date('Y-m-d');
}
?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-md-12">

				<div class="card">
					<form method="GET">
						<div class="row p-3">
							<div class="col-md-12">
								<h4 class="mb-3">Filtrele</h4>
							</div>

							<div class="col-md-12 mb-2">

								<input type="text" name="tarihSecimi" id="reportrange" class="form-control">
							</div>

							<div class="col-md-4">
								<label for="siparis_durum">Durum</label>
								<select name="siparis_durum" id="siparis_durum" class="form-control">
									<option value="">Seçiniz</option>
									<?php
									$veriCek = $conn->prepare("SELECT * FROM siparis_durumlari ORDER BY siparis_durum_id");
									$veriCek->execute();
									while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
										<option <?= (isset($siparis_durum) and $siparis_durum == $row['siparis_durum_id']) ? 'selected' : ''; ?> value="<?= $row['siparis_durum_id']; ?>"><?= $row['siparis_durum_adi']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-md-4">
								<label for="siparis_urun">Ürün</label>
								<select name="siparis_urun" id="siparis_urun" class="form-control">
									<option value="">Seçiniz</option>
									<?php
									$veriCek = $conn->prepare("SELECT * FROM a_urunler ORDER BY urun_adi ASC");
									$veriCek->execute();
									while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
										<option <?= (isset($siparis_urun) and $siparis_urun == $row['urun_id']) ? 'selected' : ''; ?> value="<?= $row['urun_id']; ?>"><?= $row['urun_adi']; ?></option>
									<?php
									}
									?>
								</select>
							</div>

							<div class="col-md-12 mt-3 d-flex justify-content-between">
								<button type="submit" name="filtre" class="btn btn-primary w-100 mx-1">Filtrele</button>
								<a href="rapor" class="btn btn-secondary mx-1">Temizle</a>
							</div>

						</div>
					</form>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<a href="siparis-listesi">
									<div class="dash-widget-header">
										<span class="dash-widget-icon bg-info">
											<i class="fa-solid fa-shopping-basket"></i>
										</span>
										<div class="dash-count">
											<div class="dash-title">Toplam Sipariş</div>
											<div class="dash-counts">
												<p class="countItem">
													<span>
														<?php
														$ek = "";
														if (isset($siparis_urun) and $siparis_urun != '') {
															$ek =  " AND siparis_urun = $siparis_urun ";
														}
														if (isset($siparis_durum) and $siparis_durum != '') {
															$ek =  " AND siparis_durum = $siparis_durum ";
														}

														$toplamSiparis = $conn->query("SELECT COUNT(*) as adet FROM a_siparisler WHERE
															DATE(siparis_tarih) >= '$gelenBaslangic'
															AND DATE(siparis_tarih) <= '$gelenBitis'" . $ek)->fetch(PDO::FETCH_ASSOC);
														echo $toplamSiparis['adet'] . ' Sipariş';
														?>
													</span>
												</p>
											</div>
										</div>
									</div>
								</a>
							</div>
							<div class="col-md-12">
								<a href="siparis-listesi">

									<div class="dash-widget-header">
										<span class="dash-widget-icon bg-3">
											<i class=" fa-solid fa-coins"></i>
										</span>
										<div class="dash-count">
											<div class="dash-title">Toplam Tutar (Sipariş Tutarı - İndirim)</div>
											<div class="dash-counts">
												<p class="countItem">
													<span>
														<?php
														$ek = "";
														if (isset($siparis_urun) and $siparis_urun != '') {
															$ek =  " AND siparis_urun = $siparis_urun ";
														}
														if (isset($siparis_durum) and $siparis_durum != '') {
															$ek =  " AND siparis_durum = $siparis_durum ";
														}

														$toplamTutar = $conn->query("SELECT SUM(siparis_tutar - siparis_indirim) as adet FROM a_siparisler WHERE
															DATE(siparis_tarih) >= '$gelenBaslangic'
															AND DATE(siparis_tarih) <= '$gelenBitis'" . $ek)->fetch(PDO::FETCH_ASSOC);
														echo number_format($toplamTutar['adet'], 2) . ' TL';
														?>
													</span>
												</p>
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<a href="siparis-listesi">

									<div class="dash-widget-header">
										<span class="dash-widget-icon bg-warning">

											<i class="fa-solid fa-plus-circle"></i>
										</span>
										<div class="dash-count">
											<div class="dash-title">Promosyonlar</div>
											<div class="dash-counts">
												<p class="countItem">
													<span>
														<?php
														$ek = "";
														if (isset($siparis_urun) and $siparis_urun != '') {
															$ek =  " AND siparis_urun = $siparis_urun ";
														}

														if (isset($siparis_durum) and $siparis_durum != '') {
															$ek =  " AND siparis_durum = $siparis_durum ";
														}

														$sql = "SELECT siparis_promosyon FROM a_siparisler WHERE DATE(siparis_tarih) >= '$gelenBaslangic' AND
														DATE(siparis_tarih) <= '$gelenBitis'" . $ek;
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
														<?= $urunSayisi; ?> Promosyon
													</span>
												</p>
											</div>
										</div>
									</div>
								</a>
							</div>

							<div class="col-md-12">
								<a href="siparis-listesi">

									<div class="dash-widget-header">
										<span class="dash-widget-icon bg-success">
											<i class="fa-solid fa-check-double"></i>
										</span>
										<div class="dash-count">
											<div class="dash-title">Toplam Tutar</div>
											<div class="dash-counts">
												<p class="countItem">
													<span>
														<?= $toplamKazanc; ?> TL
													</span>
												</p>
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>


		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="card table-responsive">
					<div class="card-header">
						<h6>Sipariş & Ürün Bazlı</h6>
					</div>
					<div class="card-body table-responsive  p-3">
						<table class="table table-bordered table-hover">
							<thead class="bg-dark">
								<tr>
									<th class=" text-white">Ürün</th>
									<th class=" text-white">Site</th>
									<th class=" text-white">Sipariş Sayısı</th>
									<th class=" text-white">Adet</th>
									<th class=" text-white">Tutar</th>
								</tr>
							</thead>
							<tbody>
								<?php

								$ek = "";
								if (isset($siparis_urun) and $siparis_urun != '') {
									$ek =  " AND siparis_urun = $siparis_urun ";
								}

								if (isset($siparis_durum) and $siparis_durum != '') {
									$ek =  " AND siparis_durum = $siparis_durum ";
								}

								$veriCek = $conn->prepare("SELECT * FROM a_urunler ORDER BY urun_adi ASC");
								$veriCek->execute();
								while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
									$urun_id = $row['urun_id'];

									$siparis_sayisi = 0;
									$siparis_adeti = 0;
									$siparis_tutari = 0;

									$siparisCek = $conn->prepare("SELECT * FROM a_siparisler WHERE siparis_urun  =:urun AND
										DATE(siparis_tarih) >= '$gelenBaslangic' AND
										DATE(siparis_tarih) <= '$gelenBitis'" . $ek);
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
										<td><?= ($row['urun_subdomain'] != '') ? $row['urun_subdomain'] : '' ?></td>
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
						<h6>Sipariş Durumuna Göre</h6>
					</div>
					<div class="card-body table-responsive  p-3">
						<table class="table table-bordered table-hover">
							<thead class="bg-dark">
								<tr>
									<th class="text-white">Durum</th>
									<th class="text-white">Sipariş Sayısı</th>
									<th class="text-white">Adet</th>
									<th class="text-white">Tutar</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$ek = "";
								if (isset($siparis_urun) and $siparis_urun != '') {
									$ek =  " AND siparis_urun = $siparis_urun ";
								}

								if (isset($siparis_durum) and $siparis_durum != '') {
									$ek =  " AND siparis_durum = $siparis_durum ";
								}
								$veriCek = $conn->prepare("SELECT * FROM siparis_durumlari ORDER BY siparis_durum_adi ASC");
								$veriCek->execute();
								while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
									$durum_id = $row['siparis_durum_id'];

									$siparis_sayisi = 0;
									$siparis_adeti = 0;
									$siparis_tutari = 0;

									$siparisCek = $conn->prepare("SELECT * FROM siparisler WHERE siparis_durum  =:durum AND
										DATE(siparis_tarih) >= '$gelenBaslangic' AND
										DATE(siparis_tarih) <= '$gelenBitis'" . $ek);
									$siparisCek->execute(array('durum' => $durum_id));
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
										<td><?= $row['siparis_durum_adi']; ?></td>
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

			<!--
            <div class="col-md-12">
                <div class="card table-responsive">
                    <div class="card-header">
                        <h6>Sitelerdeki Satışlar</h6>
                    </div>
                    <div class="card-body table-responsive  p-3">
                        <table class="table table-striped table-hover">
                            <thead class="bg-dark">
                                <tr>
                                    <th class="text-white">Site</th>
                                    <th class="text-white">Sipariş Sayısı</th>
                                    <th class="text-white">Toplam Satış Tutarı</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
								$sorgu = "SELECT COUNT(siparis_domain) as domain_adet, SUM(siparis_tutar - siparis_indirim) as totalSatis,siparis_domain 
                                FROM a_siparisler
                                WHERE DATE(siparis_tarih) >= '$gelenBaslangic' AND
                                DATE(siparis_tarih) <= '$gelenBitis'
                                 GROUP BY siparis_domain";
								$veriCek = $conn->prepare($sorgu);
								$veriCek->execute();
								while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
								?>
                                <tr>
                                    <td><?= $row['siparis_domain'] ?></td>
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

        -->


			<div class="col-md-12">
				<div class="card table-responsive">
					<div class="card-header">
						<h6>Satışlar</h6>
					</div>
					<div class="card-body table-responsive  p-3">
						<?php
						$ek = "";
						if (isset($siparis_urun) and $siparis_urun != '') {
							$ek =  " AND siparis_urun = $siparis_urun ";
						}

						if (isset($siparis_durum) and $siparis_durum != '') {
							$ek =  " AND siparis_durum = $siparis_durum ";
						}

						$sorgu = "SELECT * FROM a_siparisler,siparis_durumlari WHERE
        					a_siparisler.siparis_durum = siparis_durumlari.siparis_durum_id AND
        					DATE(a_siparisler.siparis_tarih) >= '$gelenBaslangic' AND
        					DATE(a_siparisler.siparis_tarih) <= '$gelenBitis'" . $ek . " 
        					ORDER BY a_siparisler.siparis_tarih DESC LIMIT 300";

						//echo $sorgu;
						?>
						<table class="table table-striped ozelTablo">
							<thead>
								<tr>
									<th>Tarih</th>
									<th>İsim Soyisim</th>
									<th>Telefon</th>
									<th>Ürün</th>
									<th>Tutar</th>
									<th>Şehir</th>
									<th>Web Site</th>
									<th>Sipariş Durumu</th>
									<th>Detay</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$veriCek = $conn->prepare($sorgu);
								$veriCek->execute();
								while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
									$mukerrerKontrol = $conn->query("SELECT COUNT(*) as toplam FROM a_siparisler 
        							WHERE siparis_urun = " . $row['siparis_urun'] . " AND
        							siparis_musteri = '" . $row['siparis_musteri'] . "' AND
        							siparis_telefon = '" . $row['siparis_telefon'] . "'
        							")->fetch(PDO::FETCH_ASSOC);
									$adres_il = $row['siparis_il'];
									$ilData = $conn->query("SELECT * FROM iller WHERE id = '$adres_il' ")->fetch(PDO::FETCH_ASSOC);
									$urunData = $conn->query("SELECT * FROM a_urunler WHERE urun_id =" . $row['siparis_urun'])->fetch(PDO::FETCH_ASSOC);

								?>

									<tr>
										<td>
											<?= tarihSaatFormatla($row['siparis_tarih']) ?>
										</td>
										<td>
											<?= $row['siparis_musteri']; ?>
											<span class="px-1 py-1 fs-bold">[<?= $mukerrerKontrol['toplam'] ?>]</span>
										</td>
										<td>
											<?= $row['siparis_telefon'] ?> <a
												href=" https://wa.me/+<?= $row['siparis_telefon'] ?>" target="_blank"
												class="btn btn-sm"><i class="fa-brands fa-whatsapp text-success"></i></a>
										</td>
										<td>
											<?= $urunData['urun_adi'] ?>
										</td>

										<td>
											<?= ParaFormatla($row['siparis_tutar'] - $row['siparis_indirim']) ?> TL
										</td>

										<td>
											<?= $ilData['il_adi'] ?>
										</td>

										<td>
											<a href="https://<?= $row['siparis_domain'] ?>"
												target="_blank"><?= $row['siparis_domain'] ?></a>
										</td>

										<td>
											<?= $row['siparis_durum_adi'] ?>
										</td>

										<td class="align-middle">
											<a href="siparis-detay?id=<?= $row['siparis_id'] ?>"
												class="btn btn-success text-white btn-sm px-1 py-1 fs-7"><i
													class="fa fa-eye"></i>
												Detaylar</a>
										</td>

									</tr>



								<?php } ?>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>

<script type="text/javascript" src="assets/js//moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
	$(document).ready(function() {
		$(function() {
			function cb(start, end) {
				$("#reportrange span").html(
					start.format("D MMMM, YYYY") + " - " + end.format("D MMMM, YYYY")
				);
			}

			var tarihSecimi = getUrlParameter('tarihSecimi');

			if (tarihSecimi) {
				var tarihler = tarihSecimi.split(' - ');
				var startDate = moment(tarihler[0], 'DD.MM.YYYY');
				var endDate = moment(tarihler[1], 'DD.MM.YYYY');
			} else {
				var startDate = moment().subtract(0, "days");
				var endDate = moment();
			}

			$("#reportrange").daterangepicker({
					startDate: startDate,
					endDate: endDate,
					ranges: {
						Bugün: [moment(), moment()],
						Dün: [moment().subtract(1, "days"), moment().subtract(1, "days")],
						"Son 7 Gün": [moment().subtract(6, "days"), moment()],
						"Son 14 Gün": [moment().subtract(13, "days"), moment()],
						"Son 30 Gün": [moment().subtract(29, "days"), moment()],
						"Bu Ay": [moment().startOf("month"), moment().endOf("month")],
						"Geçen Ay": [
							moment().subtract(1, "month").startOf("month"),
							moment().subtract(1, "month").endOf("month"),
						],
					},
					locale: {
						customRangeLabel: "Özel Aralık",
						format: "DD.MM.YYYY",
						separator: " - ",
						applyLabel: "Uygula",
						cancelLabel: "İptal",
						daysOfWeek: ["Pz", "Pt", "Sa", "Ça", "Pe", "Cu", "Ct"],
						monthNames: [
							"Ocak",
							"Şubat",
							"Mart",
							"Nisan",
							"Mayıs",
							"Haziran",
							"Temmuz",
							"Ağustos",
							"Eylül",
							"Ekim",
							"Kasım",
							"Aralık",
						],
						firstDay: 1,
					},
				},
				cb
			);
			cb(startDate, endDate);
		});

		function getUrlParameter(name) {
			name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
			var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
			var results = regex.exec(location.search);
			return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
		};
	});
</script>