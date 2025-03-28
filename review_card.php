<?php
// Define the maximum length for the review text preview
$max_length = 150; // Adjust the length as needed

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
        <a class="activity_grid--item_img_user" href="#">
            <?php
            $profile_image = $row['user_profile_image'] ? $row['user_profile_image'] : 'assets/images/profiles/pro_null.png';
            ?>
            <img src="<?php echo $profile_image; ?>" alt="">
            <p><?php echo $row['user_name']; ?></p>
        </a>
        
        <!-- Review image from the review_images table -->
        <a href="#"><img class="activity_grid--item_img_user-img" src="<?php echo $row['review_image']; ?>" alt=""></a>
        <a class="activity_grid--item_img_like" href="#"><i class="fa-solid fa-heart"></i></a>
    </div>
    
    <div class="activity_grid--item_content">
        <div class="activity_grid--item_content-info">
            <div class="activity_grid--item_content-info_name">
                <a href="#">
                    <h3><?php echo $row['place_name']; ?></h3>
                </a>
                <div class="activity_stars">
                    <?php
                    for ($i = 0; $i < $row['rating']; $i++) {
                        echo '<i class="fa-solid fa-star"></i>';
                    }
                    ?>
                </div>
            </div>
            <a class="activity_grid--item_content-info_link" href="#">
                <i class="<?php echo $row['icon_class']; ?>"></i>
            </a>
        </div>
        
        <p>
            <?php echo $short_review; ?>
            <?php if (strlen($full_review) > $max_length) : ?>
                <a href="review_details.php?id=<?php echo $row['review_id']; ?>" class="read-more">Read more</a>
            <?php endif; ?>
        </p>
    </div>
</div>
