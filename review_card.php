<?php
// Define the maximum length for the review text preview
$max_length = 150;

// Get the full review text
$full_review = $row['review_text'];

// Trim the text if it exceeds the max length
if (strlen($full_review) > $max_length) {
    $short_review = substr($full_review, 0, $max_length) . '...';
} else {
    $short_review = $full_review;
}

// Check if the review is liked by the logged-in user
$is_liked = false;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $check_like_query = $conn->prepare("SELECT id FROM review_likes WHERE user_id = ? AND review_id = ?");
    $check_like_query->bind_param("ii", $user_id, $row['review_id']);
    $check_like_query->execute();
    $check_like_result = $check_like_query->get_result();
    $is_liked = $check_like_result->num_rows > 0;
}
?>

<div class="activity_grid--item">
    <div class="activity_grid--item_img">
        <!-- Profile Image and Name Link -->
        <a class="activity_grid--item_img_user"
            href="profile.php?user_id=<?php echo htmlspecialchars($row['user_id'] ?? ''); ?>">
            <?php
            $profile_image = $row['user_profile_image'] ?? 'assets/images/profiles/pro_null.png';
            ?>
            <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="User Profile Image">
            <p><?php echo htmlspecialchars($row['user_name'] ?? 'Unknown User'); ?></p>
        </a>

        <a
            href="single-place.php?place_id=<?php echo $row['place_id']; ?>&review_id=<?php echo $row['review_id']; ?>#review_<?php echo $row['review_id']; ?>">
            <img class="activity_grid--item_img_user-img" src="<?php echo htmlspecialchars($row['review_image']); ?>"
                alt="Review Image">
        </a>
        <a class="activity_grid--item_img_like" href="#" onclick="toggleLike(event, <?php echo $row['review_id']; ?>)">
            <i class="<?php echo $is_liked ? 'fa-solid fa-heart' : 'fa-regular fa-heart'; ?>"></i>
        </a>
    </div>

    <div class="activity_grid--item_content">
        <div class="activity_grid--item_content-info">
            <div class="activity_grid--item_content-info_name">
                <a href="single-place.php?place_id=<?php echo $row['place_id']; ?>">
                    <h3><?php echo htmlspecialchars($row['place_name']); ?></h3>
                </a>


                <div class="activity_stars">
                    <?php
                    $rating = $row['rating'];
                    for ($i = 0; $i < $rating; $i++) {
                        echo '<i class="fa-solid fa-star"></i>';
                    }
                    for ($i = $rating; $i < 5; $i++) {
                        echo '<i class="fa-regular fa-star"></i>';
                    }
                    ?>
                </div>
            </div>
            <a class="activity_grid--item_content-info_link"
                href="listing.php?category_id=<?php echo htmlspecialchars($row['category_id']); ?>">
                <i class="<?php echo htmlspecialchars($row['icon_class'] ?? 'fa-solid fa-question'); ?>"></i>
            </a>

        </div>

        <p>
            <?php echo htmlspecialchars($short_review); ?>
            <?php if (strlen($full_review) > $max_length): ?>
            <a class="read-more"
                href="single-place.php?place_id=<?php echo $row['place_id']; ?>&review_id=<?php echo $row['review_id']; ?>#review_<?php echo $row['review_id']; ?>">Read
                more</a>
            <?php endif; ?>
        </p>
    </div>
</div>