<!-- Catalog Section --> 
<?php
    $product_all = $product_shuffle;
    shuffle($product_all);
    
    // Collect unique subjects for filters
    $sub = array_map(function($pro){return $pro['subject'];}, $product_all);
    $unique_subjects = array_unique($sub);
    sort($unique_subjects);
    
    // Pagination and filter parameters
    $items_per_page = 12; // Items per page
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $current_filter = isset($_GET['filter']) ? $_GET['filter'] : '*';

    // Apply filter
    $filtered_products = $product_all;
    if ($current_filter != '*') {
        $filtered_products = array_filter($product_all, function($item) use ($current_filter) {
            return $item['subject'] == $current_filter;
        });
    }

    // Sort by price ascending (cheapest first)
    usort($filtered_products, function($a, $b) {
        return $a['item_price'] <=> $b['item_price'];
    });

    // Calculate total pages
    $total_items = count($filtered_products);
    $total_pages = ceil($total_items / $items_per_page);
    
    // Ensure current page is valid
    if ($current_page < 1) $current_page = 1;
    if ($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages;
    
    // Slice products for current page
    $start_index = ($current_page - 1) * $items_per_page;
    $current_items = array_slice($filtered_products, $start_index, $items_per_page);
    
    // Handle add to cart
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['catalog_submit'])) {
        $Cart->addToCart($_POST['user_id'], $_POST['item_id']);
    }
?>

<html>
<head>
    <link rel="stylesheet" href="./HTML Template/catalog.css">
    <style>
        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            list-style: none;
            padding: 0;
        }
        .pagination li { margin: 0 5px; }
        .pagination li a {
            display: block;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #f8f9fa;
            color: #333;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .pagination li.active a { background-color: #007bff; color: #fff; }
        .pagination li a:hover:not(.active) { background-color: #ddd; }
        .pagination .disabled a { color: #aaa; cursor: not-allowed; }
    </style>
</head>
<main id="main-site">
    <!-- Special Price -->
    <section id="special-price">
        <div class="container mt-5">
            <h4 class="font-rubik font-size-20">Онцгой үнэ</h4>
            <div id="filter" class="button-group text-end font-baloo font-size-16">
                <button class="btn <?php echo $current_filter == '*' ? 'is-checked' : ''; ?>" data-filter="*">Бүх бүтээгдэхүүн</button>
                <?php foreach($unique_subjects as $subject):
                    $display_name = ($subject == 'Эрэгтэй' || $subject == 'Эмэгтэй') ? $subject : $subject;
                ?>
                <button class="btn <?php echo $current_filter == $subject ? 'is-checked' : ''; ?>" data-filter=".<?php echo $subject; ?>"><?php echo $display_name; ?></button>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="grid">
            <?php foreach($current_items as $item): ?>
            <div class="box <?php echo $item['subject']; ?>">
                <a href="<?php printf('%s?item_id=%s','product.php',$item['item_id']); ?>">
                    <div class="image">
                        <img src="<?php echo './products/' . basename($item['item_image']) . '?v=' . time(); ?>"
                             alt="<?php echo htmlspecialchars($item['item_name']); ?>"
                             onerror="this.onerror=null; this.src='./products/default.jpg';">
                    </div>
                    <div class="content">
                        <h3><?php echo htmlspecialchars($item['item_brand']); ?></h3>
                        <h4><?php echo htmlspecialchars($item['item_name']); ?></h4>
                        <div class="price"><?php echo number_format($item['item_price']); ?>₮<span>1000000₮</span></div>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <form method="post">
                            <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <button type="submit" name="catalog_submit" class="btn">Сагсанд нэмэх</button>
                        </form>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if($total_pages > 1): ?>
        <ul class="pagination">
            <li class="<?php echo $current_page <= 1 ? 'disabled' : ''; ?>">
                <a href="<?php echo $current_page <= 1 ? '#' : '?page='.($current_page-1).'&filter='.$current_filter; ?>">&laquo; Өмнөх</a>
            </li>
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <li class="<?php echo $current_page == $i ? 'active' : ''; ?>">
                <a href="?page=<?php echo $i; ?>&filter=<?php echo $current_filter; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>
            <li class="<?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">
                <a href="<?php echo $current_page >= $total_pages ? '#' : '?page='.($current_page+1).'&filter='.$current_filter; ?>">Дараах &raquo;</a>
            </li>
        </ul>
        <?php endif; ?>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('#filter button');
        buttons.forEach(button => {
            button.addEventListener('click', function () {
                buttons.forEach(btn => btn.classList.remove('is-checked'));
                button.classList.add('is-checked');
                const filter = button.getAttribute('data-filter');
                const clean = filter === '*' ? '*' : filter.substring(1);
                window.location.href = '?page=1&filter=' + clean;
            });
        });
    });
</script>

<!-- !Catalog Section -->
