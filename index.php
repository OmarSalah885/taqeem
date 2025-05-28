<?php
require_once 'config.php';
require_once 'db_connect.php';

include 'header.php';
?>

<main class="index-main">

    <!-- Carousel Section -->
    <div class="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="carousel-item_img">
                    <img src="assets/images/eugene-zhyvchik-vad__5nCLJ8-unsplash.jpg" alt="carousel image">
                    <div class="carousel-item-overlay"></div>
                </div>
                <div class="carousel-item_content">
                    <div class="carousel-item_content-div">
                        <h1 data-aos="fade-up" data-aos-duration="1500">Search for the best restaurants out there</h1>
                        <a href="listing.php?category_id=1" class="btn__red--l btn__red btn" data-aos="fade-up"
                            data-aos-delay="300" data-aos-duration="1500">See More</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-item_img">
                    <img src="assets/images/carousel(1).jpg" alt="carousel image">
                    <div class="carousel-item-overlay"></div>
                </div>
                <div class="carousel-item_content">
                    <div class="carousel-item_content-div">
                        <h1 data-aos="fade-up" data-aos-duration="1500">Discover stunning artworks near you</h1>
                        <a href="listing.php?category_id=8" class="btn__red--l btn__red btn" data-aos="fade-up"
                            data-aos-delay="300" data-aos-duration="1500">See More</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-item_img">
                    <img src="assets/images/carousel(2).jpg" alt="carousel image">
                    <div class="carousel-item-overlay"></div>
                </div>
                <div class="carousel-item_content">
                    <div class="carousel-item_content-div">
                        <h1 data-aos="fade-up" data-aos-duration="1500">Looking for greenery? Let’s find the best plant stores!</h1>
                        <a href="listing.php?category_id=7" class="btn__red--l btn__red btn" data-aos="fade-up"
                            data-aos-delay="300" data-aos-duration="1500">See More</a>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control prev">❮</button>
        <button class="carousel-control next">❯</button>
        <div class="carousel-indicators">
            <span class="indicator active" data-slide="0"></span>
            <span class="indicator" data-slide="1"></span>
            <span class="indicator" data-slide="2"></span>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="categories">
        <h2 class="home-title" data-aos="fade-up" data-aos-duration="1500">Categories</h2>
        <div class="categories_grid">
            <?php
            $categories = [
                1 => 'RESTAURANTS',
                2 => 'SHOPPING',
                3 => 'ACTIVE LIFE',
                4 => 'HOME SERVICES',
                5 => 'COFFEE',
                6 => 'PETS',
                7 => 'PLANTS SHOP',
                8 => 'ART',
                9 => 'HOTELS',
                10 => 'EDUCATION',
                11 => 'HEALTH',
                12 => 'WORKSPACE'
            ];

            $delay = 0;
            $maxDelay = 500;

            foreach ($categories as $id => $name) {
                $imagePath = "assets/images/categories/" . strtoupper($name) . " (1).jpg";
                echo '<div class="categories_grid--item" data-aos="fade-up" data-aos-delay="' . $delay . '" data-aos-duration="1500">
                    <a href="listing.php?category_id=' . $id . '">
                        <img src="' . $imagePath . '" alt="' . htmlspecialchars($name) . '">
                    </a>
                    <a class="categories_grid--item_link" href="listing.php?category_id=' . $id . '">' . $name . '</a>
                </div>';
                $delay += 100;
                if ($delay > $maxDelay) {
                    $delay = 0;
                }
            }
            ?>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="activity">
        <h2 class="home-title" data-aos="fade-up" data-aos-duration="1500">Recent Activity</h2>
        <div class="activity_grid" id="activity_grid" data-aos="fade-up" data-aos-duration="1500">
            <?php
            $limit = 8;
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
                c.id AS category_id
            FROM reviews r
            JOIN places p ON r.place_id = p.id
            JOIN users u ON r.user_id = u.id
            JOIN review_images ri ON r.id = ri.review_id
            JOIN categories c ON p.category_id = c.id
            ORDER BY RAND()
            LIMIT $limit";

            $result = mysqli_query($conn, $query);
            $initial_review_ids = [];
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $initial_review_ids[] = $row['review_id'];
                    include 'review_card.php';
                }
            } else {
                echo "<p>No reviews found.</p>";
            }
            mysqli_free_result($result);
            ?>
        </div>
        <a class="btn__transparent--l btn__transparent btn" id="loadMore" data-aos="fade-up"
            data-aos-duration="1500">Load more</a>
    </div>

    <!-- About Us Section -->
    <div id="aboutUs" class="aboutUs">
        <div class="aboutUs_text" data-aos="fade-right" data-aos-delay="0" data-aos-duration="1500">
            <h2>ABOUT US</h2>
            <p>
                Welcome to Taqeem, your ultimate guide to discovering the best
                local businesses, services, and experiences around you. At
                Taqeem, we believe in empowering communities through genuine
                reviews, ratings, and recommendations. Whether you're looking for
                the perfect café, a reliable service provider, or hidden gems in
                your city, Taqeem connects you with trusted opinions from real
                people. Join us in building a platform that celebrates
                excellence, transparency, and the spirit of exploration.
                Together, let’s make every choice an informed one!
            </p>
        </div>
        <div class="aboutUs_img" data-aos="fade-left" data-aos-delay="400" data-aos-duration="1500">
            <img src="assets/images/aboutus.jpg" alt="About Us">
        </div>
    </div>

    <!-- Blogs Section -->
    <div class="homeBlog">
        <h2 class="home-title" data-aos="fade-up" data-aos-duration="1500">Our Blogs</h2>
        <div class="homeBlog_blogs">
            <?php
            $query = "SELECT id, image, title, tags, content FROM blogs ORDER BY RAND() LIMIT 3";
            $result = mysqli_query($conn, $query);

            $aos_delay = 0;

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $image = htmlspecialchars($row['image']);
                    $title = htmlspecialchars($row['title']);
                    $tags = explode(',', $row['tags']);
                    $content = strip_tags($row['content']);
                    $shortContent = (strlen($content) > 200) ? substr($content, 0, 200) . '...' : $content;

                    echo '<div class="homeBlog_blogs--item" data-aos="fade-up" data-aos-delay="' . $aos_delay . '" data-aos-duration="1500">
                            <div class="homeBlog_blogs--item-img">
                                <a href="single-blog.php?id=' . $id . '" class="homeBlog_blogs--item-img_img">
                                    <img src="' . $image . '" alt="Blog Image">
                                </a>
                                <div class="homeBlog_blogs--item-img_tags">';
                    foreach ($tags as $tag) {
                        echo '<a href="blogs.php?search_term=' . urlencode(trim($tag)) . '">' . htmlspecialchars(trim($tag)) . '</a>';
                    }
                    echo '</div>
                            </div>
                            <div class="homeBlog_blogs--item-text">
                                <a href="single-blog.php?id=' . $id . '" class="homeBlog_blogs--item-text_title">' . $title . '</a>
                                <a href="single-blog.php?id=' . $id . '" style="text-decoration: none; color: inherit;">
                                    <p>' . htmlspecialchars($shortContent) . '</p>
                                </a>
                            </div>
                        </div>';

                    $aos_delay += 300;
                    if ($aos_delay > 800) {
                        $aos_delay = 0;
                    }
                }
            } else {
                echo "<p>No blogs found.</p>";
            }
            mysqli_free_result($result);
            ?>
        </div>
    </div>

</main>

<script>
// Initial review IDs from PHP
let displayedReviewIds = <?php echo json_encode($initial_review_ids); ?>;

// Toggle like functionality
function toggleLike(event, reviewId) {
    event.preventDefault();
    const heartIcon = event.currentTarget.querySelector('i');
    const isLiked = heartIcon.classList.contains('fa-solid');

    fetch('toggle_like.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `review_id=${reviewId}&action=${isLiked ? 'unlike' : 'like'}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            heartIcon.classList.toggle('fa-solid');
            heartIcon.classList.toggle('fa-regular');
        } else {
            console.error('Error toggling like:', data.message);
        }
    })
    .catch(error => console.error('Fetch error:', error));
}
</script>


<?php include 'footer.php'; ?>