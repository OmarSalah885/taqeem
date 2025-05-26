<?php
// review_template.php
// Assumes variables are set: $review, $images, $can_edit, $is_liked, $is_owner, $is_admin
$review_id = $review['id'];
$user_id = $review['user_id'];
$user_name = $review['user_name'] ?? 'Unknown User';
$profile_image = $review['profile_image'] ?? 'default.jpg';
$rating = $review['rating'];
$review_text = htmlspecialchars($review['review_text']);
$created_at = date('F j, Y', strtotime($review['created_at']));
$percentage = ($rating / 5) * 100;
?>
<div class="review" id="review_<?php echo $review_id; ?>">
    <div class="review_profile">
        <a href="profile.php?user_id=<?php echo urlencode($user_id); ?>" class="review_profile--img">
            <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="User Profile">
        </a>
        <div class="review_profile--info">
            <a href="profile.php?user_id=<?php echo urlencode($user_id); ?>" class="review_profile--info-name">
                <?php echo htmlspecialchars($user_name); ?>
            </a>
            <div class="review_profile--info-stars">
                <div class="review_stars" style="background: linear-gradient(90deg, #A21111 <?php echo $percentage; ?>%, #D0D0D0 <?php echo $percentage; ?>%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                    <i class="fa-solid fa-star star-rating"></i>
                    <?php endfor; ?>
                </div>
                <p class="review-date"><?php echo $created_at; ?></p>
            </div>
        </div>
    </div>
    <div class="review_text">
        <p><?php echo $review_text; ?></p>
    </div>
    <div class="review_gallery">
        <?php foreach ($images as $image): ?>
        <a href="<?php echo htmlspecialchars($image['image_url']); ?>" class="review_gallery-img" target="_blank">
            <img src="<?php echo htmlspecialchars($image['image_url']); ?>" alt="Review Image">
        </a>
        <?php endforeach; ?>
    </div>
    <div class="review_btns">
        <button class="btn__transparent--s btn__transparent btn" onclick="toggleLike(event, <?php echo $review_id; ?>)">
            <i class="<?php echo $is_liked ? 'fa-solid fa-heart' : 'fa-regular fa-heart'; ?>"></i>
            Like
        </button>
        <?php if ($can_edit): ?>
        <button type="button" class="btn__red--s btn__red btn edit-review" data-review-id="<?php echo $review_id; ?>">edit review</button>
        <button type="button" class="btn__red--s btn__red btn delete-review" data-review-id="<?php echo $review_id; ?>">delete review</button>
        <?php endif; ?>
        <?php if ($is_owner || $is_admin): ?>
        <button type="button" class="btn__transparent--s btn__transparent btn comment-review" data-review-id="<?php echo $review_id; ?>">comment on review</button>
        <?php endif; ?>
    </div>
</div>