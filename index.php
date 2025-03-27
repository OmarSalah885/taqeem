<?php include 'header.php'; ?>

<main>

    <div class="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="carousel-item_img"><img src="assets/images/eugene-zhyvchik-vad__5nCLJ8-unsplash.jpg"
                        alt="lolo"></div>
                <div class="carousel-item_content">
                    <div class="carousel-item_content-div">
                        <h1>Search for the
                            best restaurants out there
                        </h1>
                        <a class="btn__red--l btn__red btn">see
                            more</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-item_img"><img src="assets/images/eugene-zhyvchik-vad__5nCLJ8-unsplash.jpg"
                        alt="lolo"></div>
                <div class="carousel-item_content">
                    <div class="carousel-item_content-div">
                        <h1>Search for the
                            best restaurants out there
                        </h1>
                        <a class="btn__red--l btn__red btn">see
                            more</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-item_img"><img src="assets/images/eugene-zhyvchik-vad__5nCLJ8-unsplash.jpg"
                        alt="lolo"></div>
                <div class="carousel-item_content">
                    <div class="carousel-item_content-div">
                        <h1>Search for the
                            best restaurants out there
                        </h1>
                        <a class="btn__red--l btn__red btn">see
                            more</a>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control prev">❮</button><button class="carousel-control next">❯</button>
        <div class="carousel-indicators"><span class="indicator active" data-slide="0"></span><span class="indicator"
                data-slide="1"></span><span class="indicator" data-slide="2"></span></div>
    </div>
    <div class="categories">
        <h2 class="home-title">categories </h2>
        <div class="categories_grid">
            <div class="categories_grid--item"><a href="./listing.php?category_id=1"><img
                     src=" assets/images/categories/RESTURANTS (1).jpg" alt></a><a class="categories_grid--item_link"
                    href="./listing.html">RESTURANTS</a></div>
            <div class="categories_grid--item"><a href="./listing.php?category_id=2""><img
                     src=" assets/images/categories/SHOPPING (1).jpg" alt></a><a class="categories_grid--item_link"
                    href="./listing.html">SHOPPING</a></div>
            <div class="categories_grid--item"><a href="./listing.php?category_id=3""><img
                     src=" assets/images/categories/ACTIVE LIFE (1).jpg" alt></a><a class="categories_grid--item_link"
                    href="./listing.html">ACTIVE
                    LIFE</a>
            </div>
            <div class="categories_grid--item"><a href="./listing.php?category_id=4""><img
                     src=" assets/images/categories/HOME SERVICES (1).jpg" alt></a><a
                    class="categories_grid--item_link" href="./listing.html">HOME
                    SERVICES</a>
            </div>
            <div class="categories_grid--item"><a href="./listing.php?category_id=5"">
                  <img src=" assets/images/categories/COFFEE (1).jpg" alt></a><a class="categories_grid--item_link"
                    href="./listing.html">COFFEE</a>
            </div>
            <div class="categories_grid--item"><a href="./listing.php?category_id=6""><img
                     src=" assets/images/categories/PETS (1).jpg" alt></a><a class="categories_grid--item_link"
                    href="./listing.html">PETS</a></div>
            <div class="categories_grid--item"><a href="./listing.php?category_id=7""><img
                     src=" assets/images/categories/PLANTS SHOP (1).jpg" alt></a><a class="categories_grid--item_link"
                    href="./listing.html">PLANTS
                    SHOP</a>
            </div>
            <div class="categories_grid--item"><a href="./listing.php?category_id=8""><img
                     src=" assets/images/categories/ART (1).jpg" alt></a><a class="categories_grid--item_link"
                    href="./listing.html">ART</a></div>
            <div class="categories_grid--item"><a href="./listing.php?category_id=9""><img
                     src=" assets/images/categories/HOTELS (1).jpg" alt></a><a class="categories_grid--item_link"
                    href="./listing.html">HOTELS</a></div>
            <div class="categories_grid--item"><a href="./listing.php?category_id=10""><img
                     src=" assets/images/categories/EDUCATION (1).jpg" alt></a><a class="categories_grid--item_link"
                    href="./listing.html">EDUCATION</a></div>
            <div class="categories_grid--item"><a href="./listing.php?category_id=11""><img
                     src=" assets/images/categories/HEALTH (1).jpg" alt></a><a class="categories_grid--item_link"
                    href="./listing.html">HEALTH</a></div>
            <div class="categories_grid--item"><a href="./listing.php?category_id=12""><img
                     src=" assets/images/categories/WORKSPACE (1).jpg" alt></a><a class="categories_grid--item_link"
                    href="./listing.html">WORKSPACE</a></div>
        </div>
    </div>

    <?php
$limit = 8; // Initial limit
?>
<div class="activity">
    <h2 class="home-title">Recent Activity</h2>
    <div class="activity_grid" id="activity_grid">
        <?php
       

        $query = "SELECT r.id AS review_id, r.review_text, r.rating, r.created_at, 
                  p.name AS place_name, CONCAT(u.first_name, ' ', u.last_name) AS user_name, 
                  u.profile_image AS user_profile_image, ri.image_url AS review_image, c.icon AS icon_class
                  FROM reviews r
                  JOIN places p ON r.place_id = p.id
                  JOIN users u ON r.user_id = u.id
                  JOIN review_images ri ON r.id = ri.review_id  -- INNER JOIN to filter only reviews with images
                  JOIN categories c ON p.category_id = c.id
                  ORDER BY rand()
                  LIMIT $limit";

        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                include 'review_card.php'; // Load review card template
            }
        } else {
            echo "<p>No reviews found.</p>";
        }
        ?>
    </div>
    <button class="btn__transparent--l btn__transparent btn" id="loadMore">Load more</button>
</div>




    <div id="aboutUs" class="aboutUs">
        <div class="aboutUs_text">
            <h2>ABOUT US</h2>
            <p>Welcome to Taqeem, your ultimate guide to discovering the best
                local businesses, services, and experiences around you. At
                Taqeem, we believe in empowering communities through genuine
                reviews, ratings, and recommendations. Whether you're looking for
                the perfect café, a reliable service provider, or hidden gems in
                your city, Taqeem connects you with trusted opinions from real
                people. Join us in building a platform that celebrates
                excellence, transparency, and the spirit of exploration.
                Together, let’s make every choice an informed one!</p>
            <a href="#">read more</a>
        </div>
        <div class="aboutUs_img">
            <img src="assets/images/aboutus.jpg" alt="about Us">
        </div>
    </div>

    <div class="homeBlog">
        <h2 class="home-title">categories </h2>
        <div class="homeBlog_blogs">
            <div class="homeBlog_blogs--item">
                <div class="homeBlog_blogs--item-img">
                    <a href="#" class="homeBlog_blogs--item-img_img">
                        <img src="assets/images/blogimg (2).jpg" alt="#">
                    </a>
                    <div class="homeBlog_blogs--item-img_tags">
                        <a href="#">TRAVEL</a>
                        <a href="#">CAR</a>
                        <a href="#">AMMAN</a>
                    </div>
                </div>
                <div class="homeBlog_blogs--item-text">
                    <a href="#" class="homeBlog_blogs--item-text_title">this is
                        the title of the blog</a>
                    <p>this what is the text of the blog this what is the text of
                        the blog this what is the text of the blogthis what is the
                        text of the blogthis what is the text of the blog ...</p>
                </div>
            </div>
            <div class="homeBlog_blogs--item">
                <div class="homeBlog_blogs--item-img">
                    <a href class="homeBlog_blogs--item-img_img">
                        <img src="assets/images/blogimg (2).jpg" alt="#">
                    </a>
                    <div class="homeBlog_blogs--item-img_tags">
                        <a href="#">TRAVEL</a>
                        <a href="#">CAR</a>
                        <a href="#">AMMAN</a>
                    </div>
                </div>
                <div class="homeBlog_blogs--item-text">
                    <a href="#" class="homeBlog_blogs--item-text_title">this is
                        the title of the blog</a>
                    <p>this what is the text of the blog this what is the text of
                        the blog this what is the text of the blogthis what is the
                        text of the blogthis what is the text of the blog ...</p>
                </div>
            </div>
            <div class="homeBlog_blogs--item">
                <div class="homeBlog_blogs--item-img">
                    <a href class="homeBlog_blogs--item-img_img">
                        <img src="assets/images/blogimg (2).jpg" alt="#">
                    </a>
                    <div class="homeBlog_blogs--item-img_tags">
                        <a href="#">TRAVEL</a>
                        <a href="#">CAR</a>
                        <a href="#">AMMAN</a>
                    </div>
                </div>
                <div class="homeBlog_blogs--item-text">
                    <a href="#" class="homeBlog_blogs--item-text_title">this is
                        the title of the blog</a>
                    <p>this what is the text of the blog this what is the text of
                        the blog this what is the text of the blogthis what is the
                        text of the blogthis what is the text of the blog ...</p>
                </div>
            </div>

        </div>
    </div>
</main>
<?php include 'footer.php'; ?>