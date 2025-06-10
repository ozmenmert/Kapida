<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3>
                <a href="urun-varyant-kaydet?id=<?= $_GET['id'] ?>"
                    title="Ürün Varyantları">
                    <i class="fa fa-table"></i> Ürün Varyantları</a>
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Varyant Adı</th>
                            <th>Değerler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productVaryants as $productVaryant): ?>
                            <tr>
                                <td><?= $productVaryant["varyant_adi"] ?></td>
                                <td><?= $productVaryant["degerler"] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>