<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

include 'header.php';

// Handle search
$search = isset($_GET['search_term']) ? trim($_GET['search_term']) : '';
?>

<main>
    <div class="pageinfo">
        <div class="pageinfo_content">
            <!-- Dynamic Heading for Search -->
            <h2>
                <?php 
                    if (!empty($search)) {
                        echo "Search results for: <strong>" . htmlspecialchars($search) . "</strong>";
                    } else {
                        echo "BLOGS";
                    }
                ?>
            </h2>
            
        </div>
    </div>

    <div class="blogs">
        <div class="blogs_grid">
            <?php
            $posts_per_page = 9;
            $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $posts_per_page;

            if (!empty($search)) {
                // Escape input to prevent SQL injection
                $search_term = mysqli_real_escape_string($conn, $search);
                
                // Search query
                $query = "SELECT id, image, title, tags, content FROM blogs 
                          WHERE title LIKE '%$search_term%' OR tags LIKE '%$search_term%' 
                          ORDER BY id DESC 
                          LIMIT $offset, $posts_per_page";

                // For pagination count
                $count_query = "SELECT COUNT(id) AS total FROM blogs 
                                WHERE title LIKE '%$search_term%' OR tags LIKE '%$search_term%'";
            } else {
                // Default blog query if no search term is provided
                $query = "SELECT id, image, title, tags, content FROM blogs 
                          ORDER BY id DESC 
                          LIMIT $offset, $posts_per_page";

                // Count query for pagination without search
                $count_query = "SELECT COUNT(id) AS total FROM blogs";
            }

            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
    // Extract data
    $id = $row['id']; // Blog ID
    $image = htmlspecialchars($row['image']); // Image from DB
    $title = htmlspecialchars($row['title']);
    $tags = explode(',', $row['tags']); // Assuming tags are comma-separated
    $content = strip_tags($row['content']); // Remove HTML tags for truncation
    
    // Limit content to 200 characters
    $shortContent = (strlen($content) > 200) ? substr($content, 0, 200) . '...' : $content;

    echo '<div class="homeBlog_blogs--item">
            <div class="homeBlog_blogs--item-img">
                <a href="single-blog.php?id=' . $id . '" class="homeBlog_blogs--item-img_img" style="text-decoration: none;">
                    <img src="' . $image . '" alt="Blog Image">
                </a>
                <div class="homeBlog_blogs--item-img_tags">';
    
    // Display tags dynamically
    foreach ($tags as $tag) {
        echo '<a href="?search_term=' . urlencode(trim($tag)) . '" style="text-decoration: none;">' . htmlspecialchars(trim($tag)) . '</a>';
    }

    echo '  </div>
            </div>
            <div class="homeBlog_blogs--item-text">
                <a href="single-blog.php?id=' . $id . '" class="homeBlog_blogs--item-text_title" style="text-decoration: none;">' . $title . '</a>
                <a href="single-blog.php?id=' . $id . '" style="text-decoration: none;">
                    <p>' . htmlspecialchars($shortContent) . '</p> <!-- Truncated Content -->
                </a>
            </div>
        </div>';
}
            } else {
                echo "<p>No blogs found.</p>";
            }
            ?>
        </div> <!-- End of blogs_grid -->

        <!-- Pagination -->
        <div class="listing_indicator">
            <ul class="listing_indicator">
                <?php
                // Get total number of posts for pagination
                $result_count = $conn->query($count_query); // Use the count query with search term
                $row_count = $result_count->fetch_assoc();
                $total_posts = $row_count['total'];
                $total_pages = ceil($total_posts / $posts_per_page);
                
                // Display previous button
                if ($page > 1):
                ?>
                <li class="indicator_item">
                    <a href="?page=<?php echo $page - 1; ?><?php if (!empty($search)) echo '&search_term=' . urlencode($search); ?>">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Display page numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): 
                    echo '<li class="indicator_item ' . (($i === (int)$page) ? 'active' : '') . '">
                    <a href="?page=' . $i . (empty($search) ? '' : '&search_term=' . urlencode($search)) . '">' . $i . '</a>
                    </li>';
                    endfor; ?>

                <!-- Display next button -->
                <?php if ($page < $total_pages): ?>
                <li class="indicator_item">
                    <a href="?page=<?php echo $page + 1; ?><?php if (!empty($search)) echo '&search_term=' . urlencode($search); ?>">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
