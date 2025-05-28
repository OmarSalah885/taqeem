<?php
require_once 'config.php';
require_once 'db_connect.php';


include 'header.php';

$blog_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT * FROM blogs WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();

if (!$blog) {
    echo "<main><h1>Blog not found</h1></main>";
    include 'footer.php';
    exit;
}

$comments_query = "
    SELECT blog_comments.id, blog_comments.comment, blog_comments.created_at, 
        blog_comments.parent_comment_id, blog_comments.user_id,
        users.first_name, users.last_name, users.profile_image 
    FROM blog_comments 
    JOIN users ON blog_comments.user_id = users.id 
    WHERE blog_comments.blog_id = ?
    ORDER BY blog_comments.parent_comment_id ASC, blog_comments.created_at ASC";
$stmt = $conn->prepare($comments_query);
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$comments_result = $stmt->get_result();
$comments = $comments_result->fetch_all(MYSQLI_ASSOC);

$grouped_comments = [];
foreach ($comments as $comment) {
    $parent_id = $comment['parent_comment_id'] ?? 0;
    $grouped_comments[$parent_id][] = $comment;
}
?>

<main class="single-blog">
    <div class="single-blog_img">
        <img src="<?php echo htmlspecialchars($blog['image']); ?>" alt>
    </div>
    <div class="single-blog_tags">
        <?php
        if (!empty($blog['tags'])) {
            $tags = explode(',', $blog['tags']);
            foreach ($tags as $tag): ?>
        <a href="blogs.php?search_term=<?php echo urlencode(trim($tag)); ?>" style="text-decoration: none;">
            <?php echo htmlspecialchars(trim($tag)); ?>
        </a>
        <?php endforeach;
        } else {
            echo "<p>No tags available for this blog.</p>";
        }
        ?>
    </div>

    <h1 class="single-blog_title"><?php echo htmlspecialchars($blog['title']); ?></h1>
    <div class="single-blog_content">
        <div class="single-blog_content--paragraph">
            <p><?php echo $blog['content']; ?></p>
        </div>
    </div>
    <div class="single-blog_comments">
        <div class="comments">
            <h2 class="comments_counter" id="comments_counter">
                <?php
                $comment_count = count($comments);
                echo $comment_count > 0 ? "$comment_count Comments" : "No comments yet.";
                ?>
            </h2>
            <div class="comments_container" id="comments_container">
                <?php
                $GLOBALS['blog_id'] = $blog_id;
                function display_comments($grouped_comments, $parent_id = 0) {
                    if (!empty($grouped_comments[$parent_id])) {
                        foreach ($grouped_comments[$parent_id] as $comment):
                            $is_author = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id'];
                            $is_admin = isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin';
                            ?>
                <div class="comments_container--single <?php echo $parent_id == 0 ? 'main-comment' : 'reply-comment'; ?>"
                    data-comment-id="<?php echo $comment['id']; ?>">
                    <div class="comment">
                        <div class="comment_img">
                            <img src="<?php echo htmlspecialchars($comment['profile_image'] ?: 'assets/images/profiles/pro_null.png'); ?>"
                                alt="User Profile">
                        </div>
                        <div class="comment_content">
                            <h4 class="comment_content--name">
                                <?php echo htmlspecialchars($comment['first_name'] . ' ' . $comment['last_name']); ?>
                            </h4>
                            <p class="comment_content--date">
                                <?php
                                $comment_date = new DateTime($comment['created_at']);
                                $current_date = new DateTime();
                                $interval = $comment_date->diff($current_date);

                                if ($interval->y > 0) {
                                    echo $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
                                } elseif ($interval->m > 0) {
                                    echo $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
                                } elseif ($interval->d > 0) {
                                    echo $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
                                } elseif ($interval->h > 0) {
                                    echo $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
                                } elseif ($interval->i > 0) {
                                    echo $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
                                } else {
                                    echo 'Just now';
                                }
                                ?>
                            </p>
                            <p class="comment_content--text"><?php echo htmlspecialchars($comment['comment']); ?></p>
                            <div class="comment_actions">
                                <?php if ($is_author || $is_admin): ?>
                                <a href="#" class="comment_content--delete" data-comment-id="<?php echo $comment['id']; ?>">DELETE</a>
                                <a href="#" class="comment_content--edit"
                                    data-comment-id="<?php echo $comment['id']; ?>"
                                    data-comment-text="<?php echo htmlspecialchars($comment['comment'], ENT_QUOTES); ?>">EDIT</a>
                                <?php endif; ?>
                                <a href="#" class="comment_content--reply">REPLY</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (!empty($grouped_comments[$comment['id']])): ?>
                    <div class="replies">
                        <?php display_comments($grouped_comments, $comment['id']); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach;
                    }
                }

                display_comments($grouped_comments);
                ?>
            </div>
        </div>
    </div>
    <div id="error_message" style="color: red; display: none;"></div>
    <form class="single-blog_thought" id="comment_form">
        <h2 class="single-blog_thought--title">Leave your thought here</h2>
        <textarea name="comment" placeholder="Write your comment..." required></textarea>
        <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
        <input type="hidden" name="parent_comment_id" id="parent_comment_id" value="">
        <input type="hidden" name="comment_id" id="comment_id" value="">
        <input type="hidden" name="action" id="action" value="add">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
        <button type="submit" class="btn__red--l btn__red btn" id="submit_button">Submit</button>
        <button type="button" class="btn__red--l btn__red btn" id="cancel_button" style="display: none;">Cancel</button>
    </form>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#comment_form');
    const commentsContainer = document.querySelector('#comments_container');
    const commentsCounter = document.querySelector('#comments_counter');
    const errorMessage = document.querySelector('#error_message');
    let isSubmitting = false;

    // Show error message
    function showError(message) {
        errorMessage.textContent = message;
        errorMessage.style.display = 'block';
        setTimeout(() => {
            errorMessage.style.display = 'none';
            errorMessage.textContent = '';
        }, 5000);
    }

    // Update comments counter
    function updateCommentsCounter() {
        const count = commentsContainer.querySelectorAll('.comments_container--single').length;
        commentsCounter.textContent = count > 0 ? `${count} Comments` : 'No comments yet.';
    }

    // Format date for display
    function formatDate(dateStr) {
        const commentDate = new Date(dateStr);
        const currentDate = new Date();
        const interval = Math.floor((currentDate - commentDate) / 1000 / 60); // Minutes

        if (interval < 1) return 'Just now';
        if (interval < 60) return `${interval} minute${interval > 1 ? 's' : ''} ago`;
        const hours = Math.floor(interval / 60);
        if (hours < 24) return `${hours} hour${hours > 1 ? 's' : ''} ago`;
        const days = Math.floor(hours / 24);
        if (days < 30) return `${days} day${days > 1 ? 's' : ''} ago`;
        const months = Math.floor(days / 30);
        if (months < 12) return `${months} month${months > 1 ? 's' : ''} ago`;
        const years = Math.floor(months / 12);
        return `${years} year${years > 1 ? 's' : ''} ago`;
    }

    // Render a single comment
    function renderComment(comment, isReply = false) {
        const isAuthor = <?php echo json_encode(isset($_SESSION['user_id'])); ?> && <?php echo json_encode($_SESSION['user_id'] ?? 0); ?> == comment.user_id;
        const isAdmin = <?php echo json_encode(isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin'); ?>;
        const commentDiv = document.createElement('div');
        commentDiv.className = `comments_container--single ${isReply ? 'reply-comment' : 'main-comment'}`;
        commentDiv.dataset.commentId = comment.id;
        commentDiv.innerHTML = `
            <div class="comment">
                <div class="comment_img">
                    <img src="${comment.profile_image || 'assets/images/profiles/pro_null.png'}" alt="User Profile">
                </div>
                <div class="comment_content">
                    <h4 class="comment_content--name">${comment.first_name} ${comment.last_name}</h4>
                    <p class="comment_content--date">${formatDate(comment.created_at)}</p>
                    <p class="comment_content--text">${comment.comment}</p>
                    <div class="comment_actions">
                        ${isAuthor || isAdmin ? `
                        <a href="#" class="comment_content--delete" data-comment-id="${comment.id}">DELETE</a>
                        <a href="#" class="comment_content--edit" data-comment-id="${comment.id}" data-comment-text="${comment.comment.replace(/"/g, '&quot;')}">EDIT</a>
                        ` : ''}
                        <a href="#" class="comment_content--reply">REPLY</a>
                    </div>
                </div>
            </div>
            <div class="replies"></div>
        `;
        return commentDiv;
    }

    // Form submission (add/edit)
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!<?php echo json_encode(isset($_SESSION['user_id'])); ?>) {
            sessionStorage.setItem('isCommentTriggeredLogin', 'true');
            document.querySelector('#login-nav')?.click();
            return;
        }
        if (isSubmitting) return;

        isSubmitting = true;
        const submitButton = form.querySelector('#submit_button');
        submitButton.disabled = true;
        submitButton.textContent = 'Submitting...';

        const formData = new FormData(form);
        try {
            const response = await fetch('submit_comment.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || 'Request failed');
            }

            if (result.action === 'add') {
                const commentDiv = renderComment(result.comment, result.comment.parent_comment_id > 0);
                if (result.comment.parent_comment_id) {
                    const parent = commentsContainer.querySelector(`[data-comment-id="${result.comment.parent_comment_id}"] .replies`);
                    parent.appendChild(commentDiv);
                } else {
                    commentsContainer.appendChild(commentDiv);
                }
                form.reset();
                form.querySelector('#action').value = 'add';
                form.querySelector('#parent_comment_id').value = '';
                updateCommentsCounter();
            } else if (result.action === 'edit') {
                const commentEl = commentsContainer.querySelector(`[data-comment-id="${result.comment.id}"]`);
                commentEl.querySelector('.comment_content--text').textContent = result.comment.comment;
                commentEl.querySelector('.comment_content--date').textContent = formatDate(result.comment.created_at);
                commentEl.querySelector('.comment_content--edit').dataset.commentText = result.comment.comment.replace(/"/g, '&quot;');
                form.reset();
                form.querySelector('#action').value = 'add';
                form.querySelector('#comment_id').value = '';
                form.querySelector('#submit_button').textContent = 'Submit';
                form.querySelector('#cancel_button').style.display = 'none';
            }
        } catch (error) {
            showError(error.message);
        } finally {
            isSubmitting = false;
            submitButton.disabled = false;
            submitButton.textContent = form.querySelector('#action').value === 'edit' ? 'Update' : 'Submit';
        }
    });

    // Delete comment
    commentsContainer.addEventListener('click', async (e) => {
        if (e.target.classList.contains('comment_content--delete')) {
            e.preventDefault();
            if (!confirm('Are you sure you want to delete this comment?')) return;

            const commentId = e.target.dataset.commentId;
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('comment_id', commentId);
            formData.append('blog_id', <?php echo $blog_id; ?>);
            formData.append('csrf_token', '<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>');

            try {
                const response = await fetch('submit_comment.php', {
                    method: 'POST', // Use POST for security
                    body: formData
                });
                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.error || 'Request failed');
                }

                const commentEl = commentsContainer.querySelector(`[data-comment-id="${commentId}"]`);
                commentEl.remove();
                updateCommentsCounter();
            } catch (error) {
                showError(error.message);
            }
        }
    });

    // Edit comment
    commentsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('comment_content--edit')) {
            e.preventDefault();
            const commentId = e.target.dataset.commentId;
            const commentText = e.target.dataset.commentText;

            const textarea = form.querySelector('textarea[name="comment"]');
            const commentIdInput = form.querySelector('#comment_id');
            const actionInput = form.querySelector('#action');
            const submitButton = form.querySelector('#submit_button');
            const cancelButton = form.querySelector('#cancel_button');
            const parentCommentIdInput = form.querySelector('#parent_comment_id');

            textarea.value = commentText;
            commentIdInput.value = commentId;
            actionInput.value = 'edit';
            submitButton.textContent = 'Update';
            cancelButton.style.display = 'inline-block';
            parentCommentIdInput.value = '';

            form.scrollIntoView({ behavior: 'smooth' });
        }
    });

    // Reply to comment
    commentsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('comment_content--reply')) {
            e.preventDefault();
            const commentId = e.target.closest('.comments_container--single').dataset.commentId;
            const parentCommentIdInput = form.querySelector('#parent_comment_id');
            const actionInput = form.querySelector('#action');
            const submitButton = form.querySelector('#submit_button');
            const cancelButton = form.querySelector('#cancel_button');

            parentCommentIdInput.value = commentId;
            actionInput.value = 'add';
            submitButton.textContent = 'Submit';
            cancelButton.style.display = 'none';
            form.scrollIntoView({ behavior: 'smooth' });
        }
    });

    // Cancel edit
    form.querySelector('#cancel_button').addEventListener('click', () => {
        const textarea = form.querySelector('textarea[name="comment"]');
        const commentIdInput = form.querySelector('#comment_id');
        const actionInput = form.querySelector('#action');
        const submitButton = form.querySelector('#submit_button');
        const cancelButton = form.querySelector('#cancel_button');
        const parentCommentIdInput = form.querySelector('#parent_comment_id');

        textarea.value = '';
        commentIdInput.value = '';
        actionInput.value = 'add';
        submitButton.textContent = 'Submit';
        submitButton.disabled = false;
        cancelButton.style.display = 'none';
        parentCommentIdInput.value = '';
    });

    // Focus comment form if login was triggered
    if (sessionStorage.getItem('isCommentTriggeredLogin') === 'true' && <?php echo json_encode(isset($_SESSION['user_id'])); ?>) {
        const textarea = form.querySelector('textarea[name="comment"]');
        textarea.focus();
        sessionStorage.removeItem('isCommentTriggeredLogin');
    }
});
</script>

<?php include 'footer.php'; ?>