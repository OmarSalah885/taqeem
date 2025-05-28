document.addEventListener('DOMContentLoaded', () => {
    // Initialize star ratings for add and edit forms
    function initializeStarRatings() {
        bindStarRating('.addReview_container .addReview_stars');
        document.querySelectorAll('.edit-review-form .addReview_stars').forEach(container => {
            const form = container.closest('.edit-review-form');
            if (form) {
                bindStarRating(`#${form.id} .addReview_stars`);
            }
        });
    }

    // Bind star rating functionality to a container
    function bindStarRating(selector) {
        const container = document.querySelector(selector);
        if (!container) {
            console.error(`Star rating container not found: ${selector}`);
            return;
        }
        const stars = container.querySelectorAll('i');
        const reviewId = container.getAttribute('data-review-id');
        const ratingInput = reviewId 
            ? document.getElementById(`rating-${reviewId}`)
            : container.closest('form')?.querySelector('input[name="rating"]');
        if (!ratingInput) {
            console.error(`Rating input not found for: ${selector}`);
            return;
        }

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = parseInt(star.getAttribute('data-value'));
                ratingInput.value = value;
                stars.forEach(s => {
                    const starValue = parseInt(s.getAttribute('data-value'));
                    s.classList.toggle('selected', starValue <= value);
                    s.style.color = starValue <= value ? '#A21111' : '#D0D0D0';
                });
            });
        });

        const currentRating = parseInt(ratingInput.value) || 0;
        stars.forEach(s => {
            const starValue = parseInt(s.getAttribute('data-value'));
            s.classList.toggle('selected', starValue <= currentRating);
            s.style.color = starValue <= currentRating ? '#A21111' : '#D0D0D0';
        });
    }

    // Handle add review form submission
    const reviewForm = document.getElementById('reviewForm');
    let formDataCache = null;
    let newFiles = [];

    if (reviewForm) {
        reviewForm.addEventListener('submit', async event => {
            event.preventDefault();

            formDataCache = new FormData(reviewForm);
            sessionStorage.setItem('reviewFormData', JSON.stringify({
                review_text: formDataCache.get('review_text'),
                rating: formDataCache.get('rating'),
                place_id: formDataCache.get('place_id'),
                csrf_token: formDataCache.get('csrf_token'),
                image_names: newFiles.map(f => f.name)
            }));

            console.log('Add review form data:', {
                review_text: formDataCache.get('review_text'),
                rating: formDataCache.get('rating'),
                place_id: formDataCache.get('place_id'),
                csrf_token: formDataCache.get('csrf_token'),
                images: newFiles.map(f => f.name)
            });

            if (isLoggedIn) {
                syncFormData();
                submitReviewForm();
            } else {
                window.reviewImagesTemp = newFiles;
                sessionStorage.setItem('isReviewTriggeredLogin', 'true');
                showLogin(null, window.location.href, true);
            }
        });
    }

    // Submit add review form via AJAX
    function submitReviewForm() {
        if (!formDataCache) {
            console.error('No form data to submit');
            alert('Error: No form data. Please try again.');
            return;
        }

        if (!formDataCache.get('csrf_token')) {
            console.error('CSRF token missing');
            alert('CSRF token missing. Please refresh the page.');
            return;
        }

        console.log('Submitting review to add_review.php:', newFiles.map(f => f.name));
        fetch('add_review.php', {
            method: 'POST',
            body: formDataCache,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
        .then(response => {
            console.log('add_review.php status:', response.status);
            if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
            return response.text();
        })
        .then(text => {
            console.log('Add review response:', text);
            if (!text.trim()) throw new Error('Empty server response');
            return JSON.parse(text);
        })
        .then(data => {
            if (data.success) {
                const reviewsContainer = document.querySelector('.reviews_container');
                if (reviewsContainer) {
                    reviewsContainer.insertAdjacentHTML('afterbegin', data.html);
                    const reviewElement = document.getElementById(`review_${data.review_id}`);
                    if (reviewElement) reviewElement.scrollIntoView({ behavior: 'smooth' });
                }
                if (reviewForm) {
                    reviewForm.reset();
                    reviewForm.querySelectorAll('.addReview_stars i').forEach(star => star.classList.remove('selected'));
                }
                const imagePreview = document.getElementById('imagePreview');
                if (imagePreview) imagePreview.innerHTML = '';
                newFiles = [];
                window.reviewImagesTemp = null;
                const newEditForm = document.getElementById(`editForm-${data.review_id}`);
                if (newEditForm) {
                    bindStarRating(`#editForm-${data.review_id} .addReview_stars`);
                    bindEditForm(newEditForm);
                }
                updateRatings(data.avg_rating, data.total_reviews, data.ratings_counts);
                sessionStorage.removeItem('reviewFormData');
                sessionStorage.removeItem('isReviewTriggeredLogin');
            } else {
                alert(`Failed to add review: ${data.error || 'Unknown error'}`);
            }
        })
        .catch(error => {
            console.error('Error adding review:', error);
            alert(`Error adding review: ${error.message}`);
        });
    }

    // Handle image uploads for add review
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

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
                    thumb.querySelector('.remove-image').addEventListener('click', () => {
                        thumb.remove();
                        newFiles = newFiles.filter(f => f !== file);
                        syncFormData();
                    });
                    imagePreview.appendChild(thumb);
                };
                reader.readAsDataURL(file);
                newFiles.push(file);
            });
            syncFormData();
        });
    }

    function syncFormData() {
        if (!imageInput) return;
        const dataTransfer = new DataTransfer();
        newFiles.forEach(f => dataTransfer.items.add(f));
        imageInput.files = dataTransfer.files;
        console.log('Synced files:', newFiles.map(f => f.name));
        window.reviewImagesTemp = newFiles;
    }

    // Handle edit review form submissions
    document.addEventListener('submit', event => {
        if (!event.target.matches('.edit-review-form')) return;
        event.preventDefault();
        const form = event.target;
        const reviewId = parseInt(form.querySelector('input[name="review_id"]').value) || 0;
        const formData = new FormData(form);
        console.log('Submitting edit form for review:', reviewId, 'with delete_images:', formData.getAll('delete_images[]'));
        fetch('edit_review.php', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
        .then(response => {
            console.log('edit_review.php status:', response.status);
            if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
            return response.text();
        })
        .then(text => {
            console.log('Edit review response:', text);
            if (!text.trim()) throw new Error('Empty server response');
            return JSON.parse(text);
        })
        .then(data => {
            if (data.success) {
                const reviewElement = document.getElementById(`review_${data.review_id}`);
                if (reviewElement) {
                    reviewElement.querySelectorAll(`#editForm-${data.review_id}`).forEach(f => f.remove());
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data.html;
                    const newReview = tempDiv.querySelector(`#review_${data.review_id}`);
                    const newEditForm = tempDiv.querySelector(`#editForm-${data.review_id}`);
                    if (newReview) {
                        reviewElement.innerHTML = newReview.innerHTML;
                        console.log('Updated review:', data.review_id);
                    }
                    if (newEditForm) {
                        reviewElement.appendChild(newEditForm);
                        newEditForm.style.display = 'none';
                        bindStarRating(`#editForm-${data.review_id} .addReview_stars`);
                        bindEditForm(newEditForm);
                        console.log('Bound edit form:', data.review_id);
                    }
                    reviewElement.scrollIntoView({ behavior: 'smooth' });
                }
                form.style.display = 'none';
                updateRatings(data.avg_rating, data.total_reviews, data.ratings_counts);
            } else {
                alert(`Failed to edit review: ${data.error || 'Unknown error'}`);
            }
        })
        .catch(error => {
            console.error('Error editing review:', error);
            alert(`Error editing review: ${error.message}`);
        });
    });

    // Bind edit form functionality
    function bindEditForm(form) {
        const reviewId = parseInt(form.querySelector('input[name="review_id"]').value) || 0;
        const preview = document.getElementById(`imagePreview-${reviewId}`);
        const fileInput = document.getElementById(`imageInput-${reviewId}`);
        let newEditFiles = [];

        // Remove existing listeners to prevent duplication
        if (preview) {
            const newPreview = preview.cloneNode(true);
            preview.parentNode.replaceChild(newPreview, preview);
        }

        const updatedPreview = document.getElementById(`imagePreview-${reviewId}`);
        bindStarRating(`#editForm-${reviewId} .addReview_stars`);

        if (updatedPreview) {
            updatedPreview.addEventListener('click', e => {
                if (!e.target.matches('.remove-image')) return;
                const thumb = e.target.closest('.image-thumb');
                if (!thumb) return;
                const imgId = thumb.getAttribute('data-img-id');
                thumb.remove();
                if (imgId) {
                    const existingInputs = form.querySelectorAll('input[name="delete_images[]"]');
                    let inputExists = false;
                    existingInputs.forEach(input => {
                        if (input.value === imgId) inputExists = true;
                    });
                    if (!inputExists) {
                        const delInput = document.createElement('input');
                        delInput.type = 'hidden';
                        delInput.name = 'delete_images[]';
                        delInput.value = imgId;
                        form.appendChild(delInput);
                        console.log(`Added delete_images[] for image ID: ${imgId}`);
                    }
                }
                syncEditFiles();
            });
        }

        if (fileInput) {
            fileInput.addEventListener('change', () => {
                const currentCount = updatedPreview?.querySelectorAll('.image-thumb').length || 0;
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
                        thumb.querySelector('.remove-image').onclick = () => {
                            thumb.remove();
                            newEditFiles = newEditFiles.filter(f => f !== file);
                            syncEditFiles();
                        };
                        if (updatedPreview) updatedPreview.appendChild(thumb);
                    };
                    reader.readAsDataURL(file);
                    newEditFiles.push(file);
                });
                syncEditFiles();
            });
        }

        function syncEditFiles() {
            if (!fileInput) return;
            const dataTransfer = new DataTransfer();
            newEditFiles.forEach(f => dataTransfer.items.add(f));
            fileInput.files = dataTransfer.files;
            console.log('Synced edit files:', newEditFiles.map(f => f.name));
        }
    }

    // Update ratings display
    function updateRatings(avgRating, totalReviews, ratingsCounts) {
        console.log('Updating ratings:', { avgRating, totalReviews, ratingsCounts });
        const safeAvgRating = typeof avgRating === 'number' ? avgRating : parseFloat(avgRating) || 0;
        const percentage = (safeAvgRating / 5) * 100;

        const extraStarsContainer = document.getElementById('extra-stars-container');
        if (extraStarsContainer) {
            const extraStars = extraStarsContainer.querySelector('.extra_stars');
            const extraRating = extraStarsContainer.querySelector('.extra_rating');
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
            const totalReviewsEl = overallStarsContainer.querySelector('#total-reviews');
            if (overallStars) {
                overallStars.style.background = `linear-gradient(90deg, #A21111 ${percentage}%, #D0D0D0 ${percentage}%)`;
                overallStars.style.webkitBackgroundClip = 'text';
                overallStars.style.webkitTextFillColor = 'transparent';
            }
            if (overallRating) overallRating.textContent = `${safeAvgRating.toFixed(1)} out of 5`;
            if (totalReviewsEl) totalReviewsEl.textContent = `${totalReviews} reviews`;
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

    // Restore form data after login
    if (sessionStorage.getItem('isReviewTriggeredLogin') === 'true') {
        fetch('check_session.php', {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.isLoggedIn && reviewForm) {
                const cachedData = sessionStorage.getItem('reviewFormData');
                if (cachedData) {
                    const parsedData = JSON.parse(cachedData);
                    const textarea = reviewForm.querySelector('textarea[name="review_text"]');
                    if (textarea) textarea.value = parsedData.review_text || '';
                    reviewForm.querySelector('input[name="rating"]').value = parsedData.rating || '0';
                    const stars = reviewForm.querySelectorAll('.addReview_stars i');
                    stars.forEach(star => {
                        star.classList.toggle('selected', parseInt(star.getAttribute('data-value')) <= parseInt(parsedData.rating));
                        star.style.color = parseInt(star.getAttribute('data-value')) <= parseInt(parsedData.rating) ? '#A21111' : '#D0D0D0';
                    });
                }
                window.reviewImagesTemp = null;
                newFiles = [];
                if (imageInput) imageInput.value = '';
                if (imagePreview) imagePreview.innerHTML = '';
                sessionStorage.removeItem('reviewFormData');
                sessionStorage.removeItem('isReviewTriggeredLogin');
                formDataCache = null;
                document.querySelector('.addReview').scrollIntoView({ behavior: 'smooth' });
            }
        })
        .catch(error => console.error('Error checking session:', error));
    }

    // Initialize star ratings
    initializeStarRatings();
});