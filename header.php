<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Website</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Swiper CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Custom Css -->
    <link rel="stylesheet" href="index.css">

    <?php
    // function.php-ыг include хийнэ
    require_once __DIR__ . '/function.php';

    // DBController-г database хавтаснаас include хийнэ
    $dbControllerFile = __DIR__ . '/database/DBController.php';
    if (file_exists($dbControllerFile)) {
        require_once $dbControllerFile;
        $db = new DBController();
    } else {
        // Алдаа гарсан бол цааш үргэлжлүүлэхгүй
        die("<div style='color: red; padding: 10px; margin: 10px 0; 
                  border: 1px solid red; background: #ffeeee;'>
                 Алдаа: database/DBController.php файл олдсонгүй!
             </div>");
    }

    // Мессежүүдийн анхны утга
    $error_message   = "";
    $success_message = "";

    // Бүртгүүлэх (register) логик
    if (isset($_POST['register'])) {
        // Оролтыг цэвэрлэх, хамгаалах
        $username = $db->escapeString(trim($_POST['username'] ?? ''));
        $password = $db->escapeString(trim($_POST['password'] ?? ''));
        $email    = $db->escapeString(trim($_POST['email']    ?? ''));
        $owog     = $db->escapeString(trim($_POST['owog']     ?? ''));
        $ner      = $db->escapeString(trim($_POST['ner']      ?? ''));
        $phone    = $db->escapeString(trim($_POST['phone']    ?? ''));

        // Шаардлагатай талбаруудыг шалгах
        if (empty($username) || empty($password) || empty($email)) {
            $error_message = "Хэрэглэгчийн нэр, нууц үг, имэйл хаягийг заавал оруулна уу!";
        } else {
            // Шинэ хэрэглэгчийн давхардах эсэхийг шалгах
            $users  = $db->runQuery("SELECT username, email FROM `user`");
            $exists = false;
            foreach ($users as $u) {
                if ($u['username'] === $username) {
                    $error_message = "Энэ хэрэглэгчийн нэр аль хэдийн бүртгэгдсэн байна!";
                    $exists = true;
                    break;
                }
                if ($u['email'] === $email) {
                    $error_message = "Энэ имэйл хаяг аль хэдийн бүртгэгдсэн байна!";
                    $exists = true;
                    break;
                }
            }

            // Хэрвээ шинэ бол нэмэх
            if (! $exists) {
                $sql = "
                    INSERT INTO `user`
                        (username, password, user_type_code, email, owog, ner, utasnii_dugaar)
                    VALUES
                        ('{$username}', '{$password}', 'consumer', 
                         '{$email}', '{$owog}', '{$ner}', '{$phone}')
                ";
                if ($db->con->query($sql)) {
                    $success_message = 
                        "Бүртгэл амжилттай үүслээ! 3 секундийн дараа нэвтрэх форм гарна...";
                    echo "<script>
                            setTimeout(() => {
                                document.getElementById('login-form').style.display = 'block';
                                document.getElementById('register-form').style.display = 'none';
                            }, 3000);
                          </script>";
                } else {
                    $error_message = 
                        "Бүртгэл үүсгэхэд алдаа гарлаа: " . $db->con->error;
                }
            }
        }
    }

    // Нэвтрэх (login) логик
    if (isset($_POST['login'])) {
        $is_user_found = false;
        $users = $db->runQuery("SELECT * FROM `user`");
        
        if (!empty($users)) {
            foreach ($users as $user) {
                if (
                    isset($user['username'], $user['password']) &&
                    $user['username'] === $_POST['user'] &&
                    $user['password'] === $_POST['pass']
                ) {
                    $is_user_found = true;
                    // 30 хоногийн cookie
                    $expiration = time() + (86400 * 30); // 30 days
                    
                    if (isset($_COOKIE['user_id'])) {
                        unset($_COOKIE['user_id']);
                    }
                    
                    setcookie("user_id", $user['user_id'], $expiration, "/");
                    
                    // Access түлхүүр байгаа эсэхийг шалгах
                    if (isset($user['user_type_code'])) {
                        // Хэрвээ admin бол админ хуудас руу шилжих
                        if ($user['user_type_code'] === 'admin') {
                            header("Location: adminpanel.php");
                            exit;
                        } else {
                            // Бусад хэрэглэгчдийг үндсэн хуудас руу шилжүүлэх
                            header("Location: index.php");
                            exit;
                        }
                    } else {
                        // Access түлхүүр байхгүй бол үндсэн хуудас руу шилжих
                        header("Location: index.php");
                        exit;
                    }
                }
            }
        }
        
        if (!$is_user_found) {
            $error_message = "Хэрэглэгчийн нэр эсвэл нууц үг буруу байна!";
        }
    }
    ?>
</head>
<body>

<!-- header section -->
<header class="header">
    <div class="header-1">
        <a href="index.php#home" class="logo">
            <img src="logo/Raizen.jpg" alt="Logo">
        </a>

        <form action="search.php" method="GET" class="search-form">
            <input type="search" name="query" placeholder="хайлт хийх..." id="search-box" required>
            <label for="search-box" class="fas fa-search"></label>
        </form>
        
        <div class="icons">
            <div id="search-btn" class="fas fa-search"></div>
            <a href="cart.php" class="fas fa-shopping-cart"></a>
            <?php
            if (isset($_COOKIE['user_id'])) {
                $all_users = $db->runQuery("SELECT * FROM `user`");
                $current_user = null;
                
                foreach ($all_users as $u) {
                    if ($u['user_id'] == $_COOKIE['user_id']) {
                        $current_user = $u;
                        break;
                    }
                }
                
                if ($current_user) {
                    echo '<span style="margin-right: 8px; font-size: 14px;">' 
                         . htmlspecialchars($current_user['username']) 
                         . '</span>';
                    echo '<a href="logout.php" class="fas fa-sign-out-alt"></a>';
                } else {
                    echo '<div id="login-btn" class="fas fa-user"></div>';
                }
            } else {
                echo '<div id="login-btn" class="fas fa-user"></div>';
            }
            ?> <div id="login-btn"></div>
        </div>
    </div>

    <div class="header-2">
        <nav class="navbar">
            <a href="index.php#home" aria-label="Эхлэл"><i class="fas fa-home" aria-hidden="true"></i></a>
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

<!-- login/register form container -->
<div class="login-form-container">
    <div id="close-login-btn" class="fas fa-times"></div>

    <!-- Login Form -->
    <div id="login-form" style="<?= $success_message ? 'display:none' : 'display:block' ?>">
        <?php if ($error_message && isset($_POST['login'])): ?>
            <div class="message error"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <form method="post">
            <h3>Нэвтрэх</h3>
            <span>Хэрэглэгчийн нэр</span>
            <input type="text" name="user" class="box" placeholder="Enter your Username" required>
            <span>Нууц үг</span>
            <input type="password" name="pass" class="box" placeholder="Enter your Password" required>
            <input type="submit" name="login" value="Нэвтрэх" class="btn">
            <p>Нууц үгээ мартсан уу? <a href="#">Энд дар</a></p>
            <p>Шинэ бүртгэл үүсгэх үү? 
               <a href="#" id="show-register-form">Энд дар</a>
            </p>
        </form>
    </div>

    <!-- Register Form -->
    <div id="register-form" style="<?= $success_message ? 'display:none' : 'display:none' ?>">
        <?php if ($error_message && isset($_POST['register'])): ?>
            <div class="message error"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="message success"><?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>
        <form method="post">
            <h3>Бүртгүүлэх</h3>
            <span>Хэрэглэгчийн нэр *</span>
            <input type="text" name="username" class="box" required>
            <span>Нууц үг *</span>
            <input type="password" name="password" class="box" required>
            <span>Имэйл хаяг *</span>
            <input type="email" name="email" class="box" required>
            <span>Овог</span>
            <input type="text" name="owog" class="box">
            <span>Нэр</span>
            <input type="text" name="ner" class="box">
            <span>Утасны дугаар</span>
            <input type="text" name="phone" class="box">
            <input type="submit" name="register" value="Бүртгүүлэх" class="btn">
            <p>Бүртгэлтэй бол <a href="#" id="show-login-form">энд дарж</a> нэвтэрнэ үү.</p>
        </form>
    </div>
</div>
<!-- !login/register form -->

<!-- Энд сайтын бусад контент үргэлжилнэ -->

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- Custom JS -->
<script src="script.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm    = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    
    // Бүртгэлийн форм руу шилжих
    document.getElementById('show-register-form')
            .addEventListener('click', e => {
        e.preventDefault();
        loginForm.style.display    = 'none';
        registerForm.style.display = 'block';
    });
    
    // Нэвтрэх форм руу шилжих
    document.getElementById('show-login-form')
            .addEventListener('click', e => {
        e.preventDefault();
        registerForm.style.display = 'none';
        loginForm.style.display    = 'block';
    });
});
</script>
</body>
</html>