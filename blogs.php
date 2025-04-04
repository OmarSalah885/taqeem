<?php include 'header.php'; ?>

<main>
    <div class="pageinfo">
        <div class="pageinfo_content">
            <h2>BLOG</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a><span>/</span></li>
                <li class="breadcrumb-item active"><a href="category.html">blog</a></li>
            </ol>
        </div>
    </div>

    <div class="blogs">
        <div class="blogs_grid">
        <?php
        $posts_per_page = 9;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $posts_per_page;
        // Query to fetch 3 random blogs
        $query = "SELECT id, image, title, tags, content FROM blogs ORDER BY id DESC LIMIT $offset, $posts_per_page";
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
                    echo '<a href="#" style="text-decoration: none;">' . htmlspecialchars(trim($tag)) . '</a>';
                }

                echo '      </div>
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
        </div>  <!-- End of blogs_grid -->

        <!-- Pagination -->
        <div class="listing_indicator">
            <ul class="listing_indicator">
                <?php
                // Get total number of posts for pagination
                $result_count = $conn->query("SELECT COUNT(id) AS total FROM blogs");
                $row_count = $result_count->fetch_assoc();
                $total_posts = $row_count['total'];
                $total_pages = ceil($total_posts / $posts_per_page);
                
                // Display previous button
                if ($page > 1):
                ?>
                    <li class="indicator_item">
                        <a href="?page=<?php echo $page - 1; ?>">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Display page numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): 
                    echo '<li class="indicator_item ' . (($i === (int)$page) ? 'active' : '') . '">
                    <a href="?page=' . $i . '">' . $i . '</a>
                    </li>';
                    endfor; ?>

                <!-- Display next button -->
                <?php if ($page < $total_pages): ?>
                    <li class="indicator_item">
                        <a href="?page=<?php echo $page + 1; ?>">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
