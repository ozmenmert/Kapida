<h1 class="mb-4 pb-2 fs-4"><?=$data['urun_adi'] ?></h1>
<div class="d-flex align-items-center fs-15px mb-10">
    <p class="mb-0 fw-semibold-puan text-body-emphasis"><?php echo number_format($ortalamaYorumPuan,1); ?></p>
    <div class="d-flex align-items-center fs-12px justify-content-center mb-0 px-6 rating-result">
        <div class="rating">
            <?= yuvarlaVeYildizGoster($ortalamaYorumPuan); ?>
        </div>
    </div>
    <a href="#yorumlar" class="border-start ps-6 text-body"><?=$yorumSayi;?> Değerlendirme</a>
</div>