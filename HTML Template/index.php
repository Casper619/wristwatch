<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Website</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Swiper CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Bootstrap
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->

    <!-- Custom Css -->
    <link rel="stylesheet" href="index.css">

</head>
<body>

<!-- header section -->

<header class="header">

    <div class="header-1">
        <a href="#" class="logo"><img src="../assets/logo/BOOK (4).png" alt=""></a>

        <form action="" class="search-form">
            <input type="search" name="" placeholder="search here..." id="search-box">
            <label for="search-box" class="fas fa-search"></label>
        </form>

        <div class="icons">
            <div id="search-btn" class="fas fa-search"></div>
            <a href="#" class="fa-solid fa-heart"></a>
            <a href="cart.html" class="fas fa-shopping-cart"></a>
            <div id="login-btn" class="fas fa-user"></div>
        </div>
    </div>

    <div class="header-2">
        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#featured">Featured</a>
            <a href="#arrivals">Arrivals</a>
            <a href="#reviews">Reviews</a>
            <a href="#blogs">Blogs</a>
            <a href="catalog.html">Catalog</a>
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


<!-- login form -->

<div class="login-form-container">

    <div id="close-login-btn" class="fas fa-times">

    </div>

    <form action="">
        <h3>Бүртгүүлэх</h3>
        <span>Хэрэглэгчийн нэр</span>
        <input type="email" name="" class="box" placeholder="Enter your Email" id="">
        <span>Password</span>
        <input type="password" name="" class="box" placeholder="Enter your Password" id="">
        <div class="checkbox">
            <input type="checkbox" name="" id="remember-me">
            <label for="remember-me"> remember me </label>
        </div>
        <input type="submit" value="sign in" class="btn">
        <p>forget password ? <a href="#">click here</a></p>
        <p>don't have an account ? <a href="#">click here</a></p>
    </form>

</div>

<!-- !login form -->


<!-- Home Section -->

<section class="home" id="home">

    <div class="row">
        
        <div class="content">
            <h3>upto 75% off</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Enim rem perspiciatis odit porro aliquam debitis deleniti accusantium ipsam eos possimus!</p>
            <a href="#" class="btn">Shop Now</a>
        </div>

        <div class="swiper books-slider">
            <div class="swiper-wrapper">
                <a href="#" class="swiper-slide"><img src="../assets/image/book_13.png" alt="images"></a>
                <a href="#" class="swiper-slide"><img src="../assets/image/book_14.png" alt="images"></a>
                <a href="#" class="swiper-slide"><img src="../assets/image/book_7.png" alt="images"></a>
                <a href="#" class="swiper-slide"><img src="../assets/image/book_8.png" alt="images"></a>
                <a href="#" class="swiper-slide"><img src="../assets/image/book_12.png" alt="images"></a>
                <a href="#" class="swiper-slide"><img src="../assets/image/book_10.png" alt="images"></a>
            </div>
            <img src="../assets/image/book-stand.png" class="stand" alt="book-stand">
        </div>

    </div>

</section>

<!-- !Home Section -->


<!-- Icons Section -->

<section class="icons-container">

    <div class="icons">
        <i class="fas fa-plane"></i>
        <div class="content">
            <h3>Free Shipping</h3>
            <p>Order Over ₹500</p>
        </div>
    </div>

    <div class="icons">
        <i class="fas fa-lock"></i>
        <div class="content">
            <h3>Secure Payment</h3>
            <p>100 secure payment</p>
        </div>
    </div>

    <div class="icons">
        <i class="fas fa-redo-alt"></i>
        <div class="content">
            <h3>Easy Return</h3>
            <p>10 days returns</p>
        </div>
    </div>

    <div class="icons">
        <i class="fas fa-headset"></i>
        <div class="content">
            <h3>24/7 Support</h3>
            <p>call us anytime</p>
        </div>
    </div>
</section>

<!-- !Icons Section -->


<!-- Featured Section -->
<?php
    include('function.php');
    $product_featured = $product->getData();
?>
<section class="featured" id="featured">
    <h1 class="heading"><span>Featured Books</span></h1>

    <div class="swiper featured-slider">
        
        <div class="swiper-wrapper">
        <?php foreach($product_featured as $item) { ?>
            <div class="swiper-slide box">
                <div class="icons">
                    <a href="#" class="fas fa-search"></a>
                    <a href="#" class="fas fa-heart"></a>
                    <a href="#" class="fas fa-eye"></a>
                </div>
                <div class="image">
                    <img src="<?php echo $item['item_image'];?>" alt="images">
                </div>
                <div class="content">
                    <h3><?php echo $item['item_brand'] ?></h3>
                    <div class="price">₹<?php echo $item['item_price'] ?><span>₹500</span></div>
                    <a href="#" class="btn">Add To Cart</a>
                </div>
            </div>
        <?php } //closing foreach function?>
        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

</section>

<!-- !Features Section -->


<!-- NewLetter Section -->

<section class="newsletter">

    <form action="">
        <h3>Subscribe for latest updates</h3>
        <input type="email" name="" placeholder="Enter Your Email" id="" class="box">
        <input type="submit" value="Subscribe" class="btn">
    </form>

</section>

<!-- !NewLetter Section -->


<!-- Article Section -->

<section class="arrivals" id="arrivals">
    <h1 class="heading"><span>New Arrivals</span></h1>

    <div class="swiper arrivals-slider">

        <div class="swiper-wrapper">

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/harry-potter-book.png" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/harry-potter-book2.png" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/harry-potter-book3.webp" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-25.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-26.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-27.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-28.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-29.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-30.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-32.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

        </div>

    </div>

    <div class="swiper arrivals-slider">

        <div class="swiper-wrapper">

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/harry-potter-book.png" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/harry-potter-book2.png" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/harry-potter-book3.webp" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-25.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-26.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-27.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-28.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-29.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-30.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

            <a href="#" class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/book-32.jpg" alt="image">
                </div>
                <div class="content">
                    <h3>New Arrivals</h3>
                    <div class="price">₹200 <span>₹500</span></div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>

        </div>

    </div>
</section>

<!-- !Article Section -->


<!-- Deal Section -->

<section class="deal">

    <div class="content">
        <h3>Deal of the day</h3>
        <h1>Upto 50% off</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
        Rem, blanditiis? Sapiente tenetur nostrum quidem enim cupiditate, 
        dignissimos impedit qui dolores.</p>
        <a href="#" class="btn">Shop Now</a>
    </div>

    <div class="image">
        <img src="../assets/image/table.png" alt="image">
    </div>

</section>

<!-- !Deal Section -->


<!-- Review Section -->

<section class="reviews" id="reviews">
    <h1 class="heading"><span>Client's Review</span></h1>

    <div class="swiper reviews-slider">

        <div class="swiper-wrapper">

            <div class="swiper-slide box">
                <img src="../assets/image/review_5.webp" alt="image">
                <h3>Shashank Shewale</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                    Distinctio, adipisci iste? Voluptatum perspiciatis vero quas similique. 
                    Modi est ut laborum.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="../assets/image/review_2.png" alt="image">
                <h3>Alice Fernades</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                    Distinctio, adipisci iste? Voluptatum perspiciatis vero quas similique. 
                    Modi est ut laborum.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="../assets/image/review_1.png" alt="image">
                <h3>John Deo</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                    Distinctio, adipisci iste? Voluptatum perspiciatis vero quas similique. 
                    Modi est ut laborum.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="../assets/image/review_4.png" alt="image">
                <h3>Mary D'souza</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                    Distinctio, adipisci iste? Voluptatum perspiciatis vero quas similique. 
                    Modi est ut laborum.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="../assets/image/review_3.png" alt="image">
                <h3>John Bright</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                    Distinctio, adipisci iste? Voluptatum perspiciatis vero quas similique. 
                    Modi est ut laborum.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="../assets/image/review_6.jpg" alt="image">
                <h3>Tanay Rambhia</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                    Distinctio, adipisci iste? Voluptatum perspiciatis vero quas similique. 
                    Modi est ut laborum.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class="swiper-slide box">
                <img src="../assets/image/review_7.jpg" alt="image">
                <h3>Sujal Jain</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                    Distinctio, adipisci iste? Voluptatum perspiciatis vero quas similique. 
                    Modi est ut laborum.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>

        </div>

    </div>

</section>

<!-- !Review Section -->


<!-- Blog Section -->

<section class="blogs" id="blogs">

    <h1 class="heading"><span>Our Blogs</span></h1>

    <div class="swiper blogs-slider">
        <div class="swiper-wrapper">
            
            <div class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/blog_1.jpg" alt="images">
                </div>
                <div class="content">
                    <h3>Blog Title</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid, suscipit!</p>
                    <a href="#" class="btn">Read More</a>
                </div>
            </div>

            <div class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/blog_2.jpg" alt="images">
                </div>
                <div class="content">
                    <h3>Blog Title</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid, suscipit!</p>
                    <a href="#" class="btn">Read More</a>
                </div>
            </div>

            <div class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/blog_3.jpg" alt="images">
                </div>
                <div class="content">
                    <h3>Blog Title</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid, suscipit!</p>
                    <a href="#" class="btn">Read More</a>
                </div>
            </div>

            <div class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/blog_4.jpg" alt="images">
                </div>
                <div class="content">
                    <h3>Blog Title</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid, suscipit!</p>
                    <a href="#" class="btn">Read More</a>
                </div>
            </div>

            <div class="swiper-slide box">
                <div class="image">
                    <img src="../assets/image/blog_5.jpg" alt="images">
                </div>
                <div class="content">
                    <h3>Blog Title</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid, suscipit!</p>
                    <a href="#" class="btn">Read More</a>
                </div>
            </div>

        </div>
    </div>

</section>

<!-- !Blog Section -->


<!-- Footer Section -->

<section class="footer">

    <div class="box-container">
        <div class="box">
            <h3>Our Location</h3>
            <a href="#"><i class="fa-solid fa-location-dot"></i>India</a>
            <a href="#"><i class="fa-solid fa-location-dot"></i>USA</a>
            <a href="#"><i class="fa-solid fa-location-dot"></i>Russia</a>
            <a href="#"><i class="fa-solid fa-location-dot"></i>France</a>
            <a href="#"><i class="fa-solid fa-location-dot"></i>Japan</a>
            <a href="#"><i class="fa-solid fa-location-dot"></i>Africa</a>
        </div>

        <div class="box">
            <h3>Quick Links</h3>
            <a href="#"><i class="fas fa-arrow-right"></i>Home</a>
            <a href="#"><i class="fas fa-arrow-right"></i>Features</a>
            <a href="#"><i class="fas fa-arrow-right"></i>Arrivals</a>
            <a href="#"><i class="fas fa-arrow-right"></i>Reviews</a>
            <a href="#"><i class="fas fa-arrow-right"></i>Blogs</a>
        </div>

        <div class="box">
            <h3>Extra Links</h3>
            <a href="#"><i class="fas fa-arrow-right"></i>Account Info</a>
            <a href="#"><i class="fas fa-arrow-right"></i>Ordered Items</a>
            <a href="#"><i class="fas fa-arrow-right"></i>Privacy Policy</a>
            <a href="#"><i class="fas fa-arrow-right"></i>Payment Method</a>
            <a href="#"><i class="fas fa-arrow-right"></i>Our Services</a>
        </div>

        <div class="box">
            <h3>Contect Info</h3>
            <a href="#"><i class="fas fa-phone"></i>+123-456-7890</a>
            <a href="#"><i class="fas fa-phone"></i>+111-222-3333</a>
            <a href="#"><i class="fas fa-envelope"></i>magicbook@gmail.com</a>
            <img src="../assets/image/world-map.png" class="map" alt="images">
        </div>

    </div>

    <div class="share">
        <a href="#" class="fa-brands fa-facebook"></a>
        <a href="#" class="fa-brands fa-twitter"></a>
        <a href="#" class="fa-brands fa-instagram"></a>
        <a href="#" class="fa-brands fa-linkedin"></a>
        <a href="#" class="fa-brands fa-pinterest"></a>
    </div>

    <div class="credit">Created By <span>Atharva Shewale & Soham Sonavane</span> | all rights reserved! </div>

</section>

<!-- !Footer Section -->


<!-- Loader -->

<!-- <div class="loader-container">
    <img src="assets/image/loader-book.gif" alt="">
</div> -->

<!-- !Loader -->





    
    <!-- Custom JS -->
    <script src="js/index.js"></script>

    <!-- Swiper Jscript -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


</body>
</html>