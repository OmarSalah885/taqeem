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
            <h2>
                <?php 
                    echo !empty($search)
                        ? "Search results for: <strong>" . htmlspecialchars($search) . "</strong>"
                        : "BLOGS";
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
                $search_term = mysqli_real_escape_string($conn, $search);

                $query = "SELECT id, image, title, tags, content FROM blogs 
                          WHERE title LIKE '%$search_term%' OR tags LIKE '%$search_term%' 
                          ORDER BY id DESC 
                          LIMIT $offset, $posts_per_page";

                $count_query = "SELECT COUNT(id) AS total FROM blogs 
                                WHERE title LIKE '%$search_term%' OR tags LIKE '%$search_term%'";
            } else {
                $query = "SELECT id, image, title, tags, content FROM blogs 
                          ORDER BY id DESC 
                          LIMIT $offset, $posts_per_page";

                $count_query = "SELECT COUNT(id) AS total FROM blogs";
            }

            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $image = htmlspecialchars($row['image']);
                    $title = htmlspecialchars($row['title']);
                    $tags = explode(',', $row['tags']);
                    $content = strip_tags($row['content']);
                    $shortContent = (strlen($content) > 200) ? substr($content, 0, 200) . '...' : $content;
                    ?>

                    <div class="homeBlog_blogs--item">
                        <div class="homeBlog_blogs--item-img">
                            <a href="single-blog.php?id=<?= $id ?>" class="homeBlog_blogs--item-img_img" style="text-decoration: none;">
                                <img src="<?= $image ?>" alt="Blog Image">
                            </a>
                            <div class="homeBlog_blogs--item-img_tags">
                                <?php foreach ($tags as $tag): ?>
                                    <a href="?search_term=<?= urlencode(trim($tag)) ?>" style="text-decoration: none;">
                                        <?= htmlspecialchars(trim($tag)) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="homeBlog_blogs--item-text">
                            <a href="single-blog.php?id=<?= $id ?>" class="homeBlog_blogs--item-text_title" style="text-decoration: none;">
                                <?= $title ?>
                            </a>
                            <a href="single-blog.php?id=<?= $id ?>" style="text-decoration: none;">
                                <p><?= htmlspecialchars($shortContent) ?></p>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No blogs found.</p>";
            }
            ?>
        </div> <!-- End of blogs_grid -->

        <?php
        // Pagination count
        $result_count = $conn->query($count_query);
        $row_count    = $result_count->fetch_assoc();
        $total_posts  = (int)$row_count['total'];
        ?>

        <!-- Pagination Section -->
        <div class="listing_indicator">
            <?php
            $range       = 2;
            $jump        = 3;
            $totalPages  = (int)ceil($total_posts / $posts_per_page);
            $currentPage = $page;

            function renderEllipsis($targetPage, $search) {
                $qs = '?page=' . $targetPage . ($search !== '' ? '&search_term=' . urlencode($search) : '');
                echo '<li class="indicator_item ellipsis"><a href="' . $qs . '">…</a></li>';
            }
            ?>
            <ul class="listing_indicator">
                <?php if ($currentPage > 1): ?>
                    <li class="indicator_item">
                        <a href="?page=<?= $currentPage - 1 ?><?= $search !== '' ? '&search_term=' . urlencode($search) : '' ?>">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($currentPage > $range + 1): ?>
                    <li class="indicator_item">
                        <a href="?page=1<?= $search !== '' ? '&search_term=' . urlencode($search) : '' ?>">1</a>
                    </li>
                    <?php renderEllipsis(max(1, $currentPage - $jump), $search); ?>
                <?php endif; ?>

                <?php
                $start = max(1, $currentPage - $range);
                $end   = min($totalPages, $currentPage + $range);
                for ($i = $start; $i <= $end; $i++): ?>
                    <li class="indicator_item <?= $i === $currentPage ? 'active' : '' ?>">
                        <?php if ($i === $currentPage): ?>
                            <a href="javascript:void(0)"><?= $i ?></a>
                        <?php else: ?>
                            <a href="?page=<?= $i ?><?= $search !== '' ? '&search_term=' . urlencode($search) : '' ?>"><?= $i ?></a>
                        <?php endif; ?>
                    </li>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages - $range): ?>
                    <?php renderEllipsis(min($totalPages, $currentPage + $jump), $search); ?>
                    <li class="indicator_item">
                        <a href="?page=<?= $totalPages ?><?= $search !== '' ? '&search_term=' . urlencode($search) : '' ?>">
                            <?= $totalPages ?>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <li class="indicator_item">
                        <a href="?page=<?= $currentPage + 1 ?><?= $search !== '' ? '&search_term=' . urlencode($search) : '' ?>">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
