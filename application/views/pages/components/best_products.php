<!-- Init PHP -->
<?php
$product_show = '';
foreach ($principal_products as $product) {
    $product_show .= '<a href="' . base_url() . 'Product/Product/' . $product->id . '" class="hw-product-show">';
    $product_show .= '<h3>' . $product->product_name . '</h3>';
    $product_show .= '<div class="hw-product-show-image" style="background-image: url(\'' . base_url() . 'assets/images/productos/' . $product->image_url . '\')"></div>';
    $product_show .= '<span class="hw-product-show-price hw-font-theme">$ ' . number_format($product->price, 0, ',', '.') . '</span>';
    $product_show .= '</a>';
}
?>

<!-- Best products -->
<h1 class="hw-font-theme hw-text-center hw-pb-25 hw-mt-50">Nuestros mejores productos</h1>
<div class="hw-theme-line"></div>
<div class="hw-fluid-container">
    <div class="hw-total-center-container hw-mt-10 hw-product-show-container">
        <?= $product_show ?>
    </div>
</div>
<!-- Best products -->