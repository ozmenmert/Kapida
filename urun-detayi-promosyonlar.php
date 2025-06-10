<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3>
                <a href="urune-promosyon-ekle?id=<?= $_GET['id'] ?>"
                    title="Ürün Promosyonları">
                    <i class="fa fa-gift"></i> Ürün Promosyonları</a>
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Promosyon Adı</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productPromos as $productPromo): ?>
                            <tr>
                                <td><?= $productPromo["promosyon_adi"] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>