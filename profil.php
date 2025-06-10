<?php 
include 'ayar.php';
$pageName = 'Profilim';
$meta = array(
	'title' => $pageName . $separator .  $siteData['title'],
	'description' => $siteData['description'],
	'keywords' => $siteData['keywords'],
	'author' => $siteData['author']
);
include 'header.php'; 
$data = $conn->query("SELECT * FROM kullanicilar WHERE kul_id = '$kul_id' ")->fetch(PDO::FETCH_ASSOC);
?>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-header">
			<div class="content-page-header">
				<h5>Profil <?=$separator . $data['adi']?></h5>

			</div>
		</div>

		<div class="row">
			<div class="col-xl-12 col-md-12">
				<div class="card">
					<div class="card-body">


						<form action="islemler.php" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="kul_id" value="<?=$data['kul_id']?>">
							<input type="hidden" name="backUrl" value="profil">
							<div class="row">
								<div class="col-lg-7">
									<div class="form-group">
										<label>Kullanıcı Adı</label>
										<input type="text" name="adi" class="form-control" placeholder="Kullanıcı Adı" required
										value="<?=$data['adi']?>">
									</div>
								</div>
								<div class="col-lg-5">
									<div class="form-group">
										<label>Şifre</label>
										<input type="password" name="sifre" class="form-control" placeholder="Şifre" required
										value="<?=$data['sifre']?>">
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group">
										<label>E-Mail</label>
										<input type="email" name="email" class="form-control" placeholder="E-Mail" required
										value="<?=$data['email']?>">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Telefon</label>
										<input type="text" name="tel" class="form-control phoneMask" placeholder="Telefon" required
										value="<?=$data['tel']?>">
									</div>
								</div>

								<div class="col-lg-12 text-end">
									<div class="btn-path">
										<button type="submit" name="kullaniciDuzenle" class="btn btn-primary btn-block w-100 btn-lg"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Kaydet</button>
									</div>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>
