<?php
include 'config.php'; // Include database connection
session_start();      // Start the session

include 'header.php';

// Get the profile user ID from the query string
$profile_user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

// Get the logged-in user ID
$logged_in_user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

// Check if the logged-in user is viewing their own profile
$is_owner = ($profile_user_id === $logged_in_user_id);

// Fetch user data
$user_query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$user_query->bind_param("i", $profile_user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    echo "<p>User not found.</p>";
    exit;
}
?>

<main class="profile">
    <div class="profile_sidebar">
        <!-- User Image -->
        <div class="profile_sidebar--img">
            <img src="<?php echo htmlspecialchars($user['profile_image'] ?? 'assets/images/profiles/pro_null.png'); ?>" alt="User Profile">
        </div>

        <!-- User Info -->
        <div class="profile_sidebar--info">
            <h3 class="name"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h3>
            <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>"><?php echo htmlspecialchars($user['email']); ?></a>
            <h2 class="location"><?php echo htmlspecialchars($user['location'] ?? 'Unknown Location'); ?></h2>
        </div>

        <!-- Edit Buttons (Only for Profile Owner) -->
        <?php if ($is_owner): ?>
        <div class="profile_sidebar--edit">
            <a class="profile_sidebar--edit-btn" href="edit-profile.php"><i class="fa-solid fa-pen"></i>Edit profile</a>
            <a class="profile_sidebar--edit-btn" href="add-photo.php"><i class="fa-solid fa-user"></i>Add photo</a>
        </div>
        <a href="logout.php" class="btn__transparent--l btn__transparent btn">LOGOUT</a>
        <?php endif; ?>
    </div>
    <div class="profile_main">
        <div class="profile_main_collection">
            <h2 class="profile_title">MY PLACES</h2>
            <div class="profile_container">
                <?php
                // Fetch the newest 2 places and count total places
                $places_query = $conn->prepare("
                    SELECT 
                        p.id, p.name, p.price, p.tags, p.city, p.featured_image, 
                        c.icon AS category_icon, 
                        COALESCE(AVG(r.rating), 0) AS avg_rating
                    FROM places p
                    LEFT JOIN reviews r ON p.id = r.place_id
                    LEFT JOIN categories c ON p.category_id = c.id
                    WHERE p.user_id = ?
                    GROUP BY p.id
                    ORDER BY p.created_at DESC
                    LIMIT 2
                ");
                $places_query->bind_param("i", $profile_user_id);
                $places_query->execute();
                $places_result = $places_query->get_result();

                // Count total places for the "See All" button
                $total_places_query = $conn->prepare("SELECT COUNT(*) AS total_places FROM places WHERE user_id = ?");
                $total_places_query->bind_param("i", $profile_user_id);
                $total_places_query->execute();
                $total_places_result = $total_places_query->get_result();
                $total_places = $total_places_result->fetch_assoc()['total_places'];

                while ($place = $places_result->fetch_assoc()):
                ?>
                <div class="listing_grid--item">
                    <div class="listing_grid--item-img">
                        <a href="place.php?id=<?php echo $place['id']; ?>" class="listing_grid--item-img_img">
                            <img src="<?php echo htmlspecialchars($place['featured_image'] ?? 'assets/images/listing.jpg'); ?>" alt="Place Image">
                        </a>
                        <a href="#" class="listing_grid--item-img_category">
                            <i class="<?php echo htmlspecialchars($place['category_icon'] ?? 'fa-solid fa-question'); ?>"></i>
                        </a>
                        <?php if ($is_owner): ?>
                        <a href="edit_place.php?place_id=<?php echo $place['id']; ?>" class="edit_place--btn">EDIT PLACE</a>
                        <?php endif; ?>
                    </div>
                    <div class="listing_grid--item-content">
                        <div class="listing_grid--item-content_tages">
                            <?php
                            $tags = explode(',', $place['tags']);
                            foreach ($tags as $tag):
                            ?>
                            <a href="#"><?php echo htmlspecialchars($tag); ?></a>
                            <?php endforeach; ?>
                        </div>
                        <a class="listing_grid--item-content_name" href="place.php?id=<?php echo $place['id']; ?>">
                            <?php echo htmlspecialchars($place['name']); ?>
                        </a>
                        <a href="#" class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            <?php echo htmlspecialchars($place['city']); ?>
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
                                <?php
                                $avg_rating = round($place['avg_rating']); // Round the average rating
                                for ($i = 0; $i < $avg_rating; $i++): ?>
                                    <i class="fa-solid fa-star"></i>
                                <?php endfor; ?>
                                <?php for ($i = $avg_rating; $i < 5; $i++): ?>
                                    <i class="fa-regular fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <h4 class="listing_grid--item-content_stars-price"><?php echo htmlspecialchars($place['price']); ?></h4>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <?php if ($total_places > 2): ?>
            <a href="my_places.php?user_id=<?php echo $profile_user_id; ?>" class="btn__red--l btn__red btn">see all</a>
            <?php endif; ?>
        </div>
        <div class="profile_main_myReviews">
            <h2 class="profile_title">MY REVIEWS</h2>
            <div class="profile_container">
                <?php
                // Fetch the newest 2 reviews and count total reviews
                $reviews_query = $conn->prepare("
                    SELECT 
                        r.id AS review_id, r.rating, r.review_text, r.created_at, 
                        p.id AS place_id, p.name AS place_name, p.featured_image AS place_image, 
                        c.icon AS category_icon
                    FROM reviews r
                    INNER JOIN places p ON r.place_id = p.id
                    LEFT JOIN categories c ON p.category_id = c.id
                    WHERE r.user_id = ?
                    ORDER BY r.created_at DESC
                    LIMIT 2
                ");
                $reviews_query->bind_param("i", $profile_user_id);
                $reviews_query->execute();
                $reviews_result = $reviews_query->get_result();

                // Count total reviews for the "See All" button
                $total_reviews_query = $conn->prepare("SELECT COUNT(*) AS total_reviews FROM reviews WHERE user_id = ?");
                $total_reviews_query->bind_param("i", $profile_user_id);
                $total_reviews_query->execute();
                $total_reviews_result = $total_reviews_query->get_result();
                $total_reviews = $total_reviews_result->fetch_assoc()['total_reviews'];

                while ($review = $reviews_result->fetch_assoc()):
                ?>
                <div class="activity_grid--item">
                    <div class="activity_grid--item_img">
                        <a class="activity_grid--item_img_user" href="profile.php?user_id=<?php echo $profile_user_id; ?>">
                            <img src="<?php echo htmlspecialchars($user['profile_image'] ?? 'assets/images/profiles/pro_null.png'); ?>" alt="User Image">
                            <p><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
                        </a>
                        <a href="place.php?id=<?php echo $review['place_id']; ?>">
                            <img class="activity_grid--item_img_user-img" src="<?php echo htmlspecialchars($review['place_image'] ?? 'assets/images/listing.jpg'); ?>" alt="Place Image">
                        </a>
                        <a class="activity_grid--item_img_like" href="#"><i class="fa-solid fa-heart"></i></a>
                    </div>
                    <div class="activity_grid--item_content">
                        <div class="activity_grid--item_content-info">
                            <div class="activity_grid--item_content-info_name">
                                <a href="place.php?id=<?php echo $review['place_id']; ?>">
                                    <h3><?php echo htmlspecialchars($review['place_name']); ?></h3>
                                </a>
                                <div class="activity_stars">
                                    <?php
                                    $rating = (int)$review['rating'];
                                    for ($i = 0; $i < $rating; $i++): ?>
                                        <i class="fa-solid fa-star"></i>
                                    <?php endfor; ?>
                                    <?php for ($i = $rating; $i < 5; $i++): ?>
                                        <i class="fa-regular fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <a class="activity_grid--item_content-info_link" href="#">
                                <i class="<?php echo htmlspecialchars($review['category_icon'] ?? 'fa-solid fa-question'); ?>"></i>
                            </a>
                        </div>
                        <p><?php echo htmlspecialchars(substr($review['review_text'], 0, 150)) . '...'; ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <?php if ($total_reviews > 2): ?>
            <a href="my_reviews.php?user_id=<?php echo $profile_user_id; ?>" class="btn__red--l btn__red btn">see all</a>
            <?php endif; ?>
        </div>
        <div class="profile_main_likeReviews">
            <h2 class="profile_title">LIKED REVIEWS</h2>
            <div class="profile_container">
                <?php
                // Fetch the newest 2 liked reviews and count total liked reviews
                $liked_reviews_query = $conn->prepare("
                    SELECT 
                        rl.review_id, r.rating, r.review_text, r.created_at, 
                        p.id AS place_id, p.name AS place_name, p.featured_image AS place_image, 
                        c.icon AS category_icon
                    FROM review_likes rl
                    INNER JOIN reviews r ON rl.review_id = r.id
                    INNER JOIN places p ON r.place_id = p.id
                    LEFT JOIN categories c ON p.category_id = c.id
                    WHERE rl.user_id = ?
                    ORDER BY rl.created_at DESC
                    LIMIT 2
                ");
                $liked_reviews_query->bind_param("i", $profile_user_id);
                $liked_reviews_query->execute();
                $liked_reviews_result = $liked_reviews_query->get_result();

                // Count total liked reviews for the "See All" button
                $total_liked_reviews_query = $conn->prepare("SELECT COUNT(*) AS total_liked_reviews FROM review_likes WHERE user_id = ?");
                $total_liked_reviews_query->bind_param("i", $profile_user_id);
                $total_liked_reviews_query->execute();
                $total_liked_reviews_result = $total_liked_reviews_query->get_result();
                $total_liked_reviews = $total_liked_reviews_result->fetch_assoc()['total_liked_reviews'];

                while ($liked_review = $liked_reviews_result->fetch_assoc()):
                ?>
                <div class="activity_grid--item">
                    <div class="activity_grid--item_img">
                        <a class="activity_grid--item_img_user" href="profile.php?user_id=<?php echo $profile_user_id; ?>">
                            <img src="<?php echo htmlspecialchars($user['profile_image'] ?? 'assets/images/profiles/pro_null.png'); ?>" alt="User Image">
                            <p><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
                        </a>
                        <a href="place.php?id=<?php echo $liked_review['place_id']; ?>">
                            <img class="activity_grid--item_img_user-img" src="<?php echo htmlspecialchars($liked_review['place_image'] ?? 'assets/images/listing.jpg'); ?>" alt="Place Image">
                        </a>
                        <a class="activity_grid--item_img_like" href="#"><i class="fa-solid fa-heart"></i></a>
                    </div>
                    <div class="activity_grid--item_content">
                        <div class="activity_grid--item_content-info">
                            <div class="activity_grid--item_content-info_name">
                                <a href="place.php?id=<?php echo $liked_review['place_id']; ?>">
                                    <h3><?php echo htmlspecialchars($liked_review['place_name']); ?></h3>
                                </a>
                                <div class="activity_stars">
                                    <?php
                                    $rating = (int)$liked_review['rating'];
                                    for ($i = 0; $i < $rating; $i++): ?>
                                        <i class="fa-solid fa-star"></i>
                                    <?php endfor; ?>
                                    <?php for ($i = $rating; $i < 5; $i++): ?>
                                        <i class="fa-regular fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <a class="activity_grid--item_content-info_link" href="#">
                                <i class="<?php echo htmlspecialchars($liked_review['category_icon'] ?? 'fa-solid fa-question'); ?>"></i>
                            </a>
                        </div>
                        <p><?php echo htmlspecialchars(substr($liked_review['review_text'], 0, 150)) . '...'; ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <?php if ($total_liked_reviews > 2): ?>
            <a href="liked_reviews.php?user_id=<?php echo $profile_user_id; ?>" class="btn__red--l btn__red btn">see all</a>
            <?php endif; ?>
        </div>
        <div class="profile_main_collection">
            <h2 class="profile_title">MY COLLECTIONS</h2>
            <div class="profile_container">
                <?php
                // Fetch the newest 2 saved places and count total saved places
                $saved_places_query = $conn->prepare("
                    SELECT 
                        sp.place_id, p.name, p.price, p.tags, p.city, p.featured_image, 
                        c.icon AS category_icon, 
                        COALESCE(AVG(r.rating), 0) AS avg_rating
                    FROM saved_places sp
                    INNER JOIN places p ON sp.place_id = p.id
                    LEFT JOIN reviews r ON p.id = r.place_id
                    LEFT JOIN categories c ON p.category_id = c.id
                    WHERE sp.user_id = ?
                    GROUP BY sp.place_id
                    ORDER BY sp.created_at DESC
                    LIMIT 2
                ");
                $saved_places_query->bind_param("i", $profile_user_id);
                $saved_places_query->execute();
                $saved_places_result = $saved_places_query->get_result();

                // Count total saved places for the "See All" button
                $total_saved_places_query = $conn->prepare("SELECT COUNT(*) AS total_saved_places FROM saved_places WHERE user_id = ?");
                $total_saved_places_query->bind_param("i", $profile_user_id);
                $total_saved_places_query->execute();
                $total_saved_places_result = $total_saved_places_query->get_result();
                $total_saved_places = $total_saved_places_result->fetch_assoc()['total_saved_places'];

                while ($saved_place = $saved_places_result->fetch_assoc()):
                ?>
                <div class="listing_grid--item">
                    <div class="listing_grid--item-img">
                        <a href="place.php?id=<?php echo $saved_place['place_id']; ?>" class="listing_grid--item-img_img">
                            <img src="<?php echo htmlspecialchars($saved_place['featured_image'] ?? 'assets/images/listing.jpg'); ?>" alt="Place Image">
                        </a>
                        <a href="#" class="listing_grid--item-img_category">
                            <i class="<?php echo htmlspecialchars($saved_place['category_icon'] ?? 'fa-solid fa-question'); ?>"></i>
                        </a>
                        <a href="#" class="listing_grid--item-img_save"><i class="fa-solid fa-bookmark"></i></a>
                    </div>
                    <div class="listing_grid--item-content">
                        <div class="listing_grid--item-content_tages">
                            <?php
                            $tags = explode(',', $saved_place['tags']);
                            foreach ($tags as $tag):
                            ?>
                            <a href="#"><?php echo htmlspecialchars($tag); ?></a>
                            <?php endforeach; ?>
                        </div>
                        <a class="listing_grid--item-content_name" href="place.php?id=<?php echo $saved_place['place_id']; ?>">
                            <?php echo htmlspecialchars($saved_place['name']); ?>
                        </a>
                        <a href="#" class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            <?php echo htmlspecialchars($saved_place['city']); ?>
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
                                <?php
                                $avg_rating = round($saved_place['avg_rating']); // Round the average rating
                                for ($i = 0; $i < $avg_rating; $i++): ?>
                                    <i class="fa-solid fa-star"></i>
                                <?php endfor; ?>
                                <?php for ($i = $avg_rating; $i < 5; $i++): ?>
                                    <i class="fa-regular fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <h4 class="listing_grid--item-content_stars-price"><?php echo htmlspecialchars($saved_place['price']); ?></h4>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <?php if ($total_saved_places > 2): ?>
            <a href="saved_places.php?user_id=<?php echo $profile_user_id; ?>" class="btn__red--l btn__red btn">see all</a>
            <?php endif; ?>
        </div>
        <div class="profile_main_info">
            <div class="profile_main_info--top">
                <div class="info_top--item">
                    <h3>Name</h3>
                    <p><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
                </div>
                <div class="info_top--item">
                    <h3>Since</h3>
                    <p><?php echo htmlspecialchars(date("F Y", strtotime($user['created_at']))); ?></p>
                </div>
                <div class="info_top--item">
                    <h3>Email</h3>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
                <div class="info_top--item">
                    <h3>Gender</h3>
                    <p><?php echo htmlspecialchars($user['gender'] ?? 'Not Specified'); ?></p>
                </div>
            </div>
            <div class="profile_main_info--bottom">
                <h3>About me</h3>
                <p><?php echo htmlspecialchars($user['about_me'] ?? 'No information provided.'); ?></p>
            </div>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>