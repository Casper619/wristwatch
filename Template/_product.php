<!-- Product Section -->
<?php
//add to cart function called
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['product_submit'])){
        $Cart->addToCart($_POST['user_id'],$_POST['item_id']);
    }
}

$item_id = $_GET['item_id'] ?? 1;
foreach($product->getData() as $item):
    if($item['item_id'] == $item_id):
?>

<html>
<head>
    <link rel="stylesheet" href="./HTML Template/product.css">
</head>

<section class="product">
    <div class="row">
        <div class="image">
            <img src="products/<?php echo basename($item['item_image']) . '?v=' . time(); ?>" alt="image" 
            onerror="this.onerror=null; this.src='products/default.jpg';">
        </div>
        <div class="detail">
            <h6>Брэнд / Нэр</h6>
            <h3 class="py-4"><?php echo htmlspecialchars($item['item_brand'] . " /" . $item['item_name']); ?></h3>
            <h2>
  <?php 
    echo htmlspecialchars(number_format($item['item_price'], 0)) . '₮'; 
  ?>
</h2>

            <input type="number" name="quantity" id="qty" value="1">
            <br>
            <a href="<?php printf('%s?item_id=%s','payment.php',$item['item_id'])?>" class="buy-btn">Шууд захиалах</a>
            <form method="post">
                <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <button type='submit' name='product_submit' class='btn'>Сагсанд нэмэх</button>
            </form>
            <h4 class="pdetails">Бүтээгдэхүүний мэдээлэл</h4>
            <span>
                <?php echo !empty($item['item_description']) ? nl2br(htmlspecialchars($item['item_description'])) : "Энэ бүтээгдэхүүнд тайлбар оруулаагүй байна."; ?>
            </span>
        </div>
    </div>
</section>

<?php
    endif;
    endforeach;
?>
</html>
<!-- !Product Section -->
