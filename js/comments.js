document.addEventListener('DOMContentLoaded', function() {
    // Function to apply "See More" logic to a given comment-content element
    function applySeeMoreToComment(commentContentElement) {
        const maxHeight = 100; // pixels
        // Check if the see-more link already exists and if the comment needs truncation
        if (commentContentElement.scrollHeight > maxHeight && !commentContentElement.parentNode.querySelector('.see-more')) {
            commentContentElement.style.maxHeight = maxHeight + 'px';
            commentContentElement.style.overflow = 'hidden';
            commentContentElement.classList.add('truncated');

            const seeMoreLink = document.createElement('a');
            seeMoreLink.href = '#';
            seeMoreLink.textContent = 'See More';
            seeMoreLink.classList.add('see-more');
            commentContentElement.parentNode.insertBefore(seeMoreLink, commentContentElement.nextSibling);

            seeMoreLink.addEventListener('click', function(e) {
                e.preventDefault();
                if (commentContentElement.classList.contains('truncated')) {
                    commentContentElement.style.maxHeight = 'none';
                    commentContentElement.classList.remove('truncated');
                    this.textContent = 'See Less';
                } else {
                    commentContentElement.style.maxHeight = maxHeight + 'px';
                    commentContentElement.classList.add('truncated');
                    this.textContent = 'See More';
                }
            });
        }
    }

    const commentList = document.querySelector('.comment-list');
    if (commentList) {
        // Handle "Show/Hide Replies" and apply "See More" to replies when they are shown
        const topLevelComments = commentList.querySelectorAll(':scope > li.comment');
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
                    const isHidden = children.style.display === 'none';
                    if (isHidden) {
                        children.style.display = 'block';
                        this.textContent = 'Hide Replies';
                        // Now that replies are visible, apply "See More"
                        const repliedCommentsContent = children.querySelectorAll('.comment-content');
                        repliedCommentsContent.forEach(applySeeMoreToComment);
                    } else {
                        children.style.display = 'none';
                        this.textContent = 'Show Replies';
                    }
                });
            }
        });

        // Initial application for top-level comments
        const initialComments = document.querySelectorAll('.comment-list > li.comment > .comment-body > .comment-content');
        initialComments.forEach(applySeeMoreToComment);
    }
});