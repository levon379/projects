<?php foreach($products as $product): ?>
    <div class="product carousel-item" data-id="<?php echo $product->id ?>">
        <img src="/Product/attachment/<?php echo $product->hash ?>" alt="">
    </div>
<?php endforeach; ?>