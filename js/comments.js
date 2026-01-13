document.addEventListener('DOMContentLoaded', function() {
    // Hide replies by default
    const commentList = document.querySelector('.comment-list');
    if (commentList) {
        const topLevelComments = commentList.querySelectorAll(':scope > .comment');
        topLevelComments.forEach(comment => {
            const children = comment.querySelector('.children');
            if (children) {
                children.style.display = 'none';

                const toggleRepliesLink = document.createElement('a');
                toggleRepliesLink.href = '#';
                toggleRepliesLink.textContent = 'Show Replies';
                toggleRepliesLink.classList.add('toggle-replies');
                
                const commentBody = comment.querySelector('.comment-body');
                commentBody.appendChild(toggleRepliesLink);

                toggleRepliesLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (children.style.display === 'none') {
                        children.style.display = 'block';
                        this.textContent = 'Hide Replies';
                    } else {
                        children.style.display = 'none';
                        this.textContent = 'Show Replies';
                    }
                });
            }
        });
    }

    // "See More" for long comments
    const comments = document.querySelectorAll('.comment-content');
    comments.forEach((comment, index) => {
        const maxHeight = 100; // pixels
        console.log(`Comment ${index} scrollHeight: ${comment.scrollHeight}`);
        if (comment.scrollHeight > maxHeight) {
            console.log(`Comment ${index} is long. Truncating.`);
            comment.style.maxHeight = maxHeight + 'px';
            comment.style.overflow = 'hidden';
            comment.classList.add('truncated');

            const seeMoreLink = document.createElement('a');
            seeMoreLink.href = '#';
            seeMoreLink.textContent = 'See More';
            seeMoreLink.classList.add('see-more');
            comment.parentNode.insertBefore(seeMoreLink, comment.nextSibling);

            seeMoreLink.addEventListener('click', function(e) {
                e.preventDefault();
                if (comment.classList.contains('truncated')) {
                    comment.style.maxHeight = 'none';
                    comment.classList.remove('truncated');
                    this.textContent = 'See Less';
                } else {
                    comment.style.maxHeight = maxHeight + 'px';
                    comment.classList.add('truncated');
                    this.textContent = 'See More';
                }
            });
        }
    });
});