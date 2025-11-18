<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="HTML Template\index.css">
    <link rel="stylesheet" href="HTML Template\payment.css">

    <!-- Swiper CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
</head>
<body>
<?php
if(isset($_POST['cancel_order'])){
    $order_id = $_POST['order_id'];
    $res = $Order->cancelOrder($order_id);
    if($res){
        echo"<script>alert('Order Cancelled');</script>";
    }
}
?>
<section id="cart" class="section-p1">
    <table width="100%">
        <thead>
            <tr>
                <td>Зураг</td>
                <td>Бүтээгдэхүүн</td>
                <td>Төлөв</td>
                <td>Цуцлах</td>
            </tr>
        </thead>
        <tbody>
        <?php 
        $pro = $product->getData();
        foreach($product->getData("orders") as $order_item):
            if($order_item['user_id'] == $user_id):
            foreach($pro as $item):
                if($order_item['item_id'] == $item['item_id']):
        ?>
            <tr>
                <td>                    <img src="<?php echo './products/' . basename($item['item_image']) . '?v=' . time(); ?>"
                      alt="image"
                      onerror="this.onerror=null; this.src='./products/default.jpg';"></td>
                <td><?php echo $item['item_brand']," ",$item['item_name'];?></td>
                <td><?php echo $order_item['status']?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="order_id" value="<?php echo $order_item['order_id']?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id?>">
                        <button name="cancel_order" class="btn">Цуцлах</button>
                    </form>
                </td>
            </tr>
            <?php 
            endif;
            endforeach;
            endif;
            endforeach;
            ?>
        </tbody>
    </table>
</section>

</body>
</html>