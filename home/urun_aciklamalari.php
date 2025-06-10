<div class="border-top w-100"></div>
<section class="container pt-10 pb-12 pt-lg-10 pb-lg-20">
    <div class="collapse-tabs">
        <ul class="nav nav-tabs border-0 justify-content-center pb-12 d-none d-md-flex" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link m-auto fw-semiboldformfom py-0 px-8 fs-4 fs-lg-3 border-0 text-body-emphasis-sabit active" id="product-details-tab" data-bs-toggle="tab" data-bs-target="#product-details" role="tab" aria-controls="product-details" aria-selected="true">Ürün Detayları</button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-inner">
                <div class="tab-pane fade active show" id="product-details" role="tabpanel" aria-labelledby="product-details-tab" tabindex="0">
                    <div class="card border-0 bg-transparent">
                        <div class="card-header border-0 bg-transparent px-0 py-4 product-tabs-mobile d-block d-md-none">
                            <h5 class="mb-0">
                                <button class="lh-2 fs-5 px-6  w-100 border"  data-bs-toggle="collapse" data-bs-target="#collapse-product-detail" aria-expanded="false" aria-controls="collapse-product-detail">
                                    Ürün Detayları
                                </button>
                            </h5>
                        </div>                        
                        <div class="collapse show border-md-0 border p-md-0 p-6" id="collapse-product-detail">
                            <?php if ($data['urun_aciklama']!=''){ ?>
                                <?=$data['urun_aciklama'] ?>
                            <?php } else { ?>
                                <div class="alert alert-warning">
                                    <h4>Açıklama eklenmedi</h4>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>