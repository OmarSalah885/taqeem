// ajax_review.js
document.addEventListener('DOMContentLoaded', () => {
    // Add Review Form Submission
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('add_review.php', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.text();
            })
            .then(text => {
                console.log('Add Review Raw Response:', text); // Debug log
                if (!text.trim()) throw new Error('Empty response from server');
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Invalid JSON response:', text);
                    throw new Error('Failed to parse JSON response');
                }
            })
            .then(data => {
                if (data.success) {
                    const reviewsContainer = document.querySelector('.reviews_container');
                    reviewsContainer.insertAdjacentHTML('beforeend', data.html);
                    document.getElementById(`review_${data.review_id}`).scrollIntoView({ behavior: 'smooth' });
                    this.reset();
                    this.querySelectorAll('.addReview_stars i').forEach(star => {
                        star.classList.remove('selected');
                    });
                    document.getElementById('imagePreview').innerHTML = '';
                    newFiles = [];
                    bindStarRating(`#editForm-${data.review_id} .addReview_stars`);
                    const newEditForm = document.getElementById(`editForm-${data.review_id}`);
                    if (newEditForm) bindEditForm(newEditForm);
                    updateRatings(data.avg_rating, data.total_reviews, data.ratings_counts);
                } else {
                    alert('Failed to add review: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error occurred while adding review: ' + error.message);
            });
        });

        // Image Preview for Add Review Form
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        let newFiles = [];

        if (imageInput && imagePreview) {
    imageInput.addEventListener('change', () => {
        const currentCount = imagePreview.querySelectorAll('.image-thumb').length;
        const files = Array.from(imageInput.files);
        if (currentCount + files.length > 4) {
            alert('Maximum 4 images allowed');
            imageInput.value = '';
            return;
        }
        files.forEach(file => {
            const reader = new FileReader();
            reader.onload = event => {
                const thumb = document.createElement('div');
                thumb.className = 'image-thumb';
                thumb.innerHTML = `<img src="${event.target.result}" alt="Preview"><span class="remove-image new">×</span>`;
                thumb.querySelector('.remove-image.new').onclick = () => {
                    thumb.remove();
                    newFiles = newFiles.filter(f => f !== file);
                    syncFiles();
                };
                imagePreview.appendChild(thumb);
            };
            reader.readAsDataURL(file);
            newFiles.push(file);
        });
        syncFiles();
    });

    function syncFiles() {
        const dataTransfer = new DataTransfer();
        newFiles.forEach(f => dataTransfer.items.add(f));
        imageInput.files = dataTransfer.files;
    }
}
    }

    // Edit Review Form Submission
    document.querySelectorAll('.edit-review-form').forEach(form => {
        bindEditForm(form);
    });

    function bindEditForm(form) {
        const reviewId = parseInt(form.querySelector('input[name="review_id"]').value);
        const preview = document.getElementById(`imagePreview-${reviewId}`);
        const fileInput = document.getElementById(`imageInput-${reviewId}`);
        let newFiles = [];

        if (preview) {
            preview.addEventListener('click', e => {
                if (!e.target.matches('.remove-image.existing')) return;
                const thumb = e.target.closest('.image-thumb');
                const imgId = thumb.getAttribute('data-img-id');
                thumb.remove();
                const delInput = document.createElement('input');
                delInput.type = 'hidden';
                delInput.name = 'delete_images[]';
                delInput.value = imgId;
                form.appendChild(delInput);
                syncFiles();
            });
        }

        if (fileInput) {
    fileInput.addEventListener('change', () => {
        const currentCount = preview.querySelectorAll('.image-thumb').length;
        const files = Array.from(fileInput.files);
        if (currentCount + files.length > 4) {
            alert('Maximum 4 images allowed');
            fileInput.value = '';
            return;
        }
        files.forEach(file => {
            const reader = new FileReader();
            reader.onload = event => {
                const thumb = document.createElement('div');
                thumb.className = 'image-thumb';
                thumb.innerHTML = `<img src="${event.target.result}" alt="Preview"><span class="remove-image new">×</span>`;
                thumb.querySelector('.remove-image.new').onclick = () => {
                    thumb.remove();
                    newFiles = newFiles.filter(f => f !== file);
                    syncFiles();
                };
                preview.appendChild(thumb);
            };
            reader.readAsDataURL(file);
            newFiles.push(file);
        });
        syncFiles();
    });
}

        function syncFiles() {
            const dataTransfer = new DataTransfer();
            newFiles.forEach(f => dataTransfer.items.add(f));
            if (fileInput) fileInput.files = dataTransfer.files;
        }

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('edit_review.php', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.text();
            })
            .then(text => {
                console.log('Edit Review Raw Response:', text); // Debug log
                if (!text.trim()) throw new Error('Empty response from server');
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Invalid JSON response:', text);
                    throw new Error('Failed to parse JSON response');
                }
            })
            .then(data => {
                if (data.success) {
                    const reviewElement = document.getElementById(`review_${data.review_id}`);
                    if (reviewElement) {
                        reviewElement.outerHTML = data.html;
                    }
                    const newEditForm = document.getElementById(`editForm-${data.review_id}`);
                    if (newEditForm) bindEditForm(newEditForm);
                    bindStarRating(`#editForm-${data.review_id} .addReview_stars`);
                    form.style.display = 'none';
                    updateRatings(data.avg_rating, data.total_reviews, data.ratings_counts);
                } else {
                    alert('Failed to edit review: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error occurred while editing review: ' + error.message);
            });
        });
    }

    function bindStarRating(selector) {
        const container = document.querySelector(selector);
        if (!container) return;
        const stars = container.querySelectorAll('i');
        const reviewId = container.getAttribute('data-review-id');
        const ratingInput = reviewId ? document.getElementById(`rating-${reviewId}`) : container.querySelector('input[name="rating"]');
        if (!ratingInput) return;

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = parseInt(this.getAttribute('data-value'));
                ratingInput.value = value;
                stars.forEach(s => {
                    s.classList.toggle('selected', parseInt(s.getAttribute('data-value')) <= value);
                });
            });
        });
    }

    function updateRatings(avgRating, totalReviews, ratingsCounts) {
        const safeAvgRating = typeof avgRating === 'number' ? avgRating : parseFloat(avgRating) || 0;
        const extraStarsContainer = document.getElementById('extra-stars-container');
        if (extraStarsContainer) {
            const extraStars = extraStarsContainer.querySelector('.extra_stars');
            const extraRating = extraStarsContainer.querySelector('.extra_rating');
            const percentage = (safeAvgRating / 5) * 100;
            if (extraStars) {
                extraStars.style.background = `linear-gradient(90deg, #A21111 ${percentage}%, #D0D0D0 ${percentage}%)`;
                extraStars.style.webkitBackgroundClip = 'text';
                extraStars.style.webkitTextFillColor = 'transparent';
            }
            if (extraRating) extraRating.textContent = safeAvgRating.toFixed(1);
        }

        const overallStarsContainer = document.getElementById('reviews-overall-l');
        if (overallStarsContainer) {
            const overallStars = overallStarsContainer.querySelector('#overall-stars');
            const overallRating = overallStarsContainer.querySelector('#overall-rating');
            const totalReviewsContainer = overallStarsContainer.querySelector('#total-reviews');
            const percentage = (safeAvgRating / 5) * 100;
            if (overallStars) {
                overallStars.style.background = `linear-gradient(90deg, #A21111 ${percentage}%, #D0D0D0 ${percentage}%)`;
                overallStars.style.webkitBackgroundClip = 'text';
                overallStars.style.webkitTextFillColor = 'transparent';
            }
            if (overallRating) overallRating.textContent = `${safeAvgRating.toFixed(1)} out of 5`;
            if (totalReviewsContainer) totalReviewsContainer.textContent = `${totalReviews} reviews`;
        }

        const overallR = document.getElementById('reviews-overall-r');
        if (overallR) {
            for (let i = 5; i >= 1; i--) {
                const starsP = document.getElementById(`stars-p-${i}`);
                if (starsP) {
                    const percent = totalReviews > 0 ? ((ratingsCounts[i] || 0) / totalReviews) * 100 : 0;
                    const colorBar = starsP.querySelector('.stars_p--color');
                    if (colorBar) colorBar.style.width = `${percent}%`;
                }
            }
        }
    }
});