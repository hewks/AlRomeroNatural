<!-- Init PHP -->
<?php
$product_show = '';
foreach ($principal_products as $product) {
    $product_show .= '<a href="#" class="hw-product-show">';
    $product_show .= '<h3>' . $product->product_name . '</h3>';
    $product_show .= '<div class="hw-product-show-image" style="background-image: url(\'' . base_url() . 'assets/images/productos/' . $product->image_url . '\')"></div>';
    $product_show .= '<p class="hw-product-show-description">' . $product->short_description . '</p>';
    $product_show .= '<span class="hw-product-show-price hw-font-theme">$ ' . number_format($product->price,0,',','.') . '</span>';    
    $product_show .= '</a>';
}
?>

<h1 class="hw-font-theme hw-text-center hw-pb-25 hw-mt-20">Jabones Naturales</h1>
<div class="hw-theme-line"></div>
<div class="hw-fluid-container">
    <div class="hw-total-center-container hw-mt-10">
        <div class="hw-simple-slider hw-theme-border hw-theme-bg" id="hw-simple-slider">
            <div class="hw-ss hw-beauty-border hw-cover-bg hw-center-bg" data-slider="0" style="background-image: url('<?= base_url() ?>assets/images/jabones/jabon_avena_small.JPG')"></div>
            <div class="hw-ss hw-beauty-border hw-cover-bg hw-center-bg" data-slider="1" style="background-image: url('<?= base_url() ?>assets/images/jabones/jabon_lavanda_small.JPG')"></div>
            <div class="hw-ss hw-beauty-border hw-cover-bg hw-center-bg" data-slider="2" style="background-image: url('<?= base_url() ?>assets/images/jabones/jabon_coco_small.JPG')"></div>
            <div class="hw-ss hw-beauty-border hw-cover-bg hw-center-bg" data-slider="3" style="background-image: url('<?= base_url() ?>assets/images/jabones/jabon_calendula_small.JPG')"></div>
            <span class="hw-simple-slider-control hw-simple-slider-next" data-toggle="next">
                <i class="fas fa-arrow-right"></i>
            </span>
            <span class="hw-simple-slider-control hw-simple-slider-back" data-toggle="back">
                <i class="fas fa-arrow-left"></i>
            </span>
        </div>
    </div>
</div>

<h1 class="hw-font-theme hw-text-center hw-pb-25 hw-mt-20">Nuestros mejores productos</h1>
<div class="hw-theme-line"></div>
<div class="hw-fluid-container">
    <div class="hw-total-center-container hw-mt-10 hw-product-show-container">
        <?= $product_show ?>
    </div>
</div>