<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

if (!isset($_GET['place_id']) || !is_numeric($_GET['place_id'])) {
    die("Invalid or missing place ID");
}

$place_id = (int)$_GET['place_id'];

// Fetch place data
$place_query = $conn->prepare("
    SELECT id, name, tags, price, city, country, category_id, user_id, description,
           email, phone_1, phone_2, website, facebook_url, instagram_url, twitter_url
    FROM places WHERE id = ?
");
$place_query->bind_param("i", $place_id);
$place_query->execute();
$place_result = $place_query->get_result();

if ($place_result->num_rows === 0) {
    header("Location: /404.php");
    exit;
}

$place = $place_result->fetch_assoc();
$place_query->close();

include 'header.php';

// Check liked reviews
$is_liked_reviews = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $liked_query = $conn->prepare("SELECT review_id FROM review_likes WHERE user_id = ?");
    $liked_query->bind_param("i", $user_id);
    $liked_query->execute();
    $liked_result = $liked_query->get_result();
    while ($row = $liked_result->fetch_assoc()) {
        $is_liked_reviews[] = $row['review_id'];
    }
    $liked_query->close();
}

// Check ownership and admin status
$is_owner = false;
$is_admin = false;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $is_owner = ($place['user_id'] == $user_id);
    $is_admin = (!empty($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin');
}

// Fetch review ownership
$review_owners = [];
$review_query = $conn->prepare("SELECT id, user_id FROM reviews WHERE place_id = ?");
$review_query->bind_param("i", $place_id);
$review_query->execute();
$review_result = $review_query->get_result();
while ($row = $review_result->fetch_assoc()) {
    $review_owners[$row['id']] = $row['user_id'];
}
$review_query->close();

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<main class="place">
    <div class="place_gallery">
        <button class="gallery-btn left-btn">‹</button>
        <div class="place_gallery--items">
            <?php
            $gallery_query = $conn->prepare("SELECT image_url FROM place_gallery WHERE place_id = ?");
            $gallery_query->bind_param("i", $place_id);
            $gallery_query->execute();
            $gallery_result = $gallery_query->get_result();
            if ($gallery_result->num_rows > 0) {
                while ($image = $gallery_result->fetch_assoc()) {
                    echo '<div class="place_gallery--item"><img src="' . htmlspecialchars($image['image_url']) . '" alt="Gallery Image"></div>';
                }
            } else {
                echo '<div class="place_gallery--item"><img src="assets/images/default_gallery.jpg" alt="Default Image"></div>';
            }
            $gallery_query->close();
            ?>
        </div>
        <button class="gallery-btn right-btn">›</button>
        <?php if ($is_owner || $is_admin): ?>
            <a href="edit_place.php?place_id=<?php echo $place['id']; ?>" class="btn__red btn__red--l btn">Edit</a>
            <form action="delete_place.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this place? This action cannot be undone.');">
                <input type="hidden" name="place_id" value="<?= htmlspecialchars($place['id']) ?>">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="redirect_to" value="<?= htmlspecialchars($_SERVER['HTTP_REFERER'] ?? 'index.php') ?>">
                <button type="submit" class="btn__red btn__red--l btn">DELETE PLACE</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="place_info">
        <div class="place_info-cont">
            <div class="place_info--tages">
    <?php
    $tags = !empty($place['tags']) ? explode(',', $place['tags']) : [];
    foreach ($tags as $tag) {
        $trimmed_tag = htmlspecialchars(trim($tag));
        echo '<a href="listing.php?search=' . urlencode($trimmed_tag) . '">' . $trimmed_tag . '</a>';
    }
    ?>
</div>
            <h1 class="place_info--name"><?= htmlspecialchars($place['name']) ?></h1>
            <div class="place_info--extra">
                <?php
                $rating_query = $conn->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM reviews WHERE place_id = ?");
                $rating_query->bind_param("i", $place_id);
                $rating_query->execute();
                $rating_result = $rating_query->get_result();
                $rating_data = $rating_result->fetch_assoc();
                $avg_rating = $rating_data['avg_rating'] ?? 0;
                $total_reviews = $rating_data['total_reviews'] ?? 0;
                $percentage = ($avg_rating / 5) * 100;
                $rating_query->close();
                ?>
                <div class="extra_stars_container">
                    <div class="extra_stars" style="background: linear-gradient(90deg, #A21111 <?= $percentage ?>%, #D0D0D0 <?= $percentage ?>%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <i class="fa-solid fa-star star-rating"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="extra_rating"><?= number_format($avg_rating, 1) ?></span>
                </div>
                <h3 class="extra_price"><?= htmlspecialchars($place['price']) ?></h3>
                <a href="#" class="extra_category">
                    <?php
                    $category_query = $conn->prepare("SELECT name FROM categories WHERE id = ?");
                    $category_query->bind_param("i", $place['category_id']);
                    $category_query->execute();
                    $category_result = $category_query->get_result();
                    $category_row = $category_result->fetch_assoc();
                    $category_query->close();
                    $category_raw = strtolower($category_row['name'] ?? '');
                    $category_names = [
                        'restaurants' => 'RESTAURANTS',
                        'shopping' => 'SHOPPING',
                        'active-life' => 'ACTIVE LIFE',
                        'home s' => 'HOME SERVICES',
                        'coffee' => 'COFFEE',
                        'pets' => 'PETS',
                        'plants' => 'PLANTS SHOP',
                        'art' => 'ART',
                        'hotal' => 'HOTELS',
                        'edu' => 'EDUCATION',
                        'health' => 'HEALTH',
                        'workspace' => 'WORKSPACE'
                    ];
                    echo htmlspecialchars($category_names[$category_raw] ?? $category_row['name'] ?? 'Unknown Category');
                    ?>
                </a>
            </div>
        </div>
        
    </div>

    <?php if (!empty($place['email']) || !empty($place['phone_1']) || !empty($place['phone_2']) || !empty($place['website']) || !empty($place['facebook_url']) || !empty($place['instagram_url']) || !empty($place['twitter_url'])): ?>
        <div class="place_CONTACT">
            <h2 class="place-title">CONTACT INFO</h2>
            <div class="place_CONTACT--info">
                <?php
                if (!empty($place['email'])) {
                    echo '<div class="place_CONTACT--info-item">EMAIL: <a href="mailto:' . htmlspecialchars($place['email']) . '">' . htmlspecialchars($place['email']) . '</a></div>';
                }
                if (!empty($place['website'])) {
                    echo '<div class="place_CONTACT--info-item">WEBSITE: <a href="' . htmlspecialchars($place['website']) . '" target="_blank">' . htmlspecialchars($place['website']) . '</a></div>';
                }
                if (!empty($place['phone_1'])) {
                    echo '<div class="place_CONTACT--info-item">PHONE(1): <a href="tel:' . htmlspecialchars($place['phone_1']) . '">' . htmlspecialchars($place['phone_1']) . '</a></div>';
                }
                if (!empty($place['phone_2'])) {
                    echo '<div class="place_CONTACT--info-item">PHONE(2): <a href="tel:' . htmlspecialchars($place['phone_2']) . '">' . htmlspecialchars($place['phone_2']) . '</a></div>';
                }
                ?>
            </div>
            <div class="place_CONTACT--social">
                <?php
                if (!empty($place['facebook_url'])) {
                    echo '<a href="' . htmlspecialchars($place['facebook_url']) . '" target="_blank"><i class="fa-brands fa-square-facebook"></i></a>';
                }
                if (!empty($place['instagram_url'])) {
                    echo '<a href="' . htmlspecialchars($place['instagram_url']) . '" target="_blank"><i class="fa-brands fa-instagram"></i></a>';
                }
                if (!empty($place['twitter_url'])) {
                    echo '<a href="' . htmlspecialchars($place['twitter_url']) . '" target="_blank"><i class="fa-brands fa-square-x-twitter"></i></a>';
                }
                ?>
            </div>
        </div>
    <?php endif; ?>

    <?php
    $menu_query = $conn->prepare("SELECT name, price, description, image FROM menu_items WHERE place_id = ?");
    $menu_query->bind_param("i", $place_id);
    $menu_query->execute();
    $menu_result = $menu_query->get_result();
    if ($menu_result->num_rows > 0):
    ?>
        <div class="place_menu">
            <h2 class="place-title">MENU</h2>
            <div class="place_menu--grid">
                <?php while ($menu_item = $menu_result->fetch_assoc()): ?>
                    <div class="place_menu--item">
                        <div class="menu_item--img">
                            <img src="<?= htmlspecialchars($menu_item['image'] ?: 'assets/images/default_menu.jpg') ?>" alt="<?= htmlspecialchars($menu_item['name']) ?>">
                        </div>
                        <div class="menu_item--info">
                            <div class="menu_item--info-name">
                                <h3><?= htmlspecialchars($menu_item['name']) ?></h3>
                                <h3>$<?= htmlspecialchars(number_format($menu_item['price'], 2)) ?></h3>
                            </div>
                            <p class="menu_item--info-text"><?= htmlspecialchars($menu_item['description']) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php
    endif;
    $menu_query->close();
    ?>

    <?php if (!empty($place['description'])): ?>
        <div class="place_description">
            <h2 class="place-title">DESCRIPTION</h2>
            <p class="place_description--text"><?= htmlspecialchars($place['description']) ?></p>
        </div>
    <?php endif; ?>

    <?php
    $hours_query = $conn->prepare("SELECT day, open_time, close_time FROM opening_hours WHERE place_id = ?");
    $hours_query->bind_param("i", $place_id);
    $hours_query->execute();
    $hours_result = $hours_query->get_result();
    if ($hours_result->num_rows > 0):
    ?>
        <div class="place_time">
            <h2 class="place-title">OPENING HOURS</h2>
            <table class="place_time--table">
                <?php while ($hours = $hours_result->fetch_assoc()): ?>
                    <tr>
                        <td class="place_time--table-day"><?= htmlspecialchars($hours['day']) ?>:</td>
                        <td class="place_time--table-hour">
                            <?= $hours['open_time'] && $hours['close_time'] ? htmlspecialchars($hours['open_time'] . ' - ' . $hours['close_time']) : 'Closed' ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    <?php
    endif;
    $hours_query->close();
    ?>

    <?php
    $faq_query = $conn->prepare("SELECT question, answer FROM faqs WHERE place_id = ?");
    $faq_query->bind_param("i", $place_id);
    $faq_query->execute();
    $faq_result = $faq_query->get_result();
    if ($faq_result->num_rows > 0):
    ?>
        <div class="faq">
            <h2 class="place-title">FAQ's</h2>
            <div class="faq-container">
                <?php while ($faq = $faq_result->fetch_assoc()): ?>
                    <div class="faq-item">
                        <button class="faq-question"><?= htmlspecialchars($faq['question']) ?></button>
                        <div class="faq-answer" style="display: none;">
                            <p><?= htmlspecialchars($faq['answer']) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php
    endif;
    $faq_query->close();
    ?>

    <div class="reviews" id="reviews">
        <h2 class="place-title">REVIEWS</h2>
        <div class="reviews_overall">
            <div class="reviews_overall--L">
                <h2>Overall rating</h2>
                <div class="overall_stars" style="background: linear-gradient(90deg, #A21111 <?= $percentage ?>%, #D0D0D0 <?= $percentage ?>%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <i class="fa-solid fa-star star-rating"></i>
                    <?php endfor; ?>
                </div>
                <p><?= number_format($avg_rating, 1) ?> out of 5</p>
                <p><?= $total_reviews ?> reviews</p>
            </div>
            <div class="reviews_overall--R">
                <?php
                $ratings_counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
                $ratings_query = $conn->prepare("SELECT rating, COUNT(*) AS count FROM reviews WHERE place_id = ? GROUP BY rating");
                $ratings_query->bind_param("i", $place_id);
                $ratings_query->execute();
                $ratings_result = $ratings_query->get_result();
                while ($row = $ratings_result->fetch_assoc()) {
                    $ratings_counts[(int)$row['rating']] = (int)$row['count'];
                }
                $ratings_query->close();
                foreach (array_reverse(range(1, 5)) as $i):
                    $percent = $total_reviews > 0 ? ($ratings_counts[$i] / $total_reviews) * 100 : 0;
                ?>
                    <div class="stars_p">
                        <p><?= $i ?> STARS</p>
                        <div class="stars_p--<?= $i ?>">
                            <div class="stars_p--color" style="width: <?= $percent ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="reviews_container">
            <?php
            $reviews_query = $conn->prepare("
                SELECT r.id AS review_id, r.user_id, r.rating, r.review_text, r.created_at,
                       CONCAT(u.first_name, ' ', u.last_name) AS user_name, u.profile_image
                FROM reviews r JOIN users u ON r.user_id = u.id
                WHERE r.place_id = ?
                ORDER BY r.created_at DESC
            ");
            $reviews_query->bind_param("i", $place_id);
            $reviews_query->execute();
            $reviews_result = $reviews_query->get_result();
            if ($reviews_result->num_rows > 0):
                while ($review = $reviews_result->fetch_assoc()):
                    $review_id = $review['review_id'];
                    $rating = (int)$review['rating'];
                    $percentage = ($rating / 5) * 100;
                    $created_at = date("M j, Y", strtotime($review['created_at']));
                    $profile_image = $review['profile_image'] ?: 'assets/images/profiles/pro_null.png';
                    $can_edit = (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $review['user_id'] || $is_admin));
            ?>
                <div class="review" id="review_<?= $review_id ?>">
                    <div class="review_profile">
                        <a href="profile.php?user_id=<?= urlencode($review['user_id']) ?>" class="review_profile--img">
                            <img src="<?= htmlspecialchars($profile_image) ?>" alt="User Profile">
                        </a>
                        <div class="review_profile--info">
                            <a href="profile.php?user_id=<?= urlencode($review['user_id']) ?>" class="review_profile--info-name">
                                <?= htmlspecialchars($review['user_name']) ?>
                            </a>
                            <div class="review_profile--info-stars">
                                <div class="review_stars" style="background: linear-gradient(90deg, #A21111 <?= $percentage ?>%, #D0D0D0 <?= $percentage ?>%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fa-solid fa-star star-rating"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="review-date"><?= $created_at ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="review_text">
                        <p><?= htmlspecialchars($review['review_text']) ?></p>
                    </div>
                    <div class="review_gallery">
                        <?php
                        $gallery_query = $conn->prepare("SELECT image_url FROM review_images WHERE review_id = ?");
                        $gallery_query->bind_param("i", $review_id);
                        $gallery_query->execute();
                        $gallery_result = $gallery_query->get_result();
                        while ($image = $gallery_result->fetch_assoc()):
                        ?>
                            <a href="<?= htmlspecialchars($image['image_url']) ?>" class="review_gallery-img" target="_blank">
                                <img src="<?= htmlspecialchars($image['image_url']) ?>" alt="Review Image">
                            </a>
                        <?php endwhile; $gallery_query->close(); ?>
                    </div>
                    <div class="review_btns">
                        <?php if ($can_edit): ?>
                            <button type="button" class="btn__red--s btn__red btn" onclick="showEditForm(<?= $review_id ?>)">edit review</button>
                            <button type="button" class="btn__red--s btn__red btn" onclick="deleteReview(<?= $review_id ?>)">delete review</button>
                        <?php endif; ?>
                        <?php if ($is_owner || $is_admin): ?>
                            <button type="button" class="btn__transparent--s btn__transparent btn" onclick="showCommentForm(<?= $review_id ?>)">comment on review</button>
                        <?php endif; ?>
                        <button class="btn__transparent--s btn__transparent btn" onclick="toggleLike(event, <?= $review_id ?>)">
                            <i class="<?= in_array($review_id, $is_liked_reviews) ? 'fa-solid fa-heart' : 'fa-regular fa-heart' ?>"></i> Like
                        </button>
                    </div>
                    <?php if ($can_edit): ?>
                        <form id="editForm-<?= $review_id ?>" method="POST" action="edit_review.php" enctype="multipart/form-data" style="display: none;" class="edit-review-form">
                            <input type="hidden" name="review_id" value="<?= $review_id ?>">
                            <input type="hidden" name="place_id" value="<?= $place_id ?>">
                            <input type="hidden" name="rating" id="rating-<?= $review_id ?>" value="<?= $rating ?>">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <div class="addReview_stars" data-review-id="<?= $review_id ?>">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa-solid fa-star <?= $i <= $rating ? 'selected' : '' ?>" data-value="<?= $i ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <a class="btn__transparent--s btn__transparent btn" href="#" onclick="document.getElementById('imageInput-<?= $review_id ?>').click(); return false;">add photos</a>
                            <input type="file" name="review_images[]" id="imageInput-<?= $review_id ?>" multiple accept="image/*" style="display: none;">
                            <div class="image-preview" id="imagePreview-<?= $review_id ?>">
                                <?php
                                $img_q = $conn->prepare("SELECT id, image_url FROM review_images WHERE review_id = ?");
                                $img_q->bind_param("i", $review_id);
                                $img_q->execute();
                                $img_r = $img_q->get_result();
                                while ($img = $img_r->fetch_assoc()):
                                    $img_id = (int)$img['id'];
                                    $img_url = htmlspecialchars($img['image_url']);
                                ?>
                                    <div class="image-thumb" data-img-id="<?= $img_id ?>">
                                        <img src="<?= $img_url ?>" alt="">
                                        <span class="remove-image existing">×</span>
                                    </div>
                                <?php endwhile; $img_q->close(); ?>
                            </div>
                            <textarea name="review_text" required><?= htmlspecialchars($review['review_text']) ?></textarea>
                            <button type="submit" name="edit_review" class="btn__red--s btn__red btn">Save Changes</button>
                        </form>
                    <?php endif; ?>
                    <?php
                    $comments_query = $conn->prepare("SELECT id, user_id, comment, created_at FROM review_comments WHERE review_id = ?");
                    $comments_query->bind_param("i", $review_id);
                    $comments_query->execute();
                    $comments_result = $comments_query->get_result();
                    if ($comments_result->num_rows > 0):
                        echo '<div class="review_placeComment"><h4>Place owner commented</h4>';
                        while ($comment = $comments_result->fetch_assoc()):
                            $comment_text = htmlspecialchars($comment['comment']);
                            $comment_date = date("M j, Y", strtotime($comment['created_at']));
                            $comment_id = $comment['id'];
                            $comment_user_id = $comment['user_id'];
                            echo "<div class='comment-date'>{$comment_date}</div>";
                            echo "<div class='single-comment' id='comment-{$comment_id}'>";
                            echo "<div class='comment-content'>";
                            echo "<p id='comment-text-{$comment_id}'>{$comment_text}</p>";
                            echo "<textarea id='edit-textarea-{$comment_id}' style='display:none'>{$comment_text}</textarea>";
                            echo "</div></div>";
                            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment_user_id) {
                                echo "<div class='comment__actions'>";
                                echo "<button onclick='editComment({$comment_id})' class='btn__red--s btn__red btn'>Edit Comment</button>";
                                echo "<button onclick='saveComment({$comment_id})' class='btn__red--s btn__red btn' style='display:none'>Save</button>";
                                echo "<button onclick='deleteComment({$comment_id})' class='btn__red--s btn__red btn'>Delete Comment</button>";
                                echo "</div>";
                            }
                        endwhile;
                        echo '</div>';
                    endif;
                    $comments_query->close();
                    ?>
                    <?php if ($is_owner || $is_admin): ?>
                        <form id="commentForm-<?= $review_id ?>" method="POST" action="submit_owner_comment.php" style="display: none;">
                            <input type="hidden" name="review_id" value="<?= $review_id ?>">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <textarea name="comment" placeholder="add comment on review" required></textarea>
                            <button type="submit" class="btn__transparent--s btn__transparent btn">submit comment</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
            <?php else: ?>
                <p>No reviews available.</p>
            <?php endif; $reviews_query->close(); ?>
        </div>
    </div>

    <div class="addReview">
        <h2 class="place-title">WRITE A REVIEW</h2>
        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST" action="add_review.php" id="reviewForm" enctype="multipart/form-data">
                <div class="addReview_container">
                    <div class="addReview_stars">
                        <input type="hidden" name="rating" id="rating" value="0">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa-solid fa-star" data-value="<?= $i ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="place_id" value="<?= $place_id ?>">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <a class="btn__transparent--s btn__transparent btn" href="#" onclick="document.getElementById('imageInput').click(); return false;">add photos</a>
                    <input type="file" name="images[]" id="imageInput" multiple style="display: none;" accept="image/*">
                    <div id="imagePreview" class="image-preview"></div>
                    <textarea name="review_text" id="review_text" placeholder="Your review" required></textarea>
                    <button type="submit" name="submit_review" class="btn__red--l btn__red btn" id="submitButton">ADD REVIEW</button>
                </div>
            </form>
        <?php else: ?>
            <p>You must be logged in to write a review.</p>
        <?php endif; ?>
    </div>
</main>

<?php include 'footer.php'; ?>

<script>
function showEditForm(reviewId) {
    const form = document.getElementById(`editForm-${reviewId}`);
    if (!form) {
        console.warn(`Edit form for review ${reviewId} not found`);
        return;
    }
    console.log(`Showing edit form for review ${reviewId}`);
    form.style.display = 'block';
    const rating = form.querySelector('input[name="rating"]').value;
    form.querySelectorAll('.addReview_stars i').forEach(s => {
        s.style.color = s.getAttribute('data-value') <= rating ? '#A21111' : '#D0D0D0';
    });
}

function canEditReview(reviewId, currentUserId, reviewOwners, isAdmin) {
    console.log('Checking edit permission:', {
        reviewId,
        currentUserId,
        reviewOwner: reviewOwners[reviewId],
        isAdmin
    });
    if (!currentUserId) {
        console.log('No user logged in');
        return false;
    }
    if (!reviewOwners[reviewId]) {
        console.log('Review ID not found in reviewOwners');
        return false;
    }
    return currentUserId === reviewOwners[reviewId] || isAdmin;
}

document.addEventListener('DOMContentLoaded', function() {
    // FAQ toggle
    document.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', () => {
            const answer = btn.nextElementSibling;
            answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
        });
    });

    // Star rating
    document.querySelectorAll('.addReview_stars i').forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-value');
            const form = this.closest('form');
            const ratingInput = form.querySelector('input[name="rating"]');
            ratingInput.value = rating;
            form.querySelectorAll('.addReview_stars i').forEach(s => {
                s.style.color = s.getAttribute('data-value') <= rating ? '#A21111' : '#D0D0D0';
            });
        });
    });

    // Review navigation
    const currentUserId = <?= json_encode($_SESSION['user_id'] ?? null) ?>;
    const isAdmin = <?= json_encode($is_admin) ?>;
    const reviewOwners = <?= json_encode($review_owners) ?>;
    const params = new URLSearchParams(window.location.search);
    const rid = params.get('review_id');
    const action = params.get('action');

    if (rid) {
        console.log(`Processing review_id: ${rid}`);
        const el = document.getElementById(`review_${rid}`);
        if (el) {
            console.log(`Scrolling to review_${rid}`);
            el.scrollIntoView({ behavior: 'smooth' });
        } else {
            console.warn(`Review element review_${rid} not found`);
        }
        if (action === 'edit' && canEditReview(rid, currentUserId, reviewOwners, isAdmin)) {
            console.log(`User can edit review ${rid}, calling showEditForm`);
            showEditForm(rid);
        } else {
            console.log(`Edit form not shown for review ${rid}: action=${action}, canEdit=${canEditReview(rid, currentUserId, reviewOwners, isAdmin)}`);
        }
    } else {
        console.log('No review_id in URL');
    }
});

const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');
let selectedImages = [];

imageInput.addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    const totalImages = selectedImages.length + files.length;
    if (totalImages > 4) {
        alert("You can upload a maximum of 4 images.");
        return;
    }
    files.forEach(file => {
        if (selectedImages.length >= 4) return;
        const reader = new FileReader();
        reader.onload = function(event) {
            const previewContainer = document.createElement('div');
            previewContainer.classList.add('image-thumb');
            const img = document.createElement('img');
            img.src = event.target.result;
            const removeBtn = document.createElement('span');
            removeBtn.classList.add('remove-image');
            removeBtn.innerHTML = '×';
            removeBtn.onclick = function() {
                imagePreview.removeChild(previewContainer);
                selectedImages = selectedImages.filter(i => i !== file);
                updateFileList();
            };
            previewContainer.appendChild(img);
            previewContainer.appendChild(removeBtn);
            imagePreview.appendChild(previewContainer);
        };
        reader.readAsDataURL(file);
        selectedImages.push(file);
    });
    updateFileList();
});

function updateFileList() {
    const dataTransfer = new DataTransfer();
    selectedImages.forEach(file => dataTransfer.items.add(file));
    imageInput.files = dataTransfer.files;
}

function deleteReview(reviewId) {
    if (!confirm("Are you sure you want to delete your review?")) return;
    fetch('delete_review.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `review_id=${reviewId}&csrf_token=<?= urlencode($_SESSION['csrf_token']) ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const reviewElem = document.querySelector(`#review_${reviewId}`);
            if (reviewElem) reviewElem.remove();
        } else {
            alert("Failed to delete review: " + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred while deleting the review.");
    });
}

function showCommentForm(reviewId) {
    const form = document.getElementById(`commentForm-${reviewId}`);
    if (form) form.style.display = 'block';
}

function editComment(commentId) {
    const commentText = document.getElementById(`comment-${commentId}`);
    const editButton = document.querySelector(`button[onclick="editComment(${commentId})"]`);
    const saveButton = document.querySelector(`button[onclick="saveComment(${commentId})"]`);
    commentText.contentEditable = 'true';
    commentText.style.backgroundColor = '#f0f0f0';
    editButton.style.display = 'none';
    saveButton.style.display = 'inline';
}

function saveComment(commentId) {
    const commentText = document.getElementById(`comment-${commentId}`).innerText;
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_comment.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById(`comment-${commentId}`).contentEditable = 'false';
            document.getElementById(`comment-${commentId}`).style.backgroundColor = 'transparent';
            document.querySelector(`button[onclick="saveComment(${commentId})"]`).style.display = 'none';
            document.querySelector(`button[onclick="editComment(${commentId})"]`).style.display = 'inline';
        } else {
            alert('Error saving the comment.');
        }
    };
    xhr.send(`comment_id=${commentId}&comment_text=${encodeURIComponent(commentText)}&csrf_token=<?= urlencode($_SESSION['csrf_token']) ?>`);
}

function deleteComment(commentId) {
    if (!confirm("Are you sure you want to delete this comment?")) return;
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_owner_comment.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(`comment_id=${commentId}&csrf_token=<?= urlencode($_SESSION['csrf_token']) ?>`);
    xhr.onload = function() {
        try {
            const response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                const commentDiv = document.getElementById(`comment-${commentId}`);
                const reviewPlaceCommentDiv = commentDiv.closest('.review_placeComment');
                reviewPlaceCommentDiv.style.display = 'none';
            } else {
                alert(response.message);
            }
        } catch (e) {
            console.error("Invalid JSON response", xhr.responseText);
        }
    };
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.edit-review-form').forEach(form => {
        const reviewId = form.querySelector('input[name="review_id"]').value;
        const preview = document.getElementById(`imagePreview-${reviewId}`);
        const fileInput = document.getElementById(`imageInput-${reviewId}`);
        let newFiles = [];
        preview.addEventListener('click', e => {
            if (!e.target.matches('.remove-image.existing')) return;
            const thumb = e.target.closest('.image-thumb');
            const imgId = thumb.getAttribute('data-img-id');
            thumb.remove();
            const delInp = document.createElement('input');
            delInp.type = 'hidden';
            delInp.name = 'delete_images[]';
            delInp.value = imgId;
            form.appendChild(delInp);
        });
        fileInput.addEventListener('change', () => {
            const existingCount = preview.querySelectorAll('.image-thumb').length;
            const files = Array.from(fileInput.files);
            if (existingCount + newFiles.length + files.length > 4) {
                alert("Max 4 images total");
                fileInput.value = '';
                return;
            }
            files.forEach(file => {
                if (newFiles.length >= 4 - existingCount) return;
                const reader = new FileReader();
                reader.onload = ev => {
                    const thumb = document.createElement('div');
                    thumb.className = 'image-thumb';
                    thumb.innerHTML = `<img src="${ev.target.result}"><span class="remove-image new">×</span>`;
                    thumb.querySelector('.remove-image.new').onclick = () => {
                        thumb.remove();
                        newFiles = newFiles.filter(f => f !== file);
                        syncFiles();
                    };
                    preview.appendChild(thumb);
                };
                reader.readAsDataURL(file);
                newFiles.push(file);
            });
            syncFiles();
        });
        function syncFiles() {
            const dt = new DataTransfer();
            newFiles.forEach(f => dt.items.add(f));
            fileInput.files = dt.files;
        }
    });
    document.querySelectorAll('form[id^="commentForm-"]').forEach(form => {
        form.addEventListener('submit', () => {
            form.style.display = 'none';
        });
    });
});
</script>