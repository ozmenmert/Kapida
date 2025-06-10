<div class="border-top w-100"></div>
<section class="container pt-15 pb-15 pt-lg-17 pb-lg-20" id="yorumlar">
	<div class="mb-1" style="background:#fff9eb !important;border-radius: 17.5px;">
		<div class="text-center p-4"><h4 class="mb-101" style="text-align: center;">Ürün Değerlendirmeleri</h4></div>
		<div class="  p-5 rounded">
			<div class="p-0 text-center">
				<div class="d-flex justify-content-center align-items-center fs-6 ls-0 mb-4">
					<div class="rating fs-5 ">
						<span class="mx-2 fw-bold fw-semiboldform-puan">
							<?php echo number_format($ortalamaYorumPuan,1); ?>
						</span>
						<?= yuvarlaVeYildizGoster($ortalamaYorumPuan); ?>
					</div>
					<span class="mx-3"> | </span>

					<span class=" fs-5"><?php echo $yorumSayi; ?> Değerlendirme</span>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-1">
		<?php if ($yorumSayi > 0) {
			$veriCek = getSql("SELECT * FROM a_yorumlar WHERE urun_id = $urun_id ORDER BY sira");
			foreach($veriCek as $var){ ?>
				<div class="col-12 col-lg-4">
					<div class="border shadow my-3 py-5 px-4" style="border-radius: 17.5px;">
						<div class="d-flex flex-column mb-5">
							<div class="d-flex justify-content-between align-items-center">
								<div class="d-flex flex-column align-items-center fs-15px ls-0">
									<h5 class="mt-0 mb-0 mx-3 fs-14px text-uppercase ls-1">
										<?= $var['yorum_adi']; ?>
									</h5>									
								</div>
								<div class="rating">
										<?= yuvarlaVeYildizGoster($var['yorum_puan']); ?>
									</div>
								<div class="d-flex flex-column justify-content-end align-items-end">
									<i class="bg-success rounded-circle border border-light bi bi-check-circle text-light fs-6 p-2"></i>									
								</div>
							</div>
						</div>
						<div class="py-7 px-5">
							<p class="mb-5 fs-6">
								<?= $var['yorum_aciklama']; ?>
							</p>
							<div class="mb-5">
								<?php
									$gorsel_url = $anasayfa_url . '/' . $var['yorum_img'];
									$default_gorsel = $anasayfa_url . '/img/no-image.png';

									$yorum_images = json_decode($var['yorum_img'], true);
									if (!empty($yorum_images)) {
										foreach ($yorum_images as $image) { ?>
											<a href="<?= $anasayfa_url . '/' . $image; ?>" data-gallery="product-gallery" data-thumb-src="<?= $anasayfa_url . '/' . $image; ?>">
												<img src="#" data-src="<?= $anasayfa_url . '/' . $image; ?>" style="border-radius: 17.5px;object-fit:cover;max-height:200px;width: 100%;" 
													title class="h-auto lazy-image" alt="<?= $data['urun_adi']; ?>">
											</a>
										<?php }
									}
								?>							
							</div>
						</div>
							<span class="fs-20 commentDate"><?= date('d.m.Y',strtotime($var['tarih'])); ?></span>
					</div>
				</div>
			<?php }
		} 
		else {
			echo '<div class="alert alert-warning"><h4>Henüz yorum eklenmedi</h4></div>';
		} ?>
	</div>
</section>