<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3><a href="urun-fiyatlandirma?id=<?= $_GET['id'] ?>"
                    title="Ürün + Kargo">
                    <i class="fa fa-table"></i> Ürün - Kargo Fiyatları</a>
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Adet</th>
                            <th>Önceki Fiyat</th>
                            <th>Fiyat</th>
                            <th>Kargo Tutarı</th>
                            <th>Kargo Durumu</th>
                            <th>Aktif/Pasif</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productCargoPrices as $productCargoPrice): ?>
                            <td class="text-center"><?= $productCargoPrice["adet"] ?></td>
                            <td class="text-end"><?= ParaFormatla($productCargoPrice["onceki"]) ?></td>
                            <td class="text-end"><?= ParaFormatla($productCargoPrice["fiyat"]) ?></td>
                            <td class="text-end"><?= ParaFormatla($productCargoPrice["kargo_tutar"]) ?></td>
                            <td class="text-center">
                                <?= $productCargoPrice["kargo_durum"] == '1' ? '+Kargo' : 'Kargo Ücretsiz' ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-wrap justify-content-center align-items-center">
                                    <div class="form-check">
                                        <input name="durum[<?= $productCargoPrice["urun_fiyatlandirma_id"] ?>]" class="form-check-input" type="checkbox" <?= $productCargoPrice['durum'] == 1 ? 'checked' : '' ?> disabled="disabled">
                                    </div>
                                    <span><?= $productCargoPrice['durum'] == 1 ? 'aktif' : 'pasif' ?></span>
                                </div>
                            </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>