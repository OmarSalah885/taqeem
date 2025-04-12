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
?>

<div class="activity_grid--item">
    <div class="activity_grid--item_img">
        <!-- Profile Image and Name Link -->
        <a class="activity_grid--item_img_user" href="profile.php?user_id=<?php echo htmlspecialchars($row['user_id'] ?? ''); ?>">
            <?php
            $profile_image = $row['user_profile_image'] ?? 'assets/images/profiles/pro_null.png';
            ?>
            <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="User Profile Image">
            <p><?php echo htmlspecialchars($row['user_name'] ?? 'Unknown User'); ?></p>
        </a>
        
        <!-- Review Image -->
        <a href="#"><img class="activity_grid--item_img_user-img" src="<?php echo htmlspecialchars($row['review_image']); ?>" alt="Review Image"></a>
        <a class="activity_grid--item_img_like" href="#"><i class="fa-solid fa-heart"></i></a>
    </div>
    
    <div class="activity_grid--item_content">
        <div class="activity_grid--item_content-info">
            <div class="activity_grid--item_content-info_name">
                <a href="#">
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
            <a class="activity_grid--item_content-info_link" href="#">
                <i class="<?php echo htmlspecialchars($row['icon_class'] ?? 'fa-solid fa-question'); ?>"></i>
            </a>
        </div>
        
        <p>
            <?php echo htmlspecialchars($short_review); ?>
            <?php if (strlen($full_review) > $max_length): ?>
                <a href="review_details.php?id=<?php echo htmlspecialchars($row['review_id']); ?>" class="read-more">Read more</a>
            <?php endif; ?>
        </p>
    </div>
</div>