<div class="hw-fluid-container hw-product-container">
    <h3 class="hw-mt-50 hw-font-theme hw-text-center hw-mb-50"><?= $product->product_name ?></h3>
    <div class="hw-row-container">
        <div class="hw-row-col-50 hw-product-image">
            <div class="hw-full-width hw-full-height hw-theme-cover-bg" style="background-image: url('<?= base_url() . 'assets/images/productos/' . $product->image_url ?>')"></div>
        </div>
        <div class="hw-row-col-50 hw-product-info">
            <h5 class="hw-font-theme hw-text-center hw-mb-25">Descripcion</h5>
            <p class="hw-product-info-short"><?= $product->short_description ?></p>
            <p class="hw-product-info-large"><?= $product->large_description ?></p>
        </div>
    </div>
    <div class="hw-product-price-info">
        <h5 class="hw-text-center hw-mt-20 hw-font-theme">Valor: $<?= number_format($product->price, 0, ',', '.') ?></h5>
        <?php if ($product->discount != 0) : ?>
            <h5 class="hw-text-center hw-mt-20 hw-font-theme">Descuento: <?= $product->discount ?>%</h5>
        <?php endif; ?>
    </div>
</div>