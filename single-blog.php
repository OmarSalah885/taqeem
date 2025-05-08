<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();



include 'header.php'; // Include the header after starting the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize inputs
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate inputs
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        die('All fields are required.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format.');
    }

    if ($password !== $confirm_password) {
        die('Passwords do not match.');
    }

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        die('This email is already registered.');
    }
    $stmt->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the user into the database
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, 'Guest')");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

    if ($stmt->execute()) {
        // Automatically log the user in by setting session variables
        $_SESSION['user_id'] = $stmt->insert_id; // Get the ID of the newly inserted user
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = 'Guest';

        // Redirect to the homepage or dashboard
        header('Location: index.php?signup=success');
        exit;
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}



// Get the blog ID from the URL
$blog_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the blog data from the database
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

// Fetch comments for the blog
$comments_query = "
    SELECT blog_comments.id, blog_comments.comment, blog_comments.created_at, 
        blog_comments.parent_comment_id, 
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

// Group comments by parent_comment_id
$grouped_comments = [];
foreach ($comments as $comment) {
    $parent_id = $comment['parent_comment_id'] ?? 0; // 0 for main comments
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
                $tags = explode(',', $blog['tags']); // Assuming tags are stored as a comma-separated string
                foreach ($tags as $tag): ?>
        <a href="#"><?php echo htmlspecialchars($tag); ?></a>
        <?php endforeach;
            } else {
                echo "<p>No tags available for this blog.</p>";
            }
            ?>
    </div>
    <h1 class="single-blog_title"><?php echo htmlspecialchars($blog['title']); ?></h1>
    <div class="single-blog_content">
        <div class="single-blog_content--paragraph">
            <p><?php echo $blog['content']; // Assuming the content is stored as HTML ?></p>
        </div>
    </div>
    <div class="single-blog_comments">
        <div class="comments">
            <h2 class="comments_counter">
                <?php
                // Count the total number of comments
                $comment_count = count($comments);
                echo $comment_count > 0 ? "$comment_count Comments" : "No comments yet.";
                ?>
            </h2>
            <div class="comments_container">
                <?php
                // Recursive function to display comments and replies
                function display_comments($grouped_comments, $parent_id = 0) {
                    if (!empty($grouped_comments[$parent_id])) {
                        foreach ($grouped_comments[$parent_id] as $comment): ?>
                            <div class="comments_container--single <?php echo $parent_id == 0 ? 'main-comment' : 'reply-comment'; ?>" data-comment-id="<?php echo $comment['id']; ?>">
                                <div class="comment">
                                    <div class="comment_img">
                                        <img src="<?php echo htmlspecialchars($comment['profile_image'] ?: 'assets/images/profiles/pro_null.png'); ?>" alt="User Profile">
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
                                        <a href="#" class="comment_content--reply">REPLY</a>
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
    <form class="single-blog_thought" method="POST" action="submit_comment.php">
        <h2 class="single-blog_thought--title">Leave your thought here</h2>
        <textarea name="comment" placeholder="Write your comment..." required></textarea>
        <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
        <input type="hidden" name="parent_comment_id" id="parent_comment_id" value="">
        <button type="submit" class="btn__red--l btn__red btn">Submit</button>
    </form>
</main>

<?php include 'footer.php'; ?>