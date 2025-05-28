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
        <div class="delete_edit-places--div">
            <a href="edit_place.php?place_id=<?php echo $place['id']; ?>" class="btn__red btn__red--l btn">EDIT PLACE</a>
            <form action="delete_place.php" method="POST" style="display:inline;"
                onsubmit="return confirm('Are you sure you want to delete this place? This action cannot be undone.');">
                <input type="hidden" name="place_id" value="<?= htmlspecialchars($place['id']) ?>">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="redirect_to"
                    value="<?= htmlspecialchars($_SERVER['HTTP_REFERER'] ?? 'index.php') ?>">
                <button type="submit" class="btn__dark btn__dark--l btn">DELETE PLACE</button>
            </form>
        </div>
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
                $rating_result = $rating_query->get_result(); // Fixed: Use $rating_query instead of $conn
                $rating_data = $rating_result->fetch_assoc();
                $avg_rating = $rating_data['avg_rating'] ?? 0;
                $total_reviews = $rating_data['total_reviews'] ?? 0;
                $percentage = ($avg_rating / 5) * 100;
                $rating_query->close();
                ?>
                <div class="extra_stars_container" id="extra-stars-container">
                    <div class="extra_stars"
                        style="background: linear-gradient(90deg, #A21111 <?= $percentage ?>%, #D0D0D0 <?= $percentage ?>%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                        <i class="fa-solid fa-star star-rating"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="extra_rating" id="extra-rating"><?= number_format($avg_rating, 1) ?></span>
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
                        'hotel' => 'HOTELS',
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
        $section_title = 'MENU';
        $category_raw = strtolower($category_row['name'] ?? '');
        $section_titles = [
            'restaurants' => 'MENU',
            'coffee' => 'MENU',
            'active-life' => 'ACTIVITIES',
            'shopping' => 'PRODUCTS',
            'home s' => 'SERVICES',
            'pets' => 'PET SERVICES',
            'plants' => 'PLANTS',
            'art' => 'ARTWORKS',
            'hotel' => 'AMENITIES',
            'edu' => 'COURSES',
            'health' => 'SERVICES',
            'workspace' => 'FACILITIES'
        ];
        $section_title = $section_titles[$category_raw] ?? 'MENU';
    ?>
    <div class="place_menu">
        <h2 class="place-title"><?= htmlspecialchars($section_title) ?></h2>
        <div class="place_menu--grid">
            <?php while ($menu_item = $menu_result->fetch_assoc()): ?>
            <div class="place_menu--item">
                <div class="menu_item--img">
                    <img src="<?= htmlspecialchars($menu_item['image'] ?: 'assets/images/default_menu.jpg') ?>"
                        alt="<?= htmlspecialchars($menu_item['name']) ?>">
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
                    <?php
                    if ($hours['open_time'] && $hours['close_time']) {
                        $open_time = date("h:i A", strtotime($hours['open_time']));
                        $close_time = date("h:i A", strtotime($hours['close_time']));
                        echo htmlspecialchars("$open_time - $close_time");
                    } else {
                        echo 'Closed';
                    }
                    ?>
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
        <div class="reviews_overall--L" id="reviews-overall-l">
            <h2>Overall rating</h2>
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
            <div class="overall_stars" id="overall-stars"
                style="background: linear-gradient(90deg, #A21111 <?= $percentage ?>%, #D0D0D0 <?= $percentage ?>%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <?php for ($i = 0; $i < 5; $i++): ?>
                <i class="fa-solid fa-star star-rating"></i>
                <?php endfor; ?>
            </div>
            <p id="overall-rating"><?= number_format($avg_rating, 1) ?> out of 5</p>
            <p id="total-reviews"><?= $total_reviews ?> reviews</p>
        </div>
        <div class="reviews_overall--R" id="reviews-overall-r">
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
            <div class="stars_p" id="stars-p-<?= $i ?>">
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
            SELECT r.id, r.user_id, r.rating, r.review_text, r.created_at,
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
                $review_id = $review['id'];
                $gallery_query = $conn->prepare("SELECT image_url FROM review_images WHERE review_id = ?");
                $gallery_query->bind_param("i", $review_id);
                $gallery_query->execute();
                $gallery_result = $gallery_query->get_result();
                $images = [];
                while ($image = $gallery_result->fetch_assoc()) {
                    $images[] = $image;
                }
                $gallery_query->close();
                $can_edit = (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $review['user_id'] || $is_admin));
                $is_liked = in_array($review_id, $is_liked_reviews);
                include 'review_template.php';
            endwhile;
        else:
        ?>
        <p>No reviews available.</p>
        <?php endif; $reviews_query->close(); ?>
    </div>
</div>

    <div class="addReview">
        <h2 class="place-title">WRITE A REVIEW</h2>
        
        <form method="POST" id="reviewForm" enctype="multipart/form-data">
            <div class="addReview_container">
                <div class="addReview_stars">
                    <input type="hidden" name="rating" id="rating" value="0">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="fa-solid fa-star" data-value="<?= $i ?>"></i>
                    <?php endfor; ?>
                </div>
                <input type="hidden" name="place_id" value="<?= $place_id ?>">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <a class="btn__transparent--s btn__transparent btn" href="#"
                    onclick="document.getElementById('imageInput').click(); return false;">add photos</a>
                <input type="file" name="images[]" id="imageInput" multiple style="display: none;" accept="image/*">
                <div id="imagePreview" class="image-preview"></div>
                <textarea name="review_text" id="review_text" placeholder="Your review" required></textarea>
                <button type="submit" name="submit_review" class="btn__red--l btn__red btn" id="submitButton">ADD
                    REVIEW</button>
            </div>
        </form>
        
    </div>
</main>

<?php include 'footer.php'; ?>



<script>
window.addEventListener('load', function() { // Changed from 'DOMContentLoaded' to 'load'
    // FAQ toggle
    document.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', () => {
            const answer = btn.nextElementSibling;
            answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
        });
    });

    // Bind star ratings for add review form
    if (typeof bindStarRating === 'function') { // Added check for function existence
        bindStarRating('.addReview_container .addReview_stars');

        // Bind star ratings for all edit forms
        document.querySelectorAll('.edit-review-form .addReview_stars').forEach(container => {
            bindStarRating(`#${container.closest('.edit-review-form').id} .addReview_stars`);
        });
    } else {
        console.error('bindStarRating function is not defined. Ensure ajax_review.js is loaded correctly.');
    }

    // Event delegation for review and comment buttons
    document.querySelector('.reviews_container').addEventListener('click', function(e) {
        const target = e.target.closest('button');
        if (!target) return;

        const reviewId = target.getAttribute('data-review-id');
        const commentId = target.getAttribute('data-comment-id');

        if (target.matches('.like-btn')) {
            toggleLike(reviewId);
        } else if (target.matches('.edit-review')) {
            const form = document.getElementById(`editForm-${reviewId}`);
            if (form) {
                form.style.display = form.style.display === 'block' ? 'none' : 'block';
                if (typeof bindStarRating === 'function') { // Added check
                    bindStarRating(`#editForm-${reviewId} .addReview_stars`);
                } else {
                    console.error('bindStarRating function is not defined for edit form.');
                }
            }
        } else if (target.matches('.delete-review')) {
            deleteReview(reviewId);
        } else if (target.matches('.comment-review')) {
            showCommentForm(reviewId);
        } else if (target.matches('.comment-edit')) {
            editComment(commentId);
        } else if (target.matches('.comment-save')) {
            saveComment(commentId);
        } else if (target.matches('.comment-delete')) {
            deleteComment(commentId);
        }
    });

    // Comment form submission with event delegation
    document.querySelector('.reviews_container').addEventListener('submit', function(e) {
        if (!e.target.matches('.place--owner-comment-form')) return;
        e.preventDefault();
        if (!<?php echo json_encode(isset($_SESSION['user_id'])); ?>) {
            alert('You must be logged in to comment.');
            return;
        }

        const form = e.target;
        const formData = new FormData(form);
        const reviewId = formData.get('review_id');

        fetch('submit_owner_comment.php', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const commentId = data.comment_id;
                const commentText = formData.get('comment');
                const reviewPlaceComment = document.getElementById(`review_placeComment_${reviewId}`);
                const commentDiv = document.createElement('div');
                commentDiv.className = 'single-comment';
                commentDiv.id = `comment-${commentId}`;
                commentDiv.innerHTML = `
                    <div class="comment_content">
                        <p class="comment_date">${new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</p>
                        <p id="comment-text-${commentId}">${commentText}</p>
                        <textarea id="edit-textarea-${commentId}" style="display:none">${commentText}</textarea>
                        <div class="comment__actions">
                            <button class="btn__red--s btn__red btn comment-edit" data-comment-id="${commentId}">Edit Comment</button>
                            <button class="btn__red--s btn__red btn comment-save" data-comment-id="${commentId}" style="display:none">Save</button>
                            <button class="btn__red--s btn__red btn comment-delete" data-comment-id="${commentId}">Delete Comment</button>
                        </div>
                    </div>
                `;
                const review = document.getElementById(`review_${reviewId}`);
                if (!review) {
                    alert('Review not found. Please refresh the page.');
                    return;
                }
                if (reviewPlaceComment) {
                    reviewPlaceComment.appendChild(commentDiv);
                } else {
                    const newCommentSection = document.createElement('div');
                    newCommentSection.className = 'review_placeComment';
                    newCommentSection.id = `review_placeComment_${reviewId}`;
                    newCommentSection.innerHTML = '<h4>Place owner commented</h4>';
                    newCommentSection.appendChild(commentDiv);
                    const commentForm = document.getElementById(`commentForm-${reviewId}`);
                    if (commentForm) {
                        review.insertBefore(newCommentSection, commentForm);
                    } else {
                        review.appendChild(newCommentSection);
                    }
                }
                form.reset();
                form.style.display = 'none';
                commentDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                alert('Error adding comment: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error adding comment:', error);
            alert('Error adding comment: ' + error.message);
        });
    });

    // Review navigation
    const currentUserId = <?php echo json_encode($_SESSION['user_id'] ?? null); ?>;
    const isAdmin = <?php echo json_encode($is_admin); ?>;
    const reviewOwners = <?php echo json_encode($review_owners); ?>;
    const params = new URLSearchParams(window.location.search);
    const rid = params.get('review_id');
    const action = params.get('action');

    if (rid && document.getElementById(`review_${rid}`)) {
        document.getElementById(`review_${rid}`).scrollIntoView({ behavior: 'smooth' });
        if (action === 'edit' && canEditReview(rid, currentUserId, reviewOwners, isAdmin)) {
            const form = document.getElementById(`editForm-${rid}`);
            if (form) {
                form.style.display = 'block';
                if (typeof bindStarRating === 'function') { // Added check
                    bindStarRating(`#editForm-${rid} .addReview_stars`);
                } else {
                    console.error('bindStarRating function is not defined for edit action.');
                }
            }
        }
    }

    function canEditReview(reviewId, currentUserId, reviewOwners, isAdmin) {
        return currentUserId && reviewOwners[reviewId] && (currentUserId === reviewOwners[reviewId] || isAdmin);
    }

    function deleteReview(reviewId) {
        if (!confirm('Are you sure you want to delete your review?')) return;
        fetch('delete_review.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
            body: `review_id=${encodeURIComponent(reviewId)}&csrf_token=${encodeURIComponent('<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>')}`
        })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById(`review_${reviewId}`)?.remove();
                updateRatingsFromServer();
            } else {
                alert('Failed to delete review: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => alert('Error deleting review: ' + error.message));
    }

    function showCommentForm(reviewId) {
        const form = document.getElementById(`commentForm-${reviewId}`);
        if (form) form.style.display = 'flex';
    }

    function editComment(commentId) {
        const commentText = document.getElementById(`comment-text-${commentId}`);
        const editTextarea = document.getElementById(`edit-textarea-${commentId}`);
        const editButton = document.querySelector(`button[data-comment-id="${commentId}"].comment-edit`);
        const saveButton = document.querySelector(`button[data-comment-id="${commentId}"].comment-save`);
        if (commentText && editTextarea && editButton && saveButton) {
            commentText.style.display = 'none';
            editTextarea.style.display = 'block';
            editButton.style.display = 'none';
            saveButton.style.display = 'inline';
        }
    }

    function saveComment(commentId) {
        const editTextarea = document.getElementById(`edit-textarea-${commentId}`);
        const commentText = document.getElementById(`comment-text-${commentId}`);
        const editButton = document.querySelector(`button[data-comment-id="${commentId}"].comment-edit`);
        const saveButton = document.querySelector(`button[data-comment-id="${commentId}"].comment-save`);
        if (!editTextarea || !commentText || !editButton || !saveButton) return;
        const newText = editTextarea.value.trim();
        if (!newText) {
            alert('Comment cannot be empty');
            return;
        }
        fetch('edit_owner_comment.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `comment_id=${encodeURIComponent(commentId)}&comment_text=${encodeURIComponent(newText)}&csrf_token=${encodeURIComponent('<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>')}&update_comment=true`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                commentText.textContent = newText;
                commentText.style.display = 'block';
                editTextarea.style.display = 'none';
                editButton.style.display = 'inline';
                saveButton.style.display = 'none';
            } else {
                alert('Error saving comment: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => alert('Error saving comment: ' + error.message));
    }

    function deleteComment(commentId) {
        if (!confirm('Are you sure you want to delete this comment?')) return;
        fetch('delete_owner_comment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `comment_id=${encodeURIComponent(commentId)}&csrf_token=${encodeURIComponent('<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>')}`
        })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                const comment = document.getElementById(`comment-${commentId}`);
                if (!comment) return;
                const reviewPlaceComment = comment.closest('.review_placeComment');
                comment.remove();
                if (reviewPlaceComment && !reviewPlaceComment.querySelector('.single-comment')) {
                    reviewPlaceComment.remove();
                }
            } else {
                alert('Error deleting comment: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error deleting comment:', error);
            alert('Error deleting comment: ' + error.message);
        });
    }

    function updateRatingsFromServer() {
        fetch(`get_ratings.php?place_id=<?php echo htmlspecialchars($place_id); ?>`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => {
            if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);
            return res.json();
        })
        .then(ratings => {
            if (ratings.success) {
                updateRatings(ratings.avg_rating, ratings.total_reviews, ratings.ratings_counts);
            } else {
                console.error('Failed to fetch ratings:', ratings.error);
            }
        })
        .catch(err => console.error('Error fetching ratings:', err));
    }

    function updateRatings(avgRating, totalReviews, ratingsCounts) {
        const safeAvgRating = typeof avgRating === 'number' ? avgRating : parseFloat(avgRating) || 0;
        const extraStarsContainer = document.getElementById('extra-stars-container');
        if (extraStarsContainer) {
            const extraStars = extraStarsContainer.querySelector('.extra_stars');
            const extraRating = extraStarsContainer.querySelector('.extra_rating');
            const percentage = (safeAvgRating / 5) * 100;
            extraStars.style.background = `linear-gradient(90deg, #A21111 ${percentage}%, #D0D0D0 ${percentage}%)`;
            extraStars.style.webkitBackgroundClip = 'text';
            extraStars.style.webkitTextFillColor = 'transparent';
            if (extraRating) extraRating.textContent = safeAvgRating.toFixed(1);
        }

        const overallStarsContainer = document.getElementById('reviews-overall-l');
        if (overallStarsContainer) {
            const overallStars = overallStarsContainer.querySelector('#overall-stars');
            const overallRating = overallStarsContainer.querySelector('#overall-rating');
            const totalReviewsEl = overallStarsContainer.querySelector('#total-reviews');
            const percentage = (safeAvgRating / 5) * 100;
            overallStars.style.background = `linear-gradient(90deg, #A21111 ${percentage}%, #D0D0D0 ${percentage}%)`;
            overallStars.style.webkitBackgroundClip = 'text';
            overallStars.style.webkitTextFillColor = 'transparent';
            if (overallRating) overallRating.textContent = `${safeAvgRating.toFixed(1)} out of 5`;
            if (totalReviewsEl) totalReviewsEl.textContent = `${totalReviews} reviews`;
        }

        const overallR = document.getElementById('reviews-overall-r');
        if (overallR) {
            for (let i = 5; i >= 1; i--) {
                const starsP = document.getElementById(`stars-p-${i}`);
                if (starsP) {
                    const percent = totalReviews > 0 ? ((ratingsCounts[i] || 0) / totalReviews) * 100 : 0;
                    starsP.querySelector('.stars_p--color').style.width = `${percent}%`;
                }
            }
        }
    }

    function toggleLike(reviewId) {
        fetch('toggle_like.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `review_id=${encodeURIComponent(reviewId)}&csrf_token=${encodeURIComponent('<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>')}`
        })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const button = document.querySelector(`button.like-btn[data-review-id="${reviewId}"]`);
                const icon = button?.querySelector('i');
                if (icon) {
                    icon.className = data.liked ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
                }
            } else {
                alert('Error toggling like: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => alert('Error toggling like: ' + error.message));
    }
});
</script>