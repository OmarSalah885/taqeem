<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();
include 'header.php'; // Include the header
?>

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
                        <a href="listing.php?category_id=1" class="btn__red--l btn__red btn">See More</a>
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
                        <a href="listing.php?category_id=1" class="btn__red--l btn__red btn">See More</a>
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
                        <a href="listing.php?category_id=1" class="btn__red--l btn__red btn">See More</a>
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

    
<div class="activity">
    <h2 class="home-title">Recent Activity</h2>
    <div class="activity_grid" id="activity_grid">
        <?php 
$limit = 8; // Initial limit
$query = "SELECT 
    r.id AS review_id, 
    r.review_text, 
    r.rating, 
    p.name AS place_name, 
    p.id AS place_id,
    CONCAT(u.first_name, ' ', u.last_name) AS user_name, 
    u.id AS user_id,
    u.profile_image AS user_profile_image, 
    ri.image_url AS review_image, 
    c.icon AS icon_class,
    c.id AS category_id  -- ✅ Fetch category ID
FROM reviews r
JOIN places p ON r.place_id = p.id
JOIN users u ON r.user_id = u.id
JOIN review_images ri ON r.id = ri.review_id
JOIN categories c ON p.category_id = c.id
ORDER BY rand()
LIMIT $limit";



$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        include 'review_card.php';
    }
} else {
    echo "<p>No reviews found.</p>";
}
?>

        </div>
        <a class="btn__transparent--l btn__transparent btn" id="loadMore">Load more</a>
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
    <h2 class="home-title"> Our Blogs</h2>
    <div class="homeBlog_blogs">
        <?php
        // Query to fetch 3 random blogs
        $query = "SELECT id, image, title, tags, content FROM blogs ORDER BY RAND() LIMIT 3";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Extract data
                $id = $row['id']; // Blog ID
                $image = htmlspecialchars($row['image']); // Image from DB
                $title = htmlspecialchars($row['title']);
                $tags = explode(',', $row['tags']); // Assuming tags are comma-separated
                $content = strip_tags($row['content']); // Remove HTML tags for truncation
                
                // Limit content to 200 characters
                $shortContent = (strlen($content) > 200) ? substr($content, 0, 200) . '...' : $content;

                echo '<div class="homeBlog_blogs--item">
            <div class="homeBlog_blogs--item-img">
                <a href="single-blog.php?id=' . $id . '" class="homeBlog_blogs--item-img_img" style="text-decoration: none;">
                    <img src="' . $image . '" alt="Blog Image">
                </a>
                <div class="homeBlog_blogs--item-img_tags">';
    
    // Display tags dynamically
    foreach ($tags as $tag) {
        echo '<a href="blogs.php?search_term=' . urlencode(trim($tag)) . '" style="text-decoration: none;">' . htmlspecialchars(trim($tag)) . '</a>';
    }

    echo '  </div>
                        </div>
                        <div class="homeBlog_blogs--item-text">
                            <a href="single-blog.php?id=' . $id . '" class="homeBlog_blogs--item-text_title" style="text-decoration: none;">' . $title . '</a>
                            <a href="single-blog.php?id=' . $id . '" style="text-decoration: none;">
                                <p>' . htmlspecialchars($shortContent) . '</p> <!-- Truncated Content -->
                            </a>
                        </div>
                    </div>';
            }
        } else {
            echo "<p>No blogs found.</p>";
        }
        ?>
    </div>
</div>







</main>
<?php include 'footer.php'; ?>