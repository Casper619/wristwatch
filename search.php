<?php
// search.php
include 'header.php';

// Handle Add to Cart from search results
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_submit'])) {
    // Sanitize inputs
    $item_id = $db->con->real_escape_string($_POST['item_id']);
    $user_id = $db->con->real_escape_string($_POST['user_id']);

    // Add item to cart
    try {
        $added = $Cart->addToCart($item_id, $user_id);
        if ($added) {
            echo "<script>toastr.success('Бүтээгдэхүүн сагсанд амжилттай нэмэгдлээ');</script>";
        } else {
            echo "<script>toastr.error('Сагсанд нэмэх үед алдаа гарлаа');</script>";
        }
    } catch (Exception $e) {
        echo "<script>toastr.error('" . addslashes($e->getMessage()) . "');</script>";
    }
}

// Initialize search query
$search_query = '';
if (isset($_GET['query'])) {
    $search_query = $db->con->real_escape_string($_GET['query']);
}

// Search in products
$product_query = "SELECT * FROM `product` WHERE
    `item_name` LIKE '%$search_query%' OR
    `item_brand` LIKE '%$search_query%' OR
    `item_description` LIKE '%$search_query%' OR
    `subject` LIKE '%$search_query%'";
$product_result = $db->con->query($product_query);
?>

<html>
<head>
    <link rel="stylesheet" href="./HTML Template/catalog.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
<main id="main-site">
    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Search Results Section -->
    <section id="search-results">
        <div class="container mt-5">
            <!-- Main heading with larger inline font-size -->
            <h4 class="font-rubik" style="font-size:20px;">Хайлтын үр дүн</h4>

            <!-- Show the user what they searched for (increase font-size) -->
            <?php if (!empty($search_query)): ?>
                <p style="font-size:15px; margin-top:0.5rem;">Хайлтын утга: <strong><?php echo htmlspecialchars($search_query); ?></strong></p>
            <?php endif; ?>

            <!-- Total results card (increase font-size) -->
            <div class="col-12 mb-4">
                <div class="card border-info p-3">
                    <strong style="font-size:13px;">Нийт бүтээгдэхүүн: <?php echo $product_result->num_rows; ?> ширхэг</strong>
                </div>
            </div>

            <?php if ($product_result && $product_result->num_rows > 0): ?>
                <div class="grid">
                    <?php while ($item = $product_result->fetch_assoc()): ?>
                        <div class="box <?php echo htmlspecialchars($item['subject']); ?>">
                            <a href="<?php printf('%s?item_id=%s','product.php',$item['item_id']); ?>">
                                <div class="image">
                                    <img src="<?php echo './products/' . basename($item['item_image']) . '?v=' . time(); ?>"
                                         alt="<?php echo htmlspecialchars($item['item_name']); ?>"
                                         onerror="this.onerror=null; this.src='./products/default.jpg';">
                                </div>
                            </a>
                            <div class="content">
                                <h3><?php echo htmlspecialchars($item['item_brand']); ?></h3>
                                <h4><?php echo htmlspecialchars($item['item_name']); ?></h4>
                                <div class="price">
                                    ₮<?php echo number_format($item['item_price']); ?>
                                    <?php if (!empty($item['item_old_price']) && $item['item_old_price'] > $item['item_price']): ?>
                                        <span>₮<?php echo number_format($item['item_old_price']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="stars">
                                    <?php
                                    $stars = isset($item['rating']) ? (int)$item['rating'] : 0;
                                    for ($i = 0; $i < 5; $i++) {
                                        echo $i < $stars
                                             ? '<i class="fas fa-star"></i>'
                                             : '<i class="far fa-star"></i>';
                                    }
                                    ?>
                                </div>
                                <form method="post">
                                    <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                    <!-- Сагсанд нэмэх товчийг ингэж солино -->
                                    <a href="product.php?item_id=<?php echo $item['item_id']; ?>" class="btn btn-success mt-2">Танилцах</a>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center p-5">
                    <i class="fas fa-info-circle fa-2x text-warning mb-3"></i>
                    <h5>Хайлтын шалгуурт тохирох бүтээгдэхүүн олдсонгүй</h5>
                    <a href="index.php" class="btn btn-primary mt-3">Нүүр хуудас руу буцах</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
