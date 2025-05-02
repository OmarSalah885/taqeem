<?php
include 'config.php'; // Include session settings
session_start(); // Start the session


include 'header.php';
?>

<main class="add_blog-container">
    <form action="">
        <input type="text" placeholder="BLOG TITLE" required class="input">
        <div class="add_blog-img">
            <img src="assets/images/blogimg (2).jpg" alt="">
            <h2>NO IMAGE WAS ADDED</h2>
        </div>
        <label class="custom-file-upload">
            <input type="file" id="image" name="image" class="img_input" />
            ADD BLOG IMAGE
        </label>
        <input type="text" placeholder="BLOG TAGS" required class="input">
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
        <textarea id="code" name="code">// write your blog code here</textarea>
        <button class="btn__red--l btn__red btn">ADD BLOG</button>
    </form>
</main>
<script>
const editor = CodeMirror.fromTextArea(document.getElementById("code"), {
    lineNumbers: true,
    mode: "htmlmixed",
    theme: "3024-day",
    tabSize: 2
});
</script>
<?php include 'footer.php'; ?>