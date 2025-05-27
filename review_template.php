<?php
// review_template.php
// Assumes variables are set: $review, $images, $can_edit, $is_liked, $is_owner, $is_admin
$review_id = $review['id'];
$user_id = $review['user_id'];
$user_name = $review['user_name'] ?? 'Unknown User';
$profile_image = htmlspecialchars($review['profile_image'] ?? 'assets/images/profiles/pro_null.png');
$rating = $review['rating'];
$review_text = htmlspecialchars($review['review_text']);
$created_at = date('F j, Y', strtotime($review['created_at']));
$percentage = ($rating / 5) * 100;

// Fetch existing review images with IDs
$gallery_query = $conn->prepare("SELECT id AS image_id, image_url FROM review_images WHERE review_id = ?");
$gallery_query->bind_param("i", $review_id);
$gallery_query->execute();
$gallery_result = $gallery_query->get_result();
$images = [];
while ($image = $gallery_result->fetch_assoc()) {
    $images[] = $image;
}
$gallery_query->close();
?>

<div class="review" id="review_<?php echo htmlspecialchars($review_id); ?>">
    <div class="review_profile">
        <a href="profile.php?user_id=<?php echo urlencode($user_id); ?>" class="review_profile--img">
            <img src="<?php echo $profile_image; ?>" alt="User Profile">
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
        <button class="btn__transparent--s btn__transparent btn like-btn" data-review-id="<?php echo htmlspecialchars($review_id); ?>">
            <i class="<?php echo $is_liked ? 'fa-solid fa-heart' : 'fa-regular fa-heart'; ?>"></i>
            Like
        </button>
        <?php if ($can_edit): ?>
        <button type="button" class="btn__red--s btn__red btn edit-review" data-review-id="<?php echo htmlspecialchars($review_id); ?>">Edit Review</button>
        <button type="button" class="btn__red--s btn__red btn delete-review" data-review-id="<?php echo htmlspecialchars($review_id); ?>">Delete Review</button>
        <?php endif; ?>
        <?php if ($is_owner || $is_admin): ?>
        <button type="button" class="btn__transparent--s btn__transparent btn comment-review" data-review-id="<?php echo htmlspecialchars($review_id); ?>">Comment on Review</button>
        <?php endif; ?>
    </div>
    <?php
    $comments_query = $conn->prepare("SELECT id, user_id, comment, created_at FROM review_comments WHERE review_id = ?");
    $comments_query->bind_param("i", $review_id);
    $comments_query->execute();
    $comments_result = $comments_query->get_result();
    if ($comments_result->num_rows > 0):
    ?>
    <div class="review_placeComment" id="review_placeComment_<?php echo htmlspecialchars($review_id); ?>">
        <h4>Place owner commented</h4>
        <?php while ($comment = $comments_result->fetch_assoc()):
            $comment_text = htmlspecialchars($comment['comment']);
            $comment_date = date("M j, Y", strtotime($comment['created_at']));
            $comment_id = $comment['id'];
            $comment_user_id = $comment['user_id'];
        ?>
        <div class="single-comment" id="comment-<?php echo htmlspecialchars($comment_id); ?>">
            <div class="comment-date"><?php echo htmlspecialchars($comment_date); ?></div>
            <div class="comment-content">
                <p id="comment-text-<?php echo htmlspecialchars($comment_id); ?>"><?php echo $comment_text; ?></p>
                <textarea id="edit-textarea-<?php echo htmlspecialchars($comment_id); ?>" style="display:none"><?php echo $comment_text; ?></textarea>
            </div>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment_user_id): ?>
            <div class="comment__actions">
                <button class="btn__red--s btn__red btn comment-edit" data-comment-id="<?php echo htmlspecialchars($comment_id); ?>">Edit Comment</button>
                <button class="btn__red--s btn__red btn comment-save" data-comment-id="<?php echo htmlspecialchars($comment_id); ?>" style="display:none">Save</button>
                <button class="btn__red--s btn__red btn comment-delete" data-comment-id="<?php echo htmlspecialchars($comment_id); ?>">Delete Comment</button>
            </div>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>
    <?php endif; $comments_query->close(); ?>
    <?php if ($is_owner || $is_admin): ?>
    <form id="commentForm-<?php echo htmlspecialchars($review_id); ?>" method="POST" action="submit_owner_comment.php" style="display: none;" class="place--owner-comment-form">
        <input type="hidden" name="review_id" value="<?php echo htmlspecialchars($review_id); ?>">
        <input type="hidden" name="place_id" value="<?php echo htmlspecialchars($place_id); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <textarea name="comment" placeholder="Add comment on review" required></textarea>
        <button type="submit" class="btn__transparent--s btn__transparent btn">Submit Comment</button>
    </form>
    <?php endif; ?>
    <?php if ($can_edit): ?>
    <form id="editForm-<?php echo htmlspecialchars($review_id); ?>" method="POST" action="edit_review.php" enctype="multipart/form-data" style="display: none;" class="edit-review-form">
        <input type="hidden" name="review_id" value="<?php echo htmlspecialchars($review_id); ?>">
        <input type="hidden" name="place_id" value="<?php echo htmlspecialchars($place_id); ?>">
        <input type="hidden" name="rating" id="rating-<?php echo htmlspecialchars($review_id); ?>" value="<?php echo htmlspecialchars($rating); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <div class="addReview_stars" data-review-id="<?php echo htmlspecialchars($review_id); ?>">
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <i class="fa-solid fa-star star-rating <?php echo $i <= $rating ? 'selected' : ''; ?>" data-value="<?php echo $i; ?>"></i>
            <?php endfor; ?>
        </div>
        <a class="btn__transparent--s btn__transparent btn" href="#" onclick="document.getElementById('imageInput-<?php echo htmlspecialchars($review_id); ?>').click(); return false;">add photos</a>
        <input type="file" name="review_images[]" id="imageInput-<?php echo htmlspecialchars($review_id); ?>" multiple accept="image/*" style="display: none;">
        <div class="image-preview" id="imagePreview-<?php echo htmlspecialchars($review_id); ?>">
            <?php foreach ($images as $image): ?>
            <div class="image-thumb" data-img-id="<?php echo htmlspecialchars($image['image_id']); ?>">
                <img src="<?php echo htmlspecialchars($image['image_url']); ?>" alt="Review Image">
                <span class="remove-image existing">×</span>
            </div>
            <?php endforeach; ?>
        </div>
        <textarea name="review_text" required><?php echo $review_text; ?></textarea>
        <button type="submit" class="btn__red--s btn__red btn">Save Changes</button>
    </form>
    <?php endif; ?>
</div>