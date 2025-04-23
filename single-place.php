<?php
include 'config.php';
session_start(); // Ensure this is at the top of the file
include 'db_connect.php';



if (!isset($_GET['place_id']) || !is_numeric($_GET['place_id'])) {
    echo "<p>Invalid place ID.</p>";
    exit;
}
$place_id = (int)$_GET['place_id']; // Convert to integer for safety

include 'header.php';

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
}

$is_owner = false;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Check if user owns the place
    $owner_query = $conn->prepare("SELECT id FROM places WHERE id = ? AND user_id = ?");
    $owner_query->bind_param("ii", $place_id, $user_id);
    $owner_query->execute();
    $owner_result = $owner_query->get_result();

    if ($owner_result->num_rows > 0) {
        $is_owner = true;
    }

    $owner_query->close();
}
?>



<main class="place">
    <div class="place_gallery">
        <button class="gallery-btn left-btn">‹</button>
        <div class="place_gallery--items">
            <?php
            // Fetch gallery images for the place
            $gallery_query = $conn->prepare("SELECT image_url FROM place_gallery WHERE place_id = ?");
            $gallery_query->bind_param("i", $place_id); // Use dynamic place_id
            $gallery_query->execute();
            $gallery_result = $gallery_query->get_result();

            if ($gallery_result->num_rows > 0) {
                while ($image = $gallery_result->fetch_assoc()) {
                    echo '<div class="place_gallery--item">';
                    echo '<img src="' . htmlspecialchars($image['image_url']) . '" alt="Gallery Image">';
                    echo '</div>';
                }
            } else {
                echo '<p>No images found for place_id: ' . $place_id . '</p>'; // Debugging message
                echo '<div class="place_gallery--item">';
                echo '<img src="assets/images/default_gallery.jpg" alt="Default Image">';
                echo '</div>';
            }
            $gallery_query->close();
            ?>
        </div>
        <button class="gallery-btn right-btn">›</button>
            <?php if ($is_owner): 
                echo '<a href="#" class="btn__red--l btn__red btn">EDIT PLACE</a>';
             endif; ?>
        
    </div>
    <div class="place_info">
        <div class="place_info-cont">
            <div class="place_info--tages">
                <?php
                // Fetch place information
                $place_query = $conn->prepare("SELECT name, tags, price, city, country, category_id FROM places WHERE id = ?");
                $place_query->bind_param("i", $place_id); // Use dynamic place_id
                $place_query->execute();
                $place_result = $place_query->get_result();

                if ($place = $place_result->fetch_assoc()) {
                    $tags = explode(',', $place['tags']);
                    foreach ($tags as $tag) {
                        echo '<a href="#">' . htmlspecialchars($tag) . '</a>';
                    }
                ?>
            </div>
            <h1 class="place_info--name"><?php echo htmlspecialchars($place['name']); ?></h1>
            <div class="place_info--extra">
                    <?php
                    // Fetch average rating for the place
                    $rating_query = $conn->prepare("SELECT AVG(rating) AS avg_rating FROM reviews WHERE place_id = ?");
                    $rating_query->bind_param("i", $place_id); // Use dynamic place_id
                    $rating_query->execute();
                    $rating_result = $rating_query->get_result();
                    $rating = $rating_result->fetch_assoc()['avg_rating'] ?? 0;
                    $rating_query->close();

                    $percentage = ($rating / 5) * 100;
                    ?> 
                    <div class="extra_stars" style="background: linear-gradient(90deg, #A21111 var(--rating, <?php echo $percentage; ?>%), #D0D0D0 var(--rating,<?php echo $percentage-100; ?>%)); display: inline-block; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                    </div>
                <h3 class="extra_price"><?php echo htmlspecialchars($place['price']); ?></h3>
                <a href="#" class="extra_category">
                    <?php
                    // Fetch category name
                    $category_query = $conn->prepare("SELECT name FROM categories WHERE id = ?");
                    $category_query->bind_param("i", $place['category_id']); // Use dynamic category_id
                    $category_query->execute();
                    $category_result = $category_query->get_result();
                    $category_name = $category_result->fetch_assoc()['name'] ?? 'Unknown';
                    $category_query->close();

                    echo htmlspecialchars($category_name);
                    ?>
                </a>
            </div>
        </div>
        <div class="place_info--HIGHTLIGHTS">
            <div class="place_info--HIGHTLIGHTS-item">
                <p>Air conditioner</p><i class="fa-solid fa-fan"></i>
            </div>
            <div class="place_info--HIGHTLIGHTS-item">
                <p>Free Wifi</p><i class="fa-solid fa-wifi"></i>
            </div>
            <div class="place_info--HIGHTLIGHTS-item">
                <p>Reservations</p><i class="fa-solid fa-book-open"></i>
            </div>
            <div class="place_info--HIGHTLIGHTS-item">
                <p>Car
                    parking</p><i class="fa-solid fa-square-parking"></i>
            </div>
            <div class="place_info--HIGHTLIGHTS-item">
                <p>Credit
                    cards</p><i class="fa-solid fa-credit-card"></i>
            </div>
            <div class="place_info--HIGHTLIGHTS-item">
                <p>Non
                    smoking</p><i class="fa-solid fa-ban-smoking"></i>
            </div>
        </div>
        <?php
        } else {
            echo '<p>Place information not found.</p>';
        }
        $place_query->close();
        ?>
    </div>
    <div class="place_CONTACT">
        <h2 class="place-title">CONTACT INFO</h2>
        <div class="place_CONTACT--info">
            <?php
            // Fetch contact information for the place
            $contact_query = $conn->prepare("SELECT email, phone_1, phone_2, website, facebook_url, instagram_url, twitter_url FROM places WHERE id = ?");
            $contact_query->bind_param("i", $place_id); // Use dynamic place_id
            $contact_query->execute();
            $contact_result = $contact_query->get_result();

            if ($contact = $contact_result->fetch_assoc()) {
                // Display email
                if (!empty($contact['email'])) {
                    echo '<div class="place_CONTACT--info-item">EMAIL: <a href="mailto:' . htmlspecialchars($contact['email']) . '">' . htmlspecialchars($contact['email']) . '</a></div>';
                }
                // Display website
                if (!empty($contact['website'])) {
                    echo '<div class="place_CONTACT--info-item">WEBSITE: <a href="' . htmlspecialchars($contact['website']) . '" target="_blank">' . htmlspecialchars($contact['website']) . '</a></div>';
                }

                // Display phone numbers
                if (!empty($contact['phone_1'])) {
                    echo '<div class="place_CONTACT--info-item">PHONE(1): <a href="tel:' . htmlspecialchars($contact['phone_1']) . '">' . htmlspecialchars($contact['phone_1']) . '</a></div>';
                }
                if (!empty($contact['phone_2'])) {
                    echo '<div class="place_CONTACT--info-item">PHONE(2): <a href="tel:' . htmlspecialchars($contact['phone_2']) . '">' . htmlspecialchars($contact['phone_2']) . '</a></div>';
                }

                
            } else {
                echo '<p>Contact information not found for this place.</p>';
            }
            $contact_query->close();
            ?>
        </div>
        <div class="place_CONTACT--social">
            <?php
            // Display social media links
            if (!empty($contact['facebook_url'])) {
                echo '<a href="' . htmlspecialchars($contact['facebook_url']) . '" target="_blank"><i class="fa-brands fa-square-facebook"></i></a>';
            }
            if (!empty($contact['instagram_url'])) {
                echo '<a href="' . htmlspecialchars($contact['instagram_url']) . '" target="_blank"><i class="fa-brands fa-instagram"></i></a>';
            }
            if (!empty($contact['twitter_url'])) {
                echo '<a href="' . htmlspecialchars($contact['twitter_url']) . '" target="_blank"><i class="fa-brands fa-square-x-twitter"></i></a>';
            }
            ?>
        </div>
    </div>
    <div class="place_menu">
        <h2 class="place-title">MENU</h2>
        <div class="place_menu--grid">
            <?php
            // Fetch menu items for the place
            $menu_query = $conn->prepare("SELECT name, price, description, image FROM menu_items WHERE place_id = ?");
            $menu_query->bind_param("i", $place_id); // Use dynamic place_id
            $menu_query->execute();
            $menu_result = $menu_query->get_result();

            if ($menu_result->num_rows > 0) {
                while ($menu_item = $menu_result->fetch_assoc()) {
                    echo '<div class="place_menu--item">';
                    echo '<div class="menu_item--img">';
                    if (!empty($menu_item['image'])) {
                        echo '<img src="' . htmlspecialchars($menu_item['image']) . '" alt="' . htmlspecialchars($menu_item['name']) . '">';
                    } else {
                        echo '<img src="assets/images/default_menu.jpg" alt="Default Menu Image">';
                    }
                    echo '</div>';
                    echo '<div class="menu_item--info">';
                    echo '<div class="menu_item--info-name">';
                    echo '<h3>' . htmlspecialchars($menu_item['name']) . '</h3>';
                    echo '<h3>$' . htmlspecialchars(number_format($menu_item['price'], 2)) . '</h3>';
                    echo '</div>';
                    echo '<p class="menu_item--info-text">' . htmlspecialchars($menu_item['description']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No menu items found for this place.</p>';
            }
            $menu_query->close();
            ?>
        </div>
    </div>
    <div class="place_description">
        <h2 class="place-title">DESCRIPTION</h2>
        <p class="place_description--text">
            <?php
            // Fetch the description for the place
            $description_query = $conn->prepare("SELECT description FROM places WHERE id = ?");
            $description_query->bind_param("i", $place_id); // Use dynamic place_id
            $description_query->execute();
            $description_result = $description_query->get_result();

            if ($description = $description_result->fetch_assoc()) {
                // Display the description
                echo htmlspecialchars($description['description']);
            } else {
                echo "Description not available for this place.";
            }
            $description_query->close();
            ?>
        </p>
    </div>
    <div class="place_time">
        <h2 class="place-title">OPENING HOURS</h2>
        <table class="place_time--table">
            <?php
            // Fetch opening hours for the place
            $hours_query = $conn->prepare("SELECT day, open_time, close_time FROM opening_hours WHERE place_id = ?");
            $hours_query->bind_param("i", $place_id); // Use dynamic place_id
            $hours_query->execute();
            $hours_result = $hours_query->get_result();

            if ($hours_result->num_rows > 0) {
                while ($hours = $hours_result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td class="place_time--table-day">' . htmlspecialchars($hours['day']) . ':</td>';
                    if ($hours['open_time'] && $hours['close_time']) {
                        echo '<td class="place_time--table-hour">' . htmlspecialchars($hours['open_time']) . ' - ' . htmlspecialchars($hours['close_time']) . '</td>';
                    } else {
                        echo '<td class="place_time--table-hour">Closed</td>';
                    }
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="2">Opening hours not available for this place.</td></tr>';
            }
            $hours_query->close();
            ?>
        </table>
    </div>
    <div class="faq">
        <h2 class="place-title">FAQ's</h2>
        <div class="faq-container">
            <?php
            // Fetch FAQs for the place
            $faq_query = $conn->prepare("SELECT question, answer FROM faqs WHERE place_id = ?");
            $faq_query->bind_param("i", $place_id);
            $faq_query->execute();
            $faq_result = $faq_query->get_result();

            if ($faq_result->num_rows > 0) {
                while ($faq = $faq_result->fetch_assoc()) {
                    echo '<div class="faq-item">';
                    echo '<button class="faq-question">' . htmlspecialchars($faq['question']) . '</button>';
                    echo '<div class="faq-answer">';
                    echo '<p>' . htmlspecialchars($faq['answer']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No FAQs available for this place.</p>';
            }
            $faq_query->close();
            ?>
        </div>
    </div>
    <div class="reviews" id="reviews">
    <h2 class="place-title">REVIEWS</h2>

    <!-- Overall Rating Section -->
    <div class="reviews_overall">
        <div class="reviews_overall--L">
            <?php
            $rating_query = $conn->prepare("
                SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews 
                FROM reviews 
                WHERE place_id = ?
            ");
            $rating_query->bind_param("i", $place_id);
            $rating_query->execute();
            $rating_data = $rating_query->get_result()->fetch_assoc();
            $rating_query->close();

            $overall_rating = $rating_data['avg_rating'] ?? 0;
            $total_reviews = $rating_data['total_reviews'] ?? 0;
            $percentage = ($overall_rating / 5) * 100;
            ?>

            <h2>Overall rating</h2>
            <div class="overall_stars" style="
                background: linear-gradient(90deg, #A21111 <?= $percentage ?>%, #D0D0D0 <?= $percentage ?>%);
                display: inline-block;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;">
                <?php for ($i = 0; $i < 5; $i++): ?>
                    <i class="fa-solid fa-star star-rating"></i>
                <?php endfor; ?>
            </div>
            <p><?= number_format($overall_rating, 1) ?> out of 5</p>
            <p><?= $total_reviews ?> reviews</p>
        </div>

        <!-- Ratings Breakdown -->
        <div class="reviews_overall--R">
            <?php
            $ratings_counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
            $ratings_query = $conn->prepare("
                SELECT rating, COUNT(*) AS count 
                FROM reviews 
                WHERE place_id = ? 
                GROUP BY rating
            ");
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

    

    <!-- Individual Reviews -->
    <div class="reviews_container">
        <?php
        $reviews_query = $conn->prepare("
            SELECT r.id AS review_id, r.user_id, r.rating, r.review_text, r.created_at,
                   CONCAT(u.first_name, ' ', u.last_name) AS user_name, u.profile_image
            FROM reviews r
            JOIN users u ON r.user_id = u.id
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
        ?>
        <div class="review" id="review-<?= $review_id ?>">
            <div class="review_profile">
                <a href="profile.php?user_id=<?= urlencode($review['user_id']) ?>" class="review_profile--img">
                    <img src="<?= htmlspecialchars($profile_image) ?>" alt="User Profile">
                </a>
                <div class="review_profile--info">
                    <a href="profile.php?user_id=<?= urlencode($review['user_id']) ?>" class="review_profile--info-name">
                        <?= htmlspecialchars($review['user_name']) ?>
                    </a>
                    <div class="review_profile--info-stars">
                        <div class="review_stars" style="
                            background: linear-gradient(90deg, #A21111 <?= $percentage ?>%, #D0D0D0 <?= $percentage ?>%);
                            display: inline-block;
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;">
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

            <!-- Review Gallery -->
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
                <?php endwhile;
                $gallery_query->close();
                ?>
            </div>

            <!-- Review Buttons -->
            <div class="review_btns">
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']): ?>
                    <a class="review_btns--link" href="#" onclick="showEditForm(<?= $review_id ?>)">edit my review</a>
                    <a class="review_btns--link" href="javascript:void(0);" onclick="deleteReview(<?= $review_id ?>)">delete my review</a>
                    <form id="editForm-<?= $review_id ?>" method="POST" action="edit_review.php" style="display: none;">
                        <input type="hidden" name="review_id" value="<?= $review_id ?>">
                        <input type="hidden" name="place_id" value="<?= $place_id ?>">
                        <input type="number" name="rating" min="1" max="5" value="<?= $rating ?>" required>
                        <textarea name="review_text" required><?= htmlspecialchars($review['review_text']) ?></textarea>
                        <button type="submit" name="edit_review">Save Changes</button>
                    </form>
                <?php elseif ($is_owner): ?>
                    <a class="btn__transparent--s btn__transparent btn" href="#" onclick="showCommentForm(<?= $review_id ?>)">comment on review</a>
                <?php endif; ?>

                <?php if ($is_owner): ?>
                <form id="commentForm-<?= $review_id ?>" method="POST" action="submit_owner_comment.php" style="display: none;">
                    <input type="hidden" name="review_id" value="<?= $review_id ?>">
                    <textarea name="comment" placeholder="add comment on review" required></textarea>
                    <button type="submit" class="btn__transparent--s btn__transparent btn">submit comment</button>
                </form>
                <?php endif; ?>

                <!-- Like Icon -->
                <?php
                $is_liked = false;
                if (isset($_SESSION['user_id'])) {
                    $is_liked = in_array($review_id, $is_liked_reviews);
                }
                ?>
                <a class="review_btns--like" href="#" onclick="toggleLike(event, <?= $review_id ?>)">
                    <i class="<?= $is_liked ? 'fa-solid fa-heart' : 'fa-regular fa-heart' ?>"></i>
                </a>
            </div>

            <!-- Display Comments -->
            <?php
$comments_query = $conn->prepare("SELECT id, comment, created_at FROM review_comments WHERE review_id = ?");
$comments_query->bind_param("i", $review_id);
$comments_query->execute();
$comments_result = $comments_query->get_result();

if ($comments_result->num_rows > 0):
    echo '<div class="review_placeComment"><h4>Place owner commented</h4>';
    while ($comment = $comments_result->fetch_assoc()):
        $comment_text = htmlspecialchars($comment['comment']);
        $comment_date = date("M j, Y", strtotime($comment['created_at']));
        $comment_id = $comment['id'];  // Store the comment ID for editing
        echo "<span class='comment-date'>{$comment_date}</span>";
        echo "<div class='owner-comment' id='comment-{$comment_id}'>";
        // Editable comment with contenteditable attribute
        echo "<p id='comment-text-{$comment_id}' class='comment-text' contenteditable='false'>{$comment_text}</p>";
        echo "</div>"; // Close the owner-comment div
        // Check if the logged-in user is the owner of the comment
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id) {
            echo "<button onclick='editComment({$comment_id})' class='btn__transparent--s btn__transparent btn'>Edit Comment</button>";
            echo "<button onclick='deleteComment({$comment_id})' class='btn__transparent--s btn__transparent btn'>Delete Comment</button>";
        }
    endwhile;
    echo '</div>';
endif;
$comments_query->close();
?>



        </div>
        <?php endwhile;
        else:
            echo '<p>No reviews available for this place.</p>';
        endif;
        $reviews_query->close();
        ?>
    </div>
</div>


    <div class="addReview">
        <h2 class="place-title">WRITE A REVIEW</h2>
        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST" action="add_review.php" id="reviewForm" enctype="multipart/form-data">
                <div class="addReview_container">
                    <div class="addReview_stars">
                        <input type="hidden" name="rating" id="rating" value="0">
                        <i class="fa-solid fa-star" data-value="1"></i>
                        <i class="fa-solid fa-star" data-value="2"></i>
                        <i class="fa-solid fa-star" data-value="3"></i>
                        <i class="fa-solid fa-star" data-value="4"></i>
                        <i class="fa-solid fa-star" data-value="5"></i>
                    </div>
                    <input type="hidden" name="place_id" value="<?php echo $place_id; ?>">
                    <input type="hidden" name="review_id" id="review_id" value=""> <!-- For editing -->
                    <a class="btn__transparent--s btn__transparent btn" href="#" onclick="document.getElementById('imageInput').click(); return false;">add photos</a>
                    <input type="file" name="images[]" id="imageInput" multiple style="display: none;" accept="image/*">
                    <div id="imagePreview" class="image-preview"></div> <!-- Preview section -->
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
    document.querySelectorAll('.addReview_stars i').forEach(star => {
        star.addEventListener('click', function () {
            const rating = this.getAttribute('data-value');
            document.getElementById('rating').value = rating;

            // Highlight the selected stars
            document.querySelectorAll('.addReview_stars i').forEach(s => {
                s.style.color = s.getAttribute('data-value') <= rating ? '#A21111' : '#D0D0D0';
            });
        });
    });

    function showEditForm(reviewId) {
        document.getElementById(`editForm-${reviewId}`).style.display = 'block';
    }

    function showCommentForm(reviewId) {
        document.getElementById(`commentForm-${reviewId}`).style.display = 'block';
    }

    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    let selectedImages = [];

    imageInput.addEventListener('change', function (e) {
        const files = Array.from(e.target.files);

        // Combine already selected images with new ones
        const totalImages = selectedImages.length + files.length;
        if (totalImages > 4) {
            alert("You can upload a maximum of 4 images.");
            return;
        }

        files.forEach(file => {
            if (selectedImages.length >= 4) return;

            const reader = new FileReader();
            reader.onload = function (event) {
                const imageUrl = event.target.result;

                // Create preview container
                const previewContainer = document.createElement('div');
                previewContainer.classList.add('image-thumb');

                // Image
                const img = document.createElement('img');
                img.src = imageUrl;

                // Remove button
                const removeBtn = document.createElement('span');
                removeBtn.classList.add('remove-image');
                removeBtn.innerHTML = '&times;';
                removeBtn.onclick = function () {
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

    // Recreate the FileList object for form submission
    function updateFileList() {
        const dataTransfer = new DataTransfer();
        selectedImages.forEach(file => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;
    }



function deleteReview(reviewId) {
    if (!confirm("Are you sure you want to delete your review?")) return;

    fetch('delete_review.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `review_id=${reviewId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const reviewElem = document.querySelector(`#review-${reviewId}`);
            if (reviewElem) reviewElem.remove();
        } else {
            alert("Failed to delete review.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function editComment(commentId) {
    var commentText = document.getElementById('comment-' + commentId);
    var editButton = document.querySelector('button[onclick="editComment(' + commentId + ')"]');
    var saveButton = document.querySelector('button[onclick="saveComment(' + commentId + ')"]');

    // Make the comment editable
    commentText.contentEditable = 'true';  
    commentText.style.backgroundColor = '#f0f0f0';  // Optional: highlight the editable area

    // Show the Save button, hide the Edit button
    editButton.style.display = 'none';  
    saveButton.style.display = 'inline';
}

function saveComment(commentId) {
    var commentText = document.getElementById('comment-' + commentId).innerText;

    // AJAX request to update the comment in the database
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_comment.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // If the comment was saved successfully, disable editing
            document.getElementById('comment-' + commentId).contentEditable = 'false';
            document.getElementById('comment-' + commentId).style.backgroundColor = 'transparent';
            document.querySelector('button[onclick="saveComment(' + commentId + ')"]').style.display = 'none';
            document.querySelector('button[onclick="editComment(' + commentId + ')"]').style.display = 'inline';
        } else {
            alert('Error saving the comment.');
        }
    };
    xhr.send('comment_id=' + commentId + '&comment_text=' + encodeURIComponent(commentText));
}
// Function to delete the comment
// Function to delete the comment
function deleteComment(commentId) {
    // Ask for confirmation
    if (!confirm("Are you sure you want to delete this comment?")) {
        return; // Stop if user cancels
    }

    // Send an AJAX request to delete the comment
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_owner_comment.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Pass the comment ID in the request
    xhr.send("comment_id=" + commentId);

    // Handle the response
    xhr.onload = function() {
        try {
            var response = JSON.parse(xhr.responseText);

            if (response.status === 'success') {
                // Find the comment container by comment ID and hide it
                var commentDiv = document.getElementById('comment-' + commentId);
                var reviewPlaceCommentDiv = commentDiv.closest('.review_placeComment');
                reviewPlaceCommentDiv.style.display = 'none';  // Hide the div
            } else {
                alert(response.message);  // Show an error message if needed
            }
        } catch (e) {
            console.error("Invalid JSON response", xhr.responseText);
        }
    };
}



</script>
