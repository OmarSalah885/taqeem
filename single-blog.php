<?php
include 'header.php'; // Include the header (ensure it connects to the database)

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
?>

<main>
    <div class="single-blog">
        <div class="single-blog_img">
            <img src="<?php echo htmlspecialchars($blog['image']); ?>" alt>
        </div>
        <div class="single-blog_tags">
            <?php
            // Ensure the `tags` column exists and contains data
            if (!empty($blog['tags'])) {
                // Split the tags string into an array
                $tags = explode(',', $blog['tags']); // Assuming tags are stored as a comma-separated string

                // Loop through each tag and display it
                foreach ($tags as $tag): ?>
                    <a href="#" ><?php echo htmlspecialchars($tag); ?></a>
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
                <h2 class="comments_counter">Comments</h2>
                <div class="comments_container">
                    <?php
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
                    <div class="comments_container">
                        <?php
                        // Recursive function to display comments and replies
                        function display_comments($grouped_comments, $parent_id = 0) {
                            if (!empty($grouped_comments[$parent_id])) { // Check if there are comments for the current parent_id
                                foreach ($grouped_comments[$parent_id] as $comment): ?>
                                    <div class="comments_container--single <?php echo $parent_id == 0 ? 'main-comment' : 'reply-comment'; ?>">
                                        <div class="comment">
                                            <div class="comment_img">
                                                <img src="<?php echo htmlspecialchars($comment['profile_image'] ?: 'assets/images/profiles/pro_null.png'); ?>" alt="User Profile">
                                            </div>
                                            <div class="comment_content">
                                                <h4 class="comment_content--name">
                                                    <?php echo htmlspecialchars($comment['first_name'] . ' ' . $comment['last_name']); ?>
                                                </h4>
                                                <p class="comment_content--date"><?php echo htmlspecialchars($comment['created_at']); ?></p>
                                                <p class="comment_content--text"><?php echo htmlspecialchars($comment['comment']); ?></p>
                                                <!-- Display the REPLY button for all comments -->
                                                <a href="#" class="comment_content--reply">REPLY</a>
                                            </div>
                                        </div>
                                        <?php
                                        
                                        // Recursively display replies for this comment
                                        if (!empty($grouped_comments[$comment['id']])): ?>
                                            <div class="replies">
                                                <?php display_comments($grouped_comments, $comment['id']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach;
                            }
                        }

                        // Display main comments and their replies
                        display_comments($grouped_comments);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <form class="single-blog_thought" method="POST" action="submit_comment.php">
            <h2 class="single-blog_thought--title">Leave your thought here</h2>
            <textarea name="comment" placeholder="Write your comment..."></textarea>
            <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
            <button type="submit" class="btn__red--l btn__red btn">Submit</button>
        </form>
    </div>
</main>
<?php include 'footer.php'; ?>