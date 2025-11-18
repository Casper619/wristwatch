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

// Хүснэгтэд өгөгдөл байгаа эсэхийг шалгах
$check_sql = "SELECT COUNT(*) as count FROM reviews";
$result = $conn->query($check_sql);
$row = $result->fetch_assoc();

// Хэрэв хүснэгтэд өгөгдөл байхгүй бол анхны өгөгдлүүдийг оруулах
if ($row['count'] == 0) {
    // Эхлээд харагдах сэтгэгдлүүдийг мэдээллийн санд хадгалах
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
    
    // Өгөгдлүүдийг оруулах
    $insert_initial = "INSERT INTO reviews (name, image, comment, rating) VALUES (?, ?, ?, ?)";
    $stmt_initial = $conn->prepare($insert_initial);
    
    foreach($initial_reviews as $review) {
        $stmt_initial->bind_param("sssd", $review['name'], $review['image'], $review['comment'], $review['rating']);
        $stmt_initial->execute();
    }
    $stmt_initial->close();
    
    echo "Анхны сэтгэгдлүүдийг амжилттай нэмлээ!";
} else {
    echo "Мэдээллийн санд сэтгэгдлүүд аль хэдийн байна.";
}

// Холболтыг хаах
$conn->close();
?>