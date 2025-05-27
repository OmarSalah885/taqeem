<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

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
            <h2 class="comments_counter">
                <?php
                $comment_count = count($comments);
                echo $comment_count > 0 ? "$comment_count Comments" : "No comments yet.";
                ?>
            </h2>
            <div class="comments_container">
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
                                <a href="submit_comment.php?action=delete&comment_id=<?php echo $comment['id']; ?>&blog_id=<?php echo $GLOBALS['blog_id']; ?>"
                                    class="comment_content--delete"
                                    onclick="return confirm('Are you sure you want to delete this comment?');">DELETE</a>
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
    <form class="single-blog_thought" method="POST" action="submit_comment.php" id="comment_form">
        <h2 class="single-blog_thought--title">Leave your thought here</h2>
        <textarea name="comment" placeholder="Write your comment..." required></textarea>
        <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
        <input type="hidden" name="parent_comment_id" id="parent_comment_id" value="">
        <input type="hidden" name="comment_id" id="comment_id" value="">
        <input type="hidden" name="action" id="action" value="add">
        <input type="hidden" name="redirect_url" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
        <?php if (isset($_SESSION['csrf_token'])): ?>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <?php endif; ?>
        <button type="submit" class="btn__red--l btn__red btn" id="submit_button">Submit</button>
        <button type="button" class="btn__red--l btn__red btn" id="cancel_button" style="display: none;">Cancel</button>
    </form>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#comment_form');
    let isSubmitting = false;

    form.addEventListener('submit', (e) => {
        if (!<?php echo json_encode(isset($_SESSION['user_id'])); ?>) {
            e.preventDefault();
            sessionStorage.setItem('isCommentTriggeredLogin', 'true');
            document.querySelector('#login-nav')?.click();
            return;
        }
        if (isSubmitting) {
            e.preventDefault();
            return;
        }
        isSubmitting = true;
        const submitButton = form.querySelector('#submit_button');
        submitButton.disabled = true;
        submitButton.textContent = 'Submitting...';
    });

    // Focus comment form if login was triggered
    if (sessionStorage.getItem('isCommentTriggeredLogin') === 'true' && <?php echo json_encode(isset($_SESSION['user_id'])); ?>) {
        const textarea = form.querySelector('textarea[name="comment"]');
        textarea.focus();
        sessionStorage.removeItem('isCommentTriggeredLogin');
    }

    document.querySelectorAll('.comment_content--edit').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const commentId = link.getAttribute('data-comment-id');
            const commentText = link.getAttribute('data-comment-text');

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
            submitButton.disabled = false;
            cancelButton.style.display = 'inline-block';
            parentCommentIdInput.value = '';

            form.scrollIntoView({ behavior: 'smooth' });
        });
    });

    document.querySelector('#cancel_button').addEventListener('click', () => {
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

    document.querySelectorAll('.comment_content--reply').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const commentId = link.closest('.comments_container--single').getAttribute('data-comment-id');
            const parentCommentIdInput = form.querySelector('#parent_comment_id');
            const actionInput = form.querySelector('#action');
            const submitButton = form.querySelector('#submit_button');
            const cancelButton = form.querySelector('#cancel_button');

            parentCommentIdInput.value = commentId;
            actionInput.value = 'add';
            submitButton.textContent = 'Submit';
            submitButton.disabled = false;
            cancelButton.style.display = 'none';
            form.scrollIntoView({ behavior: 'smooth' });
        });
    });
});
</script>

<?php include 'footer.php'; ?>