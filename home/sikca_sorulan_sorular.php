<div class="mt-10">
    <h4 class="mb-101" style="text-align: center;">Sıkça Sorulan Sorular</h4>
    <div class="accordion" id="faqAccordion">
        <?php
        $veriCek = getSql("SELECT * FROM sss ORDER BY id");
        foreach($veriCek as $var){ ?>
            <div class="accordion-item">
                <h2 class="accordion-header mb-3" id="heading<?=$var['id'] ?>">
                    <button class="accordion-button collapsed bg-light border rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$var['id'] ?>" aria-expanded="false" aria-controls="collapse<?=$var['id'] ?>">
                        <?=$var['soru'] ?>
                    </button>
                </h2>
                <div id="collapse<?=$var['id'] ?>" class="accordion-collapse collapse" aria-labelledby="heading<?=$var['id'] ?>" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <?=$var['cevap'] ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>