<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3>
                <a href="urun-yorumlari?id=<?= $_GET['id'] ?>"
                     title="Ürün Yorumları">
                    <i class="fa fa-comment"></i> Ürün Yorumları</a>
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Yorum Puanı</th>
                            <th>Yorum</th>
                            <th>Yorum Açıklama</th>
                            <th>Yorum Durumu</th>
                            <th>Yorum Tarihi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productComments as $productComment): ?>
                            <tr>
                                <td><?= $productComment["yorum_puan"] ?></td>
                                <td><?= $productComment["yorum_adi"] ?></td>
                                <td><?= $productComment["yorum_aciklama"] ?></td>
                                <td><?= $productComment["durum"] ?></td>
                                <td><?= $productComment["tarih"] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>