<?php
// Өгөгдлийн сантай холбогдох
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "watch"; // Таны өгөгдлийн сангийн нэр

$conn = new mysqli($servername, $username, $password, $dbname);

// Холболтыг шалгах
if ($conn->connect_error) {
    die("Холболт амжилтгүй болсон: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Сэтгэгдэл нэмэх үйлдэл
if(isset($_POST['submit_review'])) {
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];
    
    // Зургийн холбоосыг зөв хадгалах
    $image = "";
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "image/";
        $file_name = basename($_FILES['image']['name']);
        $target_file = $target_dir . $file_name;
        
        // Зураг оруулах
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file;
        }
    }
    
    // Мэдээллийн санд хадгалах
    $sql = "INSERT INTO reviews (name, comment, rating, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $name, $comment, $rating, $image);
    
    if($stmt->execute()) {
        $success_message = "Таны сэтгэгдлийг амжилттай хадгаллаа!";
    } else {
        $error_message = "Алдаа гарлаа: " . $stmt->error;
    }
    $stmt->close();
}

// Сэтгэгдлүүдийг авах
$reviews_sql = "SELECT * FROM reviews ORDER BY created_at DESC";
$reviews_result = $conn->query($reviews_sql);
?>
<!-- Сэтгэгдэл харуулах хэсэг -->
<section class="reviews-section" id="reviews">
    <style>
        /* Review Section */
.reviews-section {
    padding: 3rem 0;
}

.reviews-section .heading {
    text-align: center;
    margin-bottom: 2rem;
    font-size: 3rem;
    color: var(--black);
}

.reviews-section .heading span {
    position: relative;
    z-index: 0;
    padding: .5rem 2rem;
}

.reviews-section .heading span::before {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    height: 100%;
    width: 100%;
    background: var(--green);
    z-index: -1;
    clip-path: polygon(0 0, 100% 0, 92% 100%, 8% 100%);
}

.reviews-section .btn-container {
    text-align: center;
    margin-bottom: 3rem;
}

.reviews-section .btn {
    display: inline-block;
    margin-top: 1rem;
    padding: .9rem 3rem;
    background: var(--green);
    color: #fff;
    font-size: 1.7rem;
    cursor: pointer;
    border-radius: .5rem;
    font-weight: 500;
    text-transform: capitalize;
    transition: .2s linear;
}

.reviews-section .btn:hover {
    background: var(--dark-color);
    color: #fff;
}

.reviews-section .swiper-wrapper {
    display: flex;
    gap: 1rem;
    padding: 1rem;
}

.reviews-section .swiper-slide.box {
    border: var(--border);
    padding: 2rem;
    text-align: center;
    margin: 2rem 0;
    flex: 0 0 auto;
    width: 300px;
    transition: all 0.3s ease;
}

.reviews-section .swiper-slide.box:hover {
    border: var(--border-hover);
    transform: translateY(-5px);
}

.reviews-section .swiper-slide.box img {
    height: 7rem;
    width: 7rem;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 1rem;
    border: 2px solid var(--green);
}

.reviews-section .swiper-slide.box h3 {
    color: var(--black);
    font-size: 2.2rem;
    padding: .5rem 0;
}

.reviews-section .swiper-slide.box p {
    color: var(--light-color);
    font-size: 1.4rem;
    padding: 1rem 0;
    line-height: 2;
}

.reviews-section .swiper-slide.box .stars {
    font-size: 1.7rem;
    color: var(--green);
}

/* Form modal styles */
.reviews-section .modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.7);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.reviews-section .modal.show {
    display: block;
    opacity: 1;
}

.reviews-section .review-form-container {
    max-width: 600px;
    margin: 5% auto;
    background: #fff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
    position: relative;
    transform: translateY(-20px);
    opacity: 0;
    transition: all 0.3s ease;
    border: 2px solid var(--green);
}

.reviews-section .modal.show .review-form-container {
    transform: translateY(0);
    opacity: 1;
}

.reviews-section .review-form-container h2 {
    text-align: center;
    color: var(--green);
    margin-bottom: 1.5rem;
    font-size: 2.2rem;
}

.reviews-section .review-form {
    display: grid;
    grid-gap: 1.5rem;
}

.reviews-section .form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
    color: var(--black);
    font-size: 1.4rem;
}

.reviews-section .form-group input,
.reviews-section .form-group textarea,
.reviews-section .form-group select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background: #f9f9f9;
    font-size: 1.4rem;
    transition: all 0.3s ease;
}

.reviews-section .form-group input:focus,
.reviews-section .form-group textarea:focus,
.reviews-section .form-group select:focus {
    border-color: var(--green);
    outline: none;
}

.reviews-section .form-group textarea {
    height: 120px;
    resize: vertical;
}

.reviews-section .btn-full {
    width: 100%;
}

.reviews-section .close-btn {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 24px;
    color: #999;
    background: none;
    border: none;
    cursor: pointer;
    transition: color 0.3s;
}

.reviews-section .close-btn:hover {
    color: var(--black);
}

.reviews-section .success-message,
.reviews-section .error-message {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 6px;
    text-align: center;
    font-weight: bold;
    font-size: 1.4rem;
}

.reviews-section .success-message {
    background-color: rgba(46, 204, 113, 0.2);
    border: 1px solid #2ecc71;
    color: #27ae60;
}

.reviews-section .error-message {
    background-color: rgba(231, 76, 60, 0.2);
    border: 1px solid #e74c3c;
    color: #c0392b;
}

/* For swiper functionality */
@media (max-width: 768px) {
    .reviews-section .swiper-slide.box {
        width: 250px;
    }
}

/* Additional responsive styles */
@media (max-width: 450px) {
    .reviews-section .heading {
        font-size: 2.5rem;
    }
    
    .reviews-section .swiper-slide.box {
        width: 100%;
    }
    
    .reviews-section .btn {
        padding: .7rem 2rem;
        font-size: 1.5rem;
    }
    
    .reviews-section .swiper-slide.box h3 {
        font-size: 1.8rem;
    }
    
    .reviews-section .swiper-slide.box p {
        font-size: 1.2rem;
    }
}
    </style>

    <h1 class="heading"><span>Хэрэглэгчийн сэтгэгдэл</span></h1>

   

    <!-- Сэтгэгдэл нэмэх товч -->
    <div class="btn-container">
        <button class="btn" id="addReviewBtn">Сэтгэгдэл нэмэх</button>
    </div>

    <!-- Модал цонх -->
    <div id="reviewModal" class="modal">
        <!-- Сэтгэгдэл нэмэх форм -->
        <div class="review-form-container">
            <button class="close-btn" id="closeModal">&times;</button>
            <h2>Сэтгэгдэл нэмэх</h2>
            <form method="post" enctype="multipart/form-data" class="review-form">
                <div class="form-group">
                    <label for="name">Нэр:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="comment">Сэтгэгдэл:</label>
                    <textarea id="comment" name="comment" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="rating">Үнэлгээ:</label>
                    <select id="rating" name="rating" required>
                        <option value="5">5 од (Маш сайн)</option>
                        <option value="4">4 од (Сайн)</option>
                        <option value="3">3 од (Дундаж)</option>
                        <option value="2">2 од (Муу)</option>
                        <option value="1">1 од (Маш муу)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="image">Зураг (заавал биш):</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                
                <button type="submit" name="submit_review" class="btn btn-full">Илгээх</button>
            </form>
        </div>
    </div>

    <!-- Сэтгэгдлүүдийг харуулах хэсэг -->
    <div class="swiper reviews-slider">
        <div class="swiper-wrapper">
            <?php
            // Мэдээллийн сангаас авсан сэтгэгдлүүдийг харуулах
            if ($reviews_result->num_rows > 0) {
                while($review = $reviews_result->fetch_assoc()) {
                    echo '<div class="swiper-slide box">';
                    
                    // Зураг байгаа эсэхийг шалгах
                    if(!empty($review['image'])) {
                        echo '<img src="' . $review['image'] . '" alt="' . $review['name'] . '">';
                    } else {
                        echo '<img src="image/default-user.png" alt="Default user">';
                    }
                    
                    echo '<h3>' . htmlspecialchars($review['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($review['comment']) . '</p>';
                    
                    // Одны үнэлгээг харуулах
                    echo '<div class="stars">';
                    for($i = 1; $i <= 5; $i++) {
                        if($i <= $review['rating']) {
                            echo '<i class="fas fa-star"></i>';
                        } elseif($i - 0.5 <= $review['rating']) {
                            echo '<i class="fas fa-star-half-alt"></i>';
                        } else {
                            echo '<i class="far fa-star"></i>';
                        }
                    }
                    echo '</div>';
                    
                    echo '</div>';
                }
            } else {
                // Эхний удаад өгөгдлийн санд зааж өгсөн сэтгэгдлүүдийг харуулах (нэг удаа)
                ?>
                <div class="swiper-slide box">
                    <img src="image/Turuu.jpg" alt="image">
                    <h3>Мөнхтөр</h3>
                    <p>Би олон жилийн турш Raizen цагны дэлгүүрээс худалдан авалтаа хийж байна.
                    Үргэлж чанартай, хямд цагуудыг бидэнд санал болгодог.
                    Яг одоо захиал харамсахгүй гэдэгт чинь итгэлтэй байна.</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="image/Naba.png" alt="image">
                    <h3>Наранбаатар</h3>
                    <p>Би энэ сайтаар үйлчлүүлэхэд үнэхээр сайхан байдаг! Энэ газрын цагууд гоёмсог, загвар сайтай,
                    ямар ч нөхцөл байдалд тохирох төгс бүтээл. Мөн энэ сайтыг хийсэн Мөнхтөр гээд оюутанд хандаж хэлэхэд чи мундаг шүү <3 .</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="image/Enke.jpg" alt="image">
                    <h3>Энхтүвшин</h3>
                    <p>Миний шинэ цаг үнэхээр гайхалтай байна. Бат бөх, зүүхэд авсаархан, хөнгөн гэж жигтээхэн 
                    . Үнэхээр гоё байнаа</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="image/Tugu.jpg" alt="image">
                    <h3>Төгөлдөр</h3>
                    <p>Юуны түрүүнд амархан захиалдаг дажгүй сайт оллоо. Одоо цагаа авах л үлдлээ муричваа.</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="image/Tsomo.jpg" alt="image">
                    <h3>Цолмон-эрдэнэ</h3>
                    <p>Яаж ийм хүмүүст ээлтэй зүйлсийн хийдэг байнаа. Энэ сайтыг хийсэн хүнд онц тавиарай. Гал2</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="image/Puujee.png" alt="image">
                    <h3>Пүрэвжав</h3>
                    <p>Арай хямдхан цаг байхгүй юу. Цалин дууслаа.</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <?php
                
                // Эхлээд харагдах сэтгэгдлүүдийг мэдээллийн санд хадгалах (ирээдүйд харуулах)
                $initial_reviews = [
                    [
                        'name' => 'Мөнхтөр',
                        'image' => 'image/Turuu.jpg',
                        'comment' => 'Би олон жилийн турш Raizen цагны дэлгүүрээс худалдан авалтаа хийж байна. Үргэлж чанартай, хямд цагуудыг бидэнд санал болгодог. Яг одоо захиал харамсахгүй гэдэгт чинь итгэлтэй байна.',
                        'rating' => 4.5
                    ],
                    [
                        'name' => 'Наранбаатар',
                        'image' => 'image/Naba.png',
                        'comment' => 'Би энэ сайтаар үйлчлүүлэхэд үнэхээр сайхан байдаг! Энэ газрын цагууд гоёмсог, загвар сайтай, ямар ч нөхцөл байдалд тохирох төгс бүтээл. Мөн энэ сайтыг хийсэн Мөнхтөр гээд оюутанд хандаж хэлэхэд чи мундаг шүү <3.',
                        'rating' => 4.5
                    ],
                    [
                        'name' => 'Энхтүвшин',
                        'image' => 'image/Enke.jpg',
                        'comment' => 'Миний шинэ цаг үнэхээр гайхалтай байна. Бат бөх, зүүхэд авсаархан, хөнгөн гэж жигтээхэн. Үнэхээр гоё байнаа',
                        'rating' => 4.5
                    ],
                    [
                        'name' => 'Төгөлдөр',
                        'image' => 'image/Tugu.jpg',
                        'comment' => 'Юуны түрүүнд амархан захиалдаг дажгүй сайт оллоо. Одоо цагаа авах л үлдлээ муричваа.',
                        'rating' => 4.5
                    ],
                    [
                        'name' => 'Цолмон-эрдэнэ',
                        'image' => 'image/Tsomo.jpg',
                        'comment' => 'Яаж ийм хүмүүст ээлтэй зүйлсийн хийдэг байнаа. Энэ сайтыг хийсэн хүнд онц тавиарай. Гал2',
                        'rating' => 4.5
                    ],
                    [
                        'name' => 'Пүрэвжав',
                        'image' => 'image/Puujee.png',
                        'comment' => 'Арай хямдхан цаг байхгүй юу. Цалин дууслаа.',
                        'rating' => 5
                    ]
                ];
                
                // Эхний удаад эдгээр сэтгэгдлүүдийг мэдээллийн санд нэмэх
                $insert_initial = "INSERT INTO reviews (name, image, comment, rating) VALUES (?, ?, ?, ?)";
                $stmt_initial = $conn->prepare($insert_initial);
                
                foreach($initial_reviews as $review) {
                    $stmt_initial->bind_param("sssd", $review['name'], $review['image'], $review['comment'], $review['rating']);
                    $stmt_initial->execute();
                }
                $stmt_initial->close();
            }
            ?>
        </div>
    </div>

    <!-- JavaScript код модал цонхны үйл ажиллагаанд -->
    <script>
        // Элементүүдийг барих
        const reviewModal = document.getElementById('reviewModal');
        const openReviewBtn = document.getElementById('addReviewBtn');
        const closeReviewBtn = document.getElementById('closeModal');

        // Модал цонхыг нээх
        openReviewBtn.addEventListener('click', function() {
            reviewModal.classList.add('show');
        });

        // Модал цонхыг хаах
        closeReviewBtn.addEventListener('click', function() {
            reviewModal.classList.remove('show');
        });

        // Модал гадна талд дарахад хаах
        window.addEventListener('click', function(event) {
            if (event.target === reviewModal) {
                reviewModal.classList.remove('show');
            }
        });
    </script>
</section>

<?php
// Холболтыг хаах
$conn->close();
?>
