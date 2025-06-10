<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3>
                <a href="urune-gorsel-ekle?id=<?= $_GET['id'] ?>"
                    title="Ürün Resimleri">
                    <i class="fa fa-table"></i> Ürün Resimleri</a>
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($productPictures as $productPicture): ?>
                    <div class="col-md-3">
                        <img src="<?= "../" . $productPicture["img"] ?>" class="img-fluid img-thumbnail" />
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>