document.addEventListener('DOMContentLoaded', () => {
    // Add Review Form Submission
    const reviewForm = document.getElementById('reviewForm');
    let formDataCache = null;
    let newFiles = []; // Preserve newFiles in outer scope

    if (reviewForm) {
        reviewForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            // Cache form data
            formDataCache = new FormData(this);
            sessionStorage.setItem('reviewFormData', JSON.stringify({
                review_text: formDataCache.get('review_text'),
                rating: formDataCache.get('rating'),
                place_id: formDataCache.get('place_id'),
                csrf_token: formDataCache.get('csrf_token')
            }));

            // Log form data for debugging
            console.log('Form data before submission:', {
                review_text: formDataCache.get('review_text'),
                rating: formDataCache.get('rating'),
                place_id: formDataCache.get('place_id'),
                csrf_token: formDataCache.get('csrf_token'),
                images: formDataCache.getAll('review_images[]').map(f => f.name)
            });

            // Check client-side login status first
            console.log('Client-side isLoggedIn:', isLoggedIn);
            if (isLoggedIn) {
                syncFiles(); // Ensure files are synced
                submitReviewForm();
                return;
            }

            // Fallback to server-side check if client-side indicates not logged in
            try {
                const response = await fetch('check_session.php', {
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                console.log('Server-side isLoggedIn:', data.isLoggedIn);
                const isLoggedInServer = data.isLoggedIn === true;

                if (!isLoggedInServer) {
                    sessionStorage.setItem('isReviewTriggeredLogin', 'true');
                    if (typeof showLogin === 'function') {
                        showLogin(() => {
                            // Submit review directly after login
                            syncFiles();
                            submitReviewForm();
                        });
                    } else {
                        console.error('showLogin function is not defined. Ensure auth.js is loaded.');
                        const overlay = document.querySelector('.LogOverlay');
                        const loginForm = document.querySelector('.LogOverlay__content--login');
                        const signupForm = document.querySelector('.LogOverlay__content--signup');
                        const loginLinkDiv = document.getElementById('login-overlay__div');
                        const signupLinkDiv = document.getElementById('signup-overlay__div');
                        if (overlay && loginForm && signupForm && loginLinkDiv && signupLinkDiv) {
                            overlay.classList.add('show');
                            loginForm.classList.add('show');
                            signupForm.classList.remove('show');
                            loginLinkDiv.classList.add('active');
                            signupLinkDiv.classList.remove('active');
                        } else {
                            console.error('Login overlay elements not found in DOM.');
                        }
                    }
                    return false;
                }

                // Proceed with form submission if logged in
                syncFiles();
                submitReviewForm();
            } catch (error) {
                console.error('Error checking login status:', error);
                alert('Error checking login state: ' + error.message);
            }
        });
    }

    // Function to submit review form
    function submitReviewForm() {
        if (!formDataCache) {
            const cachedData = sessionStorage.getItem('reviewFormData');
            if (cachedData) {
                const parsedData = JSON.parse(cachedData);
                formDataCache = new FormData();
                for (const key in parsedData) {
                    formDataCache.append(key, parsedData[key]);
                }
                // Re-append images from newFiles
                newFiles.forEach(file => formDataCache.append('review_images[]', file));
            } else {
                console.error('No form data available to submit');
                return;
            }
        }

        // Ensure CSRF token is present
        if (!formDataCache.get('csrf_token')) {
            console.error('CSRF token missing in form data');
            alert('Security error: CSRF token missing');
            return;
        }

        console.log('Submitting review to add_review.php with images:', newFiles.map(f => f.name));
        fetch('add_review.php', {
            method: 'POST',
            body: formDataCache,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
        .then(response => {
            console.log('add_review.php response status:', response.status);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.text();
        })
        .then(text => {
            console.log('Add Review Raw Response:', text);
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
                if (reviewsContainer) {
                    reviewsContainer.insertAdjacentHTML('afterbegin', data.html);
                    const reviewElement = document.getElementById(`review_${data.review_id}`);
                    if (reviewElement) {
                        reviewElement.scrollIntoView({ behavior: 'smooth' });
                    }
                }
                if (reviewForm) {
                    reviewForm.reset();
                    reviewForm.querySelectorAll('.addReview_stars i').forEach(star => star.classList.remove('selected'));
                }
                const imagePreview = document.getElementById('imagePreview');
                if (imagePreview) {
                    imagePreview.innerHTML = '';
                }
                console.log('newFiles before reset:', newFiles.map(f => f.name));
                newFiles = [];
                console.log('newFiles after reset:', newFiles);
                bindStarRating(`#editForm-${data.review_id} .addReview_stars`);
                const newEditForm = document.getElementById(`editForm-${data.review_id}`);
                if (newEditForm) bindEditForm(newEditForm);
                updateRatings(data.avg_rating, data.total_reviews, data.ratings_counts);
                sessionStorage.removeItem('reviewFormData');
                sessionStorage.removeItem('isReviewTriggeredLogin');
            } else {
                alert('Failed to add review: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error adding review:', error);
            alert('Error occurred while adding review: ' + error.message);
        });
    }

    // Check if login was triggered by review form (fallback for page reloads)
    if (sessionStorage.getItem('isReviewTriggeredLogin') === 'true') {
        fetch('check_session.php', {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.isLoggedIn === true) {
                const textarea = reviewForm?.querySelector('textarea[name="review_text"]');
                if (textarea) {
                    // Restore form data (text only, images are lost)
                    const cachedData = sessionStorage.getItem('reviewFormData');
                    if (cachedData) {
                        const parsedData = JSON.parse(cachedData);
                        textarea.value = parsedData.review_text || '';
                        reviewForm.querySelector('input[name="rating"]').value = parsedData.rating || '0';
                        const stars = reviewForm.querySelectorAll('.addReview_stars i');
                        stars.forEach(star => {
                            star.classList.toggle('selected', parseInt(star.getAttribute('data-value')) <= parseInt(parsedData.rating));
                        });
                    }
                    textarea.focus();
                    sessionStorage.removeItem('isReviewTriggeredLogin');
                    alert('Images were not saved. Please re-upload images and submit again.');
                }
            }
        })
        .catch(error => console.error('Error checking session:', error));
    }

    // Image Preview for Add Review
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
                        syncFiles();
                    });
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
            console.log('Synced files:', newFiles.map(f => f.name));
        }
    }

    // Edit Review Form Submission
    document.querySelectorAll('.edit-review-form').forEach(form => {
        bindEditForm(form);
    });

    function bindEditForm(form) {
        const reviewId = parseInt(form.querySelector('input[name="review_id"]').value) || 0;
        const preview = document.getElementById(`imagePreview-${reviewId}`);
        const fileInput = document.getElementById(`imageInput-${reviewId}`);
        let newEditFiles = [];

        if (preview) {
            preview.addEventListener('click', e => {
                if (!e.target.matches('.remove-image')) return;
                const thumb = e.target.closest('.image-thumb');
                const imgId = thumb.getAttribute('data-img-id');
                thumb.remove();
                if (imgId) {
                    const delInput = document.createElement('input');
                    delInput.type = 'hidden';
                    delInput.name = 'delete_images[]';
                    delInput.value = imgId;
                    form.appendChild(delInput);
                }
                syncEditFiles();
            });
        }

        if (fileInput) {
            fileInput.addEventListener('change', () => {
                const currentCount = preview?.querySelectorAll('.image-thumb').length || 0;
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
                            newEditFiles = newFiles.filter(f => f !== file);
                            syncEditFiles();
                        };
                        if (preview) {
                            preview.appendChild(thumb);
                        }
                    };
                    reader.readAsDataURL(file);
                    newEditFiles.push(file);
                });
                syncEditFiles();
            });
        }

        function syncEditFiles() {
            const dataTransfer = new DataTransfer();
            newEditFiles.forEach(f => dataTransfer.items.add(f));
            if (fileInput) fileInput.files = dataTransfer.files;
        }

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('edit_review.php', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.text();
            })
            .then(text => {
                console.log('Edit Review Raw Response:', text);
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
        console.log('Updating ratings:', { avgRating, totalReviews, ratingsCounts });
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