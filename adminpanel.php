<?php 
ob_start();
include('function admin.php');

// Захиалгын төлөв шинэчлэх код
if(isset($_POST['check_order'])){
  $order_id = $_POST['order_id'];
  
  try {
      $res = $product->checkOrder($order_id);
  } catch(Exception $e) {
      echo "Алдаа: " . $e->getMessage();
  }
  
  if($res){
      header("Location: ".$_SERVER['PHP_SELF'].(isset($_GET['orders_page']) ? '?orders_page='.$_GET['orders_page'] : ''));
      exit();
  }else{
      echo "<script>alert('Захиалгын төлөв шинэчлэгдсэнгүй');</script>";
  }
}

// Бүтээгдэхүүн устгах код
if(isset($_POST['delete'])){
  $res = $product->deleteProduct($_POST['item_id']);
  if($res){
      header("Location: ".$_SERVER['PHP_SELF']);
      exit();
  }else{
      echo"<script>alert('Бүтээгдэхүүн устгагдсангүй');</script>";
  }
}

// Бүтээгдэхүүн шинэчлэх үйлдлийг боловсруулах
if(isset($_POST['update'])){
  $item_id = $_POST['item_id'];
  $productBrand = $_POST['edit_item_brand'];
  $productName = $_POST['edit_item_name'];
  $productSubject = $_POST['edit_subject'];
  $productPrice = $_POST['edit_item_price'];
  $productDescription = $_POST['edit_item_description'];
  
  $image_path = $_POST['current_image'];
  
  if (isset($_FILES["edit_item_image"]) && $_FILES["edit_item_image"]["error"] == 0) {
      $targetDir = "./assets/products/";
      $filePath = $targetDir . basename($_FILES["edit_item_image"]["name"]);
      
      if (move_uploaded_file($_FILES["edit_item_image"]["tmp_name"], $filePath)) {
          $image_path = $filePath;
      }
  }
  
  try {
      $res = $product->updateProduct($item_id, $productBrand, $productName, $productPrice, $image_path, $productSubject, $productDescription);
  } catch(Exception $e) {
      echo "Алдаа: " . $e->getMessage();
  }
  
  if($res){
      header("Location: ".$_SERVER['PHP_SELF']);
      exit();
  }else{
      echo "<script>alert('Бүтээгдэхүүн шинэчлэгдсэнгүй');</script>";
  }
}
?>
    <!-- JavaScript функц нэмэх -->
    <script>
  $(function() {
    // URL-д orders_page, users_page байвал тохирох табыг идэвхжүүлэх
    if(window.location.search.indexOf('orders_page') !== -1) {
      $('#products-tab, #orders-tab, #users-tab').removeClass('active');
      $('#orders-tab').addClass('active');
    } else if(window.location.search.indexOf('users_page') !== -1) {
      $('#products-tab, #orders-tab, #users-tab').removeClass('active');
      $('#users-tab').addClass('active');
    }

    // Цэс дээр дарах үед URL сонголт болон идэвхжүүлэх
    $('#products-tab').on('click', function(e) {
      $('#products-tab, #orders-tab, #users-tab').removeClass('active');
      $(this).addClass('active');
      // URL-ээс параметрүүдийг хасах
      history.replaceState(null, '', window.location.pathname);
    });
    
    $('#orders-tab').on('click', function(e) {
      $('#products-tab, #orders-tab, #users-tab').removeClass('active');
      $(this).addClass('active');
      // URL-д ?orders_page=1 нэмэх
      history.replaceState(null, '', '?orders_page=1');
    });
    
    $('#users-tab').on('click', function(e) {
      $('#products-tab, #orders-tab, #users-tab').removeClass('active');
      $(this).addClass('active');
      // URL-д ?users_page=1 нэмэх
      history.replaceState(null, '', '?users_page=1');
    });
  });
</script>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Raizen Admin Panel</title>
  <link href="https://fonts.googleapis.com/css?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
 
    .admin-panel {
      margin-top: 50px;
    }
    .admin-panel .btn {
      margin-right: 10px;
    }
    .product-list th,
    .product-list td {
      text-align: center;
      vertical-align: middle;
    }
    .product-list img{
        height: 100px;
        object-fit: contain;
    }
    .description-column {
      max-width: 200px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    .pagination {
      display: flex;
      justify-content: center;
      margin: 20px 0;
      list-style: none;
      padding: 0;
    }
    .pagination li {
      margin: 0 5px;
    }
    .pagination li a {
      display: block;
      padding: 8px 16px;
      text-decoration: none;
      background-color: #f8f9fa;
      color: #333;
      border-radius: 4px;
      transition: background-color 0.3s;
    }
    .pagination li.active a {
      background-color: #007bff;
      color: white;
    }
    .pagination li a:hover:not(.active) {
      background-color: #ddd;
    }
    .pagination .disabled a {
      color: #aaa;
      cursor: not-allowed;
    }
    @media (max-width: 768px) {
      .admin-panel {
        margin-top: 20px;
      }
      .admin-panel .btn {
        margin-bottom: 10px;
      }
      .product-list img {
        max-width: 100%;
      }
    }
    
    
    .admin-header {
    background-color: #343a40;
    padding: 15px 0;
    margin-bottom: 30px;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
  }
  .admin-logo {
    color: white;
    font-size: 24px;
    font-weight: bold;
    margin: 0;
  }
  .admin-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .admin-menu {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
  }
  .admin-menu li {
    margin-left: 20px;
  }
  .admin-menu a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    font-size: 16px;
    transition: color 0.3s;
    cursor: pointer;
    padding: 5px 0;
    display: inline-block;
  }
  .admin-menu a:hover,
  .admin-menu a.active {
    color: white;
    text-decoration: none;
  }
  .admin-menu a.active {
    border-bottom: 2px solid #007bff;
    padding-bottom: 5px;
  }
  .admin-user {
    color: white;
    display: flex;
    align-items: center;
  }
  .admin-user i {
    margin-right: 8px;
  }
  
  @media (max-width: 768px) {
    .admin-nav {
      flex-direction: column;
    }
    .admin-menu {
      margin-top: 15px;
      width: 100%;
      justify-content: center;
    }
    .admin-user {
      margin-top: 15px;
    }
  }
  html {
  scroll-behavior: smooth;
}

  </style>
 
<link rel="stylesheet" href="adminpanel_style.css">

</head>

<body>

<!-- Админ панелийн толгой хэсэг -->
<div class="admin-header">
  <div class="container">
    <div class="admin-nav">
      <h1 class="admin-logo">Raizen Админ</h1>
      
      <ul class="admin-menu"> 
  <li>
    <a 
      href="<?php echo $_SERVER['PHP_SELF']; ?>#products-section"
      id="products-tab"
      class="<?php echo !isset($_GET['orders_page']) && !isset($_GET['users_page']) ? 'active' : ''; ?>">
      Бүтээгдэхүүн
    </a>
  </li>
  <li>
    <a 
      href="<?php echo $_SERVER['PHP_SELF'].'?orders_page=1'; ?>#orders-section"
      id="orders-tab"
      class="<?php echo isset($_GET['orders_page']) ? 'active' : ''; ?>">
      Захиалга
    </a>
  </li>
  <li>
    <a 
      href="<?php echo $_SERVER['PHP_SELF'].'?users_page=1'; ?>#users-section"
      id="users-tab"
      class="<?php echo isset($_GET['users_page']) ? 'active' : ''; ?>">
      Хэрэглэгчид
    </a>
  </li>
</ul>

      
      <div class="admin-user">
        <a href="index.php"> <i class="fas fa-home" style="color:rgb(250, 253, 251);" aria-hidden="true"></i> </a>
      </div>
    </div>
  </div>
</div>
<!-- Админ панелийн толгой хэсэг төгсгөл -->



  <div class="container admin-panel">
    <div class="row">
      <!-- Бүтээгдэхүүн хэсэг -->
      <?php if(!isset($_GET['orders_page']) && !isset($_GET['users_page'])): ?>
      <div class="col-md-12"  id="products-section">
        <h2>Бүтээгдэхүүнүүд</h2>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProductModal">Бүтээгдэхүүн нэмэх</button>
        
        <?php
        // Хуудаслалтын параметрүүд
        $items_per_page = 12; // Нэг хуудсанд харуулах бүтээгдэхүүний тоо
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Одоогийн хуудас
        
        // Бүх бүтээгдэхүүнийг авах
        $all_products = $product->getData();
        
        // Шинээр нэмсэн бүтээгдэхүүнийг эхэнд гаргах
        usort($all_products, function($a, $b) {
            return $b['item_id'] - $a['item_id'];
        });
        
        // Нийт хуудасны тоо
        $total_items = count($all_products);
        $total_pages = ceil($total_items / $items_per_page);
        
        // Хэрэв хуудасны дугаар хүчингүй бол 1-р хуудас руу шилжүүлэх
        if($current_page < 1) $current_page = 1;
        if($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages;
        
        // Одоогийн хуудсанд харуулах бүтээгдэхүүнүүд
        $start_index = ($current_page - 1) * $items_per_page;
        $current_items = array_slice($all_products, $start_index, $items_per_page);
        ?>
        
        <div class="table-responsive">
          <table class="table table-striped table-bordered product-list">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>Брэнд</th>
                <th>Нэр</th>
                <th>Зураг</th>
                <th>Хүйс</th>
                <th>Үнэ</th>
                <th>Тайлбар</th>
                <th>Үйлдлүүд</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($current_items as $item) { ?>
                <tr>
                  <td><?php echo $item['item_id'];?></td>
                  <td><?php echo $item['item_brand'];?></td>
                  <td><?php echo $item['item_name'];?></td>
                  <td><img src="<?php echo './products/' . basename($item['item_image']) . '?v=' . time(); ?>"
                      alt="image"
                      onerror="this.onerror=null; this.src='./products/default.jpg';"></td>
                  <td><?php echo $item['subject'];?></td>
                  <td><?php echo number_format($item['item_price'], 0, '.', ',');?>₮</td>
                  <td class="description-column"><?php echo isset($item['item_description']) ? $item['item_description'] : ''; ?></td>
                  <td>
                    <button class="btn btn-primary edit-btn mb-1" data-toggle="modal" data-target="#editProductModal" 
                      data-id="<?php echo $item['item_id']; ?>" 
                      data-brand="<?php echo $item['item_brand']; ?>" 
                      data-name="<?php echo $item['item_name']; ?>" 
                      data-subject="<?php echo $item['subject']; ?>" 
                      data-price="<?php echo $item['item_price']; ?>" 
                      data-image="<?php echo $item['item_image']; ?>"
                      data-description="<?php echo isset($item['item_description']) ? $item['item_description'] : ''; ?>">
                      <i class="fa fa-edit"></i> Засах
                    </button>
                    <form method="post" style="display:inline-block;">
                      <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                      <button name="delete" class="btn btn-danger" onclick="return confirm('Бүтээгдэхүүнийг устгахдаа итгэлтэй байна уу?');">
                        <i class="fa fa-trash"></i> Устгах
                      </button>
                    </form>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        
        <!-- Хуудаслалт -->
        <?php if($total_pages > 1): ?>
        <ul class="pagination">
          <!-- Өмнөх хуудас -->
          <li class="<?php echo $current_page <= 1 ? 'disabled' : ''; ?>">
            <a href="<?php echo $current_page <= 1 ? '#' : '?page='.($current_page-1); ?>">
              &laquo; Өмнөх
            </a>
          </li>
          
          <!-- Хуудасны дугаарууд -->
          <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <li class="<?php echo $current_page == $i ? 'active' : ''; ?>">
              <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
          <?php endfor; ?>
          
          <!-- Дараагийн хуудас -->
          <li class="<?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">
            <a href="<?php echo $current_page >= $total_pages ? '#' : '?page='.($current_page+1); ?>">
              Дараах &raquo;
            </a>
          </li>
        </ul>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      
      <!-- Захиалга хэсэг -->
      <?php if(isset($_GET['orders_page'])): ?>
      <div class="col-md-12 mt-5" id="orders-section">
        <h2>Захиалгууд</h2>
        <?php
          // Захиалгын хуудаслалтын параметрүүд
          $orders_per_page = 12; // Нэг хуудсанд харуулах захиалгын тоо
          $current_orders_page = isset($_GET['orders_page']) ? (int)$_GET['orders_page'] : 1; // Одоогийн хуудас

          // Бүх захиалгыг авах
          $all_orders = $product->getData("orders");

          // Шинээр нэмсэн захиалгыг эхэнд гаргах
          usort($all_orders, function($a, $b) {
              return $b['order_id'] - $a['order_id'];
          });

          // Нийт хуудасны тоо
          $total_orders = count($all_orders);
          $total_orders_pages = ceil($total_orders / $orders_per_page);

          // Хэрэв хуудасны дугаар хүчингүй бол 1-р хуудас руу шилжүүлэх
          if($current_orders_page < 1) $current_orders_page = 1;
          if($current_orders_page > $total_orders_pages && $total_orders_pages > 0) $current_orders_page = $total_orders_pages;

          // Одоогийн хуудсанд харуулах захиалгууд
          $start_orders_index = ($current_orders_page - 1) * $orders_per_page;
          $current_orders = array_slice($all_orders, $start_orders_index, $orders_per_page);
          ?>
        
        <div class="table-responsive">
  <table class="table table-striped table-bordered table-sm product-list">
    <thead class="thead-dark">
      <tr>
        <th>Захиалгын ID</th>
        <th>Бүтээгдэхүүний ID</th>
        <th>Бүтээгдэхүүний нэр</th>
        <th>Зураг</th>
        <th>Үнэ</th>
        <th>Хэрэглэгчийн ID</th>
        <th class="w-25">Утас</th>
        <th class="w-25">Хаяг</th>
        <th>Төлөв</th>
        <th>Үйлдэл</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($current_orders as $item): 
          $pro = $product->getProduct($item['item_id'], "product");  
          foreach($pro as $i):
            $checked = $item['checked'] ?? 0;
      ?>
        <tr>
          <td><?= htmlspecialchars($item['order_id']) ?></td>
          <td><?= htmlspecialchars($item['item_id']) ?></td>
          <td><?= htmlspecialchars($i['item_brand'] . ' - ' . $i['item_name']) ?></td>
          <td>
              <img src="products/<?= htmlspecialchars(basename($i['item_image'])) ?>"
        onerror="this.onerror=null;this.src='products/default.jpg';"
        style="max-width:80px; height:auto;">

          </td>
          <td><?= number_format($i['item_price'], 0, '.', ',') ?>₮</td>
          <td><?= htmlspecialchars($item['user_id']) ?></td>
          <td class="text-wrap"><?= htmlspecialchars($item['phone']) ?></td>
          <td class="text-wrap"><?= nl2br(htmlspecialchars($item['address'])) ?></td>
          <td>
            <?php if($checked): ?>
              <span class="badge badge-success">Илгээсэн</span>
            <?php else: ?>
              <span class="badge badge-warning">Хүргээгүй</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if(!$checked): ?>
              <form method="post" class="d-inline">
                <input type="hidden" name="order_id" value="<?= htmlspecialchars($item['order_id']) ?>">
                <button type="submit" name="check_order" class="btn btn-success btn-sm">
                  <i class="fa fa-check"></i>
                </button>
              </form>
            <?php else: ?>
              <button class="btn btn-secondary btn-sm" disabled>
                <i class="fa fa-check"></i>
              </button>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; endforeach; ?>
    </tbody>
  </table>
</div>

        
        <!-- Захиалгын хуудаслалт -->
        <?php if($total_orders_pages > 1): ?>
        <ul class="pagination">
          <!-- Өмнөх хуудас -->
          <li class="<?php echo $current_orders_page <= 1 ? 'disabled' : ''; ?>">
            <a href="<?php echo $current_orders_page <= 1 ? '#' : '?orders_page='.($current_orders_page-1); ?>">
              &laquo; Өмнөх
            </a>
          </li>
          
          <!-- Хуудасны дугаарууд -->
          <?php for($i = 1; $i <= $total_orders_pages; $i++): ?>
            <li class="<?php echo $current_orders_page == $i ? 'active' : ''; ?>">
              <a href="?orders_page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
          <?php endfor; ?>
          
          <!-- Дараагийн хуудас -->
          <li class="<?php echo $current_orders_page >= $total_orders_pages ? 'disabled' : ''; ?>">
            <a href="<?php echo $current_orders_page >= $total_orders_pages ? '#' : '?orders_page='.($current_orders_page+1); ?>">
              Дараах &raquo;
            </a>
          </li>
        </ul>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      
      <!-- Хэрэглэгчид хэсэг -->
      <?php if(isset($_GET['users_page'])): ?>
      <div class="col-md-12 mt-5" id="users-section">
        <h2>Бүртгэлтэй хэрэглэгчид</h2>
        <?php
        // Хэрэглэгчдийн хуудаслалтын параметрүүд
        $users_per_page = 12; // Нэг хуудсанд харуулах хэрэглэгчийн тоо
        $current_users_page = isset($_GET['users_page']) ? (int)$_GET['users_page'] : 1; // Одоогийн хуудас
        
        // Бүх хэрэглэгчийг авах
        $all_users = $product->getData("user");
        
        // Нийт хуудасны тоо
        $total_users = count($all_users);
        $total_users_pages = ceil($total_users / $users_per_page);
        
        // Хэрэв хуудасны дугаар хүчингүй бол 1-р хуудас руу шилжүүлэх
        if($current_users_page < 1) $current_users_page = 1;
        if($current_users_page > $total_users_pages && $total_users_pages > 0) $current_users_page = $total_users_pages;
        
        // Одоогийн хуудсанд харуулах хэрэглэгчид
        $start_users_index = ($current_users_page - 1) * $users_per_page;
        $current_users = array_slice($all_users, $start_users_index, $users_per_page);
        ?>
        
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-sm">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>Хэрэглэгчийн нэр</th>
                <th>И-мэйл</th>
                <th>Овог</th>
                <th>Нэр</th>
                <th>Утасны дугаар</th>
                <th>Хэрэглэгчийн төрөл</th>
                <th>Бүртгүүлсэн огноо</th>
                <th>Үйлдэл</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($current_users as $user): ?>
                <tr>
                  <td><?= htmlspecialchars($user['user_id']) ?></td>
                  <td><?= htmlspecialchars($user['username']) ?></td>
                  <td><?= htmlspecialchars($user['email']) ?></td>
                  <td><?= htmlspecialchars($user['owog'] ?? 'Хоосон') ?></td>
                  <td><?= htmlspecialchars($user['ner'] ?? 'Хоосон') ?></td>
                  <td><?= htmlspecialchars($user['utasnii_dugaar'] ?? 'Хоосон') ?></td>
                  <td>
                    <?php if($user['user_type_code'] === 'admin'): ?>
                      <span class="badge badge-danger">Админ</span>
                    <?php else: ?>
                      <span class="badge badge-info">Хэрэглэгч</span>
                    <?php endif; ?>
                  </td>
                  <td><?= htmlspecialchars($user['register_date'] ?? 'Хоосон') ?></td>
                  <td>
                    <?php if($user['user_type_code'] !== 'admin'): ?>
                      <!-- Админ биш хэрэглэгчийг л устгах боломжтой -->
                      <form method="post" class="d-inline">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                        <button type="submit" name="delete_user" class="btn btn-danger btn-sm" 
                                onclick="return confirm('Хэрэглэгч [<?= htmlspecialchars($user['username']) ?>]-г устгахдаа итгэлтэй байна уу?');">
                          <i class="fa fa-trash"></i> Устгах
                        </button>
                      </form>
                    <?php else: ?>
                      <button class="btn btn-secondary btn-sm" disabled>
                        <i class="fa fa-ban"></i> Устгах боломжгүй
                      </button>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        
        <!-- Хэрэглэгчдийн хуудаслалт -->
        <?php if($total_users_pages > 1): ?>
        <ul class="pagination">
          <!-- Өмнөх хуудас -->
          <li class="<?php echo $current_users_page <= 1 ? 'disabled' : ''; ?>">
            <a href="<?php echo $current_users_page <= 1 ? '#' : '?users_page='.($current_users_page-1); ?>">
              &laquo; Өмнөх
            </a>
          </li>
          
          <!-- Хуудасны дугаарууд -->
          <?php for($i = 1; $i <= $total_users_pages; $i++): ?>
            <li class="<?php echo $current_users_page == $i ? 'active' : ''; ?>">
              <a href="?users_page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
          <?php endfor; ?>
          
         
		  <!-- Дараагийн хуудас -->
          <li class="<?php echo $current_users_page >= $total_users_pages ? 'disabled' : ''; ?>">
            <a href="<?php echo $current_users_page >= $total_users_pages ? '#' : '?users_page='.($current_users_page+1); ?>">
              Дараах &raquo;
            </a>
          </li>
        </ul>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item_brand']) && !isset($_POST['update'])) {
    $itemBrand = $_POST['item_brand'];
    $itemName = $_POST['item_name'];
    $itemSubject = $_POST['subject'];
    $itemPrice = $_POST['item_price'];
    $itemDescription = $_POST['item_description'];

    if (isset($_FILES["item_image"]) && $_FILES["item_image"]["error"] == 0) {
      $targetDir = "assets/products/";
      $filePath = $targetDir . basename($_FILES["item_image"]["name"]);
        
        if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $filePath)) {
            echo "Файл амжилттай оруулагдлаа.";
        } else {
            echo "Файл оруулахад алдаа гарлаа.";
        }
    } else {
        echo "Файл оруулагдаагүй байна.";
    }
    
    $image_path = isset($filePath) ? $filePath : '';
    
    try{
        $res = $product->insertProduct($itemBrand, $itemName, $itemPrice, $image_path, $itemSubject, $itemDescription);
    }catch(Exception $e){
        echo $e;
    }
    
    if($res){
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }else{
        echo"<script>alert('Бүтээгдэхүүн нэмэх үйлдэл амжилтгүй.');</script>";
    }
}
?>

  <!-- Бүтээгдэхүүн нэмэх модал -->
  <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addProductModalLabel">Бүтээгдэхүүн нэмэх</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" action="adminpanel.php" method="POST">
            <div class="form-group">
              <label for="item_brand"><strong>Бүтээгдэхүүний брэнд</strong></label>
              <input type="text" class="form-control" id="item_brand" name="item_brand" placeholder="Бүтээгдэхүүний брэнд оруулах" required>
            </div>
            <div class="form-group">
              <label for="item_name"><strong>Бүтээгдэхүүний нэр</strong></label>
              <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Бүтээгдэхүүний нэр оруулах" required>
            </div>
            <div class="form-group">
              <label><strong>Хүйс</strong></label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="subject" id="male" value="Эрэгтэй" required>
                <label class="form-check-label" for="male">Эрэгтэй</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="subject" id="female" value="Эмэгтэй" required>
                <label class="form-check-label" for="female">Эмэгтэй</label>
              </div>
            </div>
            <div class="form-group">
              <label for="item_image"><strong>Зураг сонгох</strong></label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="item_image" name="item_image" accept="image/*" required>
                <label class="custom-file-label" for="item_image">Файл сонгох...</label>
              </div>
            </div>
            <div class="form-group">
              <label for="item_price"><strong>Үнэ (₮)</strong></label>
              <input type="number" class="form-control" id="item_price" name="item_price" placeholder="Бүтээгдэхүүний үнэ оруулах" min="1" required>
            </div>
            <div class="form-group">
              <label for="item_description"><strong>Тайлбар</strong></label>
              <textarea class="form-control" id="item_description" name="item_description" rows="3" placeholder="Бүтээгдэхүүний тайлбар оруулах"></textarea>
            </div>
            <div class="text-right">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Хаах</button>
              <button type="submit" class="btn btn-primary" id="add">Нэмэх</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Бүтээгдэхүүн засах модал -->
  <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editProductModalLabel">Бүтээгдэхүүн засах</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" action="adminpanel.php" method="POST">
            <input type="hidden" id="edit_item_id" name="item_id">
            <input type="hidden" id="current_image" name="current_image">
            <div class="form-group">
              <label for="edit_item_brand"><strong>Бүтээгдэхүүний брэнд</strong></label>
              <input type="text" class="form-control" id="edit_item_brand" name="edit_item_brand" placeholder="Бүтээгдэхүүний брэнд оруулах" required>
            </div>
            <div class="form-group">
              <label for="edit_item_name"><strong>Бүтээгдэхүүний нэр</strong></label>
              <input type="text" class="form-control" id="edit_item_name" name="edit_item_name" placeholder="Бүтээгдэхүүний нэр оруулах" required>
            </div>
            <div class="form-group">
              <label><strong>Хүйс</strong></label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="edit_subject" id="edit_male" value="Эрэгтэй" required>
                <label class="form-check-label" for="edit_male">Эрэгтэй</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="edit_subject" id="edit_female" value="Эмэгтэй" required>
                <label class="form-check-label" for="edit_female">Эмэгтэй</label>
              </div>
            </div>
            <div class="form-group">
              <label for="edit_item_image"><strong>Одоогийн зураг</strong></label>
              <div class="text-center mb-2">
                <img id="current_image_preview" src="" alt="Бүтээгдэхүүний одоогийн зураг" class="img-fluid img-thumbnail" style="max-height: 150px;">
              </div>
              <label for="edit_item_image" class="mt-2"><strong>Шинэ зураг сонгох (заавал биш)</strong></label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="edit_item_image" name="edit_item_image" accept="image/*">
                <label class="custom-file-label" for="edit_item_image">Файл сонгох...</label>
              </div>
            </div>
            <div class="form-group">
              <label for="edit_item_price"><strong>Үнэ (₮)</strong></label>
              <input type="number" class="form-control" id="edit_item_price" name="edit_item_price" placeholder="Бүтээгдэхүүний үнэ оруулах" min="1" required>
            </div>
            <div class="form-group">
              <label for="edit_item_description"><strong>Тайлбар</strong></label>
              <textarea class="form-control" id="edit_item_description" name="edit_item_description" rows="3" placeholder="Бүтээгдэхүүний тайлбар оруулах"></textarea>
            </div>
            <div class="text-right">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Хаах</button>
              <button type="submit" name="update" class="btn btn-primary">Шинэчлэх</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Хэрэглэгчийн дэлгэрэнгүй мэдээлэл харах модал -->
  <div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewUserModalLabel">Хэрэглэгчийн дэлгэрэнгүй мэдээлэл</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="userDetailContent">
          <!-- Энд AJAX-аар хэрэглэгчийн мэдээлэл харуулна -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Хаах</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
  
  <script>
$(document).ready(function() {
  // Файлын нэрийг харуулах
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });

  // Засах модалд бүтээгдэхүүний мэдээллийг автоматаар дүүргэх
  $('.edit-btn').click(function() {
    var id = $(this).data('id');
    var brand = $(this).data('brand');
    var name = $(this).data('name');
    var subject = $(this).data('subject');
    var price = $(this).data('price');
    var image = $(this).data('image');
    var description = $(this).data('description');

    $('#edit_item_id').val(id);
    $('#edit_item_brand').val(brand);
    $('#edit_item_name').val(name);
    $('#edit_item_price').val(price);
    $('#edit_item_description').val(description);
    $('#current_image').val(image);
    $('#current_image_preview').attr('src', image);

    if(subject === "Эрэгтэй"){
      $('#edit_male').prop('checked', true);
    } else if(subject === "Эмэгтэй"){
      $('#edit_female').prop('checked', true);
    }
  });
});
</script>

</body>
</html>

