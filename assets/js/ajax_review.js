document.addEventListener('DOMContentLoaded', () => {
    // Add Review Form Submission
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('add_review.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Invalid JSON:', text);
                        throw new Error('Failed to parse JSON response');
                    }
                });
            })
            .then(data => {
                if (data.success) {
                    const reviewsContainer = document.querySelector('.reviews_container');
                    reviewsContainer.insertAdjacentHTML('afterbegin', data.html);
                    document.querySelector('#review_' + data.review_id).scrollIntoView({ behavior: 'smooth' });
                    this.reset();
                    this.querySelectorAll('.addReview_stars i').forEach(star => {
                        star.style.color = '#D0D0D0';
                    });
                    document.getElementById('imagePreview').innerHTML = '';
                    newFiles = [];
                    // Rebind star rating and edit form events for new edit form
                    bindStarRating(`#editForm-${data.review_id} .addReview_stars`);
                    const newEditForm = document.getElementById(`editForm-${data.review_id}`);
                    if (newEditForm) bindEditForm(newEditForm);
                } else {
                    alert('Failed to add review: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the review: ' + error.message);
            });
        });

        // Image Preview for Add Review Form
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        let newFiles = [];

        imageInput.addEventListener('change', () => {
            const currentCount = imagePreview.querySelectorAll('.image-thumb').length;
            const files = Array.from(imageInput.files).slice(0, 4 - currentCount);
            if (currentCount + files.length > 4) {
                alert("Maximum 4 images allowed");
                imageInput.value = '';
                return;
            }
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = ev => {
                    const thumb = document.createElement('div');
                    thumb.className = 'image-thumb';
                    thumb.innerHTML = `<img src="${ev.target.result}"><span class="remove-image new">×</span>`;
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
            const dt = new DataTransfer();
            newFiles.forEach(f => dt.items.add(f));
            imageInput.files = dt.files;
        }
    }

    // Edit Review Form Submission
    document.querySelectorAll('.edit-review-form').forEach(form => {
        bindEditForm(form);
    });

    function bindEditForm(form) {
        const reviewId = form.querySelector('input[name="review_id"]').value;
        const preview = document.getElementById(`imagePreview-${reviewId}`);
        const fileInput = document.getElementById(`imageInput-${reviewId}`);
        let newFiles = [];

        // Remove existing images
        preview.addEventListener('click', e => {
            if (!e.target.matches('.remove-image.existing')) return;
            const thumb = e.target.closest('.image-thumb');
            const imgId = thumb.getAttribute('data-img-id');
            thumb.remove();
            const delInp = document.createElement('input');
            delInp.type = 'hidden';
            delInp.name = 'delete_images[]';
            delInp.value = imgId;
            form.appendChild(delInp);
            syncFiles();
        });

        // Add new images
        fileInput.addEventListener('change', () => {
            const currentCount = preview.querySelectorAll('.image-thumb').length;
            const files = Array.from(fileInput.files).slice(0, 4 - currentCount);
            if (currentCount + files.length > 4) {
                alert("Maximum 4 images allowed");
                fileInput.value = '';
                return;
            }
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = ev => {
                    const thumb = document.createElement('div');
                    thumb.className = 'image-thumb';
                    thumb.innerHTML = `<img src="${ev.target.result}"><span class="remove-image new">×</span>`;
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

        function syncFiles() {
            const dt = new DataTransfer();
            newFiles.forEach(f => dt.items.add(f));
            fileInput.files = dt.files;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            console.log([...formData.entries()]); // Debug form data
            fetch('edit_review.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Invalid JSON:', text);
                        throw new Error('Failed to parse JSON response');
                    }
                });
            })
            .then(data => {
                if (data.success) {
                    const reviewElem = document.querySelector('#review_' + reviewId);
                    if (reviewElem) {
                        reviewElem.outerHTML = data.html;
                        // Rebind edit form events for the updated review
                        const newForm = document.getElementById(`editForm-${reviewId}`);
                        if (newForm) bindEditForm(newForm);
                        bindStarRating(`#editForm-${reviewId} .addReview_stars`);
                    }
                    form.style.display = 'none';
                } else {
                    alert('Failed to edit review: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while editing the review: ' + error.message);
            });
        });
    }

    // Function to bind star rating events
    function bindStarRating(selector) {
        const container = document.querySelector(selector);
        if (!container) return;
        const stars = container.querySelectorAll('i');
        const reviewId = container.getAttribute('data-review-id');
        const ratingInput = reviewId ? document.getElementById(`rating-${reviewId}`) : container.querySelector('input[name="rating"]');
        
        if (!ratingInput) {
            console.warn('Rating input not found for container:', container);
            return;
        }

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = parseInt(this.getAttribute('data-value'));
                ratingInput.value = value;
                stars.forEach(s => {
                    s.style.color = s.getAttribute('data-value') <= value ? '#A21111' : '#D0D0D0';
                });
            });
        });
    }
});