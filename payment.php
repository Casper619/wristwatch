<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="HTML Template\index.css">
    <link rel="stylesheet" href="HTML Template\payment.css">

    <!-- Swiper CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    
    <style>
        /* Form styling */
        .order-form {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f9f9f9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .form-group textarea {
            height: 80px;
        }
        
        .order-btn {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 10px;
        }
        
        .order-btn:hover {
            background-color: #219653;
        }
        
        .form-title {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>

<!-- header section -->
<?php
include('function.php');

// Modified order insertion function
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['place_order'])){
        // Get form data
        $item_id = $_POST['item_id'];
        $user_id = $_POST['user_id'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        
        // Insert order with additional information
        $res = $Order->insertOrderWithDetails($item_id, $user_id, $phone, $address);
        
        if($res){
            echo "<script>alert('Захиалга амжилттай хийгдсэн!!');</script>";
        }else{
            echo "<script>alert('Захиалга амжилтгүй боллоо!!');</script>";
        }
    }
}
?>
<header class="header">

<div class="header-1">
    <a href="index.php#home" class="logo"><img src="logo/Raizen.jpg" alt=""></a>

    <form action="search.php" method="GET" class="search-form">
        <input type="search" name="query" placeholder="хайлт хийх..." id="search-box" required>
        <label for="search-box" class="fas fa-search"></label>
        </form>

        <div class="icons">
            <div id="search-btn" class="fas fa-search"></div>
            <a href="cart.php" class="fas fa-shopping-cart"></a>
            <?php
    // Хэрэглэгч нэвтэрсэн эсэхийг шалгах
    if(isset($_COOKIE['user_id'])) {
        // Хэрэглэгчийн мэдээллийг авах
        $user_id = $_COOKIE['user_id'];
        $all_users = $product->getData('user');
        $current_user = null;
        
        // Нэвтэрсэн хэрэглэгчийг олох
        foreach($all_users as $u) {
            if($u['user_id'] == $user_id) {
                $current_user = $u;
                break;
            }
        }
        
        // Хэрэглэгч олдсон бол гарах товч харуулах
        if($current_user) {
            echo '<span style="margin-right: 8px; font-size: 14px;">' . $current_user['username'] . '</span>';
            echo '<a href="logout.php" class="fas fa-sign-out-alt"></a>';
        } else {
            // Нэвтрэх товч харуулах
            echo '<div id="login-btn" class="fas fa-user"></div>';
        }
    } else {
        // Нэвтрэх товч харуулах
        echo '<div id="login-btn" class="fas fa-user"></div>';
    }
    ?>
            <div id="login-btn"></div>
        </div>
    </div>

<div class="header-2">
        <nav class="navbar">
        <a href="index.php#home"       aria-label="Эхлэл"><i class="fas fa-home"        aria-hidden="true"></i></a>
            <a href="index.php#featured">Онцлох</a>
            <a href="index.php#arrivals">Хямдрал</a>
            <a href="index.php#reviews">Сэтгэгдэл</a>
            <a href="index.php#blogs">Влогууд</a>
            <a href="catalog.php">Төрөл</a>
            <a href="orders.php">Захиалга</a>
        </nav>
    </div>

</header>

<!-- !header section -->


<!-- bottom navbar -->

<nav class="bottom-navbar">
    <a href="#home" class="fas fa-home"></a>
    <a href="#featured" class="fas fa-list"></a>
    <a href="#arrivals" class="fas fa-tags"></a>
    <a href="#reviews" class="fas fa-comments"></a>
    <a href="#blogs" class="fa-solid fa-blog"></a>
</nav>

<!-- !bottom navbar -->


<!-- Cart Section -->

<!-- Product Display -->
<?php 
$item_id = $_GET['item_id'] ?? 1;
foreach($product->getData() as $item):
    if($item['item_id'] == $item_id):
?>
<section id="cart" class="section-p1">
    <table width="100%">
        <thead>
            <tr>
                <td>Зураг</td>
                <td>Бүтээгдэхүүн</td>
                <td>Үнэ</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><img src="<?php echo './products/' . basename($item['item_image']) . '?v=' . time(); ?>"
                      alt="image"
                      onerror="this.onerror=null; this.src='./products/default.jpg';"></td>
                <td><?php echo $item['item_brand']," ",$item['item_name'];?></td>
                <td><?php echo $item['item_price']?>₮</td>
            </tr>
        </tbody>
    </table>
    
    <!-- Improved Order Form with Phone and Address -->
    <div class="order-form">
        <h3 class="form-title">Захиалга өгөх</h3>
        <form method="post">
            <input type="hidden" name="item_id" value="<?php echo $item['item_id']?>">
            <input type="hidden" name="user_id" value="<?php echo $user_id?>">
            
            <div class="form-group">
                <label for="phone">Утасны дугаар:</label>
                <input type="tel" id="phone" name="phone" placeholder="Утасны дугаараа оруулна уу" required pattern="[0-9]{8}">
            </div>
            
            <div class="form-group">
                <label for="address">Хүргэлтийн хаяг:</label>
                <textarea id="address" name="address" placeholder="Дэлгэрэнгүй хаягаа оруулна уу" required></textarea>
            </div>
            
            <button type="submit" name="place_order" class="order-btn">Захиалга өгөх</button>
        </form>
    </div>
</section>
<?php
endif;
endforeach;
?>

<!-- !Product Display -->


<!-- !Cart Section -->


<!-- Footer Section -->

<section class="footer">

    <div class="box-container">

        <div class="box">
            <h3>Холбоосууд</h3>
            <a href="index.php#home"><i class="fas fa-arrow-right"></i>НҮҮР</a>
            <a href="index.php#featured"><i class="fas fa-arrow-right"></i>ОНЦЛОХ</a>
            <a href="index.php#arrivals"><i class="fas fa-arrow-right"></i>ХЯМДРАЛ</a>
            <a href="index.php#reviews"><i class="fas fa-arrow-right"></i>СЭТГЭГДЭЛҮҮД</a>
            <a href="index.php#blogs"><i class="fas fa-arrow-right"></i>ВЛОГУУД</a>
        </div>

        <div class="box">
            <h3>Холбоо барих</h3>
            <a href="tel:+97695927050"><i class="fas fa-phone"></i> +976 95927050</a>
            <a href="tel:+97699119911"><i class="fas fa-phone"></i> +976 99119911</a>
            <a href="mailto:Raizen@gmail.com"><i class="fas fa-envelope"></i> RaizenStore@gmail.com</a>
            <a href="https://maps.app.goo.gl/HcPDRaqVhFkA4jiL7" target="_blank">
                <img src="image/office.jpg" class="map" alt="Google Maps">
            </a>
        </div>

    </div>

    <div class="share">
        <a href="https://www.facebook.com/people/%D0%90%D0%94-%D0%9C%D3%A9%D0%BD%D1%85%D1%82%D3%A9%D1%80/pfbid0w45HRxH5PFJRLCE29iv1xnsZyK2eUjSAjKRn
        WkvzP424MAJirW7LXy6fhUu9jFHSl/" class="fa-brands fa-facebook"></a>
        <a href="https://twitter.com/your_username" class="fa-brands fa-twitter"></a>
        <a href="https://www.instagram.com/mnkhtur.a/" class="fa-brands fa-instagram"></a>
        <a href="https://www.linkedin.com/in/your-profile" class="fa-brands fa-linkedin"></a>
        <a href="https://www.pinterest.com/your-profile" class="fa-brands fa-pinterest"></a>
    </div>

    <div class="credit">Зохиогч <span>А.Мөнхтөр</span> | Бүх эрх хуулиар хамгаалагдсан! </div>

</section>

<!-- !Footer Section -->



<!-- Custom JS -->
<script src="/js/index.js"></script>

<!-- Swiper Jscript -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>
</html>