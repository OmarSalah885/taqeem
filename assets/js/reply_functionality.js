document.addEventListener('DOMContentLoaded', function () {
    const replyButtons = document.querySelectorAll('.comment_content--reply');
    const commentForm = document.querySelector('.single-blog_thought');
    const parentCommentIdField = document.getElementById('parent_comment_id');

    replyButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const parentCommentId = this.closest('.comments_container--single').getAttribute('data-comment-id');
            parentCommentIdField.value = parentCommentId;

            // Scroll to the comment form
            commentForm.scrollIntoView({ behavior: 'smooth' });
        });
    });
});