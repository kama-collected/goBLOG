document.querySelectorAll('.like-form').forEach(form => {
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const contentId = this.dataset.contentId;
        const isLiked = this.dataset.liked === '1';
        const token = this.querySelector('[name="_token"]').value;
        const button = this.querySelector('.like-btn');
        const countSpan = button.querySelector('.like-count');

        const method = isLiked ? 'DELETE' : 'POST';

        const response = await fetch(`/contents/${contentId}`, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        });

        if (response.ok) {
            const data = await response.json();

            // Update count
            if (countSpan) {
                countSpan.textContent = data.likes_count;
            }

            // Toggle class and state
            button.classList.toggle('liked', !isLiked);
            this.dataset.liked = isLiked ? '0' : '1';
        } else {
            console.error("Failed to toggle like");
        }
    });
});
