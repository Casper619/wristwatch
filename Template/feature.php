<!-- Features Section -->
<?php
  //  include('function.php');
    $product_featured = $product->getDataFeatured();

    //add to cart function called
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['feature_submit'])){
            $Cart->addToCart($_POST['user_id'],$_POST['item_id']);
        }
    }
?>
<section class="featured" id="featured">
    <h1 class="heading"><span>Онцолсон цагууд</span></h1>

    <div class="swiper featured-slider">
        <div class="swiper-wrapper">
        <?php foreach($product_featured as $item) { ?>
            <div class="swiper-slide box">
                    <div class="icons">
                        <!--<a href="#" class="fas fa-search"></a>
                        <a href="#" class="fas fa-heart"></a> -->
                        <a href="<?php printf('%s?item_id=%s','product.php',$item['item_id'])?>" class="fas fa-eye"></a>
                    </div>
                    <a href="<?php printf('%s?item_id=%s','product.php',$item['item_id'])?>">
                    <div class="image">
                    <div class="image">
    <img src="<?php echo './products/' . basename($item['item_image']) . '?v=' . time(); ?>" alt="image"
         onerror="this.onerror=null; this.src='./products/default.jpg';">
</div>

                    </div>
                    <div class="content">
                        <h3><?php echo $item['item_brand'] ?></h3>
                        <h4><?php echo $item['item_name'] ?></h4>
                        <div class="price">
                            <?php 
                                $current_price = number_format($item['item_price'], 0, '.', ',');
                                $old_price = isset($item['item_old_price']) ? number_format($item['item_old_price'], 0, '.', ',') : '950,000';
                            ?>
                            <?php echo $current_price; ?>₮ 
                            <span style="text-decoration: line-through; color: gray; font-size: 0.6em; vertical-align: middle;">
                                <?php echo $old_price; ?>₮
                            </span>
                        </div>


                        <form method="post">
                            <input type="hidden" name="item_id" value="<?php echo $item['item_id']?>">
                            <input type="hidden" name="user_id" value="<?php echo $user_id?>">
                            <button type='submit' name='feature_submit' class='btn'>Сагсанд нэмэх</button>
                        </form>
                    </div>
                </a>
            </div>
        <?php } ?>
        </div>

        <!-- Navigation Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

</section>
<!-- !Features Section -->

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.featured-slider', {
        slidesPerView: 3, // Эхний 3 зураг харуулна
        spaceBetween: 20, // Зураг хоорондын зай
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>
