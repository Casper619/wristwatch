<!-- Cart Section -->

<!-- Product Display -->
<?php
    if(isset($_POST['delete'])){
        $cart_id = $_POST['cart_id'];
        $res = $Cart->deleteProduct($cart_id);
        if($res){
            echo "<script>alert('Бүтээгдэхүүнийг сагснаас хаслаа!!');</script>";
        }
    }

    // Process order submission
    if(isset($_POST['submit_order'])){
        // Get all cart items for this user
        $cart_items = array();
        foreach($product->getData('cart') as $item_cart){
            if($item_cart['user_id'] == $user_id){
                $cart_product = $product->getProduct($item_cart['item_id']);
                if(!empty($cart_product)){
                    $cart_items[] = array(
                        'item_id' => $item_cart['item_id'],
                        'item_name' => $cart_product[0]['item_name'],
                        'item_price' => $cart_product[0]['item_price'],
                        'item_brand' => $cart_product[0]['item_brand'],
                        'item_image' => $cart_product[0]['item_image']
                    );
                }
            }
        }

        // Calculate total
        $subtotalAmount = 0;
        foreach($cart_items as $item){
            $subtotalAmount += $item['item_price'];
        }

        // Calculate delivery fee
        $deliveryFee = ($subtotalAmount > 5000000) ? 0 : 20000;
        $totalAmount = $subtotalAmount + $deliveryFee;

        // Save order to database
        $order_data = array(
            'user_id' => $user_id,
            'items' => json_encode($cart_items),
            'phone' => isset($_POST['phone']) ? $_POST['phone'] : '',
            'address' => isset($_POST['address']) ? $_POST['address'] : ''
        );

        // Өөрчлөгдсөн Order класс нь массиваар захиалгын ID-г буцаана
        $result = $Order->saveOrder($order_data);
        
        if($result){
            // Clear the user's cart after successful order
            foreach($product->getData('cart') as $item_cart){
                if($item_cart['user_id'] == $user_id){
                    $Cart->deleteProduct($item_cart['item_id']);
                }
            }
            
            // Redirect to order confirmation page
            echo "<script>
                alert('Захиалга амжилттай хийгдлээ!');
                window.location.href = 'orders.php';
            </script>";
        } else {
            echo "<script>alert('Захиалга хийхэд алдаа гарлаа. Дахин оролдоно уу.');</script>";
        }
    }
?>
<html>
<head>
    <link rel="stylesheet" href="./HTML Template/cart.css">
    <style>
        .address-form {
            margin-bottom: 10px;
        }
        .address-form input, .phone-form input {
            width: 100%;
            padding: 8px;
            border: 1px solid #e1e1e1;
            border-radius: 4px;
            margin-bottom: 10px;
        }
    </style>
</head>
<section id="cart" class="section-p1">
    <table width="100%">
        <thead>
            <tr>
                <td>Хасах</td>
                <td>Зураг</td>
                <td>Бүтээгдэхүүн</td>
                <td>Үнэ</td>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($product->getData('cart') as $item_cart):
            // Assuming $product->getProduct() fetches product details based on item ID
            if($item_cart['user_id'] == $user_id):
                $cart = $product->getProduct($item_cart['item_id']);
                // Check if $cart is not empty before proceeding
                if (!empty($cart)):
                    $subtotal[] = array_map(function($item){
        ?>
                        <tr>
                            <td><form method='post'><input type='hidden' name='cart_id' value="<?php echo $item['item_id'];?>"><button type='submit' name='delete' value=""><i class="far fa-times-circle"></i></button></form></td>
                            <td><img src="<?php echo './products/' . basename($item['item_image']) . '?v=' . time(); ?>"
                      alt="image"
                      onerror="this.onerror=null; this.src='./products/default.jpg';"></td>
                            <td><?php echo $item['item_brand']," ",$item['item_name'];?></td>
                            <td><?php echo $item['item_price'];?></td>
                            <!-- <td>
                                <form method='post' class="quantity-form" data-item-id="<?php echo $item['item_id']; ?>">
                                    Place the item ID inside the form for reference 
                                    <input type="hidden" name="item_id" value="<?php // echo $item['item_id'];?>">
                                    <input type="number" name="quantity" value="1" min="1">
                                </form>
                            </td> -->
                            <!-- <td class="total-price" id="total-price-<?php echo $item['item_id']; ?>"><?php echo $item['item_price']; ?></td> -->
                        </tr>
            <?php 
                    return $item['item_price'];
                    },$cart);
                endif; // end if $cart is not empty
        endif;
        endforeach;
        ?>


        </tbody>
    </table>
</section>

<!-- !Product Display -->


<!-- Coupon & Subtotal Display -->

<section id="cart-add" class="section-p1">

    <div id="coupon">
        <!-- <h3>Apply Coupon</h3>
        <div>
            <input type="text" placeholder="Enter Your Coupon" name="" id="">
            <button>Apply</button>
        </div> -->
    </div>

    <div id="subtotal">
    <h3>Сагсанд нийт</h3>
    <table>
        <tr>
            <td>Урьдчилсан дүн</td>
            <td>
                <?php
                $subtotalAmount = isset($subtotal) ? $Cart->getSum($subtotal) : 0;
                echo number_format($subtotalAmount) . "₮";
                ?>
            </td>
        </tr>
        <tr>
            <td>Хүргэлт</td>
            <td>
                <?php
                $deliveryFee = 0;
                if (isset($subtotal)) {
                    if ($subtotalAmount > 5000000) {
                        echo "Үнэгүй";
                    } else {
                        $deliveryFee = 20000;
                        echo number_format($deliveryFee) . "₮";
                    }
                }
                ?>
            </td>
        </tr>
        <tr>
            <td><strong>Нийт үнэ</strong></td>
            <td><strong>
                <?php
                $totalAmount = $subtotalAmount + $deliveryFee;
                echo number_format($totalAmount) . "₮";
                ?>
            </strong></td>
        </tr>
    </table>
    <form method="post" action="">
        <input type="hidden" name="submit_order" value="1">
        <?php if(isset($subtotal) && count($subtotal) > 0): ?>
        <div class="phone-form">
            <input type="text" name="phone" placeholder="Утасны дугаар" required>
        </div>
        <div class="address-form">
            <input type="text" name="address" placeholder="Хүргэлтийн хаяг" required>
        </div>
        <?php endif; ?>
        <button type="submit" <?php echo (isset($subtotal) && count($subtotal) > 0) ? '' : 'disabled'; ?>>Захиалах</button>
    </form>
</div>


</section>

<!-- !Coupan & Subtotal Display -->

<!-- !Cart Section -->
</html>