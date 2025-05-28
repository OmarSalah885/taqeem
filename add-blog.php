<?php
require_once 'config.php';
require_once 'db_connect.php';




$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $tags    = trim($_POST['tags'] ?? '');
    $content = trim($_POST['code'] ?? '');

    // Basic validation
    if (empty($title) || empty($content)) {
        $error = 'Title and content are required.';
    } else {
        // Normalize folder name
        function normalizeFolderName($name) {
            return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $name)));
        }

        $folder_name = normalizeFolderName($title);
        $base_folder = __DIR__ . "/assets/images/blogs/$folder_name";

        // Create folder if it doesn't exist
        if (!is_dir($base_folder) && !mkdir($base_folder, 0755, true)) {
            $error = 'Failed to create directory for image upload.';
        }

        // Handle image upload
        $image_path = null;
        if (!empty($_FILES['image']['name'])) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $error = 'Invalid image type. Allowed types: jpg, jpeg, png, webp.';
            } elseif ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $error = 'Image upload error.';
            } else {
                $image_name = uniqid('blog_', true) . '.' . $ext;
                $target_path = "$base_folder/$image_name";

                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $image_path = "assets/images/blogs/$folder_name/$image_name";
                } else {
                    $error = 'Failed to upload image.';
                }
            }
        }

        if (empty($error)) {
            // Check if title already exists
            $check = $conn->prepare("SELECT COUNT(*) FROM blogs WHERE title = ?");
            $check->bind_param("s", $title);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();

            if ($count > 0) {
                $error = 'A blog with this title already exists. Please choose a unique title.';
            } else {
                // Insert blog into DB
                $stmt = $conn->prepare("INSERT INTO blogs (title, image, tags, content) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $title, $image_path, $tags, $content);
                if ($stmt->execute()) {
                    $newId = $stmt->insert_id;
                    $stmt->close();
                    header("Location: single-blog.php?id=" . $newId);
                    exit;
                } else {
                    $error = 'Failed to add blog.';
                    $stmt->close();
                }
            }
        }
    }
}

include 'header.php';
?>

<main class="add_blog-container">
    <form action="add-blog.php" method="POST" enctype="multipart/form-data">
        <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <input type="text" name="title" placeholder="BLOG TITLE" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
            required class="input">

        <!-- Static Preview Container with "No Image" Text -->
        <div class="add_blog-img" id="image-container">
            <img id="preview-img" alt="Blog preview image" style="display: none;">
            <h2 id="no-image-text">NO IMAGE WAS ADDED</h2>
            <a href="#" id="remove-image-btn" onclick="clearImage(); return false;" style="display: none;">X</a>
        </div>

        <label class="custom-file-upload">
            <input type="file" id="image" name="image" class="img_input" accept="image/*"
                onchange="previewImage(event)">
            ADD BLOG IMAGE
        </label>

        <input type="text" name="tags" placeholder="BLOG TAGS (comma separated)"
            value="<?= htmlspecialchars($_POST['tags'] ?? '') ?>" required class="input">

        <div class="add_blog-f">
            <h3>Please write your blog code in this format:</h3>
            <p>
                &lt;div class="single-blog_content--paragraph"&gt;<br>
                &nbsp;&nbsp;&lt;h2&gt;Title of Section&lt;/h2&gt;<br>
                &nbsp;&nbsp;&lt;p&gt;Your paragraph content goes here.&lt;/p&gt;<br>
                &nbsp;&nbsp;&lt;a href="#"&gt;&lt;h2&gt;your link goes here&lt;/h2&gt;&lt;/a&gt;<br>
                &lt;/div&gt;
            </p>
            <br>
            <p>
                &lt;div class="single-blog_content--paragraph"&gt;<br>
                &nbsp;&nbsp;&lt;h2&gt;Section Title&lt;/h2&gt;<br>
                &nbsp;&nbsp;&lt;p&gt;Your content here...&lt;/p&gt;<br>
                &nbsp;&nbsp;&lt;ul&gt;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&lt;li&gt;List item 1&lt;/li&gt;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&lt;li&gt;List item 2&lt;/li&gt;<br>
                &nbsp;&nbsp;&lt;/ul&gt;<br>
                &lt;/div&gt;
            </p>
        </div>

        <textarea id="code"
            name="code"><?= htmlspecialchars($_POST['code'] ?? '// write your blog code here') ?></textarea>
        <button class="btn__red--l btn__red btn">ADD BLOG</button>
    </form>
</main>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById('preview-img');
        img.src = e.target.result;
        img.style.display = 'block';
        document.getElementById('no-image-text').style.display = 'none';
        document.getElementById('remove-image-btn').style.display = 'inline';
    };
    reader.readAsDataURL(file);
}

function clearImage() {
    document.getElementById('image').value = '';
    const img = document.getElementById('preview-img');
    img.src = '';
    img.style.display = 'none';
    document.getElementById('no-image-text').style.display = 'block';
    document.getElementById('remove-image-btn').style.display = 'none';
}

// Initialize CodeMirror
const editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    lineNumbers: true,
    mode: 'htmlmixed',
    theme: '3024-day',
    tabSize: 2
});
</script>

<?php include 'footer.php'; ?>