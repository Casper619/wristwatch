<!-- Article Section -->
<?php 
$product_arrival1 = $product->getDataSpecific("product","arrival","M");
$product_arrival2 = $product->getDataSpecific("product","arrival","L");
shuffle($product_arrival1);
shuffle($product_arrival2);
?>
<section class="arrivals" id="arrivals">
    <h1 class="heading"><span>Хямдарсан</span></h1>

    <div class="swiper arrivals-slider">

        <div class="swiper-wrapper">
            <?php foreach($product_arrival1 as $item) { ?>
            <a href="<?php printf('%s?item_id=%s','product.php',$item['item_id'])?>" class="swiper-slide box">
                <div class="image">
                    <img src="<?php echo $item['item_image']?>" alt="image">
                </div>
                <div class="content">
                    <h3><?php echo $item['item_brand']?></h3>
                    <h4><?php echo $item['item_name']?></h4>
                    <div class="price">₹<?php echo $item['item_price']?><span>900000₮</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>
            <?php }?>
        </div>

    </div>

    <div class="swiper arrivals-slider">

    <div class="swiper-wrapper">
            <?php foreach($product_arrival2 as $item) { ?>
            <a href="<?php printf('%s?item_id=%s','product.php',$item['item_id'])?>" class="swiper-slide box">
                <div class="image">
                    <img src="<?php echo $item['item_image']?>" alt="image">
                </div>
                <div class="content">
                    <h3><?php echo $item['item_brand']?></h3>
                    <h4><?php echo $item['item_name']?></h4>
                    <div class="price"><?php echo $item['item_price']?><span>900000₮</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>
            <?php }?>
        </div>

    </div>
</section>

<!-- !Article Section -->